<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public $layout = 'test';

    public function actionTestpage()
    {
        $data="1111";
        return $this->render('testpage',$data);
    }
}
