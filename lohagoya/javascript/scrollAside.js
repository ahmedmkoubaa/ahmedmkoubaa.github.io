let definidaAlturaScrollLateral = false;
var sticky;
var headerHeight;
var aside;

// Funcion para mantener el aside "servicios"
// siempre en el mismo lugar, dar efecto de flotante
// mientras se haga scroll
function scrollAside() {
  // Get the aside
  aside = document.getElementById("servicios");
  initAside();

  if (window.pageYOffset + headerHeight > sticky) {
    aside.style.marginTop = (window.pageYOffset - sticky + headerHeight) + "px";
  } else {
    aside.style.marginTop = 0 + "px";
  }
}

// Guarda la posición inicial del elemento aside
function initAside () {
   if (!definidaAlturaScrollLateral) {
     sticky = aside.offsetTop;
     headerHeight = document.getElementById("cabecera").offsetHeight;
     definidaAlturaScrollLateral = true;
   }
}

function reiniciarAside () {
   definidaAlturaScrollLateral = false;
};
