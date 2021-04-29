<?php
   $conectado = FALSE;

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
      $pr = $mysqli->prepare("SELECT nombre, sinopsis, coste, duracion,
         trailer, DATE_FORMAT(fecha, '%H:%i') as fecha FROM eventos WHERE id=?");

      //Indicamos los valores pasados por referencia
      $pr->bind_param("s",$idEv);

      //Ejecutamos la consulta
      if($pr->execute()){

      	//Alamacenaos los datos de la consulta
      	$pr->store_result();

      	if($pr->num_rows == 0){
      		echo "Sin resultados";
      	}

      	//Indicamos la variable donde se guardaran los resultados
      	$pr->bind_result($nombre, $sinopsis, $coste, $duracion, $trailer, $fecha);

      	//listamos todos los resultados
      	while($pr->fetch()){
      	     $secure_res = ['nombre' => $nombre, 'sinopsis' => $sinopsis, 'coste' => $coste,
              'duracion' => $duracion, 'trailer' => $trailer, 'fecha' => $fecha ];
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: '.$pr->close());
      }

      return $secure_res;

      // Manera insegura
      // $res = $mysqli->query("SELECT nombre, sinopsis, coste, duracion,
      //    trailer, DATE_FORMAT(fecha, '%H:%i') as fecha FROM eventos WHERE id=" . $idEv);
      //
      // if (($res->num_rows) > 0) {
      //    $row = $res->fetch_assoc();
      // }
      // else {
      //    echo "Fallo en la consulta de eventos";
      // }
      //
      // return $row;

   }

   function getListaEventos(){
      $mysqli = conectar();

      // MANERA INSEGURA
      // $res = $mysqli->query("SELECT id, nombre, imagen, alt FROM eventos");
      // $nombres = $imagenes = $id = $alt = [];
      //
      // if (($res->num_rows) > 0) {
      //    echo "$res->num_rows </br>";
      //    while ($row = $res->fetch_assoc()) {
      //       array_push($nombres, $row['nombre']);
      //       array_push($alt, $row['alt']);
      //       array_push($imagenes, $row['imagen']);
      //       array_push($id, $row['id']);
      //    }
      // }
      // else {
      //    echo "Fallo en la consulta de eventos";
      // }
      //
      // $todo = ['nombre' => $nombres, 'imagen' => $imagenes,
      //          'alt' => $alt, 'id' => $id];
      //
      // return $todo;

      // Manera segura
      //Seleccionamos el set de caracteres
      mysqli_set_charset($mysqli, "utf8");

      //preparamos la consulta reemplazando los datos por el signo ?
      $pr = $mysqli->prepare("SELECT id, nombre, imagen, alt FROM eventos");
      $nombres = $imagenes = $ids = $alts = [];

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
            array_push($nombres, $nombre);
            array_push($alts, $alt);
            array_push($imagenes, $imagen);
            array_push($ids, $id);
      	}

      	//Cerramos la conexion
      	$pr->close();

      } else {
      	exit('Error al realizar la consulta: '.$pr->close());
      }

      $secure_res = ['nombre' => $nombres, 'imagen' => $imagenes,
                     'alt' => $alts, 'id' => $ids];

      return $secure_res;
   }

?>
