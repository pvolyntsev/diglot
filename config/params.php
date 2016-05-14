<?php

return [
    'adminEmail' => 'diglot-admin@copist.ru',
    'supportEmail' => 'diglot-support@copist.ru',
    'domain' => 'http://l.diglot.copist.ru/',

    // Send all mails to a file by default
    // You have to set 'mailer.useFileTransport' to false and configure a 'mailer.transport' to send real emails
    'mailer.useFileTransport' => true,

    'mailer.transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'hostname',
        'port' => 'port',
        'username' => 'username',
        'password' => 'userpassword',
        'encryption' => null,
    ],

    // List of options to authorize using third-party services
    'authClientCollection.clients' => [
//        'vkontakte' => [
//            'class' => 'budyaga\users\components\oauth\VKontakte',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//            'scope' => 'email'
//        ],
//        'google' => [
//            'class' => 'budyaga\users\components\oauth\Google',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'facebook' => [
//            'class' => 'budyaga\users\components\oauth\Facebook',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'github' => [
//            'class' => 'budyaga\users\components\oauth\GitHub',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//            'scope' => 'user:email, user'
//        ],
//        'linkedin' => [
//            'class' => 'budyaga\users\components\oauth\LinkedIn',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'live' => [
//            'class' => 'budyaga\users\components\oauth\Live',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'yandex' => [
//            'class' => 'budyaga\users\components\oauth\Yandex',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'twitter' => [
//            'class' => 'budyaga\users\components\oauth\Twitter',
//            'consumerKey' => 'XXX',
//            'consumerSecret' => 'XXX',
//        ],
    ]
];
