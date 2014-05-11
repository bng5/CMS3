<?php
/*
usada en:
	public_html/admin/idiomas.xhtml.php
*/

function ordenar_lista($orden, $db_criterios_orden, $flechas_par = "fl2")
 {
  $flechas_etiqueta = "<img src=\"img/".$flechas_par."_%s\" id=\"fl\" style=\"border:0;\" width=\"11\" height=\"14\" class=\"fl\" alt=\"%s\" />&nbsp;";
  $flechas_arr[] = sprintf($flechas_etiqueta, "ab", "Orden descendente");
  $flechas_arr[] = sprintf($flechas_etiqueta, "arr", "Orden ascendente");

  $orden_arr = array("DESC", "ASC");
  $ord_num = array();
  $db_criterios_indice = array();
  $o = 1;
  array_unshift($db_criterios_orden, FALSE);

  for($i = 1; $i <= count($db_criterios_orden); $i++)
   {
    $ord_num[$i] = $o;
    $db_criterios_indice[$i] = $db_criterios_orden[$i];
    $ord_fl[$i] = "<img src=\"img/trans\" id=\"fl".$i."\" border=\"0\" width=\"1\" height=\"1\" class=\"fl\" alt=\"\" />&nbsp;";
    $o += 2;
   }

  $orden_dir = $orden%2;
  if($orden_dir)
   { $orden += 1; }
  $indice = ($orden / 2);
  $ord_num[$indice] += $orden_dir;

  $ordencolor[$indice] = " class=\"sel\"";
  $ord_fl[$indice] = str_replace(" id=\"fl\" ", " id=\"fl".$indice."\" ", $flechas_arr[$orden_dir]);
  $db_orden = $db_criterios_indice[$indice]." ".$orden_arr[$orden_dir];
  return compact('ord_num', 'ordencolor', 'ord_fl', 'db_orden');
 }

?>