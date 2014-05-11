<?php



/**
 * Sesion
 *
 *

$usuario DTO_Usuario
$recordarme bool false

 */

Sesion::iniciar($usuario, $recordarme);




/**
 *
Publicacion_Items


recuperar listado de items
recuperar un item
publicar item
eliminar publicacion



	publicar(Item $item)

	preparar()

	Listado obtenerListado()

 */




$items_publicacion = new Publicacion_Items($seccion, $idioma);
$items_publicacion->criterio->rpp = 12;
$items_publicacion->rpp = 12;
$items_publicacion->pagina = intval($_GET['pag']) ? intval($_GET['pag']) : 1;
$items = $items_publicacion->obtener();

?>