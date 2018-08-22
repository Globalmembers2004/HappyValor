$(function () {
    BuscarDatos('1');

    $('#btnSeguimiento').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#pnlSeguimiento', function () {
            ListarSeguimiento();
        });
    });

    $('#btnConsultarSeguimiento').on('click', function(event) {
        event.preventDefault();
        ListarSeguimiento();
    });

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();

        datagrid.showAppBar(true, 'search');
        $('#txtSearch').focus();
    });

    $('.back-button').on('click', function () {
        $('#btnUnSelectAll').trigger('click');
    });

    $('#btnNuevoDetalle').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#pnlRegisterItemDetalle', function () {

        });
    });

    $('#btnAgregar').on('click', function(event) {
        event.preventDefault();
        
        var item  = {
            td_idequilibrio: '0',
            ta_tipo_servicio: $('#ddlTipoDetalle').val(),
            tiposervicio: $('#ddlTipoDetalle option:selected').text(),
            tm_nombre: $('#txtObservacion_Detalle').val(),
            tm_total: $('#txtImporte').val()
        };

        var strhtml = addItemDetalle(item);
        $('#gvEvaluacion tbody').append(strhtml);

        LimpiarFormDetalle();

        calcularSuma();

        closeCustomModal('#pnlRegisterItemDetalle');
        LimpiarFormDetalle();
    });

    $('#gvEvaluacion').on('click', 'a', function(event) {
        event.preventDefault();
        if (this.getAttribute('data-action') == 'delete')
            eliminarElemento(this);
    });

    $('#generic-actionbar').on('click touchend', 'button', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        
        if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar todo lo seleccionado?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            Eliminarequilibrio();
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#gvDatos').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        // var parent = this.parentNode.parentNode.parentNode.parentNode;
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
                            EliminarItemequilibrio(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#btnNuevo').on('click', function (event) {
        event.preventDefault();
        GoToEdit('0');
    });

    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();
        GuardarDatos();
    });
});

var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var datagrid = new DataList('#gvDatos', {
    onSearch: function () {
        BuscarDatos(datagrid.currentPage());
    }
});
var filaItem = 0;

