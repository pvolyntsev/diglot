<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Banner;

class BannerWidget extends Widget
{
    public $position;

    /**
     * Renders the widget.
     */
    public function run()
    {
        $banner = Banner::findOne(['position' => $this->position]); /** @var $banner Banner */
        if ($banner)
            return $banner->content;
        return null;
    }
}