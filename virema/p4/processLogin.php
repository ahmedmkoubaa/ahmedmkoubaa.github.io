<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $user = $_POST['user'];
      $pass = $_POST['pass'];


      // verificar que el usuario fue registrado previamente
      if (checkLogin($user, $pass)) {
         session_start();
         $_SESSION['user'] = $user; // guardo en la sesion el nick para la proxima vez

         // $_SESSION['userData'] = getUser($user);

         header("Location: index.php");
      }
   }

   echo $twig->render('login.html', [
      'submit'      => "Loguearse",
      'redireccion' => "processLogin.php",
      'mensaje'     => "Usuario o contraseña incorrectos"
   ]);

?>
