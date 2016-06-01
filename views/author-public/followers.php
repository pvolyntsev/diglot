<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * @var $this View
 * @var $followers ActiveDataProvider
 */

$this->title = $author->username . ' | Followers';
?>

<div class="container">
    <!-- followers are here -->
    <p class="no-followers">Nobody follows <?php echo $author->username ?></p>
</div>