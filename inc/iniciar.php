<?php
define("SITIO_TITULO", "El veloz murciélago hindú");
define("RUTA_CARPETA", "/home/cms3/");
define("DOMINIO", "cms3.tld");

define("API_VERSION", "0.0.1");

define("MYSQL_USUARIO", "jaser18_etdp");
define("MYSQL_CLAVE", "f,527bjR");
define("MYSQL_DB", "jaser18_etdp");

//if($_REQUEST['sesion'])
//  session_start();
mb_internal_encoding("UTF-8");
error_reporting(E_ALL ^ E_NOTICE);

function autoload($clase)
 {
  $clase = str_replace('_', '/', $clase);
  require_once('/usr/share/php/cms2/v2.1/'.$clase.'.php');
 }
spl_autoload_register('autoload');

header("X-Powered-By: Bng5.net");
?>