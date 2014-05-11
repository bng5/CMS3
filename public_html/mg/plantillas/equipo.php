<?php
/* Equipo */

array_unshift($titulo_arr, $seccion->nombres[$idioma->cod]);

$params = new Parametros_PublicacionItems($seccion, $idioma);
$params->rpp = false;
$items = Publicacion_Items::obtener($params);

$info = Publicacion_Seccion::obtener($seccion->id, $idioma->cod);
$valores = $info['valores'];

$estilo = '
<style type="text/css">
 .wrapper {
width:'.(373 + (661 * $items->total)).'px;
width:1720px;
}
</style>';

?>


		<div id="nav">
			<h2><?php echo $seccion->nombres[$idioma->cod] ?></h2>
			<ul id="indice"><?php 

$items_txt = '';
if($valores[3] || $valores[4]) {
	echo '<li class="ancla"><a href="#'.urlencode($valores[3]).'">'.$valores[3].'</a></li>';
	$items_txt = '				<div class="descripcion">
					<a name="'.$valores[3].'"></a>
					'.WikiTexto::render_html($valores[4]).'
				</div>';
}

$k = 1;
foreach($items AS $item) {
	$num = sprintf("%02d", $k);
	//$ancla = str_replace(" ", "_", iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $item['string__titulo']));
	echo '<li class="ancla"><a href="#'.$k.'">'.$item['string__titulo'].'</a></li>';
	$items_txt .= '
				<div class="item">
					<div class="ol"><span class="d'.$num[0].'"></span><span class="u'.$num[1].'"></span><span class="simb s'.$k.'"></span></div>
					<h3><a name="'.$k.'">'.$item['string__titulo'].'</a></h3>
					'.WikiTexto::render_html(unserialize($item['text__texto'])).'
				</div>';
	$k++;
}

?></ul>
		</div>
	</div>
	<div id="contenido">
		<div id="seccion" class="equipo">
			<div id="wrapper" class="wrapper">
<?php echo $items_txt; ?>
			</div>
		</div>
