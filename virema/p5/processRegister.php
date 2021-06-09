<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $user =      $_POST['user'];
      $pass =      $_POST['pass'];
      $nombre =    $_POST['nombre'];
      $apellidos = $_POST['apellidos'];
      $fecha =     $_POST['fecha'];
      $email =     $_POST['email'];

      // habría que hacer el check, pero nosotros lo vamos a dar por hecho
      // el check es verificar si fue registrado previamente
      if (registerNewUSer($user, $pass, $nombre, $apellidos, $fecha, $email)) {
         // si se registro exitosamente, entonces se iniciará la sesion con el nomrbe indicado
         session_start();
         $_SESSION['user'] = $user; // guardo en la sesion el usrername para la proxima vez
         header("Location: index.php");
      }
   }


   echo $twig->render('register.html', [
      'submit' => 'Registrarse',
      'redireccion' => "processRegister.php",
      "mensaje" => "Usuario ya existente, seleccione otro nombre o logueese"
   ]);

?>
