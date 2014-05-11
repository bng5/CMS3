<?php

class adminsecciones {
	public static $CMSsecciones_nombres_d;

	public function __construct() {
		global $seccion_id;
		$this->seccion = $seccion_id ? $seccion_id : false;
		$this->separador_niv = "  ";
		$this->secciones = array();
		$this->superior = array();
		$this->actual_superior = array();
		$db = DB::instancia();

		$tbsubcat = $db->query("SELECT s.id, sn.titulo, s.superior_id, s.link_cms, s.link_cms_params, s.info, s.items, s.identificador FROM usuarios_permisos up, `secciones` s LEFT JOIN secciones_nombres sn ON s.id = sn.id AND sn.leng_id = 1 WHERE up.item_id = s.id AND up.usuario_id = ".Sesion::instancia()->usuario_id." GROUP BY s.id ORDER BY s.`superior_id`, s.`sistema`, s.`orden`", DB::FETCH_ASSOC);// or die(mysql_error());  WHERE sistema != 0 OR (info != 0 OR items != 0)
		if($row_subcat = $tbsubcat->fetch()) {
			do {
				$row_subcat['nombre'] = $row_subcat['titulo'] ? $row_subcat['titulo'] : $row_subcat['identificador'];
				$this->secciones_arr[$row_subcat['id']] = $row_subcat['nombre'];
				$this->superior[$row_subcat['id']] = $row_subcat['superior_id'];
				$this->secciones[$row_subcat['superior_id']][$row_subcat['id']] = $row_subcat;
			}while($row_subcat = $tbsubcat->fetch());
		}
	}

	public function imprimir($subseccion = false, $nivel = 0) {
		if($subseccion == false)
			$subseccion = current($this->secciones);
		//echo "\n".str_repeat($this->separador_niv, $nivel)."><ul";
		$retorno = str_repeat($this->separador_niv, $nivel)."<ul>";
		$pasan = 0;
		foreach($subseccion AS $a) {
			//if(!array_key_exists($a['id'], $_SESSION['permisos']['admin_seccion']))
			//	continue;// && $nivel == 0
			$link = $a['link_cms'];
			$eslink = true;
			if($link == "listar") {
				$link .= "?seccion={$a['id']}";
				$eslink = (!$a['info'] && !$a['items']) ? false : true;
			}
			//$link .= $a['link_param'] ? "?".$a['link_param'] : "";
			$retorno .= str_repeat($this->separador_niv, $nivel)."<li class=\"'.\$seleccionado[{$a['id']}].'";
			if(is_array($this->secciones[$a['id']])) {
				array_shift($this->actual_superior);
				if($retorno_r = $this->imprimir($this->secciones[$a['id']], ++$nivel)) {
					$despleg = true;
				}
				$nivel--;
			}
			$retorno .= ($despleg ? "desplegable" : "simple")."\"'.\$seleccionado_id[{$a['id']}].'><span".($despleg ? " onclick=\"menuDesplegar(this)\"" : "")."><a".($eslink ? " href=\"".APU.$link."\"" : "").">{$a['nombre']}</a></span>{$retorno_r}</li>";
			$despleg = false;
			$retorno_r = false;
			$pasan++;
		}
		return $pasan ? $retorno.str_repeat($this->separador_niv, $nivel)."</ul>\n" : false;
	}

	public function __toString() {
		return $this->titulo ? $this->titulo : "Título";
	}
}

$CMSsecciones = new adminsecciones();
$CMSsecciones_nombres = $CMSsecciones->secciones_arr;//var_export($secciones->ssecciones_arr, false);
adminsecciones::$CMSsecciones_nombres_d = var_export($CMSsecciones->secciones_arr, true);

function guardar_encabezado($bufer) {
  //global $incluir, $CMSsecciones_nombres_d
  global $seleccionado, $seleccionado_id;//, $seleccionadoUlt;
  $menu_hash = md5($_SESSION['admin_secciones']);
  Sesion::instancia()->menuHash = $menu_hash;
  $outfile = fopen(RUTA_CARPETA."iacache/menu".$menu_hash.".php", "w");
  if($outfile) {
		$et_php = array("'.", ".'");
		$et_php_remp = array("<?= ", " ?>");
		fwrite($outfile, "<?php\n\$seleccionado[\$seccion_id] = \"activo \";\n\$seleccionado_id[\$seccion_id] = \" id=\\\"menu_activo\\\"\";\n\$secciones_nombres = ".adminsecciones::$CMSsecciones_nombres_d.";\n?>\n".str_replace($et_php, $et_php_remp, $bufer));
		fclose($outfile);
   }
  eval("\$bufer = '$bufer';");
  return $bufer;
 }

ob_start("guardar_encabezado");
$seleccionado[$seccion_id] = "activo ";
$seleccionado_id[$seccion_id] = " id=\"menu_activo\"";
//$seleccionadoUlt[$seccion_id] = " seleccionado";
echo $CMSsecciones->imprimir();
ob_end_flush();

?>