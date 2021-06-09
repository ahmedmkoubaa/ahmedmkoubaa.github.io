<?php
   // require_once "vendor/autoload.php";
   // require_once "php/database.php";
   //
   // $loader = new \Twig\Loader\FilesystemLoader('templates');
   // $twig = new \Twig\Environment($loader);
   //
   // session_start();
   //
   // if ($_SERVER['REQUEST_METHOD'] === 'POST'){
   //    $nombre =    $_POST['nombre'];
   //    $apellidos = $_POST['apellidos'];
   //    $fecha =     $_POST['fecha'];
   //    $email = $_POST['email'];
   //
   //
   //    // habría que hacer el check, pero nosotros lo vamos a dar por hecho
   //    // el check es verificar si fue registrado previamente
   //
   //    if (isset($_SESSION['user'])){
   //       $user = $_SESSION['user'];
   //       $editado = false;
   //
   //       if (isset($_GET['idUser'])){
   //          $tipo = $_POST['tipo'];
   //          $idUser = $_GET['idUser'];
   //
   //          $editado = editarUsuarioPorId($idUser, $nombre, $apellidos, $fecha, $email, $tipo);
   //       }
   //       else {
   //          $editado = editarInfoUsuario($user, $nombre, $apellidos, $fecha);
   //       }
   //
   //       // si fue editado correctamente entonces redireccionamos a la pagina principal
   //       if ($editado) header("Location: index.php");
   //
   //    }
   //    else {
   //       echo "NO SE PUDO EDITAR CORRECTAMENTE";
   //    }
   // }


   require_once "vendor/autoload.php";
   require_once "php/database.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   session_start();
   $tipo = false;

   if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $nombre =    $_POST['nombre'];
      $apellidos = $_POST['apellidos'];
      $fecha =     $_POST['fecha'];
      $email =     $_POST['email'];


      // habría que hacer el check, pero nosotros lo vamos a dar por hecho
      // el check es verificar si fue registrado previamente

      if (isset($_GET['accion'])) {
         $accion = $_GET['accion'];

         if (isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $idUser = $_GET['idUser'];
            $tipo =  $_SESSION['user_tipo'];

            $correcto = false;


            if ($accion == "EDIT") {
               if (isset($_GET['idUser'])){
                  $tipo_edit = $_POST['tipo'];
                  $correcto = editarUsuarioPorId($idUser, $nombre, $apellidos, $fecha, $email, $tipo_edit);
               }
               else {
                  $correcto = editarInfoUsuario($user, $nombre, $apellidos, $email, $fecha);
               }

            } else if ($accion == "REMOVE"){
               $confirmacion = $_POST['confirmacion'];

               if ($confirmacion == true) {
                  $correcto = eliminarUsuarioPorId($idUser);
                  if ($correcto) header("Location: index.php");

               } else {
                  $plantilla = "eliminarUsuario.html";
                  $parametros = [
                     'usuario' => getUserPorId($idUser),
                     'tipo' => $tipo,
                     'redireccion' => "processGestionarUsuario.php?accion=" . $accion . "&idUser=" . $idUser,
                     'submit' => 'Eliminar usuario',
                     'mensaje' => "Marca la casilla de confirmacion para confirmar el borrado"
                  ];

                  echo $twig->render($plantilla, $parametros);
               }

            }

            if ($correcto) header("Location: listarUsuarios.php");
         }

      }
      else {
         echo "NO SE PUDO EDITAR CORRECTAMENTE";
      }
   }

?>
