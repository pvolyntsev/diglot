<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
{	/**
     * константы
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_BLOCKED = 'blocked';

    const LANGUAGE_ORDER_COOKIE  = 'lo';
    const LANGUAGE_ORDER_ORIGINAL  = 'original';
    const LANGUAGE_ORDER_TRANSLATION  = 'translation';

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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_modified',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title_original' => Yii::t('app', 'Original Title'),
            'url_original' => Yii::t('app', 'Cross Post Original Url'),
            'title_translate' => Yii::t('app', 'Translated Title'),
            'url_translate' => Yii::t('app', 'Cross Post Translated Url'),
            'status' => Yii::t('app', 'Status'),
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
            'own_translate' => Yii::t('app', 'Own Translated Article'),
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

    public function beforeSave($insert)
    {
        if (self::STATUS_PUBLISHED == $this->getAttribute('status') && self::STATUS_PUBLISHED != $this->getOldAttribute('status')) // become published
        {
            $this->date_published = new Expression('NOW()'); // set published date
        }
        return parent::beforeSave($insert);
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

    /**
     * Обновляет параграфы
     * @param $data
     * @return Paragraph[]
     */
    public function updateParagraphs($data)
    {
        // существущие параграфы
        $oldParagraphs = $this->paragraphs;

        // построение индексированного массива параграфов, временное исправление сортировки
        $oldParagraphsIndexed = []; /** @var Paragraph[] $oldParagraphsIndexed */
        foreach($oldParagraphs as $i => $oldParagraph) {
            $oldParagraphsIndexed[$oldParagraph->id] = $oldParagraph;
            $oldParagraph->sortorder = -1 - $i;
            $oldParagraph->save();
        }

        $sortorder = 0;
        $updatedParagraphs = []; /** @var Paragraph[] $updatedParagraphs */
        $updatedParagraphsIndexed = []; /** @var Paragraph[] $updatedParagraphsIndexed */
        foreach($data['paragraph_original'] as $i => $paragraphOriginal) {
            $paragraphId = !empty($data['paragraph_original']['id']) ? $data['paragraph_original']['id'] : null;
            $paragraph = isset($oldParagraphsIndexed[$paragraphId]) ? $oldParagraphsIndexed[$paragraphId] : new Paragraph;

            $paragraphOriginal = trim($paragraphOriginal);
            $paragraphTranslate = trim($data['paragraph_translate'][$i]);

            if (empty($paragraphOriginal) && empty($paragraphTranslate))
                continue;

            $paragraph->attributes = [
                'article_id' => $this->id,
                'sortorder' => ++$sortorder,
                'paragraph_original' => $paragraphOriginal,
                'paragraph_translate' => $paragraphTranslate,
            ];
            $paragraph->validate() && $paragraph->save();

            if ($errors = $paragraph->errors)
            {
//                var_export($paragraph->attributes);
//                var_export($errors);
            }

            $updatedParagraphs[] = $paragraph;
            $updatedParagraphsIndexed[$paragraph->id] = $paragraph;
        }

        // Удалить те параграфы, которые отсутвовали в $data, то есть не обновлены
        foreach($oldParagraphsIndexed as $id => $oldParagraph)
        {
            if (!isset($updatedParagraphsIndexed[$id]))
            {
                $oldParagraph->delete();
            }
        }

        return $updatedParagraphs;
    }

	public function updateCategories($categories)
    {
		foreach ($this->categoryOfArticles as $categoryId)		
			$categoryId->delete(); //удалить старые категории, которые были присвоены статье ранее
		
		$categoriesOfArticle = [];
		
		foreach ($categories as $categoryId) { //присвоить и сохранить новые категории
			$category = new CategoryOfArticle();
			$category->attributes = [
				'category_id' => $categoryId,
				'article_id' => $this->id
				];
            $category->save();
			
			$categoriesOfArticle[] = $category;
        }
		
		return $categoriesOfArticle;
	}
    /**
     * Check if article is ready to be published
     * @return bool
     */
    public function validateOnPublish()
    {
        $this->refresh();

        if (!$this->lang_original_id)
            $this->addError('lang_original_id', Yii::t('app', 'Original Language is not defined'));

        if (!$this->lang_translate_id)
            $this->addError('lang_translate_id', Yii::t('app', 'Translation Language is not defined'));

        if ($this->lang_original_id && $this->lang_translate_id && $this->lang_original_id == $this->lang_translate_id)
        {
            $this->addError('lang_original_id', Yii::t('app', 'Original and Translation Language must be different'));
            $this->addError('lang_translate_id', Yii::t('app', 'Original and Translation Language must be different'));
        }

        if (mb_strlen($this->title_original, 'utf-8') < 10)
            $this->addError('title_original', Yii::t('app', 'Original Title is too short'));

        if (mb_strlen($this->title_translate, 'utf-8') < 10)
            $this->addError('title_original', Yii::t('app', 'Translated Title is too short'));

        if ($this->url_original && !filter_var($this->url_original, FILTER_VALIDATE_URL))
            $this->addError('url_original', Yii::t('app', 'URL of Original Article is not valid'));

        if ($this->url_translate && !filter_var($this->url_translate, FILTER_VALIDATE_URL))
            $this->addError('url_translate', Yii::t('app', 'URL of Translated Article is not valid'));

        if ($this->author_name && mb_strlen($this->author_name, 'utf-8') < 4)
            $this->addError('author_name', Yii::t('app', 'Authors\' name is too short'));

        if ($this->translator_name && mb_strlen($this->translator_name, 'utf-8') < 4)
            $this->addError('translator_name', Yii::t('app', 'Translators\' name is too short'));

        if ($this->author_url && !filter_var($this->author_url, FILTER_VALIDATE_URL))
            $this->addError('author_url', Yii::t('app', 'URL of Author is not valid'));

        if ($this->translator_url && !filter_var($this->translator_url, FILTER_VALIDATE_URL))
            $this->addError('translator_url', Yii::t('app', 'URL of Translator is not valid'));

        if (count($this->paragraphs) < 3)
            $this->addError('paragraphs', Yii::t('app', 'Article is too short, add more paragraphs'));

        foreach($this->paragraphs as $paragraph)
        {
            if (mb_strlen($paragraph->paragraph_original, 'utf-8') < 10)
            {
                $this->addError('paragraphs', Yii::t('app', 'One or more paragraphs in original language is too short or empty, find and rewrite them'));
                break;
            }
            if (mb_strlen($paragraph->paragraph_translate, 'utf-8') < 10)
            {
                $this->addError('paragraphs', Yii::t('app', 'One or more translated paragraphs is too short or empty, find and rewrite them'));
                break;
            }
        }

        return !$this->hasErrors();
    }

    public static function getLanguageOrder()
    {
        return Yii::$app->request ? Yii::$app->request->getCookies()->getValue(self::LANGUAGE_ORDER_COOKIE, self::LANGUAGE_ORDER_ORIGINAL) : self::LANGUAGE_ORDER_ORIGINAL;
    }
}
