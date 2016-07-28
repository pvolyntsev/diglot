<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imported_article".
 *
 * @property integer $id
 * @property integer $imported_repo_id
 * @property string $repo_article_path
 * @property integer $article_id
 *
 * @property Article $article
 */
class ImportedArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imported_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imported_repo_id', 'article_id'], 'integer'],
            [['repo_article_path'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imported_repo_id' => 'Imported Repo ID',
            'repo_article_path' => 'Repo Article Path',
            'article_id' => 'Article ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
