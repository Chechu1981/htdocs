<?php

require('./phpMailer/phpMailer.php');
require('./phpMailer/SMTP.php');

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$firma = "<div style='background-color: blue'>
            <p style='color: white'>Este mensaje ha sido enviado desde la web de ChechuParts</p>
        </div>";
$mensaje = 'Hola Mundo';//$_POST['mensaje'];
$body = "<div style='background-color: blue'>
            <h1 style='color: white'>Mensaje de ChechuParts</h1>
            <p style='color: white'>$mensaje</p>
        </div>$firma";

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
$mail->SetFrom('info@ppcr.es', 'ChechuParts');
$mail->AddReplyTo('no-reply@ppcr.es','no-reply');
$mail->Subject    = 'Asunto de prueba'; //$_POST['asunto'];
$mail->MsgHTML($body);

$mail->AddAddress('jesusjulian.martin@stellantis.com', 'Jesús');

$mail->send();
?>