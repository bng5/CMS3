<?php
/* Diseño */

array_unshift($titulo_arr, $seccion->nombres[$idioma->cod]);

$params = new Parametros_PublicacionItems($seccion, $idioma);
$params->rpp = 12;
$params->pagina = intval($_GET['pag']) ? intval($_GET['pag']) : 1;
$items = Publicacion_Items::obtener($params);

$desde = (($items->pagina - 1) * $items->rpp);
$hasta = $desde + $items->rpp;

$hasta = ($hasta <= $items->total) ? $hasta : $items->total;

$ancho = 0;
$desde++;

?>

		<div id="nav">
			<h2><?php echo $seccion->nombres[$idioma->cod]; ?></h2>
			<ul id="indice"><?php
	if($items->paginas > 1) {
		echo '<li class="paginado"><a id="anterior" '.($items->pagina == 1 ? 'class="activo" href="#"' : 'href="/'.$seccion->urls['es'].'?pag='.($items->pagina-1).'"').'>Anterior</a></li>';
	}

	$k = 1;
	$i = $desde;
	$items_txt = '';
	//for($i = $desde; $i <= $hasta ; $i++) {
	foreach($items AS $item) {
		//$item = $lista[$k];
		$num = sprintf("%02d", $i);
		echo '<li class="ancla"><a href="#'.$num.'">'.$num.'<span class="titulo"> '.$item["string__titulo"].'</span></a></li>';

		$ancho += 334;
		if($item["img__img_disen1"]) {
			$img1 = unserialize($item["img__img_disen1"]);
			$ancho += $img1[4] + 4;
		}
		if($item["img__img_disen2"]) {
			$img2 = unserialize($item["img__img_disen2"]);
			$ancho += $img2[4] + 4;
		}
		$items_txt .= '
				<div class="item">
					<div class="descripcion">
						<h3><a name="'.$num.'">'.$item['string__titulo'].'</a></h3>
						<span class="anyo">'.$item['string__anyo'].'</span>
						<p>'.$item['text__descripcion'].'</p>
					</div>
					<div class="imagenes">
						<img src="/img/0/'.$img1[0].'/'.$img1[1].'" alt="" />
						<img src="/img/0/'.$img2[0].'/'.$img2[1].'" alt="" />
					</div>
				</div>';
		$i++;
		$k++;
		if($k > 3)
			$k = 1;
	}

$estilo = '
<style type="text/css">
 .wrapper {
	width:'.$ancho.'px;
}
</style>';

if($items->paginas > 1) {
	echo '<li class="paginado"><a id="siguiente" '.($items->pagina == $items->paginas ? 'class="activo" href="#"' : 'href="/'.$seccion->urls['es'].'?pag='.($items->pagina+1).'"').'>Siguiente</a></li>';
}
?>
<!-- li class="ancla"><a href="#silla_americana">Silla Americana</a></li><li class="ancla"><a href="#mueble_flotante">Mueble Flotante</a></li><li class="ancla"><a href="#silla_americana2">Silla Americana</a></li><li class="ancla"><a href="#mueble_flotante2">Mueble Flotante</a></li --></ul>
		</div>
	</div>
	<div id="contenido">
		<div id="seccion" class="disenyo">
			<div id="wrapper" class="wrapper">
<?php echo $items_txt; ?>
			</div>
		</div>
