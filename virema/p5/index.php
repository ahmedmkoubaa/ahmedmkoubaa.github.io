<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   // session_destroy(); // antes de empezar
   session_start();
   $usuario = false;
   $tipo = false;
   $publicados = true;

   if (isset($_SESSION['user'])) {
      $usuario = getUser($_SESSION['user']);
      $tipo = $_SESSION['user_tipo'] = $usuario['tipo'];
      $foto_perfil = $_SESSION['foto_perfil'] = $usuario['foto_perfil'];
   }

   // listar todos solo cuando tengamos gestor o super
   if ($tipo == "GESTOR" || $tipo == "SUPER")
      $publicados = false;


   if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $busqueda = $_POST['barra_busqueda'];
      $eventos = buscarEventoAjax($busqueda, $publicados);
   } else {
      $eventos = getListaEventos($publicados);
   }

   echo $twig->render('index.html', [
      'eventos' => $eventos,
      'tipo' => $tipo,
      'foto_perfil' => $foto_perfil
   ]);
?>
