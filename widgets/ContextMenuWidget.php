<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\User;
use app\models\Article;

class ContextMenuWidget extends Widget
{
    /**
     * Renders the widget.
     */
    public function run()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (isset($this->view->params['article']))
        {
            /** @var Article $article */
            $article = $this->view->params['article'];

            if ($article->user_id == $user->id)
            {
                switch(Yii::$app->requestedRoute)
                {
                    case 'article/view':
                        return '<li class="link link-publish">' . Html::a('<i class="fa fa-2x fa-edit"></i> Edit', ['/article/update', 'id' => $article->id]) . '</li>';
                }
//                return '<li>'
//                . 'owner '
//                . Yii::$app->requestedRoute
//                . '</li>';
            } else
            {

            }
        }

        return '';
    }
}