<?php

require_once('inc/iniciar.php');
//$secciones = new adminsecciones();
require('inc/ad_sesiones.php');

header("Content-Type: text/html", true);
$seccion = array_key_exists(10, $_SESSION["permisos"]["admin_seccion"]) ? 10 : 19;
header("Location: listar?seccion=".$seccion);

?>
