<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaint_on_article".
 *
 * @property integer $id
 * @property string $complaint
 * @property integer $article_id
 * @property string $date_created
 * @property string $date_deleted
 *
 * @property Article $article
 */
class ComplaintOnArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint_on_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complaint', 'article_id'], 'required'],
            [['complaint'], 'string'],
            [['article_id'], 'integer'],
            [['date_created', 'date_deleted'], 'safe'],
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
            'complaint' => 'Complaint',
            'article_id' => 'Article ID',
            'date_created' => 'Date Created',
            'date_deleted' => 'Date Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @inheritdoc
     * @return ComplaintOnArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComplaintOnArticleQuery(get_called_class());
    }
}
