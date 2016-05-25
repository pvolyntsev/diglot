<?php

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * SearchForm is the model behind the search form.
 */
class SearchForm extends Model
{
    public $query;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // query is required
            [['query'], 'required'],
        ];
    }
}
