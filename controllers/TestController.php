<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionTestpage()
    {
        $data="1111";
        return $this->render('testpage',$data);
    }

    public function actionGit()
    {
    	// Массив для передачи в представление
    	$files = array();

    	// Получаем данные для github api
    	$ghTokens = Yii::$app->params['authClientCollection.clients']['github'];

    	// Переменные для запроса к github
    	$ghUrl = "https://api.github.com/";
    	$ghParams = "?client_id=".$ghTokens["clientId"]."&client_secret=".$ghTokens["clientSecret"];

    	// Формируем строку запроса для github

    	// Получаем github имя текущего пользователя по его github-id

    	// Черновой вариант. Добавить проверки,
    	// что текущий пользователь авторизован и у него есть github id в БД

    	// Получаем id текущего пользователя
    	$currentUser = Yii::$app->user->identity->
    				   getUserOauthKeys()
    				   ->where(['provider_id'=>4])
    				   ->asArray()
    				   ->one();

    	// Получаем github id текущего пользователя
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
    	if($data) {
	    	// Проходимся по каждому репозиторию
    		foreach ($data as $repo) {

    			// Проверяем наличие файла diglot.md
    			$ghDiglotUrl = $repo->contents_url;
    			$ghDiglotUrl = str_replace('{+path}',"diglot.md",$ghDiglotUrl);
    			$ghDiglotUrl.= $ghParams;

    			$dataDiglot = $this->runCurl($ghDiglotUrl);

    			if($dataDiglot) {
    				// Если файл существует, 
    				// значит берем все остальные файлы
    				if (!isset($dataDiglot->name)) {
    					continue;
    				}
    			} else {
    				echo "error";
    				exit;
    			}
 
    			// Получаем sha ветки master 
    			$ghMasterUrl = $repo->branches_url;
    			$ghMasterUrl = str_replace('{/branch}',"/master",$ghMasterUrl);
    			$ghMasterUrl.= $ghParams;
    			$dataMaster = $this->runCurl($ghMasterUrl);

    			if($dataMaster) {
					$ghSha = $dataMaster->commit->sha;
				} else {
					// Ошибка запроса
		    		echo "error";
		    		exit;
				}

				// Получаем файлы репозитория
				$ghFilesUrl = $repo->trees_url;
				$ghFilesUrl = str_replace('{/sha}',"/".$ghSha."?recursive=1",$ghFilesUrl);
				$ghFilesUrl.= "&client_id=".$ghTokens["clientId"]."&client_secret=".$ghTokens["clientSecret"];

				$dataFiles = $this->runCurl($ghFilesUrl);

				if(!$dataFiles){
					echo "error";
					exit;
				}

				// Проходимся по файлам репозитория
				foreach ($dataFiles->tree as $fileInfo) {

					// Получаем содержимое каждого файла
					$ghFileUrl = $repo->contents_url;
    				$ghFileUrl = str_replace('{+path}',$fileInfo->path,$ghFileUrl);
    				$ghFileUrl.= $ghParams;

    				$dataFile = $this->runCurl($ghFileUrl);

    				if(!$dataFile) {
    					echo "error - get repository file";
    					exit;
    				}

    				// Сам файл diglot.md не берем
    				if($dataFile->name == "diglot.md") {
    					continue;
    				}

    				$files[] = array(
    					'name' => $dataFile->name,
    					'content' => $dataFile->content
    				);

				}

    		}

    	}

    	return $this->render('git',compact('files'));
    }

    protected function runCurl($url) {
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
}
