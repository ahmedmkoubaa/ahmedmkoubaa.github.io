<?php
   require_once "vendor/autoload.php";
   require_once "php/database.php";
   require_once "php/subirImagen.php";

   $loader = new \Twig\Loader\FilesystemLoader('templates');
   $twig = new \Twig\Environment($loader);

   session_start();
   $tipo = false;
   $redireccion = "index.php";

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
            $foto_perfil = $_SESSION['foto_perfil'] ;

            $correcto = false;


            if ($accion == "EDIT") {
               $resultados = procesarPostImagen();


               if (isset($_GET['idUser']) && $tipo){
                  $tipo_edit = $_POST['tipo'];
                  $redireccion = "listarUsuarios.php";

                  $correcto = editarUsuarioPorId($idUser, $nombre, $apellidos, $fecha, $email, $tipo_edit);
               }
               else {

                  if (isset($resultados["imagen"])) {
                     $ruta_foto = $resultados["imagen"];
                     // echo "esta es la ruta de la foto ${ruta_foto}";

                     $correcto = editarInfoUsuario($user, $nombre, $apellidos, $email, $fecha, $ruta_foto);
                     if ($correcto) $_SESSION['foto_perfil'] = $ruta_foto ;
                  } else {
                     echo "ALGO FALLÓ CON LA IMAGEN";
                     print_r($resultados["errores"]);
                  }

               }

            } else if ($tipo == "GESTOR" || $tipo == "MODERADOR" || $tipo == "SUPER"){
               $redireccion = "listarUsuarios.php";

               if ($accion == "REMOVE"){
                  $confirmacion = $_POST['confirmacion'];

                  if ($confirmacion == true) {
                     $correcto = eliminarUsuarioPorId($idUser);
                     if ($correcto) header("Location: index.php");

                  } else {
                     $plantilla = "eliminarUsuario.html";
                     $parametros = [
                        'usuario' => getUserPorId($idUser),
                        'tipo' => $tipo,
                        'foto_perfil' => $foto_perfil,
                        'redireccion' => "processGestionarUsuario.php?accion=" . $accion . "&idUser=" . $idUser,
                        'submit' => 'Eliminar usuario',
                        'mensaje' => "Marca la casilla de confirmacion para confirmar el borrado"
                     ];

                     echo $twig->render($plantilla, $parametros);
                  }

               }
            } else {
               echo "ERROR: permisos insuficientes o url incorrecta";
            }

            if ($correcto) header("Location: ${redireccion}");
         }

      }
      else {
         echo "NO SE PUDO EDITAR CORRECTAMENTE";
      }
   }

?>
