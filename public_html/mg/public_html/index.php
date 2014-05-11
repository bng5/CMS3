<?php

require_once('../inc/iniciar.php');
header("Content-Type: text/html; charset=UTF-8");
$path = explode("/", $_SERVER['REDIRECT_URL']);

$idioma->id = 1;
$idioma->codigo = $idioma->cod = 'es';

$titulo_arr[] = SITIO_TITULO;

$portada = Publicacion_Seccion::obtener(10, $idioma->cod);

ob_start();

try {
	$seccion = Publicacion_Secciones::resolver($path[1], $idioma);
	@include('../plantillas/'.$seccion->identificador.'.php');
}
catch(Exception $e) {
	//var_dump($e);
	@include('../plantillas/error'.$e->getCode().'.php');
}

$contenido = ob_get_clean();

$secciones = Publicacion_Secciones::$secciones;

$sel_seccion[$seccion->id] = ' activo';
$sel_subseccion[$seccion->id] = ' class="activo"';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="es-uy" lang="es-uy">
<head>
 <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <title><?php echo implode(" - ", $titulo_arr); ?></title>
 <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="/js/jquery-1.4.2.min.js" charset="UTF-8"></script>
 <script type="text/javascript" src="/js/jquery.marquee.js"></script>
<?php

// <!-- script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/tooltip/jquery.dimensions.js"></script -->
echo $estilo;
echo $externos ? $externos : '
 <script type="text/javascript" src="/js/jquery.scrollTo-min.js"></script>
 <script type="text/javascript" src="/js/jquery.localscroll-min.js"></script>
 <script type="text/javascript" src="/js/jquery.tooltip.js"></script>
 <script type="text/javascript" src="/js/scroll.js"></script>
';

/*
  <script type="text/javascript">
// <![CDATA[

// ]]>
 </script>
*/
?>

</head>
<body>
<div id="contenedor">
	<div id="contenedor_encabezado">
		<div id="encabezado">
			<h1 id="logo"><a href="/home" title="<?php echo SITIO_TITULO; ?>">mg</a></h1>
			<div id="navegacion">
				<small><?php echo SITIO_TITULO; ?> Copyright 2010-<?php echo date("Y"); ?>&copy;</small>
				<div id="menu">
					<ul>
<?php

echo '
						<li class="estudio'.$sel_seccion[11].'"><a href="/'.$secciones[15]["urls"]["es"].'">'.$secciones[11]["nombres"]["es"].'</a>
							<p><a href="/'.$secciones[15]["urls"]["es"].'"'.$sel_subseccion[15].'>'.$secciones[15]["nombres"]["es"].'</a>, <a href="/'.$secciones[16]["urls"]["es"].'"'.$sel_subseccion[16].'>'.$secciones[16]["nombres"]["es"].'</a>, <br /><a href="/'.$secciones[17]["urls"]["es"].'"'.$sel_subseccion[17].'>'.$secciones[17]["nombres"]["es"].'</a></p></li>
						<li class="proyectos'.$sel_seccion[12].'"><a href="/'.$secciones[19]["urls"]["es"].'">'.$secciones[12]["nombres"]["es"].'</a>
							<p><a href="/'.$secciones[19]["urls"]["es"].'"'.$sel_subseccion[19].'>'.$secciones[19]["nombres"]["es"].'</a>, '; /*<a href="/'.$secciones[18]["urls"]["es"].'"'.$sel_subseccion[18].'>'.$secciones[18]["nombres"]["es"].'</a>, <br />*/ echo '<a href="/'.$secciones[21]["urls"]["es"].'"'.$sel_subseccion[21].'>'.$secciones[21]["nombres"]["es"].'</a>, <br /><a href="/'.$secciones[22]["urls"]["es"].'"'.$sel_subseccion[22].'>'.$secciones[22]["nombres"]["es"].'</a></p></li>
						<!-- li class="disenyo'.$sel_seccion[13].'"><a href="/'.$secciones[13]["urls"]["es"].'">'.$secciones[13]["nombres"]["es"].'</a></li -->';

?>
					</ul>
				</div>
				<div id="marquesina_cont">
					<!-- img alt="" src="/img/marquesina_bordeizq" id="marquesina_izq" class="borde" / -->
					<p id="marquesina"><?php echo $portada['valores'][25] ?></p>
					<!-- img alt="" src="/img/marquesina_bordeder" id="marquesina_der" class="borde" / -->
				</div>
				<?php echo '<p class="contacto'.$sel_seccion[14].'"><a href="/'.$secciones[14]["urls"]["es"].'">'.$secciones[14]["nombres"]["es"].'</a></p>'; ?>
			</div>
		</div>

		<?php

		echo $contenido;

		?>
	</div>
</div>
</body>
</html>