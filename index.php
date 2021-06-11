<?php 
require_once "controladores/plantilla.controlador.php";
require_once "controladores/blog.controlador.php";
require_once "modelos/blog.modelo.php";
require_once "extensiones/vendor/autoload.php";
require_once "controladores/correo.controlador.php";
$plantilla = new ControladorPlantilla();
$plantilla -> ctrTraerPlantilla();