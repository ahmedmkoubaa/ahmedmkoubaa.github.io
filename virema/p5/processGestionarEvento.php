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

      if ($tipo == "GESTOR" || $tipo == "SUPER") {

         // comprobar que tenemos un metodo post con los datos necesarios
         if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // verificar que tenemos primer parametro
            if (isset($_GET['accion'])){
               $accion = $_GET['accion'];

               if ($accion == 'ADD' || $accion == 'EDIT') {

                  $nombre    = $_POST['nombre'];
                  $sinopsis  = $_POST['sinopsis'];
                  $imagen    = $_POST['imagen'];
                  $trailer   = $_POST['trailer'];
                  $coste     = $_POST['coste'];
                  $duracion  = $_POST['duracion'];
                  $fecha     = $_POST['fecha'];
                  $alt       = $_POST['alt'];
                  $tags      = $_POST['etiquetas'];
                  $publicado = $_POST['publicado'];

                  $tags = explode(",", $tags);

                  // echo "Este es el publicado " . $publicado . " y su tipo es " . gettype($publicado);

                  if ($publicado == "1") $publicado = 1;
                  else                   $publicado = 0;

                  // $publicado = intval($publicado);
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
                     $alt,
                     $tags,
                     $publicado
                  );

                  if ($aniadido == true) {
                     $plantilla = "plantillaFormularioEvento.html";
                     $parametros = [
                        'tipo' => $tipo,
                        'foto_perfil' => $foto_perfil,
                        'redireccion' => "processGestionarEvento.php?accion=" . $accion,
                        'submit' => 'Añadir evento',
                        'mensaje' => $nombre . " añadido correctamente!"
                     ];

                     header("location: index.php");
                     // quiero renderizar la pagina limpiando lo que habia antes
                     // echo $twig->load($plantilla, $parametros);
                  }

               } else {

                  // comprobar que tenemos el id del evento sobre el
                  //  que se quiere ejecutar alguna accion de gestion
                  if (isset($_GET['evento'])){

                     // obtener evento de la base de datos
                     $idEv = $_GET['evento'];
                     // $evento = getEvento($idEv);

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
                           $alt,
                           $tags,
                           $publicado
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
                              'tipo' => $tipo,
                              'foto_perfil' => $foto_perfil,
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
