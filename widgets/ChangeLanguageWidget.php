<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class ChangeLanguageWidget extends Widget
{
    /**
     * Renders the widget.
     */
    public function run()
    {
        /** @var User $user */
        return
            '<li>'
            . '<div class="dropdown navbar-dropdown-profile">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-2x fa-globe"></i>'.\Yii::t('app', 'LANG').
                    '<span class="caret"></span>
                  </button>'
                    . '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">'
                        . '<li>' . Html::a('<i class="fa fa-2x "></i> RU', ['/set', 'lang' => 'ru'] ) . '</li>'
                        . '<li>' . Html::a('<i class="fa fa-2x "></i> EN', ['/set', 'lang' => 'en'] ) . '</li>'
            . '</ul>'
            . '</div>'
            . '</li>';
    }
}
