<?php
return [
    'showScriptName' => false,     // Disable index.php
    'enablePrettyUrl' => true,     // Disable ?r= routes
    'enableStrictParsing' => false, // Only routes being listed in rules

    'scriptUrl' => $params['domain'],
    'baseUrl' => $params['domain'],

    'rules' => [
        //sitemap
        '/sitemap' => 'site/sitemap',
        // Main page & static pages
        '/' => '/article/index',
        #'/contact' => 'site/contact',
        '/about' => 'site/article',
        '/terms' => 'site/article',
        '/team' => 'site/team',
        '/github-import' => 'site/github-import',
        '/donate' => 'site/donate',
        '/github-integration' => 'site/article',
        'set' => 'lang/set',

        // Auth & user manager
        '/signup' => '/user/user/signup',
        '/login' => '/user/user/login',
        '/logout' => '/user/user/logout',
        '/requestPasswordReset' => '/user/user/request-password-reset',
        '/resetPassword' => '/user/user/reset-password',
        '/profile' => '/user/user/profile',
        '/profile/photo?' => '/user/user/uploadPhoto',
        '/retryConfirmEmail' => '/user/user/retry-confirm-email',
        '/confirmEmail' => '/user/user/confirm-email',
        '/unbind/<id:[\w\-]+>' => '/user/auth/unbind',
        '/oauth/<authclient:[\w\-]+>' => '/user/auth/index',

        // Admin Panel
        '/user/admin' => '/user/admin/index',
        '/user/admin/<action>' => '/user/admin/<action>',
        '/user/roles' => '/user/rbac/index',
        '/user/roles/<action>' => '/user/rbac/<action>',


        // Public Profile
        '/<username>/profile' => 'author-public/profile',
        '/<username>/articles' => 'author-public/articles',
        '/<username>/responses' => 'author-public/responses',
        '/<username>/followings' => 'author-public/followings',
        '/<username>/followers' => 'author-public/followers',
        '/<username>/import-git' => 'author-public/import-git',

        // Private Profile
        '/profile/drafts' => 'author-private/drafts',
        '/profile/moderation' => 'author-private/moderation',

        // Prototypes
        [ 'pattern' => 'prototype', 'route' => 'prototype/index' ],
        [ 'pattern' => 'prototype/<entity>/<mode>', 'route' => 'prototype/page' ],

        //article
        '/article' => '/article/index',
        '/article/<action>' => '/article/<action>',
        '/article/add-comment' => '/article/addComment',
        '/article/update-comment' => '/article/updateComment',
        '/article/delete-comment' => '/article/DeleteComment',
        '/article/<action>/<id:\d+>' => '/article/<action>',
        '/search' => '/article/search',
	
        // control panel (adminka)
        '/cp' => '/admin-panel/index',

        //comment
        '/cp/comment' => '/comment/index',
        '/cp/comment/<action>' => '/comment/<action>',
        '/cp/comment/<action>/<id:\d+>' => '/comment/<action>',

        // banners
        '/cp/banner' => '/banner/index',
        '/cp/banner/<action>' => '/banner/<action>',
        '/cp/banner/<action>/<id:\d+>' => '/banner/<action>',

        // categories
        // TODO

        ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
    ],
];