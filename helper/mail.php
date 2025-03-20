<?php

require('./phpMailer/phpMailer.php');
require('./phpMailer/SMTP.php');

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';

$body = $_POST['mensaje'];

$mail->IsSMTP();
$mail->Host       = 'smtp.ppcr.es';
$mail->Port       = 587;
$mail->SMTPDebug  = 1;
$mail->SMTPAuth   = true;
$mail->Username   = 'info@ppcr.es';
$mail->Password   = 'd+#Po)w{ve4jd-';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->SetFrom('info@ppcr.es', "ChechuParts");
$mail->AddReplyTo('no-reply@ppcr.es','no-reply');
$mail->Subject    = $_POST['asunto'];
$mail->MsgHTML($body);

$mail->AddAddress('jesusjulian.martin@stellantis.com', 'Jesús');

$mail->send();
?>