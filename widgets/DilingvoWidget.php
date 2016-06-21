<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\Article;

class DilingvoWidget extends Widget
{
    protected $_original;

    protected $_translation;

    public function beginOriginal()
    {
        ob_start();
    }

    public function endOriginal()
    {
        $this->_original = ob_get_clean();
    }

    public function beginTranslation()
    {
        ob_start();
    }

    public function endTranslation()
    {
        $this->_translation = ob_get_clean();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $langOrder = Article::getLanguageOrder();
        if (Article::LANGUAGE_ORDER_ORIGINAL == $langOrder)
        {
            $html = $this->_original . $this->_translation;
        } else
        {
            $html = $this->_translation . $this->_original;
        }

        return $html;
    }
}