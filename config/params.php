<?php

return [
    'adminEmail' => 'diglot-admin@copist.ru',
    'supportEmail' => 'diglot-support@copist.ru',
    'domain' => 'http://l.diglot.copist.ru/',
    'name' => 'Diglot',
    'title' => [
        'en' => 'Diglot. Your bilingual books and articles shelf. English and Russian.',
        'ru' => 'Diglot. Твоя полка для статей и книг билингва. На английском и русском.',
    ],
    'description.256' => 'Diglot project gives the opportunity to learn English or Russian using examples of quality translation. Проект Diglot дает возможность изучать английский или русский язык, используя примеры качественного перевода.',
    'description.100' => 'Learn English Russian using high quality translation. Изучи английский русский по качественным переводам',
    'keywords' => 'learn, english, russian, translation, articles, stories, read, publish, social, service',
    'social.image' => '/img/diglot_about.png',

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
//    'authClientCollection.clients' => [
//        'vkontakte' => [ // https://vk.com/editapp?act=create
//            'class' => 'budyaga\users\components\oauth\VKontakte',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//            'scope' => 'email'
//        ],
//        'google' => [ // https://console.developers.google.com/project
//            'class' => 'budyaga\users\components\oauth\Google',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'facebook' => [ // https://developers.facebook.com/apps
//            'class' => 'budyaga\users\components\oauth\Facebook',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'github' => [ // https://github.com/settings/applications/new
//            'class' => 'budyaga\users\components\oauth\GitHub',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//            'scope' => 'user:email, user'
//        ],
//        'linkedin' => [ // https://www.linkedin.com/secure/developer
//            'class' => 'budyaga\users\components\oauth\LinkedIn',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'live' => [ // https://account.live.com/developers/applications
//            'class' => 'budyaga\users\components\oauth\Live',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'yandex' => [ // https://oauth.yandex.ru/client/new
//            'class' => 'budyaga\users\components\oauth\Yandex',
//            'clientId' => 'XXX',
//            'clientSecret' => 'XXX',
//        ],
//        'twitter' => [ // https://dev.twitter.com/apps/new
//            'class' => 'budyaga\users\components\oauth\Twitter',
//            'consumerKey' => 'XXX',
//            'consumerSecret' => 'XXX',
//        ],
//    ],

    // banner positions and attributes
    'banner.positions' => [
        'footer.central.column' => [ 'format' => 'html/list' ],
    ]
];
