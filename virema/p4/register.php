<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   echo $twig->render('register.html', [
      'submit' => 'Registrarse',
      'redireccion' => "processRegister.php"
   ]);

?>
