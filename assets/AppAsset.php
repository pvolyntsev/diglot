<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/article.css',
        'css/comments.css',
        'css/search.css',
        'css/profile.css',
        'https://maxcdn.icons8.com/fonts/line-awesome/css/line-awesome-font-awesome.min.css',
    ];
    public $js = [
        'js/application.js',
        'js/article.js',
        'js/comments.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii2mod\alert\AlertAsset'
    ];
}
