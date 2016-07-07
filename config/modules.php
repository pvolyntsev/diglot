<?php
/**
 * Created by PhpStorm.
 * User: lyudmila
 * Date: 07.07.16
 * Time: 11:30
 */
return
[
    'user' => [
        'class' => 'budyaga\users\Module',
        'userPhotoUrl' => '/upload/user',
        'userPhotoPath' => dirname(__DIR__) . '/web/upload/user'
    ],
    'markdown' => [
        'class' => '\kartik\markdown\Module',
    ],
];