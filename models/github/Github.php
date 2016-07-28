<?php

namespace app\models\github;

use Yii;
use yii\base\Model;
use kartik\markdown\Markdown;
use app\models\User;
use app\models\Article;
use app\models\Paragraph;
use app\models\ImportedRepo;
use app\models\ImportedArticle;

/**
 * ContactForm is the model behind the contact form.
 */
class Github extends Model
{
    /**
     * Базовый url github api
     * @var string
     */
    public $baseUrl = "https://api.github.com/";

    /**
     * Путь для директории с временными файлами для импорта
     * @var string
     */
    public $importDir = "github_import/";

    /**
     * Символ-разделитель для разбора отдельных предложений текста
     * @var string
     */
    public $strSeparator = "---";
    /**
     *  Получение токенов для доступа к github из параметров 
     * @return mixed
     */
    public function getGithubTokens()
    {
        return Yii::$app->params['authClientCollection.clients']['github'];
    }

    /**
     * Выполнение curl-запроса по url с параметрами
     * @param $url
     * @return mixed|null
     */
    public function runCurl($url)
    {
        // Выполнение curl-запроса

        if ($ch = @curl_init())
        {
            // Выполняем запрос
            @curl_setopt($ch, CURLOPT_URL,$url);
            @curl_setopt($ch, CURLOPT_HEADER, false);
            @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            @curl_setopt($ch, CURLOPT_USERAGENT, 'diglot');
            $data = @curl_exec($ch);
            @curl_close($ch);
            return $data = json_decode($data);
        } else {
            // Запрос не выполнился
            return null;
        }
    }

    /**
     * Получение содержимого файла репозитория
     * @param $url
     * @param $params
     * @return mixed|null
     */
    public function getFileContent($url,$path,$params)
    {
        // Получаем содержимое каждого файла
        $url = str_replace('{+path}',$path,$url);
        $url.= $params;
        $fileContent = $this->runCurl($url);
        return $fileContent;
    }

    public function getArticleStrings($url,$file,$params)
    {
        $dataFile = $this->getFileContent($url,$file,$params);

        if(!$dataFile) {
            return null;
        }

        // Массив с временным набором строк статьи
        $tempArr = array();

        // Массив с сформированным набором строк статьи
        $stringsArr = array();

        // Получение содержимого файла
        $dataFileContent = base64_decode($dataFile->content);

        // Сбор строк в массив по разделителю
        $tempArr = explode($this->strSeparator,$dataFileContent);

        // Обход и оптимизация строк контента
        foreach ($tempArr as $key=>$str)
        {

            // Оптимизация строки с текстом
            // Удаление лишних пробелов
            $str = trim($str);

            // Удаление лишних специальных символов
            $str = str_replace(array("\r","\n","\t"),"",$str);

            // Преобразование markdown в html
            $str = Markdown::convert($str);

            // Пустое содержимое не должно добавляться в массив
            if(strlen($str) == 0)
            {
                continue;
            }

            $stringsArr[$key] = $str;

        }

        return $stringsArr;
    }
    
