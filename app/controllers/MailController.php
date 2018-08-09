<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailController
{
    public static function send($to, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try{
            //$mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'emailaddress4testingstuff@gmail.com';
            $mail->Password = 'pswd2email4testing';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('waldemar.jankowski95@gmail.com', 'admin');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'Aby wyswietlic ta wiadomosc, uzyj klienta poczty, ktory jest kompatybilny z HTML.';
            $mail->send();
            return true;
        }catch(Exception $e)
        {
            return false;
        }
        //return mail($to, $subject, $body, $headers);
    }


}