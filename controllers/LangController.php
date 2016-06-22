<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\components\LangRequest;

class LangController extends Controller {

    private $lang_arr = ['en', 'ru'];

    public function actionSet($lang = null) {

        if (!in_array($lang, $this->lang_arr)) {
            throw new NotFoundHttpException;
        }
        if (isset(Yii::$app->request->cookies['lang'])) {

            Yii::$app->response->cookies->remove('lang');

            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'lang',
                'value' => $lang
            ]));

            $lang = LangRequest::getCode($lang);


            Yii::$app->language = $lang;
            Yii::$app->formatter->locale = $lang;
        } else {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'lang',
                'value' => $lang
            ]));
            $lang = LangRequest::getCode($lang);
            Yii::$app->language = $lang;
            Yii::$app->formatter->locale = $lang;
        }

        return $this->redirect(Yii::$app->request->referrer);
        //возвращаем пользователя откуда пришел
    }

}