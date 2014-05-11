<?php

$permiso_sec = $_SESSION['permisos'][$seccion] ? $_SESSION['permisos'][$seccion] : 0;
if($permiso_sec < $permiso_min)
 {
  if(!empty($_SESSION['usuario']))
	$login_xml = 7;
  header("Cache-Control: no-cache, must-revalidate", true, 401);
  include(RUTA_CARPETA.'public_html/menuXml/login.xml.php');
  exit;
 }

?>