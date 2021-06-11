<div class="container-fluid bg-white">
	<div class="container py-4">
		<div class="row">
			 <div class="col-12 col-lg-6">
				<?php 
					echo $blog["sobre_mi_completo"];
				 ?>
			 </div>
			 <div class="col-12 col-lg-6">
				<h4 class="mt-4">Contactenos</h4>
				<form method="post">
					<input type="text" class="form-control my-3" name="nombreContacto" placeholder="Nombre y Apellido" require>
					<input type="email" class="form-control my-3" name="emailContacto" placeholder="Escriba su correo electronico" require>
					<textarea name="mensajeContacto" class="form-control my-3" cols="30" rows="10"></textarea>
					<input type="submit" value="Enviar" class="btn btn-primary">
					<?php 

					$enviarCorreo= ControladorCorreo::ctrEnviarCorreo();


					if ($enviarCorreo != "") {
						echo '<script>

							if ( window.history.replaceState ) {

								window.history.replaceState( null, null, window.location.href );

							}

						</script>';
						if ($enviarCorreo=="ok") {
							echo '<script>
								notie.alert({
									type:1,
									text:"el correo ha sido enviada correctamente",
									time:5,
									})
							</script>';
						}

						if ($enviarCorreo=="error") {
							echo '<script>
								notie.alert({
									type:3,
									text:"el correo no se ha podido enviar",
									time:5,
									})
							</script>';
						}
						if ($enviarCorreo=="error-formato") {
							echo '<script>
								notie.alert({
									type:3,
									text:"el correo no se ha podido enviar debido a error de formato",
									time:5,
									})
							</script>';
						}

					}


					 ?>
				</form>
			 </div>
		 </div>
	</div>
</div>