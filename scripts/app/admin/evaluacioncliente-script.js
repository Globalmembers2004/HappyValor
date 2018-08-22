$(function () {
    BuscarDatos('1');

	$('.datepicker').pickadate({
		format: 'dd/mm/yyyy',
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15, // Creates a dropdown of 15 years to control year,
	    today: 'Today',
	    clear: 'Clear',
	    close: 'Ok',
	    closeOnSelect: false // Close upon selecting a date,
	});

	$('#btnNuevo').on('click', function(event) {
		event.preventDefault();
		GoToEdit('0');
	});

	$('#btnNuevoDetalle').on('click', function(event) {
		event.preventDefault();
		openModalCallBack('#pnlRegisterItemDetalle', function () {

    	});
	});

	$('#btnAgregar').on('click', function(event) {
		event.preventDefault();
		
		var item  = {
			td_idevaluacion: '0',
			tm_idzonacorporal: $('#ddlZonaCorporal').val(),
			zonacorporal: $('#ddlZonaCorporal option:selected').text(),
			tm_medida: $('#txtMedida').val(),
			tm_observaciones: $('#txtObservacion_Detalle').val()
		};

		var strhtml = addItemDetalle(item);
		$('#gvEvaluacion tbody').append(strhtml);

		closeCustomModal('#pnlRegisterItemDetalle');
		LimpiarFormDetalle();
	});

	$('#gvEvaluacion').on('click', 'a', function(event) {
        event.preventDefault();
        if (this.getAttribute('data-action') == 'delete')
            eliminarElemento(this);
    });

    $('#btnGuardar').on('click', function(event) {
    	event.preventDefault();
		Guardar();
    });

    $('#gvDatos').on('click touchend', '.dropdown a', function(event) {

        event.preventDefault();

        var accion = this.getAttribute('data-action');
        var parent = getParentsUntil(this, '#gvDatos', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');
        
        if (accion == 'edit')
            GoToEdit(idmodel);
        else if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar este elemento?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                             eliminarEvaluacion(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        }
    });
});

var filaItem = 0;

function LimpiarForm(){
	$('#txtImcActual').val('0');
	$('#txtImcMeta').val('0');
	$('#txtFechaInicio').val(moment().format('DD/MM/YYYY'));
	$('#txtFechaFinal').val(moment().format('DD/MM/YYYY'));
	$('#gvEvaluacion tbody').html("");
}

function LimpiarFormDetalle () {
	$('#txtDetalle').val("");
	$('#ddlZonaCorporal')[0].selectedIndex = 0;
	$('#ddlEquipo')[0].selectedIndex = 0;
	$('#txtSeries').val("0");
	$('#txtRepeticiones').val("0");
	$('#txtPeso').val("0");
}

function eliminarElemento (element) {
	var _row = getParentsUntil(element, '#gvEvaluacion', '.dato');

	MessageBox({
        content: '¿Desea quitar este item?',
        width: '320px',
        height: '130px',
        buttons: [
            {
                primary: true,
                content: 'Quitar item',
                onClickButton: function (event) {
                    $(_row[0]).remove();
                }
            }
        ],
        cancelButton: true
    });
}

function GoToEdit (idItem) {

    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';

    precargaExp(selectorModal, true);

    LimpiarForm();
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    openModalCallBack(selectorModal, function () {

        if (idItem == '0')
            precargaExp(selectorModal, false);
        else {
            $.ajax({
                type: "GET",
                url: 'services/evaluacioncliente/evaluacioncliente-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){

                        $('#hdIdPrimary').val(data[0].tm_idevaluacion);
                        $('#txtAltura').val(data[0].tm_altura);
                        $('#txtPeso').val(data[0].tm_peso);
                        $('#txtImc').val(data[0].tm_imc);
                        $('#txtPorcentajeGrasa').val(data[0].tm_grasa);
                        $('#txtObservacion_Cabecera').val(data[0].tm_observaciones);

                        Materialize.updateTextFields();

                        ListarDetalle(data[0].tm_idevaluacion);
                    };
                    
                    precargaExp(selectorModal, false);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };
    });
}

function addItemDetalle (item) {
	var strhtml = '';
	
    var iditem = item.td_idevaluacion;
    var idzonacorporal = item.tm_idzonacorporal;
    var observaciones = item.tm_observaciones;
    var medida = item.tm_medida;

 	strhtml += '<tr data-iditem="' +  iditem + '" class="dato">';

    strhtml += '<td class="hide">';
	strhtml += '<input name="itemdetalle[' + filaItem + '][iddetalle]" type="hidden" id="iddetalle' + filaItem + '" value="' + iditem + '" />';
	strhtml += '<input name="itemdetalle[' + filaItem + '][idzonacorporal]" type="hidden" id="idzonacorporal' + filaItem + '" value="' + item.tm_idzonacorporal + '" />';
	strhtml += '<input name="itemdetalle[' + filaItem + '][observaciones]" type="hidden" id="observaciones' + filaItem + '" value="' + observaciones + '" />';
	strhtml += '<input name="itemdetalle[' + filaItem + '][medida]" type="hidden" id="medida' + filaItem + '" value="' + medida + '" />';

    strhtml += '<td data-title="Descripci&oacute;n" class="v-align-middle nombre-articulo">' + item.zonacorporal + '</td>';
    strhtml += '<td data-title="Observaci&oacute;n">' + observaciones + '</td>';
    strhtml += '<td data-title="Medida" class="text-right">' + medida + '</td>';
    
    strhtml += '<td><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="delete" data-placement="left" data-toggle="tooltip" title="Eliminar"><i class="material-icons">&#xE872;</i></a></td>';
    
    strhtml += '</tr>';

    ++filaItem;

    return strhtml;
}

function Guardar () {
	var data = new FormData();
    var input_data = $('#pnlForm :input').serializeArray();
    
    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdCliente', getParameterByName('idcliente'));

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/evaluacioncliente/evaluacioncliente-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
            	closeCustomModal('#pnlForm');
                BuscarDatos('1');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function BuscarDatos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/evaluacioncliente/evaluacioncliente-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcliente: getParameterByName('idcliente'),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idevaluacion;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion"> OBJETIVO : ' + data[i].tm_observaciones + '</span>';
                    
                    strhtml += '<p> ALTURA: ' + data[i].tm_altura + ' - PESO : <span class=" peso">' + data[i].tm_peso + '</span><br>';

                    strhtml += '<span class="correo">IMC: ' + data[i].tm_imc + '</span> -  % de grasa: ' + data[i].tm_grasa + '</p>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';

                    ++i;
                };

                // datagrid.currentPage(datagrid.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                //$(selector + ' .grouped-buttons a.tooltipped').tooltip();
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#pnlListado', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
    
function EliminarEvaluacion () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    eliminarEvaluacion(elemsSelected[0], 'multiple');
}

function eliminarEvaluacion (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdevaluacioncliente', idmodel);

    $.ajax({
        url: 'services/evaluacioncliente/evaluacioncliente-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var endqueue = false;

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                $(item).fadeOut(400, function() {
                    $(this).remove();
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        eliminarEvaluacion(elemsSelected[indexList], mode);
                    else {
                        endqueue = true;
                        titulomsje = data.titulomsje;
                    };
                }
                else if (mode == 'single') {
                    endqueue = true;
                    titulomsje = data.titulomsje;
                };
            };
            
            if (endqueue) {
                createSnackbar(titulomsje);
                if ($('.actionbar').hasClass('is-visible'))
                    $('.back-button').trigger('click');
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function ListarDetalle (id) {
    $.ajax({
        type: "GET",
        url: "services/evaluacioncliente/evaluacioncliente-detalle-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '5',
            id: id,
            pagina: '1'
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    strhtml += addItemDetalle(data[i]);
                    ++i;
                };
            };

            $('#gvEvaluacion tbody').html(strhtml);
        },
        error:function (data){
            console.log(data);
        }
    });       
}