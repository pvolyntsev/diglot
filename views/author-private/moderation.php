<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Article;
use app\models\Comment;
use app\models\User;

/**
 * @var $this View
 * @var $responses ActiveDataProvider
 */

$this->title = 'Response Moderation';
?>

<div class="container">
    <!-- responses are here -->

    <p class="no-responses">No responses to moderate</p>
</div>