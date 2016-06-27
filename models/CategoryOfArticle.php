<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "category_of_article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $article_id
 *
 * @property Category $category
 * @property Article $article
 */
class CategoryOfArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_of_article';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'article_id'], 'required'],
            [['category_id', 'article_id'], 'integer'],
            [['article_id', 'category_id'], 'unique', 'targetAttribute' => ['article_id', 'category_id'], 'message' => 'The combination of Category ID and Article ID has already been taken.'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'article_id' => 'Article ID',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
     * @return CategoryOfArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryOfArticleQuery(get_called_class());
    }
}
