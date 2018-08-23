$(function () {

    $('[data-toogle="tooltip"]').tooltip();

    ListarCenCos_Combo('0');                        
    BuscarDatos('1',1);

    $('#ddlCenCos').on('change', function (event) {
        event.preventDefault();
        var val = $(this).val();
        BuscarDatos('1',val);

    });

    if ($('#hdCodigoPerfil').val() == "PRF00001")
        $("#ddlCenCos").removeClass('hide');
    else
        $("#ddlCenCos").addClass('hide');

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();

        datagrid.showAppBar(true, 'search');
        $('#txtSearch').focus();
    });

    $('.back-button').on('click', function () {
        $('#btnUnSelectAll').trigger('click');
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
                            EliminarInventario();
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
                            EliminarItemProductos(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#gvDatos').on('click', "button", function (event) {
        event.preventDefault();
        var idItem = this.getAttribute("data-idinventario");
        var idProducto = this.getAttribute("data-idproducto");
        GoToEdit(idItem, idProducto);
    });


    $('#Agregar').on('click', function (event) {
        event.preventDefault();
        AdicionarReenvio();

    });


    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();
        RegistrarReenvio();
    });

    $('#btnGuardarInv').on('click', function (event) {
        event.preventDefault();
        RegistrarInventario();
    });


    $('#form1').validate({
        lang: 'es',
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement)
                $(placement).append(error);
            else
                error.insertAfter(element);
        }
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

function LimpiarForm () {
    $('#ddlCenCosDes').val(0).focus();
    $('#txtCantidadEnv').val(0);
}

function removeValidFormRegister () {
    $('#txtCantidadInv').rules('remove');
    $('#txtCantidadCons').rules('remove');
}

function addValidFormRegister () {
    $('#txtCantidadInv').rules('add', {
        required: true,
        min: 0,
        messages:{
            required: jQuery.validator.format("Por favor ingrese Inventario actual"),
            min: jQuery.validator.format("Por favor ingrese un inventario válido")
        }
    });
}

