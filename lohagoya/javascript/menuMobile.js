let social = document.getElementById("menuMobile");
let flecha = document.getElementById("iconoFlecha");

const arriba = "fa-angle-double-up";
const abajo = "fa-angle-double-down";

const minWidthMobile = 720;

// Funcion que se ejecutara cuando se pulse el icono de redes
// sociales/contacto, si el menu esta desplegado lo contrae y viceversa
function desplegarRedesSociales() {
   if (social.style.display === "block") {
      social.style.display = "none";
      flecha.classList.add(abajo);
      flecha.classList.remove(arriba);

   } else {
      social.style.display = "block";
      flecha.classList.remove(abajo);
      flecha.classList.add(arriba);
   }
}

// Funcion que se ejecutara cuando se redimensine la pantalla,
// comprueba si el elemento "social" esta desplegado para pantallas
// "no mobile", si es asi lo contrae
function contraerSocialMobile() {
   if (screen.width > minWidthMobile && social.style.display === "block") {
      desplegarRedesSociales();
   }
}
