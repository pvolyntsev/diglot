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
 * @var $comments ActiveDataProvider
 */
$this->title = $author->username . ' | Responses';
?>

<div class="container">
    <!-- responses are here -->
    <p class="no-responses"><?php echo $author->username ?> responded to nobody</p>
</div>