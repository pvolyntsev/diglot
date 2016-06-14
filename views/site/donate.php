<?php
/**
 * Шаблон для app\controllers\actions\ArticleViewAction
 */

use yii\helpers\Html;
use app\models\Article;
use app\widgets\ParagraphWidget;

/* @see app\controllers\actions\ArticleViewAction */
/* @var $this yii\web\View */
/* @var $error bool */
/* @var $message string */
/* @var $sample array */
/* @var $article Article */

$paragraphMode = ParagraphWidget::MODE_FULL;
$articleLink = null; //['article/view', 'id' => $model->id];
?>

<div class="container article-view">

<?php if (!empty($error)) { ?>
    <h2><?php echo $title ?></h2>
    <br/>

    <p><?php echo $message ?></p>

    <p><?php echo $sample['file'] ?></p>
    <pre>&lt;?php
return <?php var_export($sample['code']) ?>;</pre>

<?php } else { ?>
<?php  /*
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
        <input type="image" src="https://www.paypalobjects.com/ru_RU/RU/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — более безопасный и легкий способ оплаты через Интернет!">
        <img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
    </form>


    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_donations">
        <input type="hidden" name="business" value="paypal@webmentor.pro">
        <input type="hidden" name="lc" value="GB">
        <input type="hidden" name="item_name" value="Diglot Service">
        <input type="hidden" name="item_number" value="One-time donation">
        <select name="amount">
            <option value="2">$2</option>
            <option value="5">$5</option>
            <option value="10">$10</option>
        </select>
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
        <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
    </form>

*/ ?>
    <div class="row article-heading">
        <div class="col col-md-6 article-heading-title-translate">
            <h1><?php echo $article->title_translate ?>
                <span class="label"><?php echo $article->langTranslate->language ?></span>
            </h1>
        </div>
        <div class="col col-md-6 article-heading-title-original">
            <h1><?php echo $article->title_original ?>
                <span class="label"><?php echo $article->langOriginal->language ?></span>
            </h1>
        </div>
    </div>

    <?php foreach($article->paragraphs as $paragraph) { ?>
        <div class="row article-paragraph">
            <?php echo ParagraphWidget::widget(['paragraph' => $paragraph, 'mode' => $paragraphMode, 'link' => $articleLink]) ?>
        </div>
    <?php } ?>


    <h2 class="align center">Your donation</h2>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4 align center">
            <h4><a href="https://www.paypal.com/">PayPal</a></h4>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <table><tr valign="top">
                    <td>
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="business" value="paypal@webmentor.pro">
                        <input type="hidden" name="lc" value="GB">
                        <input type="hidden" name="item_name" value="Diglot Service">
                        <input type="hidden" name="item_number" value="One-time donation">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
                        <select name="amount" style="font-size: 20px;">
                            <option value="2">$2</option>
                            <option value="5">$5</option>
                            <option value="10">$10</option>
                        </select>
                    </td><td>
                        <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
                        <br/>
                        <img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
                    </td>
                </tr></table>
            </form>
        </div>

        <div class="col-md-4 align center">
            <h4><a href="https://money.yandex.ru">Яндекс Деньги</a></h4>
            <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=41001295812918&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=100&targets=Service+Support+Donation&target-visibility=on&project-name=Diglot&project-site=http%3A%2F%2Fdiglot.ru%2F&button-text=01&mail=on&phone=on&successURL=http%3A%2F%2Fdiglot.ru%2Fdonate" width="522" height="117"></iframe>
        </div>
    </div>

<?php } ?>

</div> <!-- /.container -->