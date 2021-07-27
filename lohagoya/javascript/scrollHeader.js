// Add the sticky class to the header when you reach its scroll position.
// Remove "sticky" when you leave the scroll position
function scrollHeader() {

  // Get the header
  var header = document.getElementById("cabecera");
  // var height = header.offsetHeight;

  // Get the offset position of the navbar
  var sticky = header.offsetTop;

  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
