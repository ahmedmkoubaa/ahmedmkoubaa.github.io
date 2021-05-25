<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   session_start();

   echo $twig->render('login.html', [
      "submit" => "Loguearse",
      'redireccion' => "processLogin.php"]);

?>
