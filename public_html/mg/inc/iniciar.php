<?php
define("SITIO_TITULO", "Malele Gutierrez Decoración");
define("RUTA_CARPETA", "/home/malelegutierrezdecoracion.com/");
define("DOMINIO", "malelegutierrezdecoracion.com");

define("API_VERSION", "0.0.1");

define("MYSQL_HOST", "localhost");
define("MYSQL_USUARIO", "mymalelegu");
define("MYSQL_CLAVE", "YmW7m5Q9");
define("MYSQL_DB", "bng5");


// obsoleto ?
define("APU", "/");
define('DOKU_INC', RUTA_CARPETA.'bng5/clases/Doku/');
define('DOKU_CONF',DOKU_INC.'conf/');


session_name("sesion");
if($_REQUEST['sesion'])
  session_start();
mb_internal_encoding("UTF-8");
error_reporting(E_ALL ^ E_NOTICE);//E_STRICT);//

function autoload($clase) {
	$clase = str_replace('_', '/', $clase);
	require_once(RUTA_CARPETA.'bng5/clases/'.$clase.'.php');
}
spl_autoload_register('autoload');

header("X-Powered-By: Bng5.net");
