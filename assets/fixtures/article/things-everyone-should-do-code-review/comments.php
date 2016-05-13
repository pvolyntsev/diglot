<?php
use \app\models\User;
use \Faker\Factory as FakerFactory;

$faker = FakerFactory::create();

$users = [
    [ 'email' => 'allen.rowe@gmail.com' ],
    [ 'email' => 'rick.damore@hackett.net' ],
    [ 'email' => 'john@smith.ss' ],
    [ 'email' => 'bennie.effertz@bauch.info' ],
    [ 'email' => 'novella.ankunding@hotmail.com' ],
    [ 'email' => 'freeda.gleichner@hotmail.com' ],
    [ 'email' => 'leda08@gmail.com' ],
    [ 'email' => 'gmcglynn@lindgren.info' ],
    [ 'email' => 'esmeralda15@yahoo.com' ],
    [ 'email' => 'elias52@will.com' ],
    [ 'email' => 'cole.phyllis@lowe.com' ],
    [ 'email' => 'kurt.stamm@yahoo.com' ],
];

/** @var User[] $users */
foreach($users as $i => $userData)
{
    $user = User::findByEmailOrUserName($userData['email']);
    if (!$user)
        unset($users[$i]);
    else
        $users[$i] = $user;
}
$users = array_values($users);
if (empty($users))
    return [];

$comments = [];
for($i = 0; $i< 30; $i++)
{
    /** @var User $user */
    $user = $users[array_rand($users)];
    $comment = [
        'id' => $i+1,
        'user_id' => $user->id,
        'article_id' => 1,
        'comment' => $faker->text(400),
        'date_created' => time() - (30*$i + rand(5,10))*60,
        'date_modified' => time() - (30*$i + 15 + rand(5,10))*60,
        'status' => 'published',
        'user' => $user,
    ];

    $comments[] = (object)$comment;
}

return $comments;