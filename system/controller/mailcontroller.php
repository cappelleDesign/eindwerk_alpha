<?php

class MailController {

    public function mailContact($from, $to, $body) {
        $mail = new PHPMailer;
        $mail->setFrom($from);
        $mail->addReplyTo($from);
        $mail->addAddress($to);
        $mail->Subject = 'New contact mail';
        $message = $this->getBody('contact-template.html');
        $message = str_replace('%sender%', $from, $message);
        $message = str_replace('%body%', $body, $message);
        $mail->msgHTML($message);
        $send = $mail->send();
        return $send;
    }

    public function mailRegistration($userMail, $regkey) {
        $registerLink = Globals::getBasePath() . '/account/register-confirm/' . $userMail . '/' . $regkey;
        $mail = new PHPMailer;
        $mail->setFrom('info@neoludus.com');
        $mail->addReplyTo('no-reply@neoludus.com');
        $mail->addAddress($userMail);
        $mail->Subject = 'Neoludus registration';
        $message = $this->getBody('register-template.html');       
        $message = str_replace('%register%', $registerLink, $message);
        $mail->msgHTML($message);
        $send = $mail->send();
        ErrorLogger::logError($mail->ErrorInfo);
        return $send;
    }

    private function getBody($template) {
        $base = Globals::getRoot('view', 'sys');
        $content = file_get_contents($base . '/mail-templates/' . $template);
        return $content;
    }

}
