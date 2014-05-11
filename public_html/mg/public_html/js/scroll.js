var ajaxloader = new Image();
ajaxloader.src = '/img/ajax-loader.gif';
ajaxloader.setAttribute('alt', 'Cargando...');
var cargando = false;

function indiceAgregarEventos() {
	var wrapperOffset = (0 - $("#wrapper").offset().left);
	$("#indice li.ancla").localScroll({offset: wrapperOffset, queue: true, duration: 800, hash: true, onBefore: function (e, anchor, $target) {
			$("#indice a.activo").removeClass("activo");
			$(e.target).addClass("activo");
		}});
	$("#indice a .titulo").parent().tooltip({
		showURL: false,
		bodyHandler: function() {
			return this.childNodes[1].firstChild.textContent;
		}
	});
	cargando = false;
	$("#indice").fadeIn(800);
	$(ajaxloader).hide();
}

$(document).ready(function() {
		$.localScroll.defaults.axis = "x";
		if(document.getElementById("indice") != null)
			document.getElementById("indice").parentNode.appendChild(ajaxloader);
		indiceAgregarEventos();

		$('#indice li.paginado a').click(function(event) {
			if(cargando)
				return;
			cargando = true;
			var pagina = currentPagina;
			if(event.target.id == 'anterior' && currentPagina > 1) {
				pagina--
				if(pagina == 1)
					$("#anterior").addClass("activo");
				if(pagina == paginas - 1)
					$("#siguiente").removeClass("activo");
			}
			else if(event.target.id == 'siguiente' && currentPagina < paginas) {
				pagina++
				if(pagina == 2)
					$("#anterior").removeClass("activo");
				if(pagina == paginas)
					$("#siguiente").addClass("activo");
			}
			else {
				return false;
			}
			$(ajaxloader).show();
			event.preventDefault();
			$("#indice").hide();

			$.get("/listado"+location.pathname+"?pag="+pagina, null, function(data, textStatus, XMLHttpRequest) {
				currentPagina = data.pagina;

				var wrapper = $("#wrapper");

				while(wrapper[0].firstChild != null) {
					wrapper[0].removeChild(wrapper[0].firstChild);
				}
				var wrapperEl = wrapper.width(444 * data.items.length)[0];

				var indice = document.getElementById("indice");
				while(indice.childNodes.length > 2) {
					indice.removeChild(indice.childNodes[1]);
				}
				var desde = ((currentPagina - 1) * data.rpp);
				var k = 1;
				var spanEstrellas;
				for(var i = 0; i < data.items.length; i++) {
					num = ++desde < 10 ? '0'+desde : ''+desde;
					indice.insertBefore($("<li class=\"ancla\"><a href=\"#"+num+"\""+(i == 0 ? 'class="activo"' : '')+">"+num+"<span class=\"titulo\"> "+data.items[i].titulo+"</span></a></li>")[0], indice.lastChild);
					spanEstrellas = data.items[i].estrellas ? '<span class="estrellas e'+data.items[i].estrellas+'">'+data.items[i].estrellas+'</span>' : '';
					wrapper.append($('<div class="item">\n'+
								'<div class="ol"><span class="d'+num[0]+'"></span><span class="u'+num[1]+'"></span><span class="simb s'+k+'"></span></div>'+
								'<h3><a name="'+num+'" href="'+location.pathname+'?id='+data.items[i].id+'&ref='+desde+'">'+data.items[i].titulo+'</a></h3>'+
								spanEstrellas+
								'<p>'+data.items[i].descripcion+'</p>'+
								'<a href="'+location.pathname+'?id='+data.items[i].id+'&ref='+desde+'"><img src="'+data.items[i].img+'" alt="" /></a>'+
							'</div>'));
					k++
					if(k > 3)
						k = 1;
				}
				indiceAgregarEventos();

				var wrapperOffset = (0 - $("#wrapper").offset().left);
				$(window).scrollTo(wrapperEl.firstChild, 800, {axis:'x', offset: wrapperOffset});//, onAfter: function() {
			});
		});

		$('#contenido').css('margin-top', $("#contenedor_encabezado").css({left: '0', position: 'fixed', top: '0'}).height()+'px');
		$("#contenedor_encabezado").css('top', (0 - $(this).scrollTop())+'px');
		$(window).scroll(function () {
			//alert($(this).scrollLeft());
			//$("span").css("display", "inline").fadeOut("slow");
			$("#contenedor_encabezado").css('top', (0 - $(this).scrollTop())+'px');
		});
});
