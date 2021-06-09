<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);


   // session_destroy(); // antes de empezar
   session_start();
   $usuario = false;
   $tipo = false;
   $plantilla = "plantillaFormulario.html";
   $parametros = [
      'mensaje' => 'Ha habido un error',
      'usuario' => $usuario
   ];

   if (isset($_SESSION['user'])) {
      $usuario = $_SESSION['user'];
      $tipo = $_SESSION['user_tipo'];

      if ($tipo == "GESTOR" || $tipo == "SUPER") {

         // verificar que tenemos segundo argumento esto es de prueba
         if (isset($_GET['accion'])){
            $accion = $_GET['accion'];

            if ($accion == 'ADD') {
               $plantilla = "plantillaFormularioEvento.html";
               $parametros = [
                  'usuario' => $usuario,
                  'tipo' => $tipo,
                  'redireccion' => "processGestionarEvento.php?accion=" . $accion,
                  'submit' => 'Añadir evento',
               ];

            } else {
               // comprobar que tenemos el id del evento sobre el
               //  que se quiere ejecutar alguna accion de gestion
               if (isset($_GET['evento'])){

                  // obtener evento de la base de datos
                  $idEv = $_GET['evento'];
                  $evento = getEvento($idEv);

                  if ($accion == "EDIT"){
                     $plantilla = "plantillaFormularioEvento.html";
                     $parametros = [
                        'usuario' => $usuario,
                        'tipo' => $tipo,
                        'redireccion' => "processGestionarEvento.php?accion=" . $accion . "&evento=" . $idEv,
                        'submit' => 'Editar evento',
                        'evento' =>  $evento = getEvento($idEv)
                     ];


                  }
                  else if ($accion == "REMOVE") {
                     $plantilla = "plantillaFormularioEliminarEvento.html";
                     $parametros = [
                        'usuario' => $usuario,
                        'tipo' => $tipo,
                        'redireccion' => "processGestionarEvento.php?accion=" . $accion . "&evento=" . $idEv,
                        'submit' => 'Eliminar Evento',
                        'evento' =>  $evento = getEvento($idEv)
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
         $parametros['mensaje'] = "Error: no tiene suficientes permisos";
      }
   } else {
      $parametros['mensaje'] = "Usuario no logueado, logueese o registrese";
   }

   echo $twig->render($plantilla, $parametros);

?>
