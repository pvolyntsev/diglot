<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ComplaintOnArticle]].
 *
 * @see ComplaintOnArticle
 */
class ComplaintOnArticleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ComplaintOnArticle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ComplaintOnArticle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
