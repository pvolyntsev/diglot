<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Article;
use app\models\Paragraph;
use kartik\markdown\Markdown;

class ParagraphWidget extends Widget
{
    const MODE_FULL = 'full';

    const MODE_COMPACT = 'compact';

    const MEDIA_IMAGE = 'image';

    const OUTPUT_FORMAT_HTML = 'html';

    const OUTPUT_FORMAT_RSS = 'rss';

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
     * @var string
     */
    public $outputFormat = self::OUTPUT_FORMAT_HTML;

    /**
     * Renders the widget.
     */
    public function run()
    {
        $html = '';

        $paragraphOriginal = $this->decodeMediaObject($this->paragraph->paragraph_original);
        $paragraphTranslate = $this->decodeMediaObject($this->paragraph->paragraph_translate);

        if (is_array($paragraphOriginal) && is_array($paragraphTranslate)
            && $paragraphOriginal['media'] == $paragraphTranslate['media']
            && $paragraphOriginal['src'] == $paragraphTranslate['src'])
        {
            $paragraphHTML = '<p>' . $this->formatMediaObject($paragraphOriginal, $this->link) . '</p>';
            if (self::OUTPUT_FORMAT_RSS == $this->outputFormat)
                $html .= $paragraphHTML;
            else
                $html .= '<div class="col col-md-12 wide-media">' . $paragraphHTML . '</div>';

        } else
        {
            $paragraphOriginalHTML = $this->formatMediaObject($paragraphOriginal, $this->link);
            $paragraphTranslateHTML = $this->formatMediaObject($paragraphTranslate, $this->link);
            
            $langOrder = Article::getLanguageOrder();
            if (Article::LANGUAGE_ORDER_ORIGINAL == $langOrder)
            {
                if (self::OUTPUT_FORMAT_RSS == $this->outputFormat)
                    $html .= $paragraphOriginalHTML . '<br/><br/>' . $paragraphTranslateHTML;
                else
                    $html .=
                        '<div class="col col-md-6 article-paragraph-original">' . $paragraphOriginalHTML . '</div>'
                        . '<div class="col col-md-6 article-paragraph-translate">' . $paragraphTranslateHTML . '</div>';
            } else
            {
                if (self::OUTPUT_FORMAT_RSS == $this->outputFormat)
                    $html .= $paragraphTranslateHTML . '<br/><br/>' . $paragraphOriginalHTML;
                else
                    $html .=
                        '<div class="col col-md-6 article-paragraph-translate">' . $paragraphTranslateHTML . '</div>'
                        . '<div class="col col-md-6 article-paragraph-original">' . $paragraphOriginalHTML . '</div>';
            }
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
                    return '<img src="' . Url::to($object['src'], true) . '" />';
            }
            return '<!-- wrong media -->';
        }

        if ('<code>'===substr($object, 0, 6))
            $object = '<pre class="code">' . $object . '</pre>';
        elseif (!preg_match('/^\<(ul|ol|dl|table|blockquote)/', $object))
            $object = Markdown::convert($object);

        if (self::MODE_COMPACT == $this->mode)
        {
            $text = mb_substr(strip_tags($object), 0, $this->length, 'utf-8') . (mb_strlen($object > $this->length) ? '...' : '');
            $object = '<p>' . ($link ? Html::a($text, $link) : $text) . '</p>';
        }

        return $object;
    }
}