<?php
/* Contacto */


$info = Publicacion_Seccion::obtener($seccion->id, $idioma->cod);
$valores = $info['valores'];

$aviso = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	include('contactomail.php');
	$respuestaStd = $respuesta->obtenerRespuesta();

	$textosBind['mensaje'][1] = 22;
	$textosBind['email'][1] = 23;
	$textosBind['email'][2] = 24;
	if(isset($respuestaStd->errores)) {
		foreach($respuestaStd->errores AS $k => $v) {
			if(isset($avisoArr[$v['cod']]))
				$avisoArr[$v['cod']] = '<em>'.$valores[25].'</em>';
			else {
				$avisoArr[$v['cod']] = '<em>'.$valores[$textosBind[$k][$v['cod']]].'</em>';
			}
		}
		$aviso = implode("\n", $avisoArr);
	}
	else
		$aviso = $valores[26];
}
else {
	session_start();
	if($_SESSION['enviado']) {
		unset($_SESSION['enviado']);
		$aviso = $valores[21];
	}
}

/*
array(1) {
  ["valores"]=>  array(13) {
    [12]=>    array(9) {
      ["mime"]=>      string(10) "image/jpeg"
      ["peso"]=>      string(5) "23376"
      ["ancho"]=>      string(3) "328"
      ["alto"]=>      string(3) "436"
      ["archivo"]=>      string(15) "calleKLkCIZ.jpg"
      ["miniatura"]=>      string(15) "calleKLkCIZ.jpg"
      ["ancho_m"]=>      string(2) "40"
      ["alto_m"]=>      string(2) "40"
      ["peso_m"]=>      string(4) "1212"
    }
    [13]=>    string(142) "Avda. 1º de Mayo 27 - Bajo
35002 Las Palmas de G.C.
Gran Canaria - España

Tel. 928 38 16 16
Fax. 928 000 000
info@malelegutierrez.com"
    [14]=>    string(6) "Nombre"
    [15]=>    string(5) "Email"
    [16]=>    string(6) "Asunto"
    [17]=>    string(7) "Mensaje"
    [18]=>    string(6) "Enviar"
    [19]=>    string(15) "Mensaje enviado"
    [20]=>    string(25) "Complete el campo mensaje"
    [21]=>    string(24) "Complete el campo E-mail"
    [22]=>    string(34) "La casilla de correo no es válida"
    [23]=>    string(30) "Complete los campos requeridos"
    [24]=>    string(32) "No fue posible enviar el mensaje"
  }
}

 */

array_unshift($titulo_arr, $seccion->nombres[$idioma->cod]);
$img = $valores[12];
$externos = '
 <script src="http://maps.google.com/maps/api/js?sensor=false&amp;language=es&amp;key=ABQIAAAAEzFijfGoZXYF0MQaE50SshQCXHas9l_1FYl7J4BfkN7Hxd9UsxQnOghM71Ip9DyrULyeSS6jZeOabw" type="text/javascript"></script>
 <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
 <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
 <script src="/js/contacto.js" type="text/javascript"></script>
<script type="text/javascript">
// <![CDATA[
Textos[\'enviado\'] = \''.$valores[19].'\';
Textos[\'error\'] = \''.$valores[24].'\';
Textos[\'mensaje\'][ValidacionCampo.CAMPO_ERR_REQUERIDO] = \''.$valores[20].'\';
Textos[\'email\'][ValidacionCampo.CAMPO_ERR_TIPO_DATO] = \''.$valores[22].'\';
Textos[\'email\'][ValidacionCampo.CAMPO_ERR_REQUERIDO] = \''.$valores[21].'\';
Textos[ValidacionCampo.CAMPO_ERR_REQUERIDO] = \''.$valores[23].'\';
// ]]>
</script>
';
////<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAEzFijfGoZXYF0MQaE50SshTBjTjwjuOd6NDrKzpTho95zR-AABTdDc2KVosGexxnPErhyfSqru6kjQ" type="text/javascript"></script>

?>

		<div id="nav">
			<h2><?php echo $seccion->nombres[$idioma->cod] ?></h2>
		</div>
	</div>
	<div id="contenido">
		<div id="seccion">
			<div id="wrapper" class="wrapper">
				<div id="imagen">
					<img src="/img/0/12/<?php echo $img['archivo'] ?>" alt="" />
				</div>
				<div class="formulario">
					<address class="adr"><?php echo $valores[13] ?></address>
					<div id="ver_mapa"><a href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=28.105033,-15.419464&amp;sll=28.105024,-15.419481&amp;sspn=0.010126,0.01929&amp;doflg=ptk&amp;ie=UTF8&amp;z=16">ver mapa</a></div>
					<form id="form_contacto" action="/<?php echo $seccion->urls[$idioma->codigo] ?>" method="post">
						<div id="campos">
							<p><label for="nombre"><?php echo $valores[14] ?></label> <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_POST['nombre']) ?>" /></p>
							<p><label for="email"><?php echo $valores[15] ?></label> <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email']) ?>" <?php if(isset($respuestaStd->errores['email'])) echo 'class="error"'; ?> /></p>
							<p><label for="__asunto"><?php echo $valores[16] ?></label> <input type="text" id="__asunto" name="__asunto" value="<?php echo htmlspecialchars($_POST['__asunto']) ?>" /></p>
							<p><label for="mensaje"><?php echo $valores[17] ?></label> <textarea id="mensaje" name="mensaje" cols="20" rows="6" <?php echo (isset($respuestaStd->errores['mensaje']) ? 'class="error"' : '') ?>><?php echo htmlspecialchars($_POST['mensaje']) ?></textarea></p>
						</div>
						<div id="envio">
							<p id="aviso" <?php if(isset($respuestaStd->exito) && $respuestaStd->exito == false) echo 'class="error"'; ?>><?php echo $aviso ?> </p>
							<button type="submit" name="enviar" id="enviar"><?php echo $valores[18] ?></button>
						</div>
					</form>
				</div>
				<div id="map_canvas" style="width:100%;height:100%;display:none;"></div>
			</div>
		</div>
