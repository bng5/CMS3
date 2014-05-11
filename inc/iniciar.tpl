<?php
define("SITIO_TITULO", "jaser18");
define("URL_MAIL", "pablo@bng5.net");
define("PRINCIPALURL", "/");
define("RUTA_CARPETA", "/home/jaser19/");
define("APU", "/");
define("DOMINIO", "jaser19.tld");
define("T_PUBLICACION", "xml");

define("MYSQL_USUARIO", "jaser18_etdp");
define("MYSQL_CLAVE", "f,527bjR");
define("MYSQL_DB", "jaser18_etdp");

//if($_REQUEST['sesion'])
//  session_start();
mb_internal_encoding("UTF-8");
error_reporting(E_ALL);// ^ E_NOTICE);

function __autoload($clase)
 {
  $clase = str_replace('_', '/', $clase);
  require_once('cms2/v2.1/'.$clase.'.php');
 }

header("X-Powered-By: Bng5.net");
?>