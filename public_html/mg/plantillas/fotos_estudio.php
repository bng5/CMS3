<?php
/* Fotos del Estudio */
array_unshift($titulo_arr, $seccion->nombres[$idioma->cod]);

$info = Publicacion_Seccion::obtener($seccion->id, $idioma->cod);
$valores = $info['valores'];

?>


		<div id="nav">
			<h2><?php echo $seccion->nombres[$idioma->cod] ?></h2>
<?php
/*
			<!-- ul id="indice">
				<li><a href="#estudio">Estudio</a></li>
				<li><a href="#Carla_Quijano">Carla Quijano</a></li>
				<li><a href="#Susan_Sarandon">Susan Sarandon</a></li>
			</ul -->
*/
?>
		</div>
	</div>
	<div id="contenido">
		<div id="seccion" class="fotos_estudio">
			<div id="wrapper" class="wrapper">
<?php

$ancho = 0;
foreach($valores[5]['imagenes'] AS $imagen) {
	echo '
				<img src="/img/0/5/'.$imagen['archivo'].'" width="'.$imagen['ancho'].'" height="'.$imagen['alto'].'" alt="" />';
	$ancho += ($imagen['ancho'] + 13);
}

$estilo = '
<style type="text/css">
.wrapper {
	width:'.$ancho.'px;
}
</style>';

?>
			</div>
		</div>
