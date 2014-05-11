<?php

$ref = substr($_SERVER['PHP_SELF'], 0, -4);

function php_self()
 { return substr($_SERVER['PHP_SELF'],0,-4); }

function formato_fecha($fecha, $formato = TRUE, $hora = TRUE)
 {
  global $texto;
  if(empty($fecha))
   { $form = "No especificada"; }
  else
   {
   	$meses = $texto['meses'];
   	$dias = $texto['dias'];
    $mk_fecha = @mktime(0, 0, 0, mb_substr($fecha, 5, 2), mb_substr($fecha, 8, 2), mb_substr($fecha, 0, 4));
    if($formato == TRUE)
     { $form = $dias[date(w, $mk_fecha)]." ".date(j, $mk_fecha)." de ".$meses[date(n, $mk_fecha)]." de ".date(Y,$mk_fecha); }
    else
     { $form = mb_substr($dias[date(w, $mk_fecha)], 0, 3)." ".date(j, $mk_fecha)."-".mb_substr($meses[date(n, $mk_fecha)], 0, 3)."-".date(Y,$mk_fecha); }
    if($hora == TRUE && strlen($fecha) > 10)
     {
      $mk_fecha += mktime(substr($fecha, 11, 2)-3, substr($fecha, 14, 2), substr($fecha, 17, 2), 0, 0, 0);
      $form .= ", ".date("G:i", $mk_fecha)." hs.";
     }
   }
  return $form;
 }

$texto['meses'] = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");
$texto['dias'] = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

$leng = 1;

?>