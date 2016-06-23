<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\Cookie;

class BannerMenuWidget extends Widget
{
    /**
     * Renders the widget.
     */
    public function run()
    {

        $index = Yii::$app->request->getCookies()->getValue('_sup');
        if (is_null($index))
        {
            $index = rand(0, count($this->donateLinks)-1);
            $cookie = new Cookie([
                'name' => '_sup',
                'value' => $index,
                'expire' => null,
            ]);
            Yii::$app->response->getCookies()->add($cookie);
        }
        $donateLinks = [
            ['label' => '<i class="fa fa-2x fa-money"></i>'.\Yii::t('app', 'SUPPORT_US'), 'url' => ['/donate', '_utm' => 'support-us']],
            ['label' => '<i class="fa fa-2x fa-money"></i>'.\Yii::t('app', 'DONATE'), 'url' => ['/donate', '_utm' => 'donate']],
            ['label' => '<i class="fa fa-2x fa-life-ring"></i>'.\Yii::t('app', 'HELP_US'), 'url' => ['/donate', '_utm' => 'help-us']],
            ['label' => '<i class="fa fa-2x fa-thumbs-up"></i>'.\Yii::t('app', 'SUPPORT_US'), 'url' => ['/donate', '_utm' => 'support-us-up']],
        ];
        return '<li class="link link-publish">' . Html::a($donateLinks[$index]['label'], $donateLinks[$index]['url'], [ 'encode' => false, 'options' => [ 'class' => 'link']]) . '</li>';
    }
}