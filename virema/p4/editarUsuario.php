<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   session_start();
   $tipo = false;
   $plantilla = 'formularioEditarUsuario.html';
   $parametros = ['mensaje' => 'Error: no estas logueado'];

   if (isset($_SESSION['user'])){
      $tipo =  $_SESSION['user_tipo'];

      if (isset($_GET['idUser'])){
         $idUser = $_GET['idUser'];

         $parametros = [
            'usuario' => getUserPorId($idUser),
            'tipo' => $tipo,
            'submit' => "Editar datos de usuario",
            'redireccion' => "processEditarUsuario.php?idUser=" . $idUser,
            'superuser' => "SUPER"
         ];
      } else {
         $parametros = [
            'usuario' => getUser($_SESSION['user']),
            'tipo' => $tipo,
            'submit' => "Editar mis datos",
            'redireccion' => "processEditarUsuario.php"
         ];
      }

   }

   echo $twig->render($plantilla, $parametros);

?>
