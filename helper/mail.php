<?php

require('./phpMailer/phpMailer.php');
require('./phpMailer/SMTP.php');
//require('./phpMailer/OAuth.php');
//require('./phpMailer/OAuthTokenProvider.php');

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';

$body = 'Cuerpo del correo de prueba';

$mail->IsSMTP();
$mail->Host       = 'ppcr.es';
$mail->SMTPSecure = 'tls';
$mail->Port       = 993;
$mail->SMTPDebug  = 1;
$mail->SMTPAuth   = true;
$mail->Username   = 'test@ppcr.es';
$mail->Password   = 'Sd32391Laguna*';
$mail->SMTPOptions = [
  'ssl' => [
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true,
  ]
];
$mail->SetFrom('test@ppcr.es', "Chechu");
$mail->AddReplyTo('no-reply@mycomp.com','no-reply');
$mail->Subject    = 'Correo de prueba PHPMailer';
$mail->MsgHTML($body);

$mail->AddAddress('jjchechu@hotmail.com', 'Jesús');
$mail->send();
?>