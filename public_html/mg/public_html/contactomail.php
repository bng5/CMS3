<?php

// comprueba si este script es accedido directamente
if(!defined('RUTA_CARPETA')) { //if(__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	require_once('../inc/iniciar.php');
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		header("Allow: POST", true, 405);
		exit("0");
	}
	$info = Publicacion_Seccion::obtener(14, 'es');
	$valores = $info['valores'];
}
else {// o incluído
	$retorno = true;
}

//$destinatarios = file(RUTA_CARPETA.'.emailcontacto');
$conf = include(RUTA_CARPETA.'bng5/datos/contacto.php');

/*
function arraytrim(&$valor) {
	$valor = trim($valor);
}
array_walk($destinatarios, 'arraytrim');
*/
$post = $_POST;
//if(!empty($_POST['__destinatario']) && in_array($_POST['__destinatario'], $conf['casillas']))
//	$email = $_POST['__destinatario'];
//else
//	$email = current($conf['casillas']);
$email = $valores[31];


$mail = new PHPMailer();
$mail->From     = "no-responder@".DOMINIO;//$_SERVER['SERVER_NAME'];
$mail->FromName = SITIO_TITULO;
$mail->Host     = "localhost";
$mail->CharSet  = "utf-8";
$mail->Mailer   = "mail";
$mail->AddAddress($email, $mail->FromName);
$mail->AddBCC('pablo@bng5.net');
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
<body>";
$txt_mensaje = "";

//$etiquetas = array();
//$retorno = $_POST['__retorno'];
//$clave_omitir = array("onLoad", "onData", "onHTTPStatus", "__destinatario", "__asunto", "__retorno");

$respuesta = new Respuesta;
foreach($conf['campos'] AS $campo_k => $campo_v) {
	if($campo_v['requerido'] && empty($_POST[$campo_k])) {
		$respuesta->campoError($campo_k, Respuesta::CAMPO_ERR_REQUERIDO);
		$errores = true;
	}
	elseif($campo_v['esTipo'] && !call_user_func($campo_v['esTipo'], $_POST[$campo_k])) {
		$respuesta->campoError($campo_k, Respuesta::CAMPO_ERR_TIPO_DATO);
		$errores = true;
	}
	else {
		if(isset($campo_v['bind'])) {
			switch($campo_v['bind']) {
				case Validacion::REMITENTE:
					$mail->AddReplyTo($_POST[$campo_k]);
					break;
				case Validacion::ASUNTO:
					$mail->Subject = empty($_POST[$campo_k]) ? "Sin asunto (".DOMINIO.")" : $_POST[$campo_k];
					break;
			}
		}
		$mensaje .= "<u>{$campo_v['etiqueta']}</u>: ".nl2br($_POST[$campo_k])."<br>\n";
		$txt_mensaje .= "{$campo_v['etiqueta']}: {$_POST[$campo_k]}\n";
	}
	unset($post[$campo_k]);
}
if(count($post))
	$respuesta->agregarIgnorados(array_keys($post));

if(!$errores) {
	//var_dump($respuesta->obtenerRespuesta());
	$mensaje .= "
	<br><br>
	<p style=\"color:#4C4C4C;font-size:small;\">Este correo fue enviado a través del formulario de contacto del sitio http://".DOMINIO."/.
	<br>
	IP del remitente: ".$_SERVER['REMOTE_ADDR']."</p>
</body>
</html>";

    file_put_contents('./ww/'.date("Y-m-d_His").'.html', $mensaje);
	$mail->Body    = $mensaje;
	$mail->AltBody = $txt_mensaje."\n\nEste correo fue enviado a través del formulario de contacto del sitio http://".DOMINIO."/.
	IP del remitente: ".$_SERVER['REMOTE_ADDR'];

	$enviado = $mail->Send();
	if(!$enviado) {
		$respuesta->agExcepcion(Respuesta::ERR_INTERNO);
	}
	elseif($retorno) {
			session_start();
			$_SESSION['enviado'] = true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit(' ');
	}
}

if(!$retorno) {
    header("Content-Type: application/json; charset=UTF-8");
	echo json_encode($respuesta->obtenerRespuesta());
}



//ob_start();
//echo "envio: ${envio}\n";
//echo "server\n";
//print_r($_SERVER);
//echo "destinatarios\n";
//print_r($destinatarios);
//echo "post\n";
//print_r($post);
//echo "get\n";
//print_r($_GET);
//echo "files\n";
//print_r($_FILES);
//$buffer = ob_get_contents();
//file_put_contents('./ww/'.time(), $buffer);
//ob_end_clean();


?>