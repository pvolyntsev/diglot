<?php

namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{
    public function actionTestpage()
    {
        $data="1111";
        return $this->render('testpage',$data);
    }

}
