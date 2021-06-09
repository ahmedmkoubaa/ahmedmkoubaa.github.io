<?php
   require_once "vendor/autoload.php";
   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   // Esta es una funcion del lenguaje PHP
   // Rellena la variable _SESSION["<campo>"]
   session_start();

   if (!isset($_SESSION['count'])) {
      $_SESSION['count'] = 1;
   } else {
      $_SESSION['count']++;
   }

   echo $twig->render('contador.html', ["cuenta" => $_SESSION['count']]);
?>
