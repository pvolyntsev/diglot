<?php

namespace app\models;

use Yii;

use budyaga\users\models\AuthAssignment;
use budyaga\users\models\AuthItem;
use budyaga\users\models\UserEmailConfirmToken;
use budyaga\users\models\UserOauthKey;
use budyaga\users\models\UserPasswordResetToken;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $photo
 * @property integer $sex
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Article[] $articles
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property Comment[] $comments
 * @property UserEmailConfirmToken[] $userEmailConfirmTokens
 * @property UserOauthKey[] $userOauthKeys
 * @property UserPasswordResetToken[] $userPasswordResetTokens
 */
class User extends \budyaga\users\models\User
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'photo' => 'Photo',
            'sex' => 'Sex',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmailConfirmTokens()
    {
        return $this->hasMany(UserEmailConfirmToken::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOauthKeys()
    {
        return $this->hasMany(UserOauthKey::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPasswordResetTokens()
    {
        return $this->hasMany(UserPasswordResetToken::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