    public function import($id) {

        // Получаем данные для github api
        $ghTokens = $this->getGithubTokens();

        // Переменные для запроса к github
        $ghUrl = $this->baseUrl;
        $ghParams = "?client_id=".$ghTokens["clientId"]."&client_secret=".$ghTokens["clientSecret"];

        // Получение пользователя по id
        $user = User::findOne($id);

        if(!$user) {
            echo "ID - $id - пользователь не обнаружен \n";
            return;
        }

        // Получение github id пользователя
        $currentUser = $user->
        getUserOauthKeys()
            ->where(['provider_id'=>4])
            ->asArray()
            ->one();

        if(!$currentUser) {
            echo "ID - $id - пользователь не авторизован через GitHub \n";
            return;
        }

        // Получаем github username
        $ghUserId = $currentUser['provider_user_id'];
        $ghUserUrl = $ghUrl."user/".$ghUserId.$ghParams;
        $data = $this->runCurl($ghUserUrl);

        if($data) {
            // Имя пользователя github
            $ghUser = $data->login;

            // Адрес репозиториев
            $ghRepos = $data->repos_url;

        } else {
            // Ошибка запроса
            echo "error";
            exit;
        }

        // Получаем список репозиториев пользователя
        $ghReposUrl = $ghRepos.$ghParams;
        $data = $this->runCurl($ghReposUrl);

        // Если запрос прошел успешно
        if(!$data)
        {
            echo "ID - $id - ошибка получения репозиториев GitHub \n";
            return;
        }


        // Массив для сформированных статей
        $importArticles = array();

        // Работа с каждым репозиторием пользователя
        foreach ($data as $repo) {

            // Проверка на наличие файла diglot.ini
            $ghDiglotUrl = $repo->contents_url;
            $ghDiglotUrl = str_replace('{+path}',"diglot.ini",$ghDiglotUrl);
            $ghDiglotUrl.= $ghParams;

            $dataDiglot = $this->runCurl($ghDiglotUrl);

            if(!$dataDiglot || isset($dataDiglot->message))
            {
                echo "$repo->name - ini файл не найден \n";
                continue;
            }

            // Получение содержимого ini-файла
            $dataIniFile = $this->getFileContent($repo->contents_url,"diglot.ini",$ghParams);

            if(!$dataIniFile)
            {
                echo "$repo->name.Ошибка получения ini-файла \n";
                continue;
            }

            $iniConf = base64_decode($dataIniFile->content);

            $arrIniConf = parse_ini_string($iniConf,true);

            if(!$arrIniConf)
            {
                echo "$repo->name - Ошибка обработки ini-файла \n";
                continue;
            }

            // Получение имени требуемой ветки из конфигурационного файла
            $currentBranch = $arrIniConf['branch']['active'];

            if(!$currentBranch)
            {
                echo "$repo->name - Не обнаружена активная ветка \n";
                continue;
            }

            // Получаем sha ветки master
            $ghMasterUrl = $repo->branches_url;
            $ghMasterUrl = str_replace('{/branch}',"/$currentBranch",$ghMasterUrl);
            $ghMasterUrl.= $ghParams;
            $dataMaster = $this->runCurl($ghMasterUrl);

            if(isset($dataMaster->message))
            {
                echo "Ветка $currentBranch не обнаружена в репозитории $repo->name \n";
                continue;
            }

            $ghSha = $dataMaster->commit->sha;

            // Получение файлов репозитория
            $ghFilesUrl = $repo->trees_url;
            $ghFilesUrl = str_replace('{/sha}',"/".$ghSha."?recursive=1",$ghFilesUrl);
            $ghFilesUrl.= "&client_id=".$ghTokens["clientId"]."&client_secret=".$ghTokens["clientSecret"];

            $dataFiles = $this->runCurl($ghFilesUrl);

            if(!$dataFiles)
            {
                echo "$repo->name - Ошибка получения файлов репозитория \n";
                continue;
            }

            // Получение файлов по каждой статье



            foreach($arrIniConf['article'] as $article)
            {

                // Массив с мета-информацией о статье
                $arrMeta = array();

                // Массив для коллекции оригинальных фраз
                $arrOriginal = array();

                // Массив для коллекции перевода фраз
                $arrTranslate = array();

                // Проходимся по файлам репозитория
                foreach ($dataFiles->tree as $fileInfo)
                {

                    // Получение файла с оригиналом
                    if($fileInfo->path == $article."/original.md")
                    {
                        $arrOriginal = $this->getArticleStrings($repo->contents_url,$fileInfo->path,$ghParams);

                        if(!$arrOriginal)
                        {
                            echo "$repo->name - $article - Ошибка получения оригинального файла статьи \n";
                            continue;
                        }

                    } elseif ($fileInfo->path == $article."/translation.md")
                    {
                        // Получение файла с переводом
                        $arrTranslate = $this->getArticleStrings($repo->contents_url,$fileInfo->path,$ghParams);

                        if(!$arrTranslate)
                        {
                            echo "$repo->name - $article - Ошибка получения файла статьи с переводом \n";
                            continue;
                        }
                    } elseif ($fileInfo->path == $article."/meta.ini")
                    {
                        // Получение файла с метаинформацией

                        $metaIniFile = $this->getFileContent($repo->contents_url,$fileInfo->path,$ghParams);

                        if(!$metaIniFile)
                        {
                            echo "$repo->name - $article - Ошибка получения мета-информация о статье \n";
                            continue;
                        }

                        $metaIniString = base64_decode($metaIniFile->content);

                        $metaIniArr = parse_ini_string($metaIniString,true);

                        if(!$metaIniArr)
                        {
                            echo "$repo->name - $article - Ошибка обработки мета-информации \n";
                            continue;
                        }

                        // Добавление мета-информации
                        $arrMeta = $metaIniArr['info'];

                    }
                }

                // Проверки статьи перед добавлением

                // Оригинальный файл и файл с переводом должны содержать строки
                if(empty($arrOriginal) || empty($arrTranslate))
                {
                    echo "$repo->name - $article - Незаполненный оригинальный файл/файл перевода \n";
                    continue;
                }

                // Оригинальный файл и файл с переводом должны содержать одинаковое количество строк
                if(count($arrOriginal) != count($arrTranslate))
                {
                    echo "$repo->name - $article - Оригинальный файл не соответствует файлу перевода \n";
                    continue;
                }

                // Статья должна содержать мета-информацию
                if(empty($arrMeta))
                {
                    echo "$repo->name - $article - Не обнаружена мета-информация \n";
                    continue;
                }


                // Запись информации о репозитории, если он не найден

                $repo_url = $repo->svn_url;

                // Проверка на существования этого репозитория
                $newRepo = ImportedRepo::find()->where(['repo_url' => $repo_url])->limit(1)->asArray()->one();

                // Если репозиторий не найден, создаем новый
                if (empty($newRepo)) {
                    $newRepo = new ImportedRepo();
                    $newRepo->user_id = $id;
                    $newRepo->repo_url = $repo_url;
                    $newRepo->last_revision =  $ghSha;
                    $newRepo->save();
                }

                // Добавление информации по статье
                $importArticles[] = [
                    'meta' => $arrMeta,
                    'original' => $arrOriginal,
                    'translate' => $arrTranslate,
                    'repo_id' => $newRepo['id'],
                    'article_path' => $repo_url . '/tree/master/' . $article
                ];

            }

        }

        // Запись статьи в БД
        foreach ($importArticles as $article)
        {

            // Мета-информация о статье
            $meta = $article['meta'];

            // Оригинальные параграфы текста
            $original = $article['original'];

            // Переведенные параграфы текста
            $translate = $article['translate'];

            // Проверка на наличие статьи в таблице импортированных статей
            $importArticle = ImportedArticle::find()->where(
                [
                    'imported_repo_id' => $article['repo_id'],
                    'repo_article_path' => $article['article_path'],
                ]
            )->limit(1)->one();



            // Если такой статьи еще нет, то создаем новую,
            // иначе перезаписываем существующую
            if (empty($importArticle)) {
                $articleItem = new Article;
            } else {
                $articleItem = Article::findOne(['id' => $importArticle->article_id]);

                if (empty($articleItem)) {
                    echo $article['article_path'] . " - Ошибка записи статьи \n";
                    continue;
                }
            }

            // Сбор мета-информации
            $articleItem->title_original = $meta['orig-title'];
            $articleItem->title_translate = $meta['trans-title'];
            $articleItem->user_id = $id;

            // Получение информации о языках
            $originalId = "";
            $translateId = "";

            // Язык оригинала
            if($meta['orig-language'] == "english") {
                $originalId = 1;
            } elseif($meta['orig-language'] == "russian") {
                $originalId = 2;
            }

            // Язык перевода
            if($meta['translate-language'] == "english") {
                $translateId = 1;
            } elseif($meta['translate-language'] == "russian") {
                $translateId = 2;
            }

            $articleItem->lang_original_id = $originalId;
            $articleItem->lang_translate_id = $translateId;

            // Автор оригинальной статьи и ссылка на него
            $articleItem->author_name = $meta['orig-author-title'];
            $articleItem->author_url = $meta['orig-author-url'];

            // Ссылки на оригинальную статью и её перевод
            $articleItem->url_original = $meta['orig-url'];
            $articleItem->url_translate = $meta['trans-url'];

            // Автор перевода и ссылка на него
            $articleItem->translator_name = $meta['trans-author-title'];
            $articleItem->translator_url = $meta['trans-author-url'];

            // Запись статьи
            if(!$articleItem->save())
            {
                echo "$articleItem->title_original - Ошибка записи статьи \n";
                continue;
            }

            // Сбор данных для записи параграфов

            // Общее количество параграфов
            $all = count($original);

            for ($i = 0; $i < $all; $i++)
            {
                $paragraphItem = new Paragraph;
                $paragraphItem->article_id = $articleItem->id;
                $paragraphItem->paragraph_original = $original[$i];
                $paragraphItem->paragraph_translate = $translate[$i];
                $paragraphItem->sortorder = $i;
                $paragraphItem->save();
            }

            echo "$articleItem->title_original - Запись завершена \n";

            // Записываем информацию об импортированной статье, если она еще не была создана
            if (empty($importArticle)) {
                $importArticle = new ImportedArticle();
                $importArticle->imported_repo_id = $article['repo_id'];
                $importArticle->repo_article_path = $article['article_path'];
                $importArticle->article_id = $articleItem->id;
                $importArticle->save();
            }

        }
    }
}