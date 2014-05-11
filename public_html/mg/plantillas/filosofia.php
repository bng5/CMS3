<?php
/* Filosofía */

array_unshift($titulo_arr, $seccion->nombres[$idioma->cod]);

$params = new Parametros_PublicacionItems($seccion, $idioma);
$params->rpp = false;
$items = Publicacion_Items::obtener($params);

$estilo = '
<style type="text/css">
 .wrapper {
width:'.(626 * $items->total).'px;
}
</style>';

?>


		<div id="nav">
			<h2><?php echo $seccion->nombres[$idioma->cod] ?></h2>
			<ul id="indice"><?php


$salida = '</ul>
		</div>
	</div>
	<div id="contenido">
		<div id="seccion" class="filosofia">
			<div id="wrapper" class="wrapper">';
$k = 1;
foreach($items AS $item) {
	$num = sprintf("%02d", $k);
	echo '<li class="ancla"><a href="#i'.$num.'">'.$num.'<span class="titulo"> '.$item["text__filosofia_tit"].'</span></a></li>';


	$salida .= '
				<div class="item">
					<div class="ol"><span class="d'.$num[0].'"></span><span class="u'.$num[1].'"></span><span class="simb s'.$k.'"></span></div>
					<h3><a name="i'.$num.'">'.$item['text__filosofia_tit'].'</a></h3>
					<p>'.WikiTexto::render_html(unserialize($item['text__filosofia_txt'])).'</p>
				</div>';
	$k++;

/*				<div class="item">
					<div class="ol"><span class="d0"></span><span class="u2"></span><span class="simb s2"></span></div>
					<h3><a name="i02">Lorem ipsum dolor sit amet, consectetur adipis-cing elit.</a></h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dolor neque, vulputate sit amet congue ut, pharetra sed libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent non neque nisl. Maecenas orci turpis, ullamcorper eget vehicula at, pretium eget elit. Nulla congue risus nec mi fermentum congue. Lorem ipsum dolor sit amet, consectetur </p>
				</div>
				<div class="item">
					<div class="ol"><span class="d0"></span><span class="u3"></span><span class="simb s3"></span></div>
					<h3><a name="i03">Lorem ipsum dolor sit amet, consectetur adipis-cing elit. Sed dapibus pha-retra elit, sit amet lobortis tellus elementum in.</a></h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dolor neque, vulputate sit amet congue ut, pharetra sed libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent non neque nisl. Maecenas orci turpis, ullamcorper eget vehicula at, pretium eget elit. Nulla congue risus nec mi fermentum congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi iaculis, felis ut pulvinar vehicula, arcu tortor tincidunt magna, id dignissim lacus metus ac leo. Suspendisse fringilla sem in ipsum congue fermentum. Nullam vel ipsum eu ligula fringilla auctor sit amet nec est.</p>
				</div>
 */
}

echo $salida;
?>
			</div>
		</div>
