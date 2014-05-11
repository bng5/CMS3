<?php
/* Hoteles */

$pag = intval($_GET['pag']) ? intval($_GET['pag']) : 1;
$rpp = 12;
$total = 16;
$paginas = ceil($total / $rpp);
$desde = (($pag - 1) * $rpp);
$hasta = $desde + $rpp;

$hasta = ($hasta <= $total) ? $hasta : $total;

$desde++;



$lista = array(
	1 => array('titulo' => 'Tienda A', 'descripcion' => 'CALLE
						RIVADAVIA, 12
						MADRID
						ESPAÑA

					2010', 'img' => 'hotel01'),
	array('titulo' => 'Tienda B', 'descripcion' => 'CALLE
						DUOMO, 12
						MILAN
						ITALIA

					2010', 'img' => 'hotel02'),
	array('titulo' => 'Tienda C', 'descripcion' => 'CALLE
						GABOTO, 1010
						MONTEVIDEO
						URUGUAY

					2009', 'img' => 'hotel03'),
);


$respuesta->total = $total;
$respuesta->rpp = $rpp;
$respuesta->pagina = $pag;
$respuesta->paginas = ceil($total / $rpp);
$respuesta->items = array();


$k = 1;
for($i = $desde; $i <= $hasta ; $i++) {
	$respuesta->items[] = $lista[$k];
	$k++;
	if($k > 3)
		$k = 1;
	/*	$num = ''.sprintf("%02d", $i);
	echo '<div class="item">
					<div class="ol"><span class="d'.$num[0].'"></span><span class="u'.$num[1].'"></span><span class="simb s'.$k.'"></span></div>
					<h3><a name="'.urlencode($item[0]).$i.'" href="/hoteles?id=1">'.$item[0].'</a></h3>
					<span class="estrellas '.$item[1].'">'.$item[2].'</span>
					<p>'.$item[3].'</p>
					<a href="/hoteles?id=1"><img src="/img/fotos/'.$item[4].'" alt="" /></a>
				</div>';

	*/
}

return $respuesta;