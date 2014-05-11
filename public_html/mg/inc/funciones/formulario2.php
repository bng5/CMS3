<?php

function pedir_dato($id, $v_id, $valor, $tipo, $subtipo, $nombre, $i, $fk = false)
 {
  $label = "<label>{$nombre}</label>:</td>\n	   <td>";
  //$v = $v_id ? "[m][${tipo}][${v_id}]" : "[${id}][]";
  $v = "[${id}][]";
  if($tipo == "string")
   {
    if($subtipo == 1)
     {
	  $color = $valor[0][1] ? $valor[0][1] : "666666";
      return $label."<img src=\"/img/trans\" onclick=\"paletaDeColores(this, this.nextSibling).mostrar()\" class=\"muestraColor\" style=\"background-color:#{$color};\" width=\"22\" height=\"22\" alt=\"{$color}\" /><input type=\"hidden\" name=\"dato${v}\" value=\"{$color}\" />";
     }
	else
	 {
	  if(empty($subtipo)) $subtipo = "text";
	  return "<label for=\"dato${i}\">{$nombre}</label>:</td>\n	   <td><input type=\"${subtipo}\" name=\"dato${v}\" id=\"dato${i}\" value=\"{$valor[0][1]}\" size=\"45\" maxlength=\"45\" tabindex=\"2\" />";
	 }
   }
  elseif($tipo == "date")
   {
    if($subtipo == 1)
     {
	  $fecha = $valor[0][2] ? date("Y-m-d", $valor[0][2]) : "";
	  $fechaMst = formato_fecha($valor[0][2], true, false);
	  $formato = "%Y-%m-%d";
	  $formatoMst = "%A, %d de %B de %Y";
	  $mostrarHora = "false";
     }
    else
     {
	  $fecha = $valor[0][2] ? date("Y-m-d G:i", $valor[0][2]) : "";
	  $fechaMst = formato_fecha($valor[0][2]);
	  $formato = "%Y-%m-%d %H:%m";
	  $formatoMst = "%A, %d de %B de %Y, %H:%m hs.";
	  $mostrarHora = "true";
     }
	// onclick=\"return showCalendar('fecha_fin', '%A, %B %e, %Y');\"
	return $label."<span id=\"mostrar_fecha${i}\">${fechaMst}</span>&nbsp;&nbsp;<img src=\"/img/icono_calendario\" id=\"tn_calendario${i}\" style=\"cursor: pointer;\" title=\"Abrir calendario\" alt=\"Abrir calendario\" /><input type=\"hidden\" name=\"dato${v}\" value=\"${fecha}\" id=\"fecha${i}\" />
<script type=\"text/javascript\">
    Calendar.setup({
		inputField     :    \"fecha${i}\",
		ifFormat       :    \"${formato}\",
		displayArea    :    \"mostrar_fecha${i}\",
		daFormat       :    \"${formatoMst}\",
		button         :    \"tn_calendario${i}\",
		showsTime : ${mostrarHora}});
</script>";
/*
	return "<input type=\"text\" name=\"dato[fecha]\" id=\"dato${i}\" size=\"2\" maxlength=\"2\" /><select name=\"dato[fecha]\"><option value=\"1\">Ene</option><option value=\"2\">Feb</option><option value=\"3\">Mar</option></select>";
*/
   }
  elseif($tipo == "int")
   {
    if($subtipo == 1)
     {
      $ret = $label;
      global $mysqli, $p_seccion_id;
      //$bsq = ($_SESSION['permisos'][$p_seccion_id] < 4) ? "AND bsq = '".$_SESSION['usuario_id']."'" : null;
      $bsq = false;
	  //if($_SESSION['usuario_id'])      
	  if(!$cons_vista = $mysqli->query("SELECT consulta FROM vistas WHERE identificador = '${fk}' LIMIT 1")) echo __LINE__." - ".$mysqli->error;
	  if($fila_vista = $cons_vista->fetch_row())
	   {
	    $vista = sprintf($fila_vista[0], $bsq);
	    if(!$cons_fk = $mysqli->query($vista)) echo __LINE__." - ".$mysqli->error;
	    if($fila_fk = $cons_fk->fetch_row())
	     {
	      $ret .= "<select name=\"dato${v}\"><option value=\"\"> </option>";
	      do
	       {
		    $ret .= "<option value=\"{$fila_fk[0]}\"";
		    if($fila_fk[0] == $valor[0][4]) $ret .= " selected=\"selected\"";
		    $ret .= ">{$fila_fk[1]}</option>";
		   }while($fila_fk = $cons_fk->fetch_row());
		  $ret .= "</select>";
		  $cons_fk->close();
	     }
        return $ret;
       }
     }
	else
	 {
	  return "<label for=\"dato${i}\">{$nombre}</label>:</td>\n	   <td><input type=\"text\" name=\"dato${v}\" id=\"dato${i}\" value=\"{$valor[0][1]}\" size=\"5\" maxlength=\"9\" />";
	 }
   }
  else return "Tipo no válido (${tipo}).";
 }

?>