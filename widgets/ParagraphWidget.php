<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\User;
use app\models\Article;
use app\models\Paragraph;
use kartik\markdown\Markdown;

class ParagraphWidget extends Widget
{
    const MODE_FULL = 'full';

    const MODE_COMPACT = 'compact';

    const MEDIA_IMAGE = 'image';

    /** @var Paragraph */
    public $paragraph;

    /**
     * @var string
     */
    public $mode = self::MODE_FULL;

    /** @var null|string|array */
    public $link;

    /**
     * @var int
     */
    public $length = 80;

    /**
     * Renders the widget.
     */
    public function run()
    {
        $html = '';

        $paragraph_original = $this->decodeMediaObject($this->paragraph->paragraph_original);
        $paragraph_translate = $this->decodeMediaObject($this->paragraph->paragraph_translate);

        if (is_array($paragraph_original) && is_array($paragraph_translate)
            && $paragraph_original['media'] == $paragraph_translate['media']
            && $paragraph_original['src'] == $paragraph_translate['src'])
        {
            $html .= '<div class="col col-md-12 wide-media">'
                    . '<p>' . $this->formatMediaObject($paragraph_original, $this->link) . '</p>'
                    . '</div>';
        } else
        {
            $html .= '<div class="col col-md-6 article-paragraph-translate">';
            $html .= $this->formatMediaObject($paragraph_translate, $this->link);
            $html .= '</div>';
            $html .= '<div class="col col-md-6 article-paragraph-original">';
            $html .= $this->formatMediaObject($paragraph_original, $this->link);
            $html .= '</div>';
        }

        return $html;
    }

    protected function decodeMediaObject($object)
    {
        if ('{{' == substr($object, 0, 2)
            &&
            '}}' == substr($object, -2, 2)
        )
        {
            $decoded = json_decode(substr($object, 1, -1), true);
            if (false!==$decoded)
                $object = $decoded;
            else
                $object .= '<!-- can\'t decode media -->';
        }
        return $object;
    }

    protected function formatMediaObject($object, $link = null)
    {
        if (is_array($object))
        {
            switch($object['media'])
            {
                case self::MEDIA_IMAGE:
                    return '<img src="' . $object['src'] . '" />';
            }
            return '<!-- wrong media -->';
        }

        if ('<code>'===substr($object, 0, 6))
            $object = '<pre class="code">' . $object . '</pre>';
        elseif (!preg_match('/^\<(ul|ol|dl|table|blockquote)/', $object))
            $object = Markdown::convert($object); //'<p>' . $object . '</p>';

        if (self::MODE_COMPACT == $this->mode)
        {
            $text = mb_substr(strip_tags($object), 0, $this->length, 'utf-8') . (mb_strlen($object > $this->length) ? '...' : '');
            $object = '<p>' . ($link ? Html::a($text, $link) : $text) . '</p>';
        }

        return $object;
    }
}