<?php namespace denvers;

require_once( dirname(__FILE__) . "/vendor/autoload.php" );

/**
 * Class Reporter
 */
class Reporter
{
    /**
     * @param $emailaddress
     * @param $subject
     * @param $message
     */
    public static function report($emailaddress, $subject, $message)
    {
        $message .= "\n\n";
        $message .= "_REQUEST:\n";
        $message .= print_r( $_REQUEST, true );

        $message .= "\n\n";
        $message .= "_SERVER:\n";
        $message .= print_r( $_SERVER, true );

        $mail = new Zend_Mail();
        $mail->setBodyText($message);
        $mail->setBodyHtml(nl2br($message));
        $mail->setFrom('noreply@denvers-reporter.com', 'Reporter');
        $mail->addTo($emailaddress);
        $mail->setSubject($subject);
        $mail->send();
    }
}