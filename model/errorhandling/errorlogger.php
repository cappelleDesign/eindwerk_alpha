<?php

require dirname(__FILE__) . '/../plugins/PHPMailer-master/PHPMailerAutoLoad.php';

class ErrorLogger {

    public static function getLogLocation() {
        return dirname(__FILE__) . '/error.LOG';
    }

    public static function getDate() {
        return '[' . date('d-m-Y H:i:s') . ']';
    }

    public static function logError($error) {
        error_log(ErrorLogger::getDate() . PHP_EOL . var_export($error, true) . PHP_EOL, 3, ErrorLogger::getLogLocation());
        ErrorLogger::sendMail($error);
    }

    public static function testStuff($stuff) {
        error_log($stuff, 3, ErrorLogger::getLogLocation());
    }

    public static function sendMail($error) {
        $errorMessage = $error->getMessage();
        $mail = new PHPMailer;
        $mail->setFrom('faraoadmin@localhost.be', 'Farao Admin');
        $mail->addAddress('faraoadmin@localhost.be', 'Farao Admin');
        $mail->Subject = $errorMessage;
        $mail->Body = var_export($error, true);
        $mail->AltBody = 'Uw email client blijkt verouderd';

        if (!$mail->send()) {
            ErrorLogger::testStuff(PHP_EOL . 'Mail was not send' . PHP_EOL);
        } else {
            ErrorLogger::testStuff(PHP_EOL . 'Mail was send' . PHP_EOL);
        }
    }

}
