// Fichero con las funciones necesarias para la presentacion

// Adapta el tamanio del carousel principal
// al tamanio de pantalla que se nos de
function adaptarCarouselPrincipal() {
   var principal = document.getElementById("carouselPresentacion");
   var headerHeight = document.getElementById("cabecera").offsetHeight;

   if ($(window).width() > $(window).height() && screen.width > minWidthTablet) {
      principal.style.height = ($(window).height() - headerHeight) + "px";
   }
}
