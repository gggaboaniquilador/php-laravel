<?php 

require_once "conexion.php";

Class ModeloBlog{

	#MOSTRAR CONTENIDO TABLA BLOG

	static public function mdlMostrarBlog($tabla){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt=null;
	}

	static public function mdlMostrarCategorias($tabla,$item,$valor){
		if ($item != null && $valor != null) {
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");
		$stmt ->bindparam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		}else{
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetchAll();
		}
		
		$stmt -> close();
		$stmt=null;
	}
	#MOSTAR ARTICULOS Y CATEGORIAS CON INNER JOIN
	static public function mdlMostrarConInnerJoin($tabla1,$tabla2,$desde,$cantidad,$item,$valor){
		if ($item==null&&$valor==null) {
			$stmt=Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, DATE_FORMAT(fecha_articulo, '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");
		$stmt -> execute();
		return $stmt -> fetchAll();
		
		}else{
		$stmt=Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, DATE_FORMAT(fecha_articulo, '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat WHERE $item = :$item ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");
		$stmt ->bindparam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		}
		
		$stmt -> close();
		$stmt=null;
	}
	#MOSTRAR EL TOTAL DE ARTICULOS
	static public function mdlMostrarTotalArticulos($tabla, $item, $valor){
		if ($item==null&&$valor==null) {
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
		$stmt -> execute();
		return $stmt -> fetchAll();
		
		}else{
			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id_articulo DESC");
			$stmt ->bindparam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		}
		$stmt -> close();
		$stmt=null;
	}
	static public function mdlMostrarOpiniones($tabla1,$tabla2,$item,$valor){

			$stmt=Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_adm = $tabla2.id_admin WHERE $item = :$item");
			$stmt ->bindparam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> close();
			$stmt=null;
		}

		static public function mdlEnviarOpinion($tabla,$datos){

			$stmt=Conexion::conectar()->prepare("INSERT $tabla(id_art, nombre_opinion, correo_opinion, foto_opinion, contenido_opinion, fecha_opinion, id_adm) value(:id_art, :nombre_opinion, :correo_opinion, :foto_opinion, :contenido_opinion, :fecha_opinion, :id_adm)");

			$stmt -> bindParam(":id_art", $datos["id_art"], PDO::PARAM_STR);
			$stmt -> bindParam(":nombre_opinion", $datos["nombre_opinion"], PDO::PARAM_STR);
			$stmt -> bindParam(":correo_opinion", $datos["correo_opinion"], PDO::PARAM_STR);
			$stmt -> bindParam(":foto_opinion", $datos["foto_opinion"], PDO::PARAM_STR);
			$stmt -> bindParam(":contenido_opinion", $datos["contenido_opinion"], PDO::PARAM_STR);
			$stmt -> bindParam(":fecha_opinion", $datos["fecha_opinion"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_adm", $datos["id_adm"], PDO::PARAM_STR);
			if ($stmt -> execute()) {
				return "ok";
			}else{
				print_r(Conexion::conectar()->errorInfo());
			}
			$stmt -> close();
			$stmt=null;
		}
		#ACTUALIZAR VISTA ARTICULO
		static public function mdlActualizarVista($tabla,$valor,$ruta){
			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET vistas_articulo=:vistas_articulo WHERE ruta_articulo=:ruta_articulo");
			$stmt -> bindParam(":vistas_articulo", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":ruta_articulo", $ruta, PDO::PARAM_STR);
			if ($stmt->execute()) {
				return "ok";
			}else{
				print_r(Conexion::conectar()->errorInfo());
			}
			$stmt -> close();
			$stmt=null;
		}
		#ARTICULOS DESTACADOS
		static public function mdlArticulosDestacados($tabla,$item,$valor){
			if ($item != null && $valor != null) {
				$stmt=Conexion::conectar()->prepare("SELECT * FROM  $tabla WHERE $item=:$item ORDER BY vistas_articulo DESC LIMIT 3");
				$stmt ->bindparam(":".$item, $valor, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetchAll();	
			}else{
				$stmt=Conexion::conectar()->prepare("SELECT * FROM  $tabla ORDER BY vistas_articulo DESC LIMIT 3");
				$stmt -> execute();
				return $stmt -> fetchAll();	
		}
			$stmt -> close();
			$stmt=null;
	}
	static public function mdlBuscador($tabla1,$tabla2,$desde,$cantidad,$busqueda){
		$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, DATE_FORMAT(fecha_articulo, '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat WHERE titulo_articulo like '%$busqueda%' OR descripcion_articulo like '%$busqueda%' OR contenido_articulo like '%$busqueda%' OR ruta_articulo like '%$busqueda%' OR p_claves_articulo like '%$busqueda%' ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");
		$stmt -> execute();
		return $stmt -> fetchAll();	
		$stmt -> close();
		$stmt=null;
	}
	static public function mdlTotalBuscador($tabla,$busqueda){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta_articulo like '%$busqueda%' OR titulo_articulo like '%$busqueda%' OR descripcion_articulo like '%$busqueda%' OR contenido_articulo like '%$busqueda%' OR ruta_articulo like '%$busqueda%' OR p_claves_articulo like '%$busqueda%'");

		$stmt -> execute();
		return $stmt -> fetchAll();	
		$stmt -> close();
		$stmt=null;
	}
	static public function mdlTraerAnuncios($tabla,$valor){
				$stmt=Conexion::conectar()->prepare("SELECT * FROM  $tabla WHERE pagina_anuncio=:pagina_anuncio");
				$stmt ->bindparam(":pagina_anuncio", $valor, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetchAll();	
				$stmt -> close();
				$stmt=null;

	}
	
	static public function mdlTraerBanner($tabla,$valor){
				$stmt=Conexion::conectar()->prepare("SELECT * FROM  $tabla WHERE pagina_banner=:pagina_banner");
				$stmt ->bindparam(":pagina_banner", $valor, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetchAll();	
				$stmt -> close();
				$stmt=null;
	}
}
