

// fichero con funciones utiles a todos los modulos
function validarInput(elemento) {

   // tratar el tipo file de manera diferente
   if (elemento.type != "file" && elemento.value == "") document.getElementById("submitFormulario").disabled = true;
   else document.getElementById("submitFormulario").disabled = false;
}
