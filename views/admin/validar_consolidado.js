function validar() {

	var Descripcion, Periodo, Importe, Inicio, Expresion;

	Descripcion = document.getElementById("txtDescripcion").value;
	Periodo = document.getElementById("txtPeriodo").value;
	Importe = document.getElementById("txtImporte").value;
	Inicio = document.getElementById("txtInicio").value;

	if (Descripcion == ""){
		alert("El campo Descripción está vacío");
		return false;
	}


}
