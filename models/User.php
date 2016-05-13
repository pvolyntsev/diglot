<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\base\InvalidConfigException;

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

    /**
     * Find record(s) by pk. Allow use variants:
     * - findByPk(1)
     * - findByPk([1,2])
     * - findByPk(['id1' => 1, 'id2' => 2])
     * - findByPk([
     *      ['id1' => 1, 'id2' => 2],
     *      ['id1' => 3, 'id2' => 4]
     *   ])
     * @inheritdoc
     * @return ActiveQueryInterface the newly created [[ActiveQueryInterface|ActiveQuery]] instance.
     */
    public static function findByPk($pk)
    {
        $query = static::find();
        if (ArrayHelper::isAssociative($pk)) {
            $keys = array_keys($pk);
            if (!static::isPrimaryKey($keys)) {
                throw new InvalidParamException(get_called_class() . ' has no composite primary key named "' . implode(', ', $keys) . '".');
            }
            // hash condition
            return $query->andWhere($pk);
        } elseif (ArrayHelper::isIndexed($pk, true)) {
            if (is_array($pk[0])) {
                $condition = ['or'];
                foreach ($pk as $compositePk) {
                    $keys = array_keys($compositePk);
                    if (!static::isPrimaryKey($keys)) {
                        throw new InvalidParamException(get_called_class() . ' has no composite primary key named "' . implode(', ', $keys) . '".');
                    }
                    $condition[] = ['and', $compositePk];
                }
                return $query->andWhere($condition);
            }
        }
        // query by primary key
        $primaryKey = static::primaryKey();
        if (isset($primaryKey[0])) {
            return $query->andWhere([$primaryKey[0] => $pk]);
        } else {
            throw new InvalidConfigException(get_called_class() . ' must have a primary key.');
        }
    }
}
