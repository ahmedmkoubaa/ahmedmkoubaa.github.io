<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   session_start();

   if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $nombre =    $_POST['nombre'];
      $apellidos = $_POST['apellidos'];
      $fecha =     $_POST['fecha'];
      $email =     $_POST['email'];

      if (isset($_SESSION['user'])){
         $user = $_SESSION['user'];

         $user = $_SESSION['user'];
         $correcto = editarInfoUsuario($user, $nombre, $apellidos, $email, $fecha);

         if ($correcto) header("Location: listarUsuarios.php");
      }

      // habría que hacer el check, pero nosotros lo vamos a dar por hecho
      // el check es verificar si fue registrado previamente

      // if (isset($_GET['accion'])) {
      //    $accion = $_GET['accion'];
      //
      //
      //
      // }
      // else {
      //    echo "NO SE PUDO EDITAR CORRECTAMENTE";
      // }
   }

?>
