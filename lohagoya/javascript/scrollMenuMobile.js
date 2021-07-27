let topPosicion        = 0;
// let headerHeight       = 0;
let definidoMenuMobile = false;
let menuMobile         = undefined;

menuMobile = document.getElementById("menuMobile");

function scrollMenuMobile() {

   if (!definidoMenuMobile) {
      topPosicion = menuMobile.offsetTop;
      definidoMenuMobile = true;
   }

   if (window.pageYOffset > topPosicion) {
      menuMobile.classList.add("scrollMenuMobile");
      menuMobile.style.marginTop = headerHeight - topPosicion + "px";
   } else {
      menuMobile.classList.remove("scrollMenuMobile");
      menuMobile.style.marginTop = "0px";
   }
}
