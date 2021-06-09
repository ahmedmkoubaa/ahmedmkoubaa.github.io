<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);


   // session_destroy(); // antes de empezar
   session_start();
   $tipo = false;
   $usuario = false;

   $plantilla = "plantillaFormulario.html";
   $parametros = [
      'tipo' => $tipo,
      'mensaje' => 'Ha habido un error',
   ];

   if (isset($_SESSION['user'])) {
      $usuario = $_SESSION['user'];
      $tipo = $_SESSION['user_tipo'];
      $foto_perfil = $_SESSION['foto_perfil'] ;

      if ($tipo == "MODERADOR" || $tipo == "GESTOR" || $tipo == "SUPER") {

         // comprobar que tenemos un metodo post con los datos necesarios
         if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // verificar que tenemos primer parametro
            if (isset($_GET['accion'])){
               $accion = $_GET['accion'];
               $idCom = $_GET['idCom'];

               // comprobar que tenemos el id del comentario sobre el
               //  que se quiere ejecutar alguna accion de gestion
               if (isset($_GET['idCom'])){

                  // obtener evento de la base de datos

                  $texto = $_POST['texto'];
                  $idEv = $_GET['idEv'];

                  if ($accion == "EDIT"){
                     // Vamos a editar un evento que ya existia
                     $editado = editarTextoComentario($idCom, $texto);
                     if ($editado) header("Location: evento.php?evento=${idEv}");

                  }
                  else if ($accion == "REMOVE") {
                     // Eliminarmos el evento identificado con idEv
                     $confirmacion = $_POST['confirmacion'];

                     if ($confirmacion == true) {

                        $eliminado = eliminarComentario($idCom);

                        if ($eliminado) header("Location: evento.php?evento=${idEv}");
                     } else {
                        $plantilla = "formularioEliminarComentario.html";
                        $parametros = [
                           'tipo' => $tipo,
                           'foto_perfil' => $foto_perfil,
                           'redireccion' => "processGestionarComentario.php?accion=" . $accion . "&idCom=" . $idCom,
                           'submit' => 'Eliminar Evento',
                           'comentario' => getComentario($idCom),
                           'mensaje' => "Marca la casilla si quieres confirmar borrado"
                        ];
                        echo $twig->render($plantilla, $parametros);
                     }
                  } else {
                     $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
                  }

               } else {
                  $idEv = -1; // Valor incorrecto
                  $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en el id del evento";
               }
            } else {
               $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
            }
         }
      } else {
         $parametros['mensaje'] = "Error: no tiene suficientes permisos";
      }
   } else {
      $parametros['mensaje'] = "Usuario no logueado, logueese o registrese";
   }

   echo $twig->render($plantilla, $parametros);

?>
