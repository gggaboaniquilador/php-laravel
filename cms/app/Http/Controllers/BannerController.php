<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Blog;
use App\Administradores;

class BannerController extends Controller
{
    public function index(){

		 if(request()->ajax()){

            return datatables()->of(Banner::all())          
            ->addColumn('acciones', function($data){

                $acciones = '<div class="btn-group">
                            <a href="'.url()->current().'/'.$data->id_banner.'" class="btn btn-warning btn-sm">
                              <i class="fas fa-pencil-alt text-white"></i>
                            </a>
                         
                            <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_banner.'" method="DELETE" token="'.csrf_token().'" pagina="banner"> 
                            <i class="fas fa-trash-alt"></i>
                            </button>

                          </div>';
               
                return $acciones;

            })
            ->rawColumns(['acciones'])
            ->make(true);

        }

		$blog = Blog::all();
		$administradores = Administradores::all();

		return view("paginas.banner", array("blog"=>$blog, "administradores"=>$administradores));

	}

    /*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

        // Recoger los datos

        $datos = array("pagina_banner"=>$request->input("pagina_banner"),
                        "titulo_banner"=>$request->input("titulo_banner"),
                        "descripcion_banner"=>$request->input("descripcion_banner"),
                        "imagen_temporal"=>$request->file("img_banner"));  

        // Recoger datos de la BD blog para las rutas de imágenes 

        $blog = Blog::all();

         // Validar los datos
        // https://laravel.com/docs/5.7/validation
        if(!empty($datos)){
            
            $validar = \Validator::make($datos,[

                "titulo_banner" => "nullable|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "descripcion_banner" => 'nullable|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i' ,
                "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"
            ]);

            //Guardar artículo

            if(!$datos["imagen_temporal"] || $validar->fails()){
   
                return redirect("banner")->with("no-validacion", "");

            }else{ 

                $aleatorio = mt_rand(100,999);

                $ruta = "img/banner/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

                //Redimensionar Imágen

                list($ancho, $alto) = getimagesize($datos["imagen_temporal"]);

                $nuevoAncho = 1440;
                $nuevoAlto = 500;

                if($datos["imagen_temporal"]->guessExtension() == "jpeg"){

                    $origen = imagecreatefromjpeg($datos["imagen_temporal"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagejpeg($destino, $ruta);

                }

                if($datos["imagen_temporal"]->guessExtension() == "png"){

                    $origen = imagecreatefrompng($datos["imagen_temporal"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagealphablending($destino, FALSE); 
                    imagesavealpha($destino, TRUE);
                    imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagepng($destino, $ruta);
                    
                }
           
                $banner = new Banner();
                $banner->pagina_banner = $datos["pagina_banner"];
                $banner->titulo_banner = $datos["titulo_banner"];
                $banner->descripcion_banner = $datos["descripcion_banner"];
                $banner->img_banner = $ruta;
                $banner->save();    

                return redirect("banner")->with("ok-crear", "");
            }

        }else{
         
            return redirect("banner")->with("error", "");

        }

    }

        public function show($id){   

        $banner = Banner::where('id_banner', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();

        if(count($banner) != 0){

            return view("paginas.banner", array("status"=>200, "banner"=>$banner, "blog"=>$blog, "administradores"=>$administradores)); 
        }

        else{
            
            return view("paginas.banner", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array("pagina_banner"=>$request->input("pagina_banner"),
                        "titulo_banner"=>$request->input("titulo_banner"),
                        "descripcion_banner"=>$request->input("descripcion_banner"),
                        "imagen_actual"=>$request->input("imagen_actual"));  


        // Recoger Imagen

        $imagen = array("imagen_temporal"=>$request->file("img_banner"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[

                "titulo_banner" => "nullable|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "descripcion_banner" => 'nullable|regex:/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i' ,
                "imagen_actual" => "required"
            ]);

            if($imagen["imagen_temporal"] != ""){

                $validarImagen = \Validator::make($imagen,[

                    "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"

                ]);

                if($validarImagen->fails()){
               
                    return redirect("/banner")->with("no-validacion", "");

                }

            }

            if($validar->fails()){

                return redirect("/banner")->with("no-validacion", "");

            }else{

                if($imagen["imagen_temporal"] != ""){

                    unlink($datos["imagen_actual"]);

                    $aleatorio = mt_rand(100,999);

                    $ruta = "img/banner/".$aleatorio.".".$imagen["imagen_temporal"]->guessExtension();

                    //Redimensionar Imágen

                    list($ancho, $alto) = getimagesize($imagen["imagen_temporal"]);

                    $nuevoAncho = 1440;
                    $nuevoAlto = 500;

                    if($imagen["imagen_temporal"]->guessExtension() == "jpeg"){

                        $origen = imagecreatefromjpeg($imagen["imagen_temporal"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);

                    }

                    if($imagen["imagen_temporal"]->guessExtension() == "png"){

                        $origen = imagecreatefrompng($imagen["imagen_temporal"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagealphablending($destino, FALSE); 
                        imagesavealpha($destino, TRUE);
                        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                        
                    }

                }else{

                    $ruta = $datos["imagen_actual"];

                }

                $datos = array("pagina_banner" => $datos["pagina_banner"],
                                "titulo_banner" => $datos["titulo_banner"],
                                "descripcion_banner" => $datos["descripcion_banner"],
                                "img_banner" => $ruta);

                $banner = Banner::where('id_banner', $id)->update($datos); 

                return redirect("/banner")->with("ok-editar", "");

            }

        }else{

           return redirect("/banner")->with("error", "");

        }


    }

        public function destroy($id, Request $request){

        $validar = Banner::where("id_banner", $id)->get();
        
        if(!empty($validar)){

            if(!empty($validar[0]["img_banner"])){

                unlink($validar[0]["img_banner"]);
            
            }

            $banner = Banner::where("id_banner",$validar[0]["id_banner"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("banner")->with("no-borrar", "");   

        }

    }

}

