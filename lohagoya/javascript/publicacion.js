// minimo valor de width para diferenciar entre moviles y pcs
const minWidthTablet = 1150;
let imagenes = [];

// Adapta una imagen a la altura total del marco de la publicacion
function adaptarImagenAPublicacion(imagen) {

   if (imagen.style && screen.width > minWidthTablet) {
      // Adaptar imagen automaticamente (volver a altura original)
      imagen.style.height = "";

      // Obtener marco de la publicacion y su altura tras adaptacion automatica
      var parentHeight = imagen.parentElement.parentElement.offsetHeight;
      imagen.style.height = parentHeight + "px";

      // Buscar la imagen pasada por parametro en la lista de imagenes,
      // si no esta en dicha lista se aniade
      if (imagenes.find(element => element == imagen) == undefined)
         imagenes.push(imagen);

   } else {
      // En otro caso altura depende de fichero css original
      imagen.style.height = "";
   }
}

// Adapta todas las imagenes de todos los carousels
// para que cuadren con el texto que acompaña la publicacion
function adaptarImagenesDePublicaciones() {
   if (window.innerWidth > minWidthTablet) {
      var publicaciones = document.getElementsByName('publicacion');
      
      // Recorrer todas las publicaciones
      publicaciones.forEach((publi, i) => {
         var imagenes = publi.getElementsByTagName('img');
         var descripcion = publi.getElementsByTagName('div').descripcion;

         // Buscar la maxima altura
         var maxAltura = descripcion.offsetHeight;
         // for (var i = 0; i < imagenes.length; i++) {
         //    var imagen = imagenes[i];
         //    if (imagen.offsetHeight > maxAltura)
         //       maxAltura = imagen.offsetHeight;
         // }

         // Recorrer las imagenes y decidir que altura asignarles
         for (var i = 0; i < imagenes.length; i++) {
            var imagen = imagenes[i];

            // si no estamos en tablet, procedemos, en otro caso auto
            if (window.innerWidth > minWidthTablet) {
               imagen.style.height = maxAltura + "px";
            } else {
               imagen.style.height = "";
            }
         }
      });
   }
}

function adaptarImagenCarousel(imagen) {
   if (imagen.style && screen.width > minWidthTablet) {

      // Adaptar imagen automaticamente (volver a altura original)
      imagen.style.height = "";

      // Obtener marco de la publicacion y su altura tras adaptacion automatica
      var parentHeight = imagen.parentElement.parentElement.offsetHeight;
      imagen.style.height = parentHeight + "px";

      // Buscar la imagen pasada por parametro en la lista de imagenes,
      // si no esta en dicha lista se aniade
      if (imagenes.find(element => element == imagen) == undefined)
         imagenes.push(imagen);

   } else {
      // En otro caso altura depende de fichero css original
      imagen.style.height = "";
   }
}

function adaptarTodasImagenes() {
   imagenes.forEach((imagen, i) => {
      adaptarImagenAPublicacion(imagen);
   });
}

/*// minimo valor de width para diferenciar entre moviles y pcs
const minWidthTablet = 1150;
let imagenes = [];
let imagenesCarousel = [];

// Adapta una imagen a la altura total del marco de la publicacion
function adaptarImagenAPublicacion(imagen) {
   adaptarImagen(imagen, imagen.parentElement.parentElement.offsetHeight);

   // Buscar la imagen pasada por parametro en la lista de imagenes,
   // si no esta en dicha lista se aniade
   if (imagenes.find(element => element == imagen) == undefined)
      imagenes.push(imagen);
}

// Adapta una imagen a la altura total del carousel
function adaptarImagenCarousel(imagen) {
   adaptarImagen(imagen, imagen.parentElement.parentElement.parentElement.offsetHeight);

   // Buscar la imagen pasada por parametro en la lista de imagenes,
   // si no esta en dicha lista se aniade
   if (imagenesCarousel.find(element => element == imagen) == undefined)
      imagenesCarousel.push(imagen);
}

function adaptarImagen(imagen, parentHeight) {
   if (imagen.style && screen.width > minWidthTablet) {

      // Adaptar imagen automaticamente (volver a altura original)
      // Obtener marco de la publicacion y su altura tras adaptacion automatica
      imagen.style.height = "";
      // imagen.parentElement.parentElement.offsetHeight;
      imagen.style.height = parentHeight + "px";

      // // Buscar la imagen pasada por parametro en la lista de imagenes,
      // // si no esta en dicha lista se aniade
      // if (imagenes.find(element => element == imagen) == undefined)
      //    imagenes.push(imagen);

   } else {
      // En otro caso altura depende de fichero css original
      imagen.style.height = "";
   }
}

// Recorre la lista de imagenes de publicacion y las adapta
function adaptarImagenesPublicacion() {
   imagenes.forEach((imagen, i) => {
      adaptarImagenAPublicacion(imagen);
   });
}

// Recorre la lista de imaenes que estan
// dentro de un carousel y las adapta
function adaptarImagenesCarousel() {
   imagenesCarousel.forEach((imagen, i) => {
      adaptarImagenCarousel(imagen);
   });
}

// Adapta todas las imagenes
function adaptarTodasImagenes() {
   adaptarImagenesPublicacion();
   adaptarImagenesCarousel();
}
*/
