<?php

/* Home */

/*$items = new Publicacion_Acceso_Items($seccion, $idioma);
$items->rpp = 1;
$items->ordenAleat = true;
$item = $items->obtenerListado()->getIterator()->fetch();*/

$externos = '
 <script src="/js/slide.js" type="text/javascript"></script>';


/*
<style type="text/css">
 .wrapper {
	width:2700px;
}
</style>
*/
?>


	</div>
	<div id="contenido">
		<div id="seccion" class="home">
			<div id="wrapper" class="wrapper">
<?php

$primera = true;
foreach($portada['valores'][32]['imagenes'] AS $img) {
	echo '
				<img src="/img/0/32/'.$img['archivo'].'" width="'.$img['ancho'].'" height="'.$img['alto'].'" alt="" '.($primera ? 'class="active"' : '').' />';
	$primera = false;
}

?>
			</div>
		</div>
	</div>
