<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   session_start();
   $tipo = false;
   // si el usuario está registrado
   if (isset($_SESSION['user'])) {
      $tipo =  $_SESSION['user_tipo'];
      $listaUsuarios = getListaUsuarios();
   }

   echo $twig->render('listaUsuarios.html', [
      'usuarios' => $listaUsuarios,
      'tipo' => $tipo,
      'usuario' => true
   ]);

?>
