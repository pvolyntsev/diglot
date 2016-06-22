<?php
namespace app\components;

use Yii;
use yii\web\Request;
use yii\web\NotFoundHttpException;

class LangRequest extends Request
{
    private $lang_arr = ['en', 'ru'];

    public function init()
    {
        parent::init();

        if (isset(Yii::$app->request->cookies['lang']))
        {
            $user_lang = Yii::$app->request->cookies->getValue('lang');
            if (!in_array($user_lang, $this->lang_arr))
            {
                throw new NotFoundHttpException;
            }
            Yii::$app->language = $user_lang;
            Yii::$app->formatter->locale = $user_lang;
        } else {
            $language = $this->getBrowserLoc();
            $language_code = $this->getCode($language);
            Yii::$app->language = $language_code;
            Yii::$app->formatter->locale = $language_code;
        }
    }

    static function getCode($lang) {
        switch ($lang) {
            case 'ru':
                return "ru-RU";

            case 'en':
                return "en-US";

            default :
                return "en-US";
        }
    }

    private function getBrowserLoc() {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }
        else {
            return 'eng';
        }

    }
}