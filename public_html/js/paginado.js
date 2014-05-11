
/**
 * Constructor Paginado
 * //ruta, pagina, paginas)
*/
function Paginado() {
	//this.ruta = 'aaa';
	this.pagina = 1;
	this.paginas = 1;
	this.maxPaginas = 10;
	this.HTMLEl = null;// = new Array();
	//this.HTMLElTmp;
	this.listener = function() {
		alert('Debe indicar un listener para los enlaces.');
	};
}

Paginado.prototype.agregarContenedorHTML = function(el) {
	if(typeof el == 'string') {
		el = document.getElementById(el);
	}
	if(el != null) {
		//this.HTMLEl.push(el);
		this.HTMLElTmp = el;
	}
}

//Paginado.prototype.agregarListener = function(funcion)
// {
//  this.handler = funcion;
// }

Paginado.prototype._enlace = function(pagina, etiqueta) {
	if(!etiqueta)
		etiqueta = pagina;
	var a = document.createElement('a');
	var self = this;
	/*agregarEvento(a, 'click', function() {
		//Pagina = pagina;
		self.listener(pagina);//obtenerItems();
	});*/
	a.appendChild(document.createTextNode(etiqueta));
	return a;
}

Paginado.prototype.mostrar = function() {
	//if(this.HTMLEl.length == 0 || this.pagina > this.paginas)
	if(this.pagina > this.paginas) {
		return;
	}
	//for(var h = 0; h < this.HTMLEl.length; h++) {
	while(this.HTMLElTmp.firstChild != null)
		this.HTMLElTmp.removeChild(this.HTMLElTmp.firstChild);
	// }

	var el = this.HTMLElTmp;//[0];
	var ant = this.pagina - 1;
	var pos = this.pagina + 1;
	var em = document.createElement('em');
	em.appendChild(document.createTextNode(this.pagina));
	el.appendChild(em);
	var max = Math.min(this.paginas, this.maxPaginas-1);
	for(max; max > 0; ant--, pos++) {
		if(ant <= 0 && pos > this.paginas)
			break;
		if(ant > 0) {
			el.insertBefore(document.createTextNode(' '), el.firstChild);
			el.insertBefore(this._enlace(ant, ant), el.firstChild);
			max--
		}
		if(pos <= this.paginas) {
			el.appendChild(document.createTextNode(' '));
			el.appendChild(this._enlace(pos, pos));
			max--
		}
	}
	el.insertBefore(document.createTextNode(' '), el.firstChild);
	el.insertBefore((this.pagina > 1) ? this._enlace((this.pagina - 1), "Anterior") : document.createTextNode(" Anterior"), el.firstChild);
	var span = document.createElement('span');
	span.className = "antsig";
	el.appendChild(document.createTextNode(' '));
	span.appendChild((this.pagina < this.paginas) ? this._enlace((this.pagina + 1), "Siguiente") : document.createTextNode(" Siguiente"));
	el.appendChild(span);
	//  if(this.HTMLEl.length > 1)
	//   {
	//    for(h = 1; h < this.HTMLEl.length; h++)
	//     {
	//     // el
	//     }
	//   }
}
