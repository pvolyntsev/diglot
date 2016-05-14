<?php

namespace app\controllers;

use app\models\Comment;

class AddcommentController extends \yii\web\Controller
{
    public function actionAddcomment()
    {

        $comment=new Comment();
        $input = Yii::app()->request->getPost('input');


//        return $this->render('addcomment',['data'=>$input['newComment']."*********************************"]);
        return $this->render('addcomment');
    }

}
