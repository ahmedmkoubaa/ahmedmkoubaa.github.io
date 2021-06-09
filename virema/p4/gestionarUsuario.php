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


   // verificar que tenemos segundo argumento esto es de prueba
   if (isset($_GET['accion'])) {
      $accion = $_GET['accion'];

      if ($accion == "EDIT"){
         $plantilla = "formularioEditarUsuario.html";

         if (isset($_GET['idUser'])){
            $idUser = $_GET['idUser'];
            $tipo =  $_SESSION['user_tipo'];

            $parametros = [
               'usuario' => getUserPorId($idUser),
               'tipo' => $tipo,
               'submit' => "Editar datos de usuario",
               'redireccion' => "processGestionarUsuario.php?accion=" . $accion . "&idUser=" . $idUser,
               'superuser' => "SUPER"
            ];
         } else {
            $parametros = [
               'usuario' => getUser($_SESSION['user']),
               'tipo' => $tipo,
               'submit' => "Editar mis datos",
               'redireccion' => "processGestionarUsuario.php?accion=" . $accion
            ];
         }
      }
      else if ($accion == "REMOVE" && isset($_GET['idUser'])) {
         $idUser = $_GET['idUser'];
         $tipo =  $_SESSION['user_tipo'];

         $plantilla = "eliminarUsuario.html";
         $parametros = [
            'usuario' => getUserPorId($idUser),
            'tipo' => $tipo,
            'redireccion' => "processGestionarUsuario.php?accion=" . $accion . "&idUser=" . $idUser,
            'submit' => 'Eliminar usuario'
         ];
      } else {
         $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
      }

   } else {
      $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
   }

   echo $twig->render($plantilla, $parametros);

?>
