<?php

define("SITIO_TITULO", "Malele Gutierrez Decoración");
define("RUTA_CARPETA", "/home/malelegutierrezdecoracion.com/");
define("DOMINIO", "malelegutierrezdecoracion.com");

require_once(RUTA_CARPETA.'bng5/clases/PHPMailer.php');

$mail = new PHPMailer();

$mail->From     = "no-responder@".DOMINIO;//$_SERVER['SERVER_NAME'];
$mail->FromName = SITIO_TITULO;
$mail->Host     = "localhost";
$mail->CharSet  = "utf-8";
$mail->Mailer   = "mail";
$mail->AddAddress('pablo@bng5.net', 'Bng5');
$mail->AddBCC('pablobngs@gmail.com');
//$mail->SMTPAuth = true;
//$mail->Username = $mail->From;
//$mail->Password = "{h,90W{&m+~l";

//$mail->Sendmail = '/usr/sbin/sendmail -t -i';
$mail->Subject = "Formulario de contacto en ".SITIO_TITULO;

$mensaje = "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>{$mail->Subject}</title>
<style type=\"text/css\">
body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;}
</style>
</head>
<body>
	<br><br>
	<p style=\"color:#4C4C4C;font-size:small;\">Este correo fue enviado a través del formulario de contacto del sitio http://".DOMINIO."/.
	<br>
	IP del remitente: ".$_SERVER['REMOTE_ADDR']."</p>
</body>
</html>";

$mail->Body    = $mensaje;
$mail->AltBody = "Texto alternativo\n\nEste correo fue enviado a través del formulario de contacto del sitio http://".DOMINIO."/.
	IP del remitente: ".$_SERVER['REMOTE_ADDR'];

$enviado = $mail->Send();
var_dump($enviado);


?>