<?php

   function procesarPostImagen($imagen = "imagen", $ruta = "imagenesUsuarios/", $max_size = 2097152) {
      if(isset($_FILES[$imagen])){
          $errors= array();
          $file_name = $_FILES[$imagen]['name'];

          // si el nombre de la imagen no es vacio
          if ($file_name != '') {

            $file_size = $_FILES[$imagen]['size'];
            $file_tmp = $_FILES[$imagen]['tmp_name'];
            $file_type = $_FILES[$imagen]['type'];
            $file_ext = strtolower(end(explode('.',$_FILES[$imagen]['name'])));

            $extensions= array("jpeg","jpg","png");

            if (in_array($file_ext,$extensions) === false){
             $errors[] = "Extensión no permitida, elige una imagen JPEG o PNG.";
            }

            if ($file_size > $max_size){
             $errors[] = 'Tamaño del fichero demasiado grande';
            }

            if (empty($errors)==true) {
             move_uploaded_file($file_tmp, $ruta . $file_name);

             $resultado[$imagen] = $ruta . $file_name;
            }

            if (sizeof($errors) > 0) {
             $resultado['errores'] = $errors;
            }
         } else {
            // si la imagen era vacío, es decir, no había, entonces usamos default
            $resultado[$imagen] = $ruta . 'default.jpg';
         }
      }

      return $resultado;
   }
?>
