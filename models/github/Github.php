<?php

namespace app\models\github;

use Yii;
use yii\base\Model;
use kartik\markdown\Markdown;

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
}