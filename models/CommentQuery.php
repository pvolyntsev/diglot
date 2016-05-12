<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Comment]].
 *
 * @see Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
