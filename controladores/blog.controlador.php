<?php

class controladorBlog{

	#MOSTRAR CONTENIDO TABLA BLOG
	static public function ctrMostrarBlog(){

	$tabla = "blog";

	$respuesta = modeloBlog::mdlMostrarBlog($tabla);

	return $respuesta;

	}
	#MOSTRAR CATEGORIAS
	static public function ctrMostrarCategorias($item,$valor){

	$tabla = "categorias";

	$respuesta = modeloBlog::mdlMostrarCategorias($tabla,$item,$valor);

	return $respuesta;

	}
	#MOSTRAR ARTICULOS CON INNERJOIN
	static public function ctrMostrarConInnerJoin($desde, $cantidad, $item, $valor){
		$tabla1= "categorias";
		$tabla2= "articulos";
		$respuesta= modeloBlog::mdlMostrarConInnerJoin($tabla1, $tabla2, $desde, $cantidad, $item, $valor);
		return $respuesta;
	}
	#MOSTRAR EL TOTAL DE ARTICULOS
	static public function ctrMostrarTotalArticulos($item, $valor){
		$tabla="articulos";
		$respuesta= modeloBlog::mdlMostrarTotalArticulos($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarOpiniones($item, $valor){
		$tabla1= "opiniones";
		$tabla2= "administradores";
		$respuesta= modeloBlog::mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor);
		return $respuesta;
	}
	static public function ctrEnviarOpinion(){
		if (isset($_POST["nombre_opinion"])) {
			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["nombre_opinion"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo_opinion"]) &&
			   preg_match('/^[=\\$\\;\\*\\"\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/',  $_POST["contenido_opinion"])) {

			   	#VALIDACION FOTO LADO SERVIDOR
			   	if (isset($_FILES["fotoOpinion"]["tmp_name"]) && !empty($_FILES["fotoOpinion"]["tmp_name"])) {
			   		#CAPTURAR ANCHO Y ALTO Y DEFINIR NUEVOS VALORES
			   		list($ancho,$alto)= getimagesize($_FILES["fotoOpinion"]["tmp_name"]);
			   		$nuevoAncho = 128;
			   		$nuevoAlto = 128;
			   		#CREAMOS DIRECTORIO DONDE GUARDAREMOS LA FOTO
			   		$directorio = "vistas/img/usuarios/";
			   		if($_FILES["fotoOpinion"]["type"] == "image/jpeg"){
			   			$aleatorio = mt_rand(100, 9999);

			   			$ruta=$directorio.$aleatorio.".jpg";

			   			$origen=imagecreatefromjpeg($_FILES["fotoOpinion"]["tmp_name"]);

			   			$destino=imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagejpeg($destino, $ruta);
			   		}elseif($_FILES["fotoOpinion"]["type"] == "image/png"){
			   			$aleatorio = mt_rand(100, 9999);

			   			$ruta=$directorio.$aleatorio.".png";

			   			$origen=imagecreatefrompng($_FILES["fotoOpinion"]["tmp_name"]);

			   			$destino=imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			   			imagealphablending($destino, FALSE);

			   			imagesavealpha($destino, TRUE);

			   			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			   			imagepng($destino, $ruta);

			   		}else{
			   			return "error-formato";
			   		}
			   	}else{
			   		$ruta="vistas/img/usuarios/default.png";
			   	}

			   	$tabla="opiniones";
			   	$datos=array("id_art"=>$_POST["id_art"],
			   				"nombre_opinion"=>$_POST["nombre_opinion"],
			   				"correo_opinion"=>$_POST["correo_opinion"],
			   				"foto_opinion"=>$ruta,
			   				"contenido_opinion"=>$_POST["contenido_opinion"],
			   				"fecha_opinion"=>date('Y-m-d'),
			   				"id_adm"=>1);
			   	$respuesta=ModeloBlog::mdlEnviarOpinion($tabla,$datos);
			   	return $respuesta;
				
			}else{
				return "error";
			}
		}
	}

#ACTUALIZAR VISTAS ARTICULOS
static public function ctrActualizarVista($ruta){
	$articulo=controladorBlog::ctrMostrarConInnerJoin(0,1,"ruta_articulo",$ruta);
	$valor=$articulo[0]["vistas_articulo"]+1;
	$tabla="articulos";
	$respues=ModeloBlog::mdlActualizarVista($tabla,$valor,$ruta);
}
#ARTICULOS DESTACADOS
		static public function ctrArticulosDestacados($item,$valor){
			$tabla="articulos";		
			$respuesta = ModeloBlog::mdlArticulosDestacados($tabla,$item,$valor);
			return $respuesta;
		}
#BUSCADOR
		static public function ctrBuscador($desde,$cantidad,$busqueda){
			$tabla1="categorias";
			$tabla2="articulos";
			$respuesta=ModeloBlog::mdlBuscador($tabla1,$tabla2,$desde,$cantidad,$busqueda);
			return $respuesta;
		}
		static public function ctrTotalBuscador($busqueda){
			$tabla="articulos";
			$respuesta=ModeloBlog::mdlTotalBuscador($tabla,$busqueda);
			return $respuesta;
		}
#ANUNCIOS
		static public function ctrTraerAnuncios($valor){
			$tabla="anuncios";
			$respuesta=ModeloBlog::mdlTraerAnuncios($tabla, $valor);
			return $respuesta;
		}
		static public function ctrTraerBanner($valor){
			$tabla="banner";
			$respuesta=ModeloBlog::mdlTraerBanner($tabla, $valor);
			return $respuesta;
		}


}