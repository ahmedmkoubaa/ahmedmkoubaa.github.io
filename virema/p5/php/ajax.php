<?php
   require_once "database.php";


   // session_destroy(); // antes de empezar
   session_start();
   $usuario = false;
   $todos = false;
   $eventos = [];

   // me quedo con el tipo porque dependiendo de eso, mostraremos todos
   // los eventos o solamente los publicados

   if (isset($_GET['texto'])) {
      $texto = $_GET['texto'];
      $publicado = true;               // En principio se muestran los publicados

      if (isset($_SESSION['user_tipo'])) {

         // quedarse con el tipo de usuario
         $user_tipo = $_SESSION['user_tipo'];

         // si el tipo es gestor o superior, entonces buscaremos entre todos
         // los eventos registrados en la base de datos sin importar su estado
         if ($user_tipo == "GESTOR" || $user_tipo == "SUPER")
            $publicado = false;
      }

      $eventos = buscarEventoAjax($texto, $publicado);

      header('Content-Type: application/json');
      echo( json_encode($eventos) );

   } else {
      echo "El campo texto no ha sido enviado";
   }

?>
