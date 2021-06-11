
/*=============================================
BANNER
=============================================*/

$(".fade-slider").jdSlider({

	isSliding: false,
	isAuto: true,
	isLoop: true,
	isDrag: false,
	interval:5000,
	isCursor: false,
	speed:3000

});

var alturaBanner = $(".fade-slider").height();

$(".bannerEstatico").css({"height":alturaBanner+"px"})


/*=============================================
ANIMACIONES SCROLL
=============================================*/

$(window).scroll(function(){

	var posY = window.pageYOffset;
	
	if(posY > alturaBanner){

		$("header").css({"background":"white"})

		$("header .logotipo").css({"filter":"invert(100%)"})

		$(".fa-search, .fa-bars").css({"color":"black"})

	}else{

		$("header").css({"background":"rgba(0,0,0,.5)"})

		$("header .logotipo").css({"filter":"invert(0%)"})

		$(".fa-search, .fa-bars").css({"color":"white"})

	}

})

/*=============================================
MENÚ
=============================================*/

$(".fa-bars").click(function(){

	$(".menu").fadeIn("fast");

})

$(".btnClose").click(function(e){

	e.preventDefault();

	$(".menu").fadeOut("fast");

})

/*=============================================
GRID CATEGORÍAS
=============================================*/

$(".grid figure, .gridFooter figure").mouseover(function(){

	$(this).css({"background-position":"right bottom"})

})

$(".grid figure, .gridFooter figure").mouseout(function(){

	$(this).css({"background-position":"left top"})

})

$(".grid figure, .gridFooter figure").click(function(){

	var vinculo = $(this).attr("vinculo");

	window.location = vinculo;

})

/*=============================================
PAGINACIÓN
=============================================*/
var rutaActual = $("#rutaActual").val();
var totalPaginas = Number($(".pagination").attr("totalPaginas"));
var paginaActual = Number($(".pagination").attr("paginaActual"));
var rutaPagina = ($(".pagination").attr("rutaPagina"));
if ($(".pagination").length!=0) {
	$(".pagination").twbsPagination({
		totalPages: totalPaginas,
		startPage: paginaActual,
		visiblePages: 4,
		first: "Primero",
		last: "Último",
		prev: '<i class="fas fa-angle-left"></i>',
		next: '<i class="fas fa-angle-right"></i>'

	}).on("page", function(evt, page){
		if (rutaPagina!="") {
			window.location=rutaActual+rutaPagina+"/"+page;
		}else{
			window.location=rutaActual+page;
		}
		
	})
}



/*=============================================
SCROLL UP
=============================================*/

$.scrollUp({
	scrollText:"",
	scrollSpeed: 2000,
	easingType: "easeOutQuint"
})

/*=============================================
DESLIZADOR DE ARTÍCULOS
=============================================*/


$(".deslizadorArticulos").jdSlider({
	wrap: ".slide-inner",
	slideShow: 3,
	slideToScroll:3,
	isLoop: true,
	responsive: [{
		viewSize: 320,
		settings:{
			slideShow: 1,
			slideToScroll: 1
		}

	}]

})

/*=============================================
COMPARTIR EN REDES SOCIALES
=============================================*/
$('.social-share').shapeShare({

  // your twitter name
  twitter: {
    account: 'jqueryscript'
  },

  // bitly.com API here
  shortenUrl: {
    enable: true,
    apiKey: 'R_cb9b7614dbd84e4b8aee2a4f25a2fda9',
    login: 'o_65q884feb1'
  }
  
});


/*=============================================
OPINIONES VACIAS
=============================================*/
if ($(".opiniones").html()) {
if (document.querySelector(".opiniones").childNodes.length == 1) {
	$(".opiniones").html(` 
			<p class="pl-3 text-secondary">¡Este Articulo no tiene opiniones!</p>
		`)
}
}
/*=============================================
SUBIR FOTO TEMPORALMENTE
=============================================*/
$("#fotoOpinion").change(function(){
	$(".alert").remove();
	var imagen = this.files[0];
	/*=============================================
	SUBIR FOTO TEMPORALMENTE
	=============================================*/
	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
		$("#fotoOpinion").val("");
		$("#fotoOpinion").after(`
				<div class="alert alert-danger">el formato del archivo debe ser una imagen de tipo png o jpg</div>
			`)
		return;
	}else if(imagen["size"]>3000000){
		$("#fotoOpinion").val("");
		$("#fotoOpinion").after(`
				<div class="alert alert-danger">la imagen no debe pesar mas de 2 megas/div>
			`)
	}else{
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);
		$(datosImagen).on("load", function(event){
			var rutaImagen = event.target.result;
			$(".prevFotoOpinion").attr("src", rutaImagen);
		})
	}
})
/*=============================================
BUSCADOR
=============================================*/
$(".buscador").change(function(){
	var busqueda = $(this).val().toLowerCase();

	var expresion = /^[a-z0-9ñÑáéíóú ]*$/;

	if (!expresion.test(busqueda)) {
		$(".buscador").val("");
	}else{
		var evaluarBusqueda = busqueda.replace(/[0-9ñáéíóú ]/g, "_");

		var rutaBuscador = evaluarBusqueda;

		$(".buscar").click(function(){
			if ($(".buscador").val() != "") {
				window.location=rutaActual+rutaBuscador;
			}
		})

	}
})

/*=============================================
BUSCADOR CON ENTER
=============================================*/

$(document).on("keyup", ".buscador", function(evento){

	evento.preventDefault();

	if(evento.keyCode == 13 && $(".buscador").val() != ""){

		var busqueda = $(this).val().toLowerCase();

		var expresion = /^[a-z0-9ñÑáéíóú ]*$/;

		if(!expresion.test(busqueda)){

			$(".buscador").val("");

		}else{

			var evaluarBusqueda = busqueda.replace(/[0-9ñáéíóú ]/g, "_");

			var rutaBuscador = evaluarBusqueda;

			window.location = rutaActual+rutaBuscador;

		}


	}

})