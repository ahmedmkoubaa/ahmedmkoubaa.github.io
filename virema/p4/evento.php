<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);


   // session_destroy(); // antes de empezar
   session_start();
   $usuario = false;
   $tipo = false;

   // Procesar entrada, valores incorrectos inyecciones etc
   if (isset($_GET['evento'])){
      $idEv = $_GET['evento'];
   } else {
      $idEv = -1; // Valor incorrecto
   }


   if (!isset($_SESSION['user'])) {
      $anonimo = true;
   } else {
      $tipo =  $_SESSION['user_tipo'];
      $usuario = getUser($_SESSION['user']);
   }

   $censura = getPalabrasCensuradas();
   $comentarios = getComentarios($idEv);
   $evento = getEvento($idEv);

   echo $twig->render('evento.html', [
         'id' => $evento['id'],
         'titulo' => $evento['nombre'],
         'sinopsis' => $evento['sinopsis'],
         'coste' => $evento['coste'],
         'duracion' => $evento['duracion'],
         'fecha' => $evento['fecha'],
         'trailer' => $evento['trailer'],
         'censuradas' => $censura,
         'comentarios' => $comentarios,
         'usuario' => $usuario,
         'tipo' => $tipo
      ]);

?>
