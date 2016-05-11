<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CategoryOfArticle]].
 *
 * @see CategoryOfArticle
 */
class CategoryOfArticleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CategoryOfArticle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CategoryOfArticle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
