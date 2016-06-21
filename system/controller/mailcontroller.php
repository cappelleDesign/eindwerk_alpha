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
    
    
    private function getBody($template) {
        $base = Globals::getRoot('view', 'sys');        
        $content = file_get_contents($base . '/mail-templates/' .$template);
        return $content;
    }
}