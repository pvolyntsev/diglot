<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Tag]].
 *
 * @see Tag
 */
class TagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
