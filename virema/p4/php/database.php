<?php
   $conectado = FALSE;

   function registerNewUser($user, $pass, $nombre, $apellidos, $fecha, $email) {
      $registrado = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      // Si el usuario ya se encuentra registrado en la base de datos
      if (!isUserInBD($user)) {

         //preparamos la consulta reemplazando los datos por el signo ?
         $pr = $mysqli->prepare(
            "INSERT INTO usuarios (username, password, nombre, apellidos, fecha_nacimiento, email)
            VALUES(?, ?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?);");

         if ($pr == false) {
            echo "ha habido un error";
            echo " errores: ";

            print_r($mysqli->error_list);

         } else {
            $userCifrado = $userCifrado = password_hash($user, PASSWORD_DEFAULT);
            $passCifrado = $passCifrado = password_hash($pass, PASSWORD_DEFAULT);

            //Indicamos los valores pasados por referencia
            $pr->bind_param("ssssss", $userCifrado, $passCifrado, $nombre, $apellidos, $fecha, $email);

            //Ejecutamos la consulta
            if($pr->execute()){
               $registrado = true;

               //Cerramos la conexion
               $pr->close();

            } else {
               exit('Error al realizar la consulta: ' . $pr->close());
            }
         }
      }


      return $registrado;
   }

   // Comprobar que el usuario está registrado en la base de datos o no
   // Si lo esta devuelve true si no, devuelve false
   function isUserInBD($user) {
      $check = false;

      $mysqli = conectar();
      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT username FROM usuarios");

      //Ejecutamos la consulta
      if($pr->execute()){

         //Alamacenaos los datos de la consulta
         $pr->store_result();

         if($pr->num_rows == 0){
         	return $check;
         }

         //Indicamos la variable donde se guardaran los resultados
         $pr->bind_result($username);


         //listamos todos los resultados
         while($pr->fetch()){
             if (password_verify($user, $username)) {
                return (true);
             }
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: ' . $pr->close());
      }

      return false;
   }

   function checkLogin($user, $pass) {
      $check = false;

      $mysqli = conectar();
      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT username, password FROM usuarios");

      //Ejecutamos la consulta
      if($pr->execute()){

         //Alamacenaos los datos de la consulta
         $pr->store_result();

         if($pr->num_rows == 0){
         	return $check;
         }

         //Indicamos la variable donde se guardaran los resultados
         $pr->bind_result($username, $passGot);

         // cifrar las credenciales para compararlas

         //listamos todos los resultados
         while($pr->fetch()){
             if (password_verify($user, $username) &&
                 password_verify($pass, $passGot)) {
                  return ($check = true);
             }
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: ' . $pr->close());
      }

      return $check;
   }

   function getUser($user) {

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "SELECT id, nombre, apellidos, username, date_format(fecha_nacimiento,'%d/%m/%Y') as fecha , tipo, email
         FROM usuarios"
      );

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($id, $nombre, $apellidos, $username, $fecha_nacimiento, $tipo, $email);

      	//listamos todos los resultados
      	while($pr->fetch()){
            if (password_verify($user, $username)) {
               $secure_res = [
                  'id' => $id,
                  'nombre' => $nombre,
                  'apellidos' => $apellidos,
                  'tipo' => $tipo,
                  'fecha_nacimiento' => $fecha_nacimiento,
                  'email' => $email
               ];

               // una vez que se encuentra, se devuelve el resultado
               return $secure_res;
            }

      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: ' . $pr->close());
      }

      return $secure_res;
   }

   function conectar() {
      if ($conectado != TRUE){

         // new mysqli(tipo base de datos, nombre usuario, contraseña usuario, nombre base de datos)
         $mysqli = new mysqli("mysql", "ahmed", "12345678", "SIBW");
         if ($mysqli->connect_errno){
            echo("Fallo al conectar: " . $mysqli->connect_errno);
         } else {
            $conectado = TRUE;
         }
      }

      return $mysqli;
   }

   function getEvento($idEv) {

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT id, nombre, sinopsis, imagen, coste, duracion,
         trailer, alt, DATE_FORMAT(fecha, '%H:%i') as fecha FROM eventos WHERE id=?");

      //Indicamos los valores pasados por referencia
      $pr->bind_param("i",$idEv);

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($id, $nombre, $sinopsis, $imagen, $coste, $duracion, $trailer, $alt, $fecha);

      	//listamos todos los resultados
      	while($pr->fetch()){
      	     $secure_res = ['id' => $id, 'nombre' => $nombre, 'sinopsis' => $sinopsis,
              'imagen' => $imagen, 'coste' => $coste, 'duracion' => $duracion,
              'trailer' => $trailer, 'fecha' => $fecha, 'alt' => $alt ];
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: ' . $pr->close());
      }

      return $secure_res;
   }

   function getListaEventos(){
      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT id, nombre, imagen, alt FROM eventos");
      $eventos = [];

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($id, $nombre, $imagen, $alt);

      	//listamos todos los resultados
      	while($pr->fetch()){
            $evento = [
               'id' => $id,
               'nombre' => $nombre,
               'imagen' => $imagen,
               'alt' => $alt
            ];

            array_push($eventos, $evento);
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: '.$pr->close());
      }


      return $eventos;
   }

   function getPalabrasCensuradas(){
      $mysqli = conectar();

      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT palabra FROM palabras_censuradas");
      $palabras = [];

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($palabra);

      	//listamos todos los resultados
      	while($pr->fetch()){
            array_push($palabras, $palabra);
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: '.$pr->close());
      }

      return $palabras;
   }

   function getComentarios($idEv) {

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "SELECT usuario, DATE_FORMAT(comentarios.fecha, '%d de %M del %Y'), texto
         FROM eventos, comentarios
         WHERE idEvento=eventos.id AND idEvento=?;");

      //Indicamos los valores pasados por referencia
      $pr->bind_param("i",$idEv);

      //Ejecutamos la consulta$check
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($usuario, $fecha, $texto);

         $secure_res = [];

      	//listamos todos los resultados
      	while($pr->fetch()){
            $comentario = [
               'usuario' => $usuario,
               'fecha' => $fecha,
               'texto' => $texto
            ];

            array_push($secure_res, $comentario);
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: ' . $pr->close());
      }

      return $secure_res;
   }

   function aniadirNuevoEvento($nombre, $sinopsis, $imagen, $trailer, $coste, $duracion, $fecha, $alt) {
      $aniadido = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "INSERT INTO eventos (nombre, sinopsis, imagen, trailer, coste, duracion, alt, fecha)
         VALUES(?, ?, ?, ?, ?, ?, ?, ?);"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Indicamos los valores pasados por referencia
         $pr->bind_param("ssssdiss", $nombre, $sinopsis, $imagen, $trailer, $coste, $duracion, $alt, $fecha);

         //Ejecutamos la consulta
         if($pr->execute()){
            $aniadido = true;

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la consulta: ' . $pr->close());
            print_r($mysqli->error_list);
         }
      }

      return $aniadido;
   }

   function editarEvento($idEv, $nombre, $sinopsis, $imagen, $trailer, $coste, $duracion, $fecha, $alt) {
      $editado = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "UPDATE eventos
          SET nombre = ?, sinopsis = ?, imagen = ?, trailer = ?, coste = ?, duracion = ?, alt = ?, fecha = ?
          WHERE id = ?;"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Indicamos los valores pasados por referencia
         $pr->bind_param("ssssdissi", $nombre, $sinopsis, $imagen, $trailer, $coste, $duracion, $alt, $fecha, $idEv);

         //Ejecutamos la consulta
         if($pr->execute()){
            $editado = true;

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la consulta: ' . $pr->close());
         }
      }

      return $editado;
   }

   // Elimina de la base de datos el evento con el id especificado
   function eliminarEvento($idEv) {
      $eliminado = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "DELETE FROM eventos
          WHERE id = ?;"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Indicamos los valores pasados por referencia
         $pr->bind_param("i", $idEv);

         //Ejecutamos la consulta
         if($pr->execute()){
            $eliminado = true;

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la consulta: ' . $pr->close());
         }
      }

      return $eliminado;
   }

   function editarInfoUsuario($user, $nombre, $apellidos, $email, $fecha_nacimiento) {
      $idUser = getUser($user)['id'];

      $editado = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "UPDATE usuarios
         SET nombre = ?, apellidos = ?, email = ?
          -- SET nombre = ?, apellidos = ?, fecha_nacimiento = STR_TO_DATE(?, '%Y-%m-%d')
          WHERE id = ?;"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Indicamos los valores pasados por parametro
         $pr->bind_param("sssi", $nombre, $apellidos, $email, $idUser);

         //Ejecutamos la consulta
         if($pr->execute()){
            $editado = true;

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la consulta: ' . $pr->close());
         }
      }

      return $editado;
   }

   function getListaUsuarios(){
      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "SELECT id, nombre, apellidos, email, fecha_nacimiento, tipo
         FROM usuarios"
      );

      $usuarios = [];

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($id, $nombre, $apellidos, $email, $fecha_nacimiento, $tipo);

      	//listamos todos los resultados
      	while($pr->fetch()){
            $usuario = [
               'id' => $id,
               'nombre' => $nombre,
               'apellidos' => $apellidos,
               'fecha_nacimiento' => $fecha_nacimiento,
               'email' => $email,
               'tipo' => $tipo
            ];

            array_push($usuarios, $usuario);
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: '.$pr->close());
      }

      // $secure_res = ['nombre' => $nombres, 'imagen' => $imagenes,
      //                'alt' => $alts, 'id' => $ids];

      return $usuarios;
   }

   function getUserPorId($idUser){
      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "SELECT id, nombre, apellidos, email, fecha_nacimiento, tipo
         FROM usuarios
         WHERE id = ?;"
      );

      $pr->bind_param("i", $idUser);

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($id, $nombre, $apellidos, $email, $fecha_nacimiento, $tipo);

      	//listamos todos los resultados
      	while($pr->fetch()){
            $usuario = [
               'id' => $id,
               'nombre' => $nombre,
               'apellidos' => $apellidos,
               'fecha_nacimiento' => $fecha_nacimiento,
               'email' => $email,
               'tipo' => $tipo
            ];

      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: '.$pr->close());
      }

      // $secure_res = ['nombre' => $nombres, 'imagen' => $imagenes,
      //                'alt' => $alts, 'id' => $ids];

      return $usuario;
   }

   function editarUsuarioPorId($idUser, $nombre, $apellidos, $fecha, $email, $tipo) {
      $editado = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      // si el usuario que vamos a editar es superusuario
      // y el nuevo tipo no es superusuario
      // y ademas hay menos de dos superusuarios
      // entonces no podemos editar el tipo
      if (getUserPorId($idUser)['tipo'] == "SUPER" &&
         $tipo != "SUPER" &&
         getNumeroSuperUsuarios() < 2) {

         // el tipo sigue siendo un SUPER
         $tipo = "SUPER";
      }

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "UPDATE usuarios
          SET nombre = ?, apellidos = ?, email = ?, tipo = ?
          WHERE id = ?"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Indicamos los valores pasados por referencia
         $pr->bind_param("ssssi", $nombre, $apellidos, $email, $tipo, $idUser);

         //Ejecutamos la consulta
         if($pr->execute()){
            $editado = true;

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la edicion de usuario: ' . $pr->close());
         }
      }

      return $editado;
   }

   function eliminarUsuarioPorId($idUser) {
      $eliminado = false;

      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "DELETE FROM usuarios
          WHERE id = ?;"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Indicamos los valores pasados por referencia
         $pr->bind_param("i", $idUser);

         //Ejecutamos la consulta
         if($pr->execute()){
            $eliminado = true;

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la consulta: ' . $pr->close());
         }
      }

      return $eliminado;
   }

   function getNumeroSuperUsuarios() {
      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare(
         "SELECT count(tipo) FROM usuarios WHERE tipo = 'super'"
      );

      if ($pr == false) {
         echo "ha habido un error";
         echo " errores: ";
         print_r($mysqli->error_list);

      } else {

         //Ejecutamos la consulta
         if($pr->execute()){

            //Alamacenaos los datos de la consulta
            $pr->store_result();

            if($pr->num_rows == 0){
               echo "Sin resultados";
            }

            //Indicamos la variable donde se guardaran los resultados
            $pr->bind_result($numeroUsuarios);

            //listamos todos los resultados
            while($pr->fetch()){
               return $numeroUsuarios;
            }

            //Cerramos la conexion
            $pr->close();

         } else {
            exit('Error al realizar la consulta: ' . $pr->close());
         }
      }

      return 0;
   }


   function getEventoPorNombreCoincidente($nombreEvento) {
      $mysqli = conectar();

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT id, nombre, imagen, alt FROM eventos
         WHERE nombre LIKE CONCAT('%', ?, '%')"
      );

      $eventos = [];

      $pr->bind_param("s", $nombreEvento);

      //Ejecutamos la consulta
      if($pr->execute()){

         //Alamacenaos los datos de la consulta
         $pr->store_result();

         if($pr->num_rows == 0){
            echo "Sin resultados";
         } else {
            //Indicamos la variable donde se guardaran los resultados
            $pr->bind_result($id, $nombre, $imagen, $alt);

            //listamos todos los resultados
            while($pr->fetch()){
               $evento = [
                  'id' => $id,
                  'nombre' => $nombre,
                  'imagen' => $imagen,
                  'alt' => $alt
               ];

               array_push($eventos, $evento);
            }

            //Cerramos la conexion
            $pr->close();
         }



      } else {
         exit('Error al realizar la consulta: '.$pr->close());
      }


      return $eventos;
   }
