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
      'usuario' => $usuario
   ];

   if (isset($_SESSION['user'])) {
      $usuario = $_SESSION['user'];
      $tipo = $_SESSION['user_tipo'];

      if ($tipo == "GESTOR" || $tipo == "SUPER") {

         // comprobar que tenemos un metodo post con los datos necesarios
         if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // verificar que tenemos primer parametro
            if (isset($_GET['accion'])){
               $accion = $_GET['accion'];

               if ($accion == 'ADD' || $accion == 'EDIT') {
                  $nombre   = $_POST['nombre'];
                  $sinopsis = $_POST['sinopsis'];
                  $imagen   = $_POST['imagen'];
                  $trailer  = $_POST['trailer'];
                  $coste    = $_POST['coste'];
                  $duracion = $_POST['duracion'];
                  $fecha    = $_POST['fecha'];
                  $alt      = $_POST['alt'];
               }

               if ($accion == 'ADD') {
                  $aniadido = aniadirNuevoEvento(
                     $nombre,
                     $sinopsis,
                     $imagen,
                     $trailer,
                     $coste,
                     $duracion,
                     $fecha,
                     $alt
                  );

                  if ($aniadido == true) {
                     $plantilla = "plantillaFormularioEvento.html";
                     $parametros = [
                        'usuario' => $_SESSION['user'],
                        'tipo' => $tipo,
                        'redireccion' => "processGestionarEvento.php?accion=" . $accion,
                        'submit' => 'Añadir evento',
                        'mensaje' => $nombre . " añadido correctamente!"
                     ];

                     echo $twig->render($plantilla, $parametros);
                  }

               } else {

                  // comprobar que tenemos el id del evento sobre el
                  //  que se quiere ejecutar alguna accion de gestion
                  if (isset($_GET['evento'])){

                     // obtener evento de la base de datos
                     $idEv = $_GET['evento'];
                     $evento = getEvento($idEv);

                     if ($accion == "EDIT"){
                        // Vamos a editar un evento que ya existia

                        $editado = editarEvento(
                           $idEv,
                           $nombre,
                           $sinopsis,
                           $imagen,
                           $trailer,
                           $coste,
                           $duracion,
                           $fecha,
                           $alt
                        );

                        if ($editado) header("Location: index.php");
                     }
                     else if ($accion == "REMOVE") {
                        // Eliminarmos el evento identificado con idEv
                        $confirmacion = $_POST['confirmacion'];

                        if ($confirmacion == true) {
                           $eliminado = eliminarEvento($idEv);

                           if ($eliminado) header("Location: index.php");
                        } else {
                           $plantilla = "plantillaFormularioEliminarEvento.html";
                           $parametros = [
                              'usuario' => $usuario,
                              'tipo' => $tipo,
                              'redireccion' => "processGestionarEvento.php?accion=" . $accion . "&evento=" . $idEv,
                              'submit' => 'Eliminar Evento',
                              'evento' =>  $evento = getEvento($idEv),
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
