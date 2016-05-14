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

];
