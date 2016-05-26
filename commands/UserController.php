<?php
namespace app\commands;

use yii\console\Controller;
use \app\models\User;

class UserController extends Controller
{
    public function actionSeedBasic()
    {
        $users = [
            [ 'username' => 'allen_rowe', 'email' => 'allen.rowe@gmail.com', 'sex' => User::SEX_MALE, 'photo' => '1_440x440.png', ],
            [ 'username' => 'rick-damore', 'email' => 'rick.damore@hackett.net', 'sex' => User::SEX_MALE, 'photo' => '10_440x440.png', ],
            [ 'username' => 'john_smith', 'email' => 'john@smith.ss', 'sex' => User::SEX_MALE, 'photo' => '9_440x440.png', ],
            [ 'username' => 'bennie-effertz', 'email' => 'bennie.effertz@bauch.info', 'sex' => User::SEX_MALE, 'photo' => '8_440x440.png', ],
            [ 'username' => 'novella-ankunding', 'email' => 'novella.ankunding@hotmail.com', 'sex' => User::SEX_FEMALE, 'photo' => '2_440x440.png', ],
            [ 'username' => 'freeda_gleichner', 'email' => 'freeda.gleichner@hotmail.com', 'sex' => User::SEX_FEMALE, 'photo' => '0_440x440.png', ],
            [ 'username' => 'leda08', 'email' => 'leda08@gmail.com', 'sex' => User::SEX_FEMALE, 'photo' => '3_440x440.png', ],
            [ 'username' => 'g_mc_glynn', 'email' => 'gmcglynn@lindgren.info', 'sex' => User::SEX_MALE, 'photo' => '11_440x440.png', ],
            [ 'username' => 'esmeralda15', 'email' => 'esmeralda15@yahoo.com', 'sex' => User::SEX_FEMALE, 'photo' => '4_440x440.png', ],
            [ 'username' => 'elias52', 'email' => 'elias52@will.com', 'sex' => User::SEX_FEMALE, 'photo' => '5_440x440.png', ],
            [ 'username' => 'cole-phyllis', 'email' => 'cole.phyllis@lowe.com', 'sex' => User::SEX_MALE, 'photo' => '7_440x440.png', ],
            [ 'username' => 'kurt_stamm', 'email' => 'kurt.stamm@yahoo.com', 'sex' => User::SEX_MALE, 'photo' => '6_440x440.png', ],
        ];
        foreach($users as $userData)
        {
            $user = User::findByEmailOrUserName($userData['email']);
            if (!$user)
                $user = new User;

            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $user->photo = $userData['photo'];
            $user->status = User::STATUS_ACTIVE;
            $user->sex = $userData['sex'];

            if (!$user->save())
                var_export($user->errors);
            else
                echo 'Added/Updated user #', $user->id, ' username=', $user->username, ' email=', $user->email, PHP_EOL;
        }
    }

    public function actionSeed($users = 1)
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<$users; $i++)
        {
            $user = new User;
            $user->username = $faker->userName;
            $user->email = $faker->email;
            $user->status = User::STATUS_ACTIVE;
            $user->sex = User::SEX_MALE;

            if (!$user->save())
                var_export($user->errors);
            else
                echo 'Added user #', $user->id, ' username=', $user->username, ' email=', $user->email, PHP_EOL;
        }
    }
}
