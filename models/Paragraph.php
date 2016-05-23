<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paragraph".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $paragraph_original
 * @property string $paragraph_translate
 * @property string $date_modified
 * @property integer $sortorder
 *
 * @property Article $article
 */
class Paragraph extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paragraph';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'paragraph_original'], 'required'],
            [['article_id', 'sortorder'], 'integer'],
            [['paragraph_original', 'paragraph_translate'], 'string'],
            [['date_modified'], 'safe'],
            [['article_id', 'sortorder'], 'unique', 'targetAttribute' => ['article_id', 'sortorder'], 'message' => 'The combination of Article ID and Порядковый номер параграфа в статье has already been taken.'],
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
            'article_id' => 'Article ID',
            'paragraph_original' => 'Paragraph Original',
            'paragraph_translate' => 'Paragraph Translate',
            'date_modified' => 'Date Modified',
            'sortorder' => 'Порядковый номер параграфа в статье',
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
     * @return ParagraphQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParagraphQuery(get_called_class());
    }
}
