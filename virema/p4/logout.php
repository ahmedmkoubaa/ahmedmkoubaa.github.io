<?php
   // Comenzar la sesion y por lo tanto cargar la variable _SESSION
   session_start();

   // Desetearla, hemos cogido _session de
   // las cookies y ahora la modificamos
   unset($_SESSION['user']);
   unset($_SESSION['user_tipo']);
   header("Location: index.php");
?>
