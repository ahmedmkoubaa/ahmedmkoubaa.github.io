<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   // session_destroy(); // antes de empezar
   session_start();
   $usuario = false;
   $tipo = false;

   if (isset($_SESSION['user'])) {
      $usuario = getUser($_SESSION['user']);
      $tipo = $_SESSION['user_tipo'] = $usuario['tipo'];
   }

   if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $nombreEvento = $_POST['nombreEvento'];
      $eventos = getEventoPorNombreCoincidente($nombreEvento);
   } else {
      $eventos = getListaEventos();
   }

   echo $twig->render('index.html', [
      'eventos' => $eventos,
      'usuario' => $usuario,
      'tipo' => $tipo
   ]);
?>
