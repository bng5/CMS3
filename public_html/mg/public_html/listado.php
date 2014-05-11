<?php

require_once('../inc/iniciar.php');
header("Content-Type: application/json; charset=UTF-8");
$path = explode("/", $_SERVER['PATH_INFO']);

$idioma->id = 1;
$idioma->cod = 'es';

$seccion = Publicacion_Secciones::resolver($path[1], $idioma);

$params = new Parametros_PublicacionItems($seccion, $idioma);
$params->rpp = 12;
$params->pagina = intval($_GET['pag']) ? intval($_GET['pag']) : 1;
$items = Publicacion_Items::obtener($params);

$respuesta->total = (int) $items->total;
$respuesta->rpp = $items->rpp;
$respuesta->pagina = $items->pagina;
$respuesta->paginas = $items->paginas;
$respuesta->items = array();

foreach($items AS $item) {
	$img = unserialize($item["img__imagen"]);
	$arr = array(
		'id' => $item["id"],
		'titulo' => $item["string__titulo"],
		'descripcion' => $item["string__ubicacion"]."\n\n".$item["string__anyo"],
		'img' => '/img/0/'.$img[0].'/'.$img[1]);
		//"estrellas":4,
	$respuesta->items[] = $arr;
}

echo json_encode($respuesta);

?>