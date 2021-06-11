<?php 
$blog = controladorBlog::ctrMostrarBlog();
$categorias = controladorBlog::ctrMostrarCategorias(null,null);
$articulos = controladorBlog::ctrMostrarConInnerJoin(0, 5, null, null);
$totalArticulos = controladorBlog::ctrMostrarTotalArticulos(null, null);
$totalPaginas = ceil(count($totalArticulos)/5);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php 
	$rutaCategoria="";
	if (isset($_GET["pagina"])) {
		$rutas=explode("/", $_GET["pagina"]);
	foreach ($categorias as $key => $value) {
		if ($rutas[0]==$value["ruta_categoria"] && !is_numeric($rutas[0])) {
			$rutaCategoria="categorias";
			break;
		}
	}

		if (isset($rutas[1])) {
			foreach ($totalArticulos as $key => $artValue) {
			if ($rutas[1]==$artValue["ruta_articulo"] && !is_numeric($rutas[1])) {
				$rutaCategoria="articulos";
				break;
			}
		}
	}


	if ($rutaCategoria == "categorias") {
			echo '<title>'.$value["descripcion_categoria"].'</title>
			<meta name="titulo" content="'.$value["titulo_categoria"].'">
			<meta name="description" content="'.$value["descripcion_categoria"].'">';

			echo '<meta property="og:site_name" content="'.$value["titulo_categoria"].'">
					<meta property="og:title" content="'.$value["titulo_categoria"].'">
					<meta property="og:description" content="'.$value["descripcion_categoria"].'">
					<meta property="og:type" content="article">
					<meta property="og:image" content="'.$blog["dominio"].$value["img_categoria"].'">
					<meta property="og:url" content="'.$blog["dominio"].$value["ruta_categoria"].'">';

			$palabras_claves = json_decode($value["p_claves_categoria"], true);

			$p_claves = "";
			
			foreach ($palabras_claves as $key => $value) {
				
				$p_claves .= $value.", ";

				
			}

			$p_claves = substr($p_claves, 0, -2);

			echo '<meta name="keywords" content="'.$p_claves.'">';
			
			
		}elseif ($rutaCategoria == "articulos") {

			echo '<title>'.$artValue["titulo_articulo"].'</title>

			<meta name="titulo" content="'.$artValue["titulo_articulo"].'">
			<meta name="description" content="'.$artValue["descripcion_articulo"].'">';
			echo '<meta property="og:site_name" content="'.$artValue["titulo_articulo"].'">
					<meta property="og:title" content="'.$artValue["titulo_articulo"].'">
					<meta property="og:description" content="'.$artValue["descripcion_articulo"].'">
					<meta property="og:type" content="article">
					<meta property="og:image" content="'.$blog["dominio"].$artValue["portada_articulo"].'">
					<meta property="og:url" content="'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'">';

			$palabras_claves = json_decode($artValue["p_claves_articulo"], true);

			$p_claves = "";
			
			foreach ($palabras_claves as $key => $value) {
				
				$p_claves .= $value.", ";
				
			}

			$p_claves = substr($p_claves, 0, -2);
			
		}else{
			echo '<title>'.$blog["titulo"].'</title>

			<meta name="titulo" content="'.$blog["titulo"].'">
			<meta name="description" content="'.$blog["descripcion"].'">';

			$palabras_claves = json_decode($blog["palabras_claves"], true);

			$p_claves = "";
			
			foreach ($palabras_claves as $key => $value) {
				
				$p_claves .= $value.", ";
				
			}

			$p_claves = substr($p_claves, 0, -2);

			echo '<meta name="keywords" content="'.$p_claves.'">';
			echo '<meta property="og:site_name" content="'.$blog["titulo"].'">
					<meta property="og:title" content="'.$blog["titulo"].'">
					<meta property="og:description" content="'.$blog["descripcion"].'">
					<meta property="og:type" content="article">
					<meta property="og:image" content="'.$blog["servidor"].$blog["portada"].'">
					<meta property="og:url" content="'.$blog["dominio"].'">';
		}

}else{
	echo '<title>'.$blog["titulo"].'</title>

			<meta name="titulo" content="'.$blog["titulo"].'">
			<meta name="description" content="'.$blog["descripcion"].'">';

			$palabras_claves = json_decode($blog["palabras_claves"], true);

			$p_claves = "";
			
			foreach ($palabras_claves as $key => $value) {
				
				$p_claves .= $value.", ";
				
			}

			$p_claves = substr($p_claves, 0, -2);

			echo '<meta name="keywords" content="'.$p_claves.'">';
			echo '<meta property="og:site_name" content="'.$blog["titulo"].'">
					<meta property="og:title" content="'.$blog["titulo"].'">
					<meta property="og:description" content="'.$blog["descripcion"].'">
					<meta property="og:type" content="article">
					<meta property="og:image" content="'.$blog["servidor"].$blog["portada"].'">
					<meta property="og:url" content="'.$blog["dominio"].'">';

}
 ?>
	<link rel="icon" href="<?php echo $blog["servidor"].$blog["icono"];?>">

	<!--=====================================
	PLUGINS DE CSS
	======================================-->
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<link href="https://fonts.googleapis.com/css?family=Chewy|Open+Sans:300,400" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">

	<!-- JdSlider -->
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
	<link rel="stylesheet" href="<?php echo $blog["dominio"];?>vistas/css/plugins/jquery.jdSlider.css">
	<!-- notiejscss -->
	<link rel="stylesheet" href="<?php echo $blog["dominio"];?>vistas/css/plugins/notie.min.css">

	<link rel="stylesheet" href="<?php echo $blog["dominio"];?>vistas/css/style.css">

	<!--=====================================
	PLUGINS DE JS
	======================================-->

	<!-- notiejs -->
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
	<script src="<?php echo $blog["dominio"];?>vistas/js/plugins/notie.min.js"></script>

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	<!-- JdSlider -->
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
	<script src="<?php echo $blog["dominio"];?>vistas/js/plugins/jquery.jdSlider-latest.js"></script>
	
	<!-- pagination -->
	<!-- http://josecebe.github.io/twbs-pagination/ -->
	<script src="<?php echo $blog["dominio"];?>vistas/js/plugins/pagination.min.js"></script>

	<!-- scrollup -->
	<!-- https://markgoodyear.com/labs/scrollup/ -->
	<!-- https://easings.net/es# -->
	<script src="<?php echo $blog["dominio"];?>vistas/js/plugins/scrollUP.js"></script>
	<script src="<?php echo $blog["dominio"];?>vistas/js/plugins/jquery.easing.js"></script>
	<!-- shape share o OpenGraph -->
	<script src="<?php echo $blog["dominio"];?>vistas/js/plugins/shape.share.js"></script>

