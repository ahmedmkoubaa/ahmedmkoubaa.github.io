<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);


   // session_destroy(); // antes de empezar
   session_start();
   $tipo = false;


   $plantilla = "plantillaFormulario.html";
   $parametros = [
      'mensaje' => 'Ha habido un error',
      'tipo' => $tipo
   ];

   if (isset($_SESSION['user'])) {
      $usuario = $_SESSION['user'];
      $tipo = $_SESSION['user_tipo'];
      $foto_perfil = $_SESSION['foto_perfil'];

      // if ($tipo == "REGISTRADO" || $tipo == "MODERADOR" || $tipo == "GESTOR" || $tipo == "SUPER") {

         // verificar que tenemos segundo argumento esto es de prueba
         if (isset($_GET['accion']) ){
            $accion = $_GET['accion'];
            $idEv = $_GET['idEv'];

            if ($accion == 'ADD' && isset($_GET['idEv']) && isset($_GET['nombreUser']) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
               $idEv =          $_GET['idEv'];
               $nombreUsuario = $_GET['nombreUser'];
               $texto = $_POST['texto'];

               if (aniadirComentario($nombreUsuario, $idEv, $texto)) {
                  header("Location: evento.php?evento=${idEv}");
               }

            } else {
               // comprobar que tenemos el id del evento sobre el
               //  que se quiere ejecutar alguna accion de gestion
               if (isset($_GET['idCom'])){

                  // obtener evento de la base de datos
                  $idCom = $_GET['idCom'];
                  $comentario = getComentario($idCom);
                  $idEv = $_GET['idEv'];

                  $redireccion = "processGestionarComentario.php?accion=${accion}&idCom=${idCom}&idEv=${idEv}";

                  if ($accion == "EDIT"){
                     $plantilla = "formularioEditarComentario.html"; // crear esto
                     $parametros = [
                        'tipo' => $tipo,
                        'foto_perfil' => $foto_perfil,
                        'redireccion' => $redireccion ,
                        'submit' => 'Editar evento',
                        'comentario' => $comentario
                     ];
                  }
                  else if ($accion == "REMOVE") {
                     $idEv = $_GET['idEv'];

                     $plantilla = "formularioEliminarComentario.html";
                     $parametros = [
                        'tipo' => $tipo,
                        'foto_perfil' => $foto_perfil,
                        'redireccion' => $redireccion ,
                        'submit' => 'Eliminar comentario',
                        'comentario' => $comentario
                     ];
                  } else {
                     $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
                  }

               } else {
                  $idEv = -1; // Valor incorrecto
                  $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en el id del evento";
               }
            }

         } else {
            $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
         }

   } else {
      $parametros['mensaje'] = "Usuario no logueado, logueese o registrese";
   }

   echo $twig->render($plantilla, $parametros);

?>
