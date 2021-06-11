@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

   <!-- Content Header (Page header) -->
  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">Opiniones</h1>
          
        </div><!-- /.col -->
        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>

            <li class="breadcrumb-item active">Opiniones</li>

          </ol>

        </div><!-- /.col -->

      </div><!-- /.row -->

    </div><!-- /.container-fluid -->

  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-lg-12">

          <div class="card card-primary card-outline">

            <div class="card-body">

              <table class="table table-bordered table-striped dt-responsive" id="tablaOpiniones" width="100%">

                <thead>

                  <tr>

                    <th width="10px">#</th>
                    <th>Artículo</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Foto</th>  
                    <th>Opinión</th> 
                    <th>Fecha Opinión</th> 
                    <th>Aprobación</th> 
                    <th>Administrador</th> 
                    <th>Respuesta</th>
                    <th>fecha Respuesta</th>                 
                    <th>Acciones</th>         

                  </tr> 

                </thead>  

              </table>

      
            </div>

          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->

  </div>
  <!-- /.content -->
</div>

<!--=====================================
Modal Editar Artículo
======================================-->

@if (isset($status))
                 
  @if ($status == 200)
    
    @foreach ($opinion as $key => $value)

    <div class="modal" id="editarOpinion">

      <div class="modal-dialog modal-lg">

        <div class="modal-content">

           <form action="{{url('/')}}/opiniones/{{$value->id_opinion}}" method="post">

              @method('PUT')

              @csrf

            <div class="modal-header bg-info">
              <h4 class="modal-title">Editar Opinion</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

               {{-- nombre articulo --}}
               
              <div class="input-group mb-3">

                <div class="input-group-append input-group-text">
                  <i class="fas fa-list-ul"></i>
                </div>

                @foreach ($articulos as $element)
                  @if ($element->id_articulo == $value->id_art)
                    <input type="text" class="form-control" value="{{$element->titulo_articulo}}" readonly>
                  @endif
                @endforeach
                
              </div>
            
              {{-- Nombre Opinion --}}
                        
              <div class="input-group mb-3">

                <div class="input-group-append input-group-text">
                  <i class="fas fa-list-ul"></i>
                </div>

                <input type="text" class="form-control" name="nombre_opinion" placeholder="Ingrese el nombre de la opinion" value="{{$value->nombre_opinion}}" required readonly> 

              </div> 

              {{-- Descripción artículo --}}
                      
              <div class="input-group mb-3">
         
                <div class="input-group-append input-group-text">
                  <i class="fas fa-pencil-alt"></i>
                </div>

                <input type="email" class="form-control" name="correo_opinion" value="{{$value->correo_opinion}}" readonly> 

              </div> 

               {{-- Ruta artículo --}}
                      
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Contenido opinion</span>
                </div>
                <textarea readonly class="form-control" aria-label="With textarea">{{$value->contenido_opinion}}</textarea>
              </div>  

              <hr class="pb-2">

               {{-- Aprobacion --}}
                      
               <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Opciones</label>
                </div>
                <select name="aprobacion_opinion" class="custom-select" id="inputGroupSelect01">
                  <option selected>Escoje una opcion</option>
                  <option value="0">No aprobado</option>
                  <option value="1">Aprobado</option>
                </select>
              </div> 

              <hr class="pb-2">

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Respuesta</span>
                </div>
                <textarea  name="respuesta_opinion" class="form-control" aria-label="With textarea">{{$value->respuesta_opinion}}</textarea>
              </div>
              @foreach ($administradores as $element)

                 @if ($_COOKIE["email_login"] == $element->email)
                    <input name="id_adm" type="hidden" value="{{$element->id}}">
                 @endif
           
               @endforeach
            <!-- Modal footer -->
            <div class="modal-footer d-flex justify-content-between">

              <div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>

              <div>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  @endforeach

  <script>
  $("#editarOpinion").modal()
  </script>

  @endif

@endif

@if (Session::has("no-validacion"))

  <script>
      notie.alert({ type: 2, text: '¡Hay campos no válidos en el formulario!', time: 10 })
 </script>

@endif

@if (Session::has("error"))

  <script>
      notie.alert({ type: 3, text: '¡Error en el gestor de opiniones!', time: 10 })
 </script>

@endif

@if (Session::has("ok-editar"))

  <script>
      notie.alert({ type: 1, text: '¡La Opinion ha sido actualizado correctamente!', time: 10 })
 </script>

@endif

@endsection