function LimpiarForm () {
    $('#txtServicios').val("0.00");
    $('#txtSueldos').val("0.00");
    $('#txtotros').val("0.00");
    $('#txttotal').val("0.00");
    $('#txtutilidad').val("0.00");
    $('#txtmeta').val("0.00");
    Materialize.updateTextFields();
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

        if (idItem == '0') {

            $('#ddlmes').focus();

            precargaExp(selectorModal, false);
            }
        else {
            $.ajax({
                type: "GET",
                url: 'services/equilibrio/equilibrio-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        // var foto_original = data[0].tm_foto;
                        // var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idequilibrio);
                        $('#ddlanno').val(data[0].ta_anno);
                        $('#txtServicios').val(data[0].tm_servicios);
                        $('#txtSueldos').val(data[0].tm_sueldos);
                        $('#txtotros').val(data[0].tm_otros);
                        $('#txttotal').val(data[0].tm_total);
                        $('#txtutilidad').val(data[0].tm_utilidad);

                        $('#ddlmes').val(data[0].ta_mes).focus();
                        
                        Materialize.updateTextFields();
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

function BuscarDatos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/equilibrio/equilibrio-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    
                    var idItem = data[i].tm_idequilibrio;

                    // var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + idItem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + idItem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    // if (foto == 'no-set')
                    //     strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    // else
                    //     strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title Mes" > Periodo: ' + data[i].periodo + '    - Meta Mensual : ' + data[i].tm_meta + '  - Utilidad Neta S/- : ' + data[i].ganancia  + ' </span>';
                    
                    strhtml += '<p>Servicios: <span class="Servicios">' + data[i].tm_servicios + '  Sueldos: <span class="servicios">'+ data[i].tm_sueldos +'  Otros gastos: <span class="sueldos">'+ data[i].tm_otros +'  TOTAL GASTOS: <span class="sueldos">'+ data[i].tm_total + '</span><br>';

                    strhtml += '<p>Utilidad: <span class="Utilidad Planificada">' + data[i].tm_utilidad  + '%</span><br>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';

                    ++i;
                };

                datagrid.currentPage(datagrid.currentPage() + 1);

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

function GuardarDatos () {
    // var hdFoto = document.getElementById('hdFoto');
    //var data = newFormData('#pnlForm');
    var data = new FormData();

    //if ($('#form1').valid()){
        precargaExp('#pnlForm', true);

        // if (hdFoto.value == 'images/user-nosetimg-233.jpg')
        //     hdFoto.value = 'no-set';

        data.append('btnGuardar', 'btnGuardar');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());
        // data.append('archivo', file);

        var input_data = $('#pnlForm :input').serializeArray();

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/equilibrio/equilibrio-post.php',
            contentType:false,
            processData:false,
            cache: false,
            data: data,
            dataType: 'json',
            success: function(data){
                precargaExp('#pnlForm', false);
                //showSnackbar({ message: data.titulomsje });
                createSnackbar(data.titulomsje);
                
                if (Number(data.rpta) > 0){
                    // removeValidFormRegister();
                    closeCustomModal('#pnlForm');
                    paginaGeneral = 1;
                    BuscarDatos('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    //};
}

function Eliminarequilibrio () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemequilibrio(elemsSelected[0], 'multiple');
}

function EliminarItemequilibrio (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdequilibrio', idmodel);

    $.ajax({
        url: 'services/equilibrio/equilibrio-post.php',
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
                        EliminarItemequilibrio(elemsSelected[indexList], mode);
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

function Buscar () {
    BuscarDatos('1');
}

function LimpiarFormDetalle () {
    $('#ddlTipoDetalle')[0].selectedIndex = 0;
    $('#txtImporte').val("0.00")
    $('#txtObservacion_Detalle').val("");
}

function addItemDetalle (item) {
    var strhtml = '';
    
    var iditem = item.td_idequilibrio;
    var codtiposervicio = item.ta_tipo_servicio;
    var nombre = item.tm_nombre;
    var total = item.tm_total;

    strhtml += '<tr data-iditem="' +  iditem + '" class="dato" data-tiposervicio="' + codtiposervicio + '">';

    strhtml += '<td class="hide">';
    strhtml += '<input name="itemdetalle[' + filaItem + '][iddetalle]" type="hidden" id="iddetalle' + filaItem + '" value="' + iditem + '" />';
    strhtml += '<input name="itemdetalle[' + filaItem + '][codtiposervicio]" type="hidden" id="codtiposervicio' + filaItem + '" value="' + codtiposervicio + '" />';
    strhtml += '<input name="itemdetalle[' + filaItem + '][idcliente]" type="hidden" id="idcliente' + filaItem + '" value="' + item.tm_idcliente + '" />';
    strhtml += '<input name="itemdetalle[' + filaItem + '][nombre]" type="hidden" id="nombre' + filaItem + '" value="' + nombre + '" />';
    strhtml += '<input name="itemdetalle[' + filaItem + '][total]" type="hidden" id="total' + filaItem + '" value="' + total + '" />';

    strhtml += '<td data-title="Tipo de detalle" class="v-align-middle nombre-articulo">' + item.tiposervicio + '</td>';
    strhtml += '<td data-title="Detalle">' + nombre + '</td>';
    strhtml += '<td data-title="Importe" class="text-right">' + total + '</td>';
    
    strhtml += '<td><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="delete" data-placement="left" data-toggle="tooltip" title="Eliminar"><i class="material-icons">&#xE872;</i></a></td>';
    
    strhtml += '</tr>';

    ++filaItem;

    return strhtml;
}

function calcularSuma () {
    var totalGastoServicio = 0;
    var totalGastoSueldo = 0;
    var totalGastoOtros = 0;

    var data = document.querySelectorAll('#gvEvaluacion tbody tr');
    var countdata = data.length;
    var i = 0;

    if (countdata > 0){
        while(i < countdata){
            var tiposervicio = data[i].getAttribute('data-tiposervicio');
            var subtotal = Number(data[i].querySelector('td[data-title="Importe"]').textContent);
            
            if (tiposervicio == '01') {
                totalGastoServicio += subtotal;
            }
            else if (tiposervicio == '01') {
                totalGastoSueldo += subtotal;
            }
            else if (tiposervicio == '02') {
                totalGastoOtros += subtotal;
            };
            
            ++i;
        };
    };

    $('#txtServicios').val(totalGastoServicio.toFixed(2));
    $('#txtSueldos').val(totalGastoSueldo.toFixed(2));
    $('#txtotros').val(totalGastoOtros.toFixed(2));
}

function ListarSeguimiento () {
    $.ajax({
        url: 'services/seguimiento/seguimiento-reporte.php',
        type: 'GET',
        dataType: 'json',
        data: {
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            anho: $('#ddlAnhoSeguimiento').val(),
            mes_inicial: $('#ddlMesInicialSeguimiento').val(),
            mes_final: $('#ddlMesFinalSeguimiento').val()
        },
        success: function (data) {
            var countdata = data.length;
            var i = 0;
            var strhtml_thead = '';
            var strhtml_tbody = '';

            var str_jsonChart__Meta = '';
            var str_jsonChart__Ingreso = '';
            var str_jsonChart__Avance = '';

            if (countdata > 0){
                strhtml_thead += '<thead><tr>';
                i = 0;
                while(i < countdata){
                    strhtml_thead += '<th>' + data[i].mes + '</th>';
                    ++i;
                };
                strhtml_thead += '</tr></thead>';
                
                strhtml_tbody += '<tbody><tr>';
                str_jsonChart__Meta += '{ type: "column", name: "Metas", showInLegend: true, xValueFormatString: "MMMM YYYY", yValueFormatString: "#,##0.#", dataPoints: [';

                var dataPoints__Meta = [];

                i = 0;
                while(i < countdata){
                    str_jsonChart__Meta += '{ x: new Date(' + data[i].anho + ', ' + (Number(data[i].ta_mes) - 1) + '), y: ' + Number(data[i].tm_meta).toFixed(2) + ' },';
                    strhtml_tbody += '<td>' + Number(data[i].tm_meta).toFixed(2)  + '</td>';

                    var dataPoint__Meta = {
                        x: new Date(data[i].anho, (Number(data[i].ta_mes) - 1)),
                        y: Number(data[i].tm_meta)
                    };

                    dataPoints__Meta.push(dataPoint__Meta);

                    ++i;
                };

                str_jsonChart__Meta = str_jsonChart__Meta.substr(0, str_jsonChart__Meta.length - 1);
                str_jsonChart__Meta += ']},';
                
                strhtml_tbody += '</tr><tr>';

                str_jsonChart__Ingreso += '{ type: "column", name: "Ingresos", showInLegend: true, xValueFormatString: "MMMM YYYY", yValueFormatString: "#,##0.#", dataPoints: [';

                var dataPoints__Ingreso = [];

                i = 0;
                while(i < countdata){
                    str_jsonChart__Ingreso += '{ x: new Date(' + data[i].anho + ', ' + (Number(data[i].ta_mes) - 1) + '), y: ' + Number(data[i].tm_total).toFixed(2) + ' },';
                    strhtml_tbody += '<td>' + Number(data[i].tm_total).toFixed(2) + '</td>';

                    var dataPoint__Ingreso = {
                        x: new Date(data[i].anho, (Number(data[i].ta_mes) - 1)),
                        y: Number(data[i].tm_total)
                    };

                    dataPoints__Ingreso.push(dataPoint__Ingreso);

                    ++i;
                };
                
                str_jsonChart__Ingreso = str_jsonChart__Ingreso.substr(0, str_jsonChart__Ingreso.length - 1);
                str_jsonChart__Ingreso += ']},';

                strhtml_tbody += '</tr><tr>';

                str_jsonChart__Avance += '{ type: "line", name: "Avance", axisYType: "secondary", showInLegend: true, yValueFormatString: "#,##0", dataPoints: [';

                var dataPoints__Avance = [];

                i = 0;
                while(i < countdata){
                    str_jsonChart__Avance += '{ x: new Date(' + data[i].anho + ', ' + (Number(data[i].ta_mes) - 1) + '), y: ' + data[i].avance + ' },';
                    strhtml_tbody += '<td>' + Number(data[i].avance).toFixed(2) + '</td>';

                    var dataPoint__Avance = {
                        x: new Date(data[i].anho, (Number(data[i].ta_mes) - 1)),
                        y: Number(data[i].avance)
                    };

                    dataPoints__Avance.push(dataPoint__Avance);

                    ++i;
                };

                str_jsonChart__Avance = str_jsonChart__Avance.substr(0, str_jsonChart__Avance.length - 1);
                str_jsonChart__Avance += ']}';

                strhtml_tbody += '</tr></tbody>';
            };

            var strhtml = strhtml_thead + strhtml_tbody;
            $('#tableReporte').html(strhtml);
            
            var str_jsonChart = '[';
            str_jsonChart += str_jsonChart__Meta + str_jsonChart__Ingreso + str_jsonChart__Avance;
            str_jsonChart += ']';
            
            var dateTimeReviver = function (key, value) {
                var a;
                if (typeof value === 'string') {
                    a = /\/Date\((\d*)\)\//.exec(value);
                    if (a) {
                        return new Date(+a[1]);
                    }
                }
                return value;
            };

            var convertedDatax = [
                {
                    type: "column",
                    name: "Metas",
                    showInLegend: true,
                    xValueFormatString: "MMM",
                    yValueFormatString: "#,##0.#",
                    dataPoints: dataPoints__Meta
                },
                {
                    type: "column",
                    name: "Ingresos",
                    axisYType: "secondary",
                    showInLegend: true,
                    xValueFormatString: "MMM",
                    yValueFormatString: "#,##0.#",
                    dataPoints: dataPoints__Ingreso
                }
            ];

            var convertedData = [
                {
                    type: "column",
                    showInLegend: true,
                    name: "Axis Y-1",
                    xValueFormatString: "MMM",
                    dataPoints: dataPoints__Meta
                },
                {
                    type: "column",
                    showInLegend: true,                  
                    axisYType: "secondary",
                    name: "Axis Y2-1",
                    xValueFormatString: "MMM",
                    dataPoints: dataPoints__Ingreso
                },
                {
                    type: "spline",
                    showInLegend: true,                     
                    axisYType: "secondary",
                    axisYIndex: 1,
                    name: "Axis Y2-2",
                    xValueFormatString: "MMM",
                    dataPoints: dataPoints__Avance
                }
            ];

            //var convertedData = JSON.parse(JSON.stringify(eval("(" + str_jsonChart + ")")), dateTimeReviver);

            console.log(convertedData);

            var chart = new CanvasJS.Chart("chartContainer", {
                title:{
                    text: "Gráfica de seguimiento"
                },
                axisX: {
                    title: "Meses",
                    valueFormatString: "MMM"
                },
                axisY: {
                    title: "Meta (en soles)",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC"
                },
                axisY2: {
                    title: "Avance",
                    titleFontColor: "#C0504E",
                    lineColor: "#C0504E",
                    labelFontColor: "#C0504E",
                    tickColor: "#C0504E"
                },
                data: convertedData
            });

            chart.render();
        },
        error: function (error) {
            console.log(error);
        }
    });
    
}