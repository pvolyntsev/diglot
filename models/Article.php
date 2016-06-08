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
 * @property User $user
 * @property Language $langOriginal
 * @property Language $langTranslate
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
            [['title_original', 'user_id', 'lang_original_id'], 'required'],
            [['status'], 'string'],
            [['date_created', 'date_modified', 'date_deleted', 'date_published'], 'safe'],
            [['user_id', 'own_original', 'own_translate', 'lang_original_id', 'lang_translate_id'], 'integer'],
            [['title_original', 'title_translate'], 'string', 'max' => 100],
            [['url_original', 'url_translate', 'author_url', 'translator_url'], 'string', 'max' => 500],
            [['author_name', 'translator_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['lang_original_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_original_id' => 'id']],
            [['lang_translate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['lang_translate_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title_original' => Yii::t('app', 'Title Original'),
            'url_original' => Yii::t('app', 'Url Original'),
            'title_translate' => Yii::t('app', 'Title Translate'),
            'url_translate' => Yii::t('app', 'Url Translate'),
            'status' => Yii::t('app', 'Статуc'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'date_deleted' => Yii::t('app', 'Date Deleted'),
            'date_published' => Yii::t('app', 'Date Published'),
            'user_id' => Yii::t('app', 'User ID'),
            'author_name' => Yii::t('app', 'Author Name'),
            'author_url' => Yii::t('app', 'Author Url'),
            'own_original' => Yii::t('app', 'Own Original Article'),
            'translator_name' => Yii::t('app', 'Translator Name'),
            'translator_url' => Yii::t('app', 'Translator Url'),
            'own_translate' => Yii::t('app', 'Собственный перевод'),
            'lang_original_id' => Yii::t('app', 'Original Language'),
            'lang_translate_id' => Yii::t('app', 'Translation Language'),
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
        return $this->hasMany(Paragraph::className(), ['article_id' => 'id'])->orderBy('sortorder');
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

    public function afterSave($insert, $changedAttributes)
    {
        try {
            $elArticle = \app\elastic\models\Article::findOne(['id' => $this->id]);
            if (!$elArticle) {
                $elArticle = new \app\elastic\models\Article();
            }
            $elArticle->attributes = [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'status' => $this->status,
                'title_original' =>$this->title_original,
                'title_translate' => $this->title_translate
            ];
            $elArticle->save();

        } catch(\Exception $e)
        {
            if (isset($elArticle) && $elArticle->errors)
                Yii::error('Error afterSave: '.$e.' '.var_export($elArticle->errors, true), 'accessElastic');
            else
                Yii::error('Error afterSave: '.$e, 'accessElastic');
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function afterDelete()
    {
        try {
            $elArticle = \app\elastic\models\Article::findOne(['id' => $this->id]);
            if ($elArticle) {
                $elArticle->delete();
            }

        } catch(\Exception $e)
        {
            if (isset($elArticle) && $elArticle->errors)
                Yii::error('Error afterDelete: '.$e.' '.var_export($elArticle->errors, true), 'accessElastic');
            else
                Yii::error('Error afterDelete: '.$e, 'accessElastic');
        }

        parent::afterDelete(); // TODO: Change the autogenerated stub
    }
}
