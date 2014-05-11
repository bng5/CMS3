<?php

/* Locales Comerciales
 */

array_unshift($titulo_arr, $seccion->nombres[$idioma->cod]);

if($_GET['id'] && $item = @include(RUTA_CARPETA.'bng5/datos/item/'.$_GET['id'].'.'.$idioma->cod.'.php')) {
	$estilo = '';
	array_unshift($titulo_arr, $item["valores"][6]);
	$ref = (intval($_GET['ref']) ? intval($_GET['ref']) : $item['orden']);
	$k = (($ref-1)%3) + 1;
	$num = sprintf("%02d", $ref);

	echo '
			<div id="nav">
				<h2>'.$seccion->nombres[$idioma->cod].'</h2>
			</div>
		</div>
		<div id="contenido">
			<div id="seccion" class="proyectos">
				<div id="wrapper" class="wrapper">
					<div class="ampliacion">
						<div class="ol"><span class="d'.$num[0].'"></span><span class="u'.$num[1].'"></span><span class="simb s'.$k.'"></span></div>
						<h3>'.$item["valores"][6].'</h3>
						<!-- span class="estrellas "></span -->
						<p class="ubicacion">'.$item["valores"][11].'

'.$item["valores"][9].'</p>
						<div class="descripcion">'.$item["valores"][8].'<br/><span class="volver"><a href="/'.$seccion->urls['es'].'?pag='.ceil($ref/12).'">&lt; Volver</a></span></div>

					</div>
					<div class="imagenes">';
	$ancho = 370;
	foreach($item["valores"][10]["imagenes"] AS $img) {
		echo '<img src="/img/0/10/'.$img['archivo'].'" width="'.$img['ancho'].'" height="'.$img['alto'].'" alt="" />';
		$ancho += ($img['ancho'] + 11);
	}
	echo '
					</div>
				</div>
			</div>
		</div>';
}
else {
	$params = new Parametros_PublicacionItems($seccion, $idioma);
	$params->rpp = 12;
	$params->pagina = intval($_GET['pag']) ? intval($_GET['pag']) : 1;
	$items = Publicacion_Items::obtener($params);

	$desde = (($items->pagina - 1) * $items->rpp);
	$hasta = $desde + $items->rpp;

	$hasta = ($hasta <= $items->total) ? $hasta : $items->total;

	$ancho = 444 * ($hasta - $desde);
	$desde++;

	$estilo = '
<script type="text/javascript">
var currentPagina = '.$items->pagina.';
var rpp = '.$items->rpp.';
var total = '.$items->total.';
var paginas = Math.ceil(total / rpp);
</script>';

?>

		<div id="nav">
			<h2><?php echo $seccion->nombres[$idioma->cod] ?></h2>
			<ul id="indice"><li class="paginado"><a id="anterior" <?php echo ($items->pagina == 1 ? 'class="activo" href="#"' : 'href="/'.$seccion->urls['es'].'?pag='.($items->pagina-1).'"') ?>>Anterior</a></li><?php

	$k = 1;
	$i = $desde;
	$items_txt = '';
	//for($i = $desde; $i <= $hasta ; $i++) {
	foreach($items AS $item) {
		//$item = $lista[$k];
		$num = sprintf("%02d", $i);
		echo '<li class="ancla"><a href="#'.$num.'">'.$num.'<span class="titulo"> '.$item["string__titulo"].'</span></a></li>';

		$img = unserialize($item["img__imagen"]);
		$items_txt .= '<div class="item">
					<div class="ol"><span class="d'.$num[0].'"></span><span class="u'.$num[1].'"></span><span class="simb s'.$k.'"></span></div>
					<h3><a name="'.$num.'" href="/'.$seccion->urls[$idioma->cod].'?id='.$item['id'].'&amp;ref='.$i.'">'.$item["string__titulo"].'</a></h3>
					<p>'.$item["string__ubicacion"].'

'.$item["string__anyo"].'</p>
					<a href="/'.$seccion->urls[$idioma->cod].'?id='.$item['id'].'&amp;ref='.$i.'"><img src="/img/0/'.$img[0].'/'.$img[1].'" alt="" /></a>
				</div>';
		$i++;
		$k++;
		if($k > 3)
			$k = 1;
	}
?><li class="paginado"><a id="siguiente" <?php echo ($items->pagina == $items->paginas ? 'class="activo" href="#"' : 'href="/'.$seccion->urls['es'].'?pag='.($items->pagina+1).'"') ?>>Siguiente</a></li></ul>
		</div>
	</div>
	<div id="contenido">
		<div id="seccion" class="proyectos">
			<div id="wrapper" class="wrapper"><?php echo $items_txt; ?></div>
		</div>
<?php

}

$estilo .= '
<style type="text/css">
 .wrapper {
	width:'.$ancho.'px;
}
</style>';

?>