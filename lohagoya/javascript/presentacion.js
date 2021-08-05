// Fichero con las funciones necesarias para la presentacion
let carouselPresentacion = document.getElementById("carouselPresentacion");

// Adapta el tamanio del carousel principal
// al tamanio de pantalla que se nos de
function adaptarCarouselPrincipal() {
   var headerHeight = document.getElementById("cabecera").offsetHeight;

   if ($(window).width() > $(window).height() && screen.width > minWidthTablet) {
      carouselPresentacion.style.height = ($(window).height() - headerHeight) + "px";
   }
}

// Adapta la presentacion inicial a todo tipo de dispotivos
// sirviendo como fondo para el formulario y la presentacion
// escrita de la pagina
function adaptarCarouselPresentacionPorDispositivo() {
   const minWidthMobile = 440;

   const bordeExtra = screen.width > minWidthMobile ? 60 : 30;

   // WARNING: otra idea es usar un conjunto diferente de imagenes que nos asegure
   // que se verá decentemente bien y de manera congruente lo que queremos

   var presentacionHeight = document.getElementById('overlayCarousel').offsetHeight;
   const newHeight = (presentacionHeight + bordeExtra) + "px";

   if (carouselPresentacion.offsetHeight < parseInt(newHeight)) {
      var imagenes = carouselPresentacion.getElementsByTagName('img');
      for (var i = 0; i < imagenes.length; i++) {
         var imagen = imagenes[i];
         imagen.style.height = newHeight;
      }

      carouselPresentacion.style.height = "auto";
   }
}
