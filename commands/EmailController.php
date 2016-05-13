<?php

namespace app\commands;

use yii\console\Controller;

class EmailController extends Controller
{
    /**
     * The email subject
     * @var string
     */
    public $subject = 'Test Email Message';

    /**
     * The email message
     * @var string
     */
    public $message = 'Hello, World!';

    /**
     * The target email address to send message
     * @var string
     */
    public $to = '';

    public function options($actionID)
    {
        switch($actionID)
        {
            case 'send-test':
                return [
                    'subject',
                    'message',
                    'to'
                ];
        }
    }

//    public function optionAliases()
//    {
//        return ['m' => 'message'];
//    }

    /**
     * This command sends message to email
     * @param string $subject the email subject
     * @param string $message the email message
     * @param string $to the email address to send message
     */
    public function actionSendTest()
    {
        if (empty($this->subject))
        {
            echo 'Error: subject not set', PHP_EOL;
            echo 'php yii email/send-test --subject="Email Subject"';
            return 1;
        }
        if (empty($this->message))
        {
            echo 'Error: message not set', PHP_EOL;
            echo 'php yii email/send-test --message="Email Subject"';
            return 2;
        }

        if (empty($this->to))
        {
            echo 'Error: email address not set', PHP_EOL;
            echo 'php yii email/send-test --to="your@email.com"';
            return 3;
        }


        \Yii::$app->mailer->compose([ 'text' => '/mail/simple-text' ], [
                'from' => \Yii::$app->params['supportEmail'],
                'to' => $this->to,
                'subject' => $this->subject,
                'message' => $this->message
            ])
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->send();

        echo 'Email was sent', PHP_EOL;
        return 0;
    }
}
