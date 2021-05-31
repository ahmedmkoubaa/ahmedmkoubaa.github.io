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
      $foto_perfil = $_SESSION['foto_perfil'];
   }

   echo $twig->render('listaUsuarios.html', [
      'usuarios' => $listaUsuarios,
      'tipo' => $tipo,
      'foto_perfil' => $foto_perfil,
      'superuser' => $tipo
   ]);

?>
