<?php
require "../../../../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendmail($email,$body){


    $mail = new PHPMailer(true);
    $mail->SMTPDebug=2;
    $mail->isSMTP();
    $mail->Host = '172.31.255.82';
    $mail->SMTPAuth = false;
    $mail->Username = 'jcosta@prosecure.com';
    $mail->Port = 25;
    $mail->SMTPAutoTLS = false;
    $mail->setFrom('alert@prosecure.com', 'ATTENTION');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Payment infos changed';
    $mail->Body = $bodyl;

    if ($mail->Send()) {
        return "Success send mail";
    } else {
        return "Err";
    }
}
?>