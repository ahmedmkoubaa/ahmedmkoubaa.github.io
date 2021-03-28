
class Comentario {
	constructor (autor, fecha, texto){
		this.autor = autor;
		this.fecha = fecha;
		this.texto = texto;
	}

	toString() {
		var formatoFecha = this.fecha.getDate() + "/" + (this.fecha.getMonth()+1) + "/" + this.fecha.getFullYear() + " " + this.fecha.getHours() + ":" + this.fecha.getMinutes();
		return this.autor + " " + formatoFecha + "</br>" + this.texto;
	}
}

// Vector variable global con comentarios
let listaComentarios = [ /*new Comentario('ahmed', '24/11/200', 'Qué asco de página',*/
  new Comentario ('Roberto García Escobar', new Date(), 'Vaya asco de página, jamás la volveré a usar'),
  new Comentario ('Pablo Antonio José', new Date(), 'Al principio pensé que no me gustaría, y al final también')
];

function showComments(){
	var commentPanel = document.getElementById('comment');
	commentPanel.style.display = "grid";

	var descripcionEvento = document.getElementById("descripcionEvento");
		descripcionEvento.style.gridTemplateAreas  =
			'"header header  header header" "video content content comment" "video horarios horarios comment"';
	descripcionEvento.style.gridTemplateColumns = "30% auto auto 40%";

	cargarComentarios(listaComentarios);

	return false;
}

function cargarComentarios(lista) {
	 console.log("Estamos haciendo la lista");
    for (i = 0; i < lista.length; ++i) loadComment(lista[i]);
}

function enviarComentario(){
	// vamos a envíar un comentario
	// consiste en añadir a la lista de comentarios un nuevo comentario
	// primero: obtener los elementos por su id
	// segundo: extraer de estos los textos
	// tercero: procesar los datos
	// cuarto: crear a partir de datos procesados nuevos comentarios
	// quinto: añadir a la lista los nuevos comentarios

	// 1.- obtener elementos por id
	var nombre = document.getElementById('nombre');
	var email = document.getElementById('email');
	var texto = document.getElementById('textoComentario');

	// 2.- extraer textos de ellos
	var emailValue = email.value;

	// 3.- procesar los datos
	// Para validación de email podemos usar RegExp, una clase existente en javascript
	// dicha clase usa expresiones regulares que se definen en el constructor y evalua mediante
	// el metodo test(str) si la cadena pasada como argumento encaja en la expresion regular descrita
	// asi pues nos hace falta solamente una regexp para validar email.
	// Una RegExp trivial sería: [numeros y letras]@[nombre de dominio].[dominio de primer nivel]
	// Nosotros vamos a usar una regexp ajena, encontrada en internet, algo mas complicada y efectiva

	var validaEmail = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$");
	if (!validaEmail.test(emailValue)) {
		alert("Email introducido incorrecto, por favor, introduzca uno de nuevo");
		return false;
	}


	if (nombre.value == "" || texto.value == "" ){
		alert("Tienes que rellenar todos los campos");
		return false;
	}


	//4.- crear objetos comentario
	var nuevoComentario = new Comentario (nombre.value, new Date(), texto.value);
	listaComentarios.push(nuevoComentario);

	// 5.- cargar el comentario en pantalla
	loadComment(nuevoComentario);

}

function loadComment(newComment){
	var listContainer = document.getElementById('listaComentarios');

	// create an item for each one
	listItem = document.createElement('p');

	listItem.innerHTML = newComment.toString();
	listItem.classList.add("itemComentario");

	// Add listItem to the listElement
	listContainer.appendChild(listItem);
}
