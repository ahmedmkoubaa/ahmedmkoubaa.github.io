<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   $nombreTitulo = 'nombre por defecto';
   $eventos = getListaEventos();
   $size = count($eventos['id']);

   echo $twig->render('index.html', ['eventos' => $eventos, 'size' => $size]);

?>