</head>

<body>
<?php 

#MODULOS FIJOS SUPERIORES
include "paginas/modulos/cabecera.php";
include "paginas/modulos/redes-sociales-movil.php";
include "paginas/modulos/buscador-movil.php";
include "paginas/modulos/menu.php";

#BLOQUE QUE NOS AYUDARA A NAVEGAR ENTRE PAGINAS

$validarRuta="";
if (isset($_GET["pagina"])) {
	$rutas=explode("/", $_GET["pagina"]);
	if (is_numeric($rutas[0])) {

		$desde = ($rutas[0]-1)*5;
		$cantidad = 5;
		$articulos = controladorBlog::ctrMostrarConInnerJoin($desde, $cantidad, null, null);
		
	}else{

	foreach ($categorias as $key => $value) {
		if ($rutas[0] == $value["ruta_categoria"]) {
		$validarRuta="categorias";
		break;
	}elseif ($rutas[0] == "sobre-mi") {
		$validarRuta="sobre-mi";
		break;
	}else{
		$validarRuta="buscador";	
		}
	}
}
	#INDICE 1: RUTAS ARTICULOS o PAGINACION CATEGORIAS
	if (isset($rutas[1])) {
		if (is_numeric($rutas[1])) {
			$desde = ($rutas[1]-1)*5;
			$cantidad = 5;
			$articulos = controladorBlog::ctrMostrarConInnerJoin($desde, $cantidad, null, null);
		}else{
			foreach ($totalArticulos as $key => $value) {
					if ($rutas[1] == $value["ruta_articulo"]) {
					$validarRuta="articulos";
					break;
			}
		}
	}
}
	if ($validarRuta == "categorias") {
		include "paginas/categorias.php";
	}elseif ($validarRuta == "articulos"){
		include "paginas/articulos.php";
	}elseif ($validarRuta == "buscador"){
		include "paginas/buscador.php";
	}elseif ($validarRuta == "sobre-mi"){
		include "paginas/sobre-mi.php";
	}elseif (is_numeric($rutas[0]) && $rutas[0]<=$totalPaginas) {
		include "paginas/inicio.php";
	}elseif(isset($rutas[1])&&is_numeric($rutas[1])){
		include "paginas/inicio.php";
	}else{
		include "paginas/404.php";
	}

	}else{
	include "paginas/inicio.php";
}
#MODULOS FIJOS INFERIORES
include "paginas/modulos/footer.php";
 ?>
 <input type="hidden" id="rutaActual" value="<?php echo $blog["dominio"]; ?>">
<script src="<?php echo $blog["dominio"];?>vistas/js/script.js"></script>


</body>
</html>