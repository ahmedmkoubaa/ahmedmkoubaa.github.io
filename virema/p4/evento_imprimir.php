<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   // Procesar entrada, valores incorrectos inyecciones etc
   if (isset($_GET['evento'])){
      $idEv = $_GET['evento'];
   } else {
      $idEv = -1; // Valor incorrecto
   }

   $row = getEvento($idEv);
   echo $twig->render('evento_imprimir.html', [
         'nombre' => $row['nombre'],
         'sinopsis' => $row['sinopsis'],
         'imagen' => $row['imagen']
      ]);
?>