function GoToEdit (idItem, idproducto) {
    
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdInventario').value = 0;

    precargaExp(selectorModal, true);

    LimpiarForm();

    removeValidFormRegister();
    addValidFormRegister();

    var centroOrigen = document.getElementById("ddlCenCos").value;

    document.getElementById("hdIdProducto").value = idproducto;
    document.getElementById("hdIdInventario").value = idItem;

    openModalCallBack(selectorModal, function () {

        $.ajax({
            type: "GET",
            url: 'services/reenvio/reenvio-getdetails.php',
            cache: false,
            dataType: 'json',
            data: 'idinventario=' + idItem,
            success: function (data) {
                console.log(data);
                ListarCenCosDes_Combo('0', centroOrigen);                        
                if (data.length > 0){
                  
                    ListarCenCosDes_Combo(data[0].tm_idcencosto_des);                        
                    
                    $('#ddlCenCosDes').val(data[0].tm_idcencosto_des);

                    $('#txtCantidadEnv').val(data[0].tm_cant_envi);
                    
                    Materialize.updateTextFields();
                };
                
                precargaExp(selectorModal, false);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
}

function BuscarDatos (pagina, centrocosto) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' tbody';

    precargaExp('#pnlListado', true);

    $.ajax({
        type: "GET",
        url: "services/inventario/inventario-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            pagina: pagina,
            idcencosto: centrocosto
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var idinventario = data[i].tm_idinventario;
                    var idproducto = data[i].tm_idproducto;
                    var idcentrocosto = data[i].tm_idcencosto_ori;
                    var idperiodo = data[i].tm_idperiodo;                    
                    strhtml += '<tr>';
                    strhtml += '<td class="hidden">'+idinventario +'</td>';
                    strhtml += '<td class="align-left">'+data[i].Producto +'</td>';
                    strhtml += '<td class="align-center">'+data[i].tm_cant_ant +'</td>';
                    strhtml += '<td class="align-center">'+data[i].tm_cant_envi +'</td>';
                    strhtml += '<td class="align-center"><input class="validate" id="txtInventario'+i+'" class="inputTextInTable align-right" value="'+data[i].tm_cant_inve +'" type="text"/></td>';
                    strhtml += '<td class="align-center">'+data[i].tm_cant_cons +'</td>';
                    strhtml += '<td class="align-center"><button data-idproducto="'+idproducto+'" data-idcentrocosto="'+idcentrocosto+'" data-idperiodo="'+idperiodo+'" type="button id="cambio'+i+'">Redirigir</button></td>';
                    strhtml += '</tr>';
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


function AdicionarReenvio() {
    var idcentro = $("#ddlCenCosDes").val();
    var centro = $("#ddlCenCosDes option:selected").text();
    var cantidad = document.getElementById("txtCantidadEnvi").value;

    var strhtml = "";

    strhtml += '<tr data-idcentrodes="'+idcentro+'">';
    strhtml += '<td>'+centro +'</td>';
    strhtml += '<td>'+cantidad +'</td>';
    strhtml += '</tr>';

    $("#gvDetalle tbody").append(strhtml);

}


function guardarReenvios() {

}


function GuardarDatos () {
    var data = new FormData();

    if ($('#form1').valid()){
        precargaExp('#pnlForm', true);

        data.append('btnGuardar', 'btnGuardar');

        var input_data = $('#pnlForm :input').serializeArray();

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/inventario/inventario-post.php',
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
                    closeCustomModal('#pnlForm');
                    paginaGeneral = 1;
                    ListarCenCos_Combo();                        
                    BuscarDatos('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function EliminarInventario () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemProductos(elemsSelected[0], 'multiple');
}

function EliminarItemProductos (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdEnlace', idmodel);

    $.ajax({
        url: 'services/inventario/inventario-post.php',
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
                        EliminarItemInventario(elemsSelected[indexList], mode);
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
    ListarCenCos_Combo('0');                        
    BuscarDatos('1');
}

function ListarProducto_Combo (idproducto_default) {
    $.ajax({
        type: 'GET',
        url: 'services/productos/productos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idproducto_default == data[i].tm_idproducto ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idproducto + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlProducto').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarCenCos_Combo (idcencos_default) {
    $.ajax({
        type: 'GET',
        url: 'services/centrocosto/centrocosto-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idcencos_default == data[i].tm_idcencosto ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcencosto + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlCenCos').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });

}

function ListarCenCosDes_Combo (idcencos_default, idcencos_origen) {
    $.ajax({
        type: 'GET',
        url: 'services/centrocosto/centrocosto-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            id: idcencos_origen,
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idcencos_default == data[i].tm_idcencosto ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcencosto + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlCenCosDes').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function DetalleReenvio (centrodes, cantidad) {
    this.centrodes = centrodes;
    this.cantidad = cantidad;
}

function RegistrarReenvio () {
    var data = new FormData();

    precargaExp('#pnlForm > .gp-body', true);

    var i = 0;
    var gvDatos = document.getElementById("gvDetalle");
    var countdata = gvDatos.rows.length;
    var listDetalle = [];
    var detalleReenvio = '';
    var centroori = document.getElementById("ddlCenCos").value;
    var centrodes = document.getElementById("ddlCenCosDes").value;    
    var idproducto = document.getElementById("hdIdProducto").value;    
    var idinventario = document.getElementById("hdIdInventario").value;    
    if (countdata > 0){
        while (i < countdata){
            var centrodes = gvDatos.rows[i].getAttribute('data-idcentrodes');
            var cantidad = gvDatos.rows[i].cells[1].innerText;
            var detalle = new DetalleReenvio(centrodes, cantidad);
            listDetalle.push(detalle);
            ++i;
        };

        detalleReenvio = JSON.stringify(listDetalle);
    };

    data.append('centroori', centroori);
    data.append('idinventario', idinventario);    
    data.append('idProducto', idproducto);    
    data.append('detalleReenvio', detalleReenvio);

    $.ajax({
        url: 'services/reenvio/reenvio-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlForm > .gp-body', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function DetalleInventario (iditem, idproducto, cantante, cantenvi, cantinve, cantcons) {
    this.iditem = iditem;
    this.idproducto = idproducto;
    this.cantante = cantante;
    this.cantenvi = cantenvi;
    this.cantinve = cantinve;
    this.cantcons = cantcons;
}

function RegistrarInventario () {
    var data = new FormData();

    precargaExp('#pnlListado > .gp-body', true);

    var i = 0;
    var itemsDetalle = $('#gvDatos .ibody table');
    var gvDatos = itemsDetalle[0];
    var countdata = gvDatos.rows.length;
    var listDetalle = [];
    var detalleInventario = '';

    if (countdata > 0){
        while (i < countdata){
            var iditem = gvDatos.rows[i].getAttribute('data-iddetalle');
            var idproducto = gvDatos.rows[i].getAttribute('data-idproducto');
            var idcentrocosto = gvDatos.rows[i].getAttribute('data-idcentrocosto');
            var idperiodo = gvDatos.rows[i].getAttribute('data-idperiodo');
            var cantante = gvDatos.rows[i].cells[1].innerText;
            var cantenvi = gvDatos.rows[i].cells[2].innerText;
            var cantinve = gvDatos.rows[i].cells[3].childNodes[0].value;
            var cantcons = gvDatos.rows[i].cells[5].innerText;

            var detalle = new DetalleInventario(iditem, idproducto, cantante, cantenvi, cantinve, cantcons);
            listDetalle.push(detalle);

            ++i;
        };

        detalleInventario = JSON.stringify(listDetalle);
    };

    data.append('periodo', $('#periodo').val());
    data.append('centroCosto', $('#centroCosto').val());

    $.ajax({
        url: 'services/inventario/inventario-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function (data) {
            precargaExp('#pnlListado > .gp-body', false);

            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (data.rpta != '0'){
                    ListarInventario('consulta');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

