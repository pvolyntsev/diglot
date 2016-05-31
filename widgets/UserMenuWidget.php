<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\User;

class UserMenuWidget extends Widget
{
    /**
     * Renders the widget.
     */
    public function run()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        return
            '<li>'
            . '<div class="dropdown navbar-dropdown-profile">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-2x fa-user"></i> '. $user->username . '
                    <span class="caret"></span>
                  </button>'
                    . '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-user"></i> Profile', ['/' . rawurlencode($user->username) . '/profile'] ) . '</li>'
//                        . '<li role="separator" class="divider"></li>'
//                        . '<li>' . Html::a('<i class="fa fa-2x fa-cogs"></i> Settings', ['/author/settings'] ) . '</li>'
                        . '<li role="separator" class="divider"></li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-file-text"></i> Articles', ['/' . rawurlencode($user->username) . '/articles'] ) . '</li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-comments"></i> Responses', ['/' . rawurlencode($user->username) . '/responses'] ) . '</li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-star"></i> Followings', ['/' . rawurlencode($user->username) . '/followings'] ) . '</li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-heart"></i> Followers', ['/' . rawurlencode($user->username) . '/followers'] ) . '</li>'
                        . '<li role="separator" class="divider"></li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-file"></i> Draft', ['/profile/drafts'] ) . '</li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-bullhorn"></i> Moderation', ['/profile/moderation'] ) . '</li>'
                        . '<li role="separator" class="divider"></li>'
                        . '<li>' . Html::a('<i class="fa fa-2x fa-plus-square"></i> Add Article', ['/article/create'] ) . '</li>'
                    . '</ul>'
            . '</div>'
            . '</li>';
    }
}