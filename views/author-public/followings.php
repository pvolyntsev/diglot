<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * @var $this View
 * @var $followings ActiveDataProvider
 */

$this->title = $author->username . ' | Followings';
?>

<div class="container">
    <!-- followings are here -->
    <p class="no-followings"><?php echo $author->username ?> follows nobody</p>
</div>