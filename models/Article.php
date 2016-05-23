<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title_original
 * @property string $url_original
 * @property string $title_translate
 * @property string $url_translate
 * @property string $status
 * @property string $date_created
 * @property string $date_modified
 * @property string $date_deleted
 * @property string $date_published
 * @property integer $user_id
 * @property string $author_name
 * @property string $author_url
 * @property integer $own_original
 * @property string $translator_name
 * @property string $translator_url
 * @property integer $own_translate
 * @property integer $lang_original_id
 * @property integer $lang_translate_id
 *
 * @property Language $langTranslate
 * @property User $user
 * @property Language $langOriginal
 * @property CategoryOfArticle[] $categoryOfArticles
 * @property Category[] $categories
 * @property Comment[] $comments
 * @property ComplaintOnArticle[] $complaintOnArticles
 * @property Paragraph[] $paragraphs
 * @property TagOfArticle[] $tagOfArticles
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_original', 'title_translate', 'user_id', 'lang_original_id'], 'required'],
            [['status'], 'string'],
            [['date_created', 'date_modified', 'date_deleted', 'date_published'], 'safe'],
            [['user_id', 'own_original', 'own_translate', 'lang_original_id', 'lang_transtate_id'], 'integer'],
            [['title_original', 'title_translate'], 'string', 'max' => 100],
            [['url_original', 'url_translate', 'author_url', 'translator_url'], 'string', 'max' => 500],
            [['author_name', 'translator_name'], 'string', 'max' => 255],
            [['lang_translate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_translate_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['lang_original_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_original_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_original' => 'Title Original',
            'url_original' => 'Url Original',
            'title_translate' => 'Title Translate',
            'url_translate' => 'Url Translate',
            'status' => 'Статуc',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'date_deleted' => 'Date Deleted',
            'date_published' => 'Date Published',
            'user_id' => 'User ID',
            'author_name' => 'Author Name',
            'author_url' => 'Author Url',
            'own_original' => 'Собственная оригинальная статья',
            'translator_name' => 'Translator Name',
            'translator_url' => 'Translator Url',
            'own_translate' => 'Собственный перевод',
            'lang_original_id' => 'Язык оригинальной статьи',
            'lang_translate_id' => 'Язык перевода',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangTranslate()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_translate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangOriginal()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_original_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryOfArticles()
    {
        return $this->hasMany(CategoryOfArticle::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('category_of_article', ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaintOnArticles()
    {
        return $this->hasMany(ComplaintOnArticle::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParagraphs()
    {
        return $this->hasMany(Paragraph::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagOfArticles()
    {
        return $this->hasMany(TagOfArticle::className(), ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
