/**********************************************************
   FICHERO JAVASCRIPT CON FUNCIONALIDADES
   NECESARIAS PARA LA GESTION DE LOS EVENTOS
***********************************************************/


const urlGestionEvento  = "gestionarEvento.php";
const urlEditarEvento   = "editarEvento.php";
const urlEliminarEvento = "eliminarEvento.php";

const parametroEvento = "evento";
const parametroAccion = "accion";

const codeEditar   = "EDIT";
const codeAniadir  = "ADD";
const codeEliminar = "REMOVE";


// Redirecciona a la url de edicion de un evento
function editarEvento(idEvento){
   location.href = urlGestionEvento + "?" +
      parametroAccion + "=" + codeEditar
      + "&" +
      parametroEvento + "=" + idEvento;
}

// Redirecciona a la url para eliminar un evento
function eliminarEvento(idEvento) {
   location.href = urlGestionEvento + "?" +
      parametroAccion + "=" + codeEliminar
         + "&" +
      parametroEvento + "=" + idEvento;

}

// Redirecciona a la pagina que permite aniadir un nuevo evento
function aniadirEvento() {
   location.href = urlGestionEvento + "?" +
      parametroAccion + "=" + codeAniadir;
}
