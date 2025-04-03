<?php

require('../helper/phpMailer/phpMailer.php');
require('../helper/phpMailer/SMTP.php');

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$head = "<head>
    <title>Recuperación de contraseña - ChechuParts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px;
        }
        .header img {
            max-width: 100%;
            height: auto;
        }
        .content {
            margin-top: 20px;
        }
        .content h1 {
            color: #333;
        }
        .content p {
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .header img {
                width: 80%;
            }
        }
        @media (max-width: 400px) {
            .button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>";
$body = "<body>
  <div class='container'>
    <div class='header'>
      <img src='https://ppcr.es/img/Logo-PPCR-2022.png' alt='ChechuParts'>
    </div>
    <div class='content'>
      <h1>Recuperación de contraseña</h1>
      <p>Hemos enviado su contraseña a la dirección de correo electrónico <strong>".$_POST['mail']."</strong>.</p>
      <p>Esta es la clave de recuperación de contrseña:</p>
      <p><strong><font size='8'>" .$_POST['key'] ."</font></strong></p>
      <a href='https://www.ppcr.es/recuperarPass2.php?mail=".$_POST['mail']."' class='button'>Ir a la página de inicio de sesión</a>
    </div>
    <div class='footer'>
      ChechuParts &copy; 2022
    </div>
  </div>
</body>";

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
$mail->Subject    = 'Recuperación de contraseña de ChechuParts'; //$_POST['asunto'];
$mail->MsgHTML($head.$body);

$mail->AddAddress($_POST['mail'], 'NewUser');

$mail->send();
?>