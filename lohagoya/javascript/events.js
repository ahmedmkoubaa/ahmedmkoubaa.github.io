
// Funciones a ejecutar cuando se deslice
window.onscroll = function() {
   scrollHeader();
   scrollAside();
   scrollMenuMobile();
};


window.onload = function () {
   adaptarImagenesDePublicaciones();
   adaptarCarouselPrincipal();
   adaptarCarouselPresentacionPorDispositivo();
}

window.onorientationchange = function () {
   reiniciarAside();
   adaptarCarouselPresentacionPorDispositivo();
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
   adaptarCarouselPresentacionPorDispositivo();
}

screen.orientation.onchange = function() {
   reiniciarAside();
   adaptarCarouselPresentacionPorDispositivo();
};
