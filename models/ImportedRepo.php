<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imported_repo".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $repo_url
 * @property string $last_revision
 */
class ImportedRepo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imported_repo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['repo_url', 'last_revision'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'repo_url' => 'Repo Url',
            'last_revision' => 'Last Revision',
        ];
    }
}
