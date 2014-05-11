<?php

return array(
	//'casillas' => array('contacto@karintopolanski.com'),
	'casillas' => array('pablobngs@gmail.com'),
	'campos' => array(
		'nombre' => array('etiqueta' => 'Nombre'),
		'email' => array('etiqueta' => 'Email', 'requerido' => true, 'esTipo' => 'Validacion::esEmail', 'bind' => Validacion::REMITENTE),
		'__asunto' => array('etiqueta' => 'Asunto', 'bind' => Validacion::ASUNTO),
		'mensaje' => array('etiqueta' => 'Mensaje', 'requerido' => true),
	),
);
