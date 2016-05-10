<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TagOfArticle]].
 *
 * @see TagOfArticle
 */
class TagOfArticleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TagOfArticle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TagOfArticle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
