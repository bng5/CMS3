var iniciado = false;
function cargarMapa() {
	iniciado = true;
	var myLatlng = new google.maps.LatLng(28.104851,-15.419379);
	var myOptions = {
	  zoom: 16,
	  center: myLatlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  mapTypeControl: false
	}
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	var marcador = new google.maps.Marker({
		position: myLatlng,
		map: map
	});
}

$(document).ready(function() {
	$("#ver_mapa").click(function() {
		if(!iniciado) {
			cargarMapa();
		}
		$("#map_canvas").dialog({modal: true, resizable: true, width: 600, height: 400});
		return false;
		//$("#map_canvas").toggle();
	});
  });

//Requiere jquery-1.4.2

ValidacionCampo = {
	CAMPO_ERR_REQUERIDO: 1,
	CAMPO_ERR_TIPO_DATO: 2,
	CAMPO_ERR_VALOR_INCORRECTO: 3,
	CAMPO_ERR_LARGO_MINIMO: 4,
	CAMPO_ERR_LARGO_MAXIMO: 5,
	esEmail: function(str) {
		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	}
};

function FormularioErrores() {
	this.errores = [];
	this.erroresDistintos = {};
	this.length = 0;
}

FormularioErrores.prototype = {
	agregar: function(obj) {
		//this.errores.push(obj);
		this.errores[this.length] = obj;
		if(this.erroresDistintos[obj.cod]) {
			this.erroresDistintos[obj.cod].push(this.length);
		}
		else {
			this.erroresDistintos[obj.cod] = [this.length];
		}
		this.length++
	},
	limpiar: function() {
		this.errores.splice(0, this.errores.length);
		this.erroresDistintos = {};
		this.length = 0;
	},
	itemAt: function(i) {
		return this.errores[i];
	},
	itemsPorTipo: function(tipo) {
		var i, arr = [];
		for(i = 0; i < this.errores.length; i++) {
			if(this.errores[i].cod == tipo)
				arr.push(this.errores[i]);
		}
		return arr;
	}
}

// HTMLFormElement
function Formulario(formulario, action) {
	this.action = action;
	this.validaciones = {};
	this.htmlForm = formulario;
	this.errores = new FormularioErrores();
	var self = this;
	$(formulario).submit(function(event) {
		self.enviar();
		event.preventDefault();
	});
}

Formulario.prototype.enviar = function() {
	if(this.previoEnvio) {
		this.previoEnvio();
	}

	this.errores.limpiar();
	var datos = new Array();
	var elems = this.htmlForm.elements;// var f = document.getElementById('form_contacto').elements;//.namedItem('nombre');
	var valor, errorCod;
	for(var i = 0; i < elems.length; i++) {
		errorCod = 0;
		k = elems.item(i);
		valor = jQuery.trim(k.value);
		//valor = k.value.trim();
		if(this.validaciones[k.name]) {
			if(this.validaciones[k.name].req && valor == '') {
				errorCod = ValidacionCampo.CAMPO_ERR_REQUERIDO;
			}
			else if(this.validaciones[k.name].esTipo && !this.validaciones[k.name].esTipo(valor)) {
				errorCod = ValidacionCampo.CAMPO_ERR_TIPO_DATO;
			}
			if(errorCod > 0) {
				this.errores.agregar({campo: k, cod: errorCod});
				$(k).addClass('error').one('keydown', function() {
					$(this).removeClass('error');
				});
				continue;
			}
		}
		datos.push(k.name+'='+encodeURIComponent(valor));
	}
	if(this.errores.length) {
		this.erroresHandler(this.errores);
		return;
	}
	var formulario = this.htmlForm;
	/* TODO
	 * #enviar y #cargando esto estÃ¡ de prepo
	 */
	var img = new Image();
	img.id = 'cargando';
	img.src = '/img/ajax-loader';
	$("#enviar").addClass('deshabilitado').after(img)[0].disabled = true;
	$.ajax({
		type: "POST",
		data: datos.join("&"),
		url: this.action,
		contentType: "application/x-www-form-urlencoded",
		dataType: "json",
		async:false,
		success: function(data, textStatus, XHR) {
			var k;
			if(data.exito) {
				formulario.reset();
				k = 'enviado';
			}
			else {
				k = 'error';
				$("#aviso").addClass('error');
			}
			/* TODO
			 * #enviar y #cargando esto estÃ¡ de prepo
			 */
			$("#enviar").removeClass('deshabilitado')[0].disabled = false;
			var img = document.getElementById('cargando');
			img.parentNode.removeChild(img);
			$("#enviar").removeClass('deshabilitado')[0].disabled = false;
			$("#aviso").append('<em>'+Textos[k]+'</em> ').fadeIn(600);
			return false;
		},
		error: function(XHR, textStatus, errorThrown) {
			/* TODO
			 * #enviar y #cargando esto está de prepo
			 */
			var img = document.getElementById('cargando');
			img.parentNode.removeChild(img);
			$("#aviso").addClass('error').append('<em>'+Textos['error']+'</em> ').fadeIn(600);
			$("#enviar").removeClass('deshabilitado')[0].disabled = false;
			return false;
		}
	});
}

var Textos = {
	mensaje: {},
	email: {}
};

$(document).ready(function() {
	var f = new Formulario(document.getElementById('form_contacto'), '/contactomail');
	f.validaciones = {
		email: {req: true, esTipo: ValidacionCampo.esEmail},
		mensaje: {req: true}
	};
	f.erroresHandler = function(errores) {
		for(var k in errores.erroresDistintos) {
			if(errores.erroresDistintos[k].length > 1)
				$("#aviso").append('<em>'+Textos[k]+'</em> ');
			else
				$("#aviso").append('<em>'+Textos[errores.itemAt(errores.erroresDistintos[k][0]).campo.name][k]+'</em> ');
		}
		$("#aviso").addClass('error').fadeIn(600);
	};
	f.previoEnvio = function() {
		$("#aviso").removeClass('error');
		$("#aviso").text('').hide();//.fadeOut()
	};

	//$("#form_contacto").submit(validarForm);
});