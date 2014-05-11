<?php

/*
$suceso = null;
if(!empty($_REQUEST['cuenta']))
 {
  $login = new Login($_REQUEST['cuenta']);
  $suceso = $login->sucesoId();
  if($suceso == 3) $_SESSION['admin_secciones'] = "-".implode("-", array_keys($_SESSION['permisos']['admin_seccion']))."-";
  // {
  //	$params = $_POST['get'] ? "&".http_build_query($_POST['get']) : "";
  //	header("Location: ${ref}?cuenta=0${params}");
  //	exit;
  // }
 }
*/

if(empty($_SESSION['usuario'])) {
    //print_r($_COOKIE);
    if($_COOKIE['pase'] && $_COOKIE['usuario']) {
        $login = new Legacy_Login("recuperar", $_COOKIE['usuario']);
        //$suceso = $login->sucesoId();
	    if($login->respuesta->exito) {
            $_SESSION['admin_secciones'] = "-".implode("-", array_keys($_SESSION['permisos']['admin_seccion']))."-";
        }
    }
    else {
		header("Content-Type: text/html", true);
        header("Location: ".APU."login?ref=".urlencode($_SERVER["REQUEST_URI"]), true, 303);//include(RUTA_CARPETA.'inc/admin_login.php');
        exit(" ");
    }
    //echo "header(\"Location: ".APU."login?id=".$ssid."&ref=".$ref."&usuario=".$ad_username."\",TRUE,307);";//include(RUTA_CARPETA.'inc/admin_login.php');
}

if($seccion_id && $_SESSION['permisos']['admin_seccion'][$seccion_id] < 1) {
    header("Cache-Control: no-cache, must-revalidate", true, 403);
    include('./error/403.php');
    exit;
}
