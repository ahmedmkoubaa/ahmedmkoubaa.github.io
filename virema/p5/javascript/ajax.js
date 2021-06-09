$(document).ready(function() {
  barra_busqueda.onkeyup = hacerPeticionAjax;
});

function hacerPeticionAjax() {
    texto = $("#barra_busqueda").val();

    $.ajax({
       data: {texto},
       url: '../php/ajax.php',
       type: 'get',
       beforeSend: function () {

       },
       success: function(respuesta) {

         procesaRespuestaAjax(respuesta);
       }
    });
}

// Funcion que se ejecuta cuando obtenemos respuesta de AJAX
function procesaRespuestaAjax(respuesta) {
   const maxelementos = 5;
   var numElementos = 0;

   res = "";

   console.log(respuesta);

   respuesta.forEach((evento, i) => {
      if (numElementos < maxelementos) {

         var onclick = 'onclick="irAEvento(' + evento.id + ')"';

         res += "<tr><td " + onclick + " >" + evento.nombre + "</td></tr>";
         numElementos++;
      }
   });




   if (numElementos == 0)
      res = "<tr><td> No hay resultados </td></tr>";

   $("#resultados_busqueda > tbody").html(res);
}

function irAEvento(idEvento) {
   location.href = "evento.php?evento=" + idEvento;
}
