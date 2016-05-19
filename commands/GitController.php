<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\github\Github;
use app\models\User;
use app\models\Article;
use app\models\Paragraph;

class GitController extends Controller
{
    /**
     * id пользователя, репозитории которого надо импортировать
     * @param $id
     */
    public function actionIndex($id)
    {
        $github = new Github();

        // Получаем данные для github api
        $ghTokens = $github->getGithubTokens();

        // Переменные для запроса к github
        $ghUrl = $github->baseUrl;
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
        $data = $github->runCurl($ghUserUrl);

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
        $data = $github->runCurl($ghReposUrl);

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

            $dataDiglot = $github->runCurl($ghDiglotUrl);

            if(!$dataDiglot || isset($dataDiglot->message))
            {
                echo "$repo->name - ini файл не найден \n";
                continue;
            }

            // Получение содержимого ini-файла
            $dataIniFile = $github->getFileContent($repo->contents_url,"diglot.ini",$ghParams);

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
            $dataMaster = $github->runCurl($ghMasterUrl);

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

            $dataFiles = $github->runCurl($ghFilesUrl);

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
                        $arrOriginal = $github->getArticleStrings($repo->contents_url,$fileInfo->path,$ghParams);

                        if(!$arrOriginal)
                        {
                            echo "$repo->name - $article - Ошибка получения оригинального файла статьи \n";
                            continue;
                        }

                    } elseif ($fileInfo->path == $article."/translation.md")
                    {
                        // Получение файла с переводом
                        $arrTranslate = $github->getArticleStrings($repo->contents_url,$fileInfo->path,$ghParams);

                        if(!$arrTranslate)
                        {
                            echo "$repo->name - $article - Ошибка получения файла статьи с переводом \n";
                            continue;
                        }
                    } elseif ($fileInfo->path == $article."/meta.ini")
                    {
                        // Получение файла с метаинформацией

                        $metaIniFile = $github->getFileContent($repo->contents_url,$fileInfo->path,$ghParams);

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

                // Добавление информации по статье
                $importArticles[] = [
                    'meta' => $arrMeta,
                    'original' => $arrOriginal,
                    'translate' => $arrTranslate
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
            
            // Сбор мета-информации
            $articleItem = new Article;
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
            $articleItem->lang_transtate_id = $translateId;

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

        }
    }
}