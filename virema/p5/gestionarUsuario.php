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
      'tipo' => $tipo
   ];


   // verificar que tenemos segundo argumento esto es de prueba
   if (isset($_GET['accion'])) {
      $accion = $_GET['accion'];
      $foto_perfil = $_SESSION['foto_perfil'] ;

      if ($accion == "EDIT"){
         $plantilla = "formularioEditarUsuario.html";
         $tipo =  $_SESSION['user_tipo'];

         if (isset($_GET['idUser'])){
            $idUser = $_GET['idUser'];

            $parametros = [
               'usuario' => getUserPorId($idUser),
               'tipo' => $tipo,
               'foto_perfil' => $foto_perfil,
               'submit' => "Editar datos de usuario",
               'redireccion' => "processGestionarUsuario.php?accion=" . $accion . "&idUser=" . $idUser,
               'superuser' => "SUPER"
            ];
         } else {
            $parametros = [
               'usuario' => getUser($_SESSION['user']),
               'tipo' => $tipo,
               'foto_perfil' => $foto_perfil,
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
            'foto_perfil' => $foto_perfil,
            'redireccion' => "processGestionarUsuario.php?accion=" . $accion . "&idUser=" . $idUser,
            'submit' => 'Eliminar usuario',
            'superuser' =>  'SUPER'
         ];
      } else {
         $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
      }

   } else {
      $parametros['mensaje'] = "ERROR: URL incorrecta, fallo en la acción";
   }

   echo $twig->render($plantilla, $parametros);

?>
