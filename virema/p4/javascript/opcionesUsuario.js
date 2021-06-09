/**********************************************************
   FICHERO JAVASCRIPT CON FUNCIONALIDADES
   NECESARIAS PARA LA GESTION DE LOS USUARIOS
***********************************************************/


const urlListarUsuarios = "listarUsuarios.php";
const urlEditarUsuario = "editarUsuario.php";
const urlCerrarSesionUsuario = "logout.php";
const urlGEstionUsuario = "gestionarUsuario.php";

const parametroUsuario = "idUser";
// const parametroAccion = "accion";
//
// const codeEditar   = "EDIT";
// const codeAniadir  = "ADD";
// const codeEliminar = "REMOVE";

// Redirecciona a la url de edicion de un usuario
function editarMiUsuario(){
   location.href = urlGEstionUsuario + "?" +
      parametroAccion + "=" + codeEditar;
}

function editarUsuario(idUser) {
   location.href = urlGEstionUsuario + "?" +
      parametroAccion + "=" + codeEditar
      + "&" +
      parametroUsuario + "=" + idUser;
}

function eliminarUsuario(idUser) {
   location.href = urlGEstionUsuario + "?" +
      parametroAccion + "=" + codeEliminar
      + "&" +
      parametroUsuario + "=" + idUser;
}

function cerrarSesion() {
   location.href = urlCerrarSesionUsuario;
}

function listarUsuarios() {
   location.href = urlListarUsuarios;
}
