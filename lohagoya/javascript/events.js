
// Funciones a ejecutar cuando se deslice
window.onscroll = function() {
   scrollHeader();
   scrollAside();
   scrollMenuMobile();
};


window.onload = function () {
   adaptarImagenesDePublicaciones();
   adaptarCarouselPrincipal();
}

window.onorientationchange = function () {
   reiniciarAside();
}

window.onchange = function () {
   reiniciarAside();
}

window.onresize = function () {
   reiniciarAside();
   adaptarTodasImagenes();
   contraerSocialMobile();
   adaptarImagenesDePublicaciones();
   adaptarCarouselPrincipal();
}

screen.orientation.onchange = function() {
   reiniciarAside();
};
