$(function () {
    DefaultAlmacen();
    // ListarCategorias('1');
    // ListarAlmacen();
    // ListarInsumos('#gvDatos', '1', '0', '1');

    $('#txtMedida, #txtCostoPromedio, #txtCostoReceta, #txtStockMinimo, #txtStockMaximo, #txtStockMax_Masivo, #txtStockMin_Masivo').on('focus', function(event) {
        event.preventDefault();
        this.select();
    });

    $('#btnCambiarStockMinMax').on('click', function(event) {
        event.preventDefault();
        MessageBox({
            content: '¿Desea actualizar stock mínimo y máximo de todo lo seleccionado?',
            width: '320px',
            height: '130px',
            buttons: [
                {
                    primary: true,
                    content: 'Actualizar',
                    onClickButton: function (event) {
                        ActualizarStockMinMax();
                    }
                }
            ],
            cancelButton: true
        });
    });
    
    $('#txtSearchStock').on('keyup', function(event) {
        ListarInsumos('#gvStockInsumo', $('#hdTipoInsumo').val(), $('#hdIdAlmacen').val(), '1');
    });

    $('#btnSearchStock').on('click', function(event) {
        event.preventDefault();
        gvStockInsumo.showAppBar(true, 'search');
        $('#txtSearchStock').focus();
    });

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();
        var gridview;
        if ($('#gvCategoria').is(':visible'))
            gridview = gvCategoria;
        else if ($('#gvAlmacen').is(':visible'))
            gridview = gvAlmacen;
        else
            gridview = datagrid;

        gridview.showAppBar(true, 'search');
        $('#txtSearch').focus();
    });

    $('#btnCerrarKardex').on('click', function(event) {
        event.preventDefault();
        CerrarKardex();
    });

    $('#btnCambiarCostoInsumo').on('click', function(event) {
        event.preventDefault();
        CambiarCostoInsumo();
    });

    $('#btnRecursosBack').on('click', function(event) {
        event.preventDefault();
        $('#btnUnSelectAll').trigger('click');
    });

    $('#gvStockInsumo tbody').on('scroll', function(event){
        var gridview;
        
        gvStockInsumo.listenerScroll(this, event);
    });

    $('#pnlListado .mdl-layout__content').on('scroll', function(event){
        var gridview;
        
        if ($('#gvCategoria').is(':visible'))
            gridview = gvCategoria;
        else if ($('#gvAlmacen').is(':visible'))
            gridview = gvAlmacen;
        else
            gridview = datagrid;

        gridview.listenerScroll(this, event);
    });

    $('#gvStockInsumo tbody').on('click', 'input:checkbox', function (event) {
        handlerRowCheck(this, '#gvStockInsumo', event);
    });
    
    $('#gvStockInsumo tbody').on('click', 'tr', function (event) {
        handlerRowCheck(this, '#gvStockInsumo', event);
    });

    $('#gvStockInsumo tbody').on('click', 'tr .mdl-textfield__input', function (event) {
        event.stopPropagation();
    });

    $('#gvStockInsumo tbody').on('keyup', 'tr .mdl-textfield__input', function (event) {
        var elem = this;

        if (!elem.classList.contains('costotal')) {
            var saldoinicial = 0;
            var costounitario = 0;
            var _row = getParentsUntil(elem, '#gvStockInsumo', 'tr');

            var inputSubtotal = _row[0].getElementsByClassName('costotal')[0];

            if (elem.classList.contains('saldoinicial')) {
                saldoinicial = elem.value;
                costounitario = Number(_row[0].getElementsByClassName('costounitario')[0].value);
            }
            else {
                saldoinicial = Number(_row[0].getElementsByClassName('saldoinicial')[0].value);
                costounitario = elem.value;
            };

            var costotal = saldoinicial * costounitario;
            inputSubtotal.value = costotal.toFixed(2);
        };
    });

    $('#btnTipoInsumo').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$(this).hasClass('disabled'))
            $('#mnuTipoInsumo').addClass('is-visible');
    });

    $('#mnuTipoInsumo').on('click', 'a', function(event) {
        event.preventDefault();

        var referencia = this.getAttribute('href');
        var titulo = this.innerText;
        
        $('#mnuTipoInsumo').removeClass('is-visible');

        var titleLayout = document.querySelector('#pnlStock .mdl-layout-title span.text');
        titleLayout.innerText = titulo;

        // $('#pnlStock section').hide();
        // $(referencia).show();

        var tipo = referencia == '#gvStockInsumo' ? '1' : '2';
        $('#hdTipoInsumo').val(tipo);
        
        ListarInsumos('#gvStockInsumo', tipo, $('#hdIdAlmacen').val(), '1');
    });

    $('#btnUnSelectAll').on('click', function(event) {
        event.preventDefault();
        if ($('#pnlListado').is(':visible')) {
            if ($('#gvCategoria').is(':visible')){
                gvCategoria.removeSelection(function () {
                    $('#gvCategoria .dato .title').removeClass('hide');
                    $('#gvCategoria .dato .mdl-textfield').addClass('hide');
                    // $('#btnCategoriaEdit').addClass('hide');

                    // [].forEach.call($('#gvCategoria .mdl-checkbox'), function (el) {
                    //     el.MaterialCheckbox.checkToggleState();
                    // });
                });
            }
            else if ($('#gvAlmacen').is(':visible'))
                gvAlmacen.removeSelection();
            else
                datagrid.removeSelection();
        }
        else
            gvStockInsumo.removeSelection();
    });

    $('.back-button').on('click', function () {
        $('#btnUnSelectAll').trigger('click');
    });

    $("#txtSearchAlmacen").easyAutocomplete({
        url: function (phrase) {
            var _url = 'services/almacen/almacen-search.php';
            
            _url += '?idempresa=' + $('#hdIdEmpresa').val();
            _url += '&idcentro=' + $('#hdIdCentro').val();
            _url += '&criterio=' + phrase;

            return _url;
        },
        getValue: function (element) {
            return element.tm_nombre;
        },
        list: {
            onSelectItemEvent: function () {
                var idalmacen = $("#txtSearchAlmacen").getSelectedItemData().tm_idalmacen;

                $("#hdIdAlmacen").val(idalmacen).trigger("change");
                ListarInsumos('#gvStockInsumo', $('#hdTipoInsumo').val(), idalmacen, '1');
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_nombre;
            }
        },
        theme: "square"
    });

    // $("#txtSearchAlmacenKardex").easyAutocomplete({
    //     url: function (phrase) {
    //         var _url = 'services/almacen/almacen-search.php';
            
    //         _url += '?idempresa=' + $('#hdIdEmpresa').val();
    //         _url += '&idcentro=' + $('#hdIdCentro').val();
    //         _url += '&criterio=' + phrase;

    //         return _url;
    //     },
    //     getValue: function (element) {
    //         return element.tm_nombre;
    //     },
    //     list: {
    //         onSelectItemEvent: function () {
    //             var idalmacen = $("#txtSearchAlmacenKardex").getSelectedItemData().tm_idalmacen;

    //             $("#hdIdAlmacen").val(idalmacen).trigger("change");

    //             // if ($('#hdIdArticulo').val() != '0')
    //             //     ListarKardex();
    //         }
    //     },
    //     template: {
    //         type: "custom",
    //         method: function (value, item) {
    //             return item.tm_nombre;
    //         }
    //     },
    //     theme: "square"
    // });

    $("#txtSearchInsumoKardex").easyAutocomplete({
        url: function (phrase) {
            var _url = 'services/insumos/insumos-search.php';
            
            _url += '?tipobusqueda=EXISTENCIAS';
            _url += '&idempresa=' + $('#hdIdEmpresa').val();
            _url += '&idcentro=' + $('#hdIdCentro').val();
            _url += '&tipoproducto=' + $('#ddlTipoExistencia').val();
            _url += '&criterio=' + phrase;

            return _url;
        },
        getValue: function (element) {
            return element.tm_nombre;
        },
        list: {
            onSelectItemEvent: function () {
                var idarticulo = $("#txtSearchInsumoKardex").getSelectedItemData().idarticulo;

                $("#hdIdArticulo").val(idarticulo).trigger("change");

                // if ($('#hdIdAlmacen').val() != '0')
                //     ListarKardex();
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_nombre;
            }
        },
        theme: "square"
    });

    $('#btnStockInsumo').on('click touchend', function(event) {
        event.preventDefault();
        GuardarStockInicial();
    });

    $('#btnBackToList').on('click', function(event) {
        event.preventDefault();
        BackToList();
    });

    $('#btnNuevo').on('click', function (event) {
        event.preventDefault();
        Nuevo();
    });

    $('#btnGuardarInsumo').on('click', function(event) {
        event.preventDefault();
        GuardarInsumo();
    });

    $('.actionbar').on('click touchend', 'button', function(event) {
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
                            if ($('#gvCategoria').is(':visible'))
                                EliminarCategoria();
                            else if ($('#gvAlmacen').is(':visible'))
                                EliminarAlmacen();
                            else if ($('#gvDatos').is(':visible'))
                                EliminarInsumo();
                        }
                    }
                ],
                cancelButton: true
            });
         }
         else if (accion == 'change-stockminmax'){
            openModalCallBack('#modalChangeStockMinMax', function () {
                $('#txtStockMin_Masivo').val('0.000');
                $('#txtStockMax_Masivo').val('0.000');
            });
         };
    });

    $('#btnAgregarPresentacion').on('click', function(event) {
        event.preventDefault();
        $('#btnPresentacionAdd').html('Agregar a detalle').removeClass('mode-edit').addClass('mode-add');
        // resetForm('#pnlInfoPresentacion');
        openModalCallBack('#pnlInfoPresentacion', function () {
            // ListarUnidadMedida_Combo('#ddlUnidadMedida', '0');

            // var idunidadmedida = $('#ddlUnidadMedidaReg').val();
            var unidadmedida = $('#ddlUnidadMedidaReg option:selected').text();

            $('label[for="txtMedida"]').text('Equivalencia en: ' + unidadmedida);

            ListarPresentacion_Combo('0');
        });
    });

    // $('#btnEditarPresentacion').on('click', function(event) {
    //     event.preventDefault();
    //     clearFormPresentacion();
    //     $('#btnPresentacionAdd').innerHTML = 'Modificar detalle').removeClass('mode-add').addClass('mode-edit');
    //     GetInfoPresentacion();
    //     openCustomModal('#pnlInfoPresentacion');
    // });

    // $('#btnHidePnlInfoPresentacion').on('click', function(event) {
    //     event.preventDefault();
    //     closeCustomModal('#pnlInfoPresentacion');
    // });

    $('#btnPresentacionAdd').on('click', function(event) {
        event.preventDefault();
        AddDetalle();
    });

    $('#gvAlmacen').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        var parent = getParentsUntil(this, '#gvAlmacen', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');

        if (accion == 'edit')
            GoToEditAlmacen(idmodel);
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
                            EliminarItemAlmacen(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#gvCategoria').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        // var parent = this.parentNode.parentNode.parentNode.parentNode;
        var parent = getParentsUntil(this, '#gvCategoria', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');

        if (accion == 'edit')
            GoToEditCategoria(idmodel);
        // else if (accion == 'goto')
        //     FiltrarPorIdItem(idmodel);
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
                            EliminarItemCategoria(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });                
        };
    });

    // $('#gvCategoria').on('click touchend', 'a', function(event) {
    //     event.preventDefault();
    //     event.stopPropagation();

    //     var idmodel = '0';
    //     var accion = this.getAttribute('data-action');
    //     var parent = $(this).parent();

    //     idmodel = parent.parent().attr('data-idmodel');
        
    //     if (accion == 'edit')
    //         GoToEditCategoria(idmodel);
    //     else if (accion == 'goto')
    //         FiltrarPorIdItem(idmodel);
    // });

    $('#btnAplicarCategoria').on('click', function(event) {
        event.preventDefault();
        GuardarCategoria();
    });

    $('#btnAplicarAlmacen').on('click', function(event) {
        event.preventDefault();
        GuardarAlmacen();
    });

    $('#gvDatos').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        // var parent = this.parentNode.parentNode.parentNode.parentNode;
        var parent = getParentsUntil(this, '#gvDatos', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');

        datagrid.removeSelection();

        // if (accion == 'change-cost') {
        //     LimpiarChangeCost();
            
        //     openModalCallBack('#modalChangeCost', function () {
        //         $('#hdIdInsumo').val(idmodel);

        //         var _nombreInsumo = (function () {
        //             var _descripcion = parent[0].getElementsByClassName('descripcion')[0];
        //             return _descripcion.textContent || _descripcion.innerText;
        //         });

        //         var _nombreUnidadMedida = (function () {
        //             var _unidadmedida = parent[0].getElementsByClassName('unidadmedida')[0];
        //             return _unidadmedida.textContent || _unidadmedida.innerText;
        //         });

        //         $('#lblInsumo_Costo').text(_nombreInsumo);
        //         $('#lblUnidadMedida_Costo').text(_nombreUnidadMedida);
        //     });
        // }
        // else 
        if (accion == 'edit')
            GoToEditInsumo(idmodel);
        else if (accion == 'delete') {
            MessageBox({
                content: '¿Desea eliminar este elemento?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            EliminarItemInsumo(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#tablePresentacion tbody').on('click', 'a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');

        if (accion == 'delete') {
            var parent = getParentsUntil(this, '#tablePresentacion', 'tr');
            
            $(parent).fadeOut(400, function() {
                $(this).remove();
            });
        };
    });

    // $('#tablePresentacion tbody').on('click', 'tr', function(event) {
    //     event.preventDefault();
    //     if (this.hasClass('selected')){
    //         this.removeClass('selected');
    //         if ($('#tablePresentacion tbody tr.selected') === null){
    //             $('#btnQuitarPresentacion, #btnEditarPresentacion, #btnCleanSelectPresentacion').addClass('oculto');
    //             $('#btnAgregarPresentacion').removeClass('oculto');
    //         };
    //     }
    //     else {
    //         this.addClass('selected');
    //         $('#btnQuitarPresentacion, #btnEditarPresentacion, #btnCleanSelectPresentacion').removeClass('oculto');
    //         $('#btnAgregarPresentacion').addClass('oculto');
    //     };
    // });

    // $('#btnQuitarPresentacion').on('click', function(event) {
    //     event.preventDefault();
    //     // $('#tablePresentacion tbody tr.selected').fadeOut('400', function() {
    //     //     $(this).remove();
    //     // });
    //     $('#btnQuitarPresentacion, #btnEditarPresentacion, #btnCleanSelectPresentacion').addClass('oculto');
    //     $('#btnAgregarPresentacion').removeClass('oculto');
    // });

    /*$(document).on('click.fixedActionBtn', '.fixed-action-btn.click-to-toggle > a', function(e) {
        var $this = $(this);
        var $menu = $this.parent();
        
        if ($menu.hasClass('active')) {
            $this.find('.material-icons').text('close');
            $('.buttonfab-overlay').attr('data-relfab', $menu.attr('id')).show();
            doRippleEffect('.buttonfab-overlay');
        }
        else {
            $this.find('.material-icons').text('widgets');
            $('.buttonfab-overlay').removeAttr('data-relfab').hide();
        };
    });*/

    /*$('#btnOptions').on('click', function(event) {
        event.preventDefault();
        var $this = $(this);

        if ($this.hasClass('active')) {
            $this.removeClass('active').find('.material-icons').text('widgets');
            $('.buttonfab-overlay').removeAttr('data-relfab').hide();
            $('#modalOptions').slideUp();
        }
        else {
            $this.addClass('active').find('.material-icons').text('close');
            $('.buttonfab-overlay').attr('data-relfab', this.getAttribute('id')).show();
            $('#modalOptions').slideDown();
        };
    });*/
});

// var paginaCategoria = 1;
// var paginaInsumo = 1;
var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var selectorSelection = '#pnlListado .mdl-layout__content section:visible';

var messagesValid = {
    txtNombreCategoria: {
        remote: "Este nombre de categoría ya existe"
    },
    txtNombreAlmacen: {
        remote: "Este nombre de almacen ya existe"
    }
};

var handlerRowCheck = function  (_this, selectorgrid, event) {
    if ((event.target || {}).type !== 'textbox') {
        var _checkbox = _this;
        var _showAppbar = true;
        var _parent, _gridview, _controlsEnable;

        if ((_this || {}).type !== 'checkbox') {
            event.preventDefault();
            _parent = _this;
            _checkbox = _this.querySelector('input[type="checkbox"]');
            
            if (_checkbox != null)
                _checkbox.checked = !_checkbox.checked;
        }
        else
            _parent = getParentsUntil(_checkbox, selectorgrid, '.dato');

        if (selectorgrid == '#gvStockInsumo') {

            var inputSaldoInicial = _parent.getElementsByClassName('saldoinicial')[0];
            var inputCostoUnitario = _parent.getElementsByClassName('costounitario')[0];
            
            _gridview = gvStockInsumo;
            _controlsEnable = [inputSaldoInicial, inputCostoUnitario];
            
            if (_checkbox != null){
                habilitarControl(_controlsEnable, _checkbox.checked);

                if (_checkbox.checked) {
                    _parent.classList.add('selected');
                    _showAppbar = true;
                    
                    inputSaldoInicial.parentNode.classList.remove('is-disabled'); 
                    inputCostoUnitario.parentNode.classList.remove('is-disabled');

                    inputSaldoInicial.focus();
                    inputSaldoInicial.select();
                }
                else {
                    _parent.classList.remove('selected');
                    
                    inputSaldoInicial.parentNode.classList.add('is-disabled');
                    inputCostoUnitario.parentNode.classList.add('is-disabled');
                    
                    if ($(selectorgrid).find('.selected').length == 0)
                        _showAppbar = false;
                };
            };

            _gridview.showAppBar(_showAppbar, 'edit');
        };
    };
};

var gvCategoria = new DataList('#gvCategoria', {
    typeview: 'checklist',
    onSearch: function () {
        ListarCategorias(gvCategoria.currentPage());
    }
});

var gvAlmacen = new DataList('#gvAlmacen', {
    typeview: 'checklist',
    onSearch: function () {
        ListarAlmacen(gvAlmacen.currentPage());
    }
});

var datagrid = new DataList('#gvDatos', {
    onSearch: function () {
        ListarInsumos('#gvDatos', '1', '0', datagrid.currentPage());
    }
});

var gvStockInsumo = new DataList('#gvStockInsumo', {
    actionbar: '#stockinsumo-actionbar',
    onSearch: function () {
        ListarInsumos('#gvStockInsumo', $('#hdTipoInsumo').val(), $('#hdIdAlmacen').val(), gvStockInsumo.currentPage());
    }
});

function LimpiarCategoria () {
    $('#hdIdCategoria').val('0');
    $('#txtNombreCategoria').val('').focus();
}

function LimpiarAlmacen () {
    $('#hdIdAlmacen').val('0');
    $('#txtDireccionAlmacen').val('');
    $('#txtNombreAlmacen').val('').focus();
}

function LimpiarInsumo () {
    $('#hdIdPrimary').val('0');
    $('#txtDescripcion').val('');
    $('#txtCostoPromedio').val('0.00');
    $('#txtStockMinimo').val('0.000');
    $('#txtStockMaximo').val('0.000');
    $('#txtNombre').val('').focus();
}

function Nuevo () {
    if ($('#gvDatos').is(':visible'))
        GoToEditInsumo('0');
    else if ($('#gvAlmacen').is(':visible'))
        GoToEditAlmacen('0');
    else
        GoToEditCategoria('0');
}

// function showMenuItem (obj, selector) {
//     var descripcion = '';
//     var header_dialog;
//     var dialog = $(selector).data('dialog');

//     idregistro = $(obj).parent().attr('data-idmodel');
//     descripcion = $(obj).parent().find('.descripcion').text();

//     header_dialog = document.querySelector(selector + ' .header-dialog');
//     header_dialog.setAttribute('title', descripcion);
//     header_dialog.innerText = descripcion;

//     dialog.open();
// }

function FiltrarPorIdItem (iditem) {
    $('#hdIdCategoria').value = iditem;
    navigateSubSite('#gvDatos', 'Insumos');
    //paginaInsumo = 1;
    ListarInsumos('#gvDatos', '1', '0', '1');
}

function clearFormPresentacion () {
    $('#ddlPresentacion')[0].selectedIndex = 0;
    $('#txtMedida').val('0');
}

function ListarPresentaciones (idinsumo) {
    $.ajax({
        type: "GET",
        url: 'services/presentacion/presentacion-search.php',
        cache: false,
        data: 'tipobusqueda=1&idinsumo=' + idinsumo + '&tipoinsumo=00',
        dataType: 'json',
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';
            if (countdata > 0){
                while(i < countdata){
                    strhtml += crearItem_Presentacion(data[i].tm_idpresentacion, data[i].tm_idunidadmedida, data[i].Presentacion, data[i].UnidadMedida, data[i].td_medida);
                    ++i;
                    counter_presentacion = i;
                }
            };
            
            $('#tablePresentacion tbody').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GetInfoPresentacion () {
    var rowSelected = $('#tablePresentacion tbody tr.selected:first');

    var idpresentacion = rowSelected[0].getAttribute('data-idpresentacion');
    var idunidadmedida = rowSelected[0].getAttribute('data-idunidadmedida');
    var medida = rowSelected.find('.medida').text();

    $('#ddlPresentacion').val(idpresentacion);
    // $('#ddlUnidadMedida').val(idunidadmedida);
    $('#txtMedida').val(medida);
}

var counter_presentacion = 0;

function crearItem_Presentacion (idpresentacion, idunidadmedida, presentacion, unidadmedida, medida) {
    var strhtml = '';

    strhtml += '<tr data-iddetalle="0" data-idpresentacion="' + idpresentacion + '" data-idunidadmedida="' + idunidadmedida + '">';
    
    strhtml += '<td class="hide">';

    strhtml += '<input type="hidden" name="pre_insumo[' + counter_presentacion + '][idpresentacion]" value="' + idpresentacion  + '" />';
    strhtml += '<input type="hidden" name="pre_insumo[' + counter_presentacion + '][idunidadmedida]" value="' + idunidadmedida  + '" />';
    strhtml += '<input type="hidden" name="pre_insumo[' + counter_presentacion + '][medida]" value="' + medida  + '" />';
    strhtml += '</td>';

    strhtml += '<td class="presentacion">' + presentacion + '</td>';
    strhtml += '<td class="unidadmedida">' + unidadmedida + '</td>';
    strhtml += '<td class="medida text-right">' + medida + '</td>';
    strhtml += '<td class="text-center"><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></td>';
    strhtml += '</tr>';

    return strhtml;
}

function AddDetalle () {
    var rowSelected = $('#tablePresentacion tbody tr.selected');
    
    var idpresentacion = $('#ddlPresentacion').val();
    var presentacion = $('#ddlPresentacion option:selected').text();
    var idunidadmedida = $('#ddlUnidadMedidaReg').val();
    var unidadmedida = $('#ddlUnidadMedidaReg option:selected').attr('data-simbolo');
    var medida = Number($('#txtMedida').val());

    if ($('#btnPresentacionAdd').hasClass('mode-edit')){
        if (rowSelected.length > 0){
            rowSelected.attr('data-idpresentacion', idpresentacion);
            rowSelected.attr('data-idunidadmedida', idunidadmedida);
            
            rowSelected.find('.presentacion').text(presentacion);
            rowSelected.find('.unidadmedida').text(unidadmedida);
            rowSelected.find('.medida').text(medida);
            closeCustomModal('#pnlInfoPresentacion');
            $('#tablePresentacion tbody tr.selected').removeClass('selected');
        };
    }
    else {
        if ($('#tablePresentacion tbody tr:first').find('h3').length > 0)
            $('#tablePresentacion tbody tr').remove();
        
        var strhtml = crearItem_Presentacion(idpresentacion, idunidadmedida, presentacion, unidadmedida, medida);

        $('#tablePresentacion tbody').append(strhtml);
        ++counter_presentacion;
        
        clearFormPresentacion();
        $('#ddlPresentacion').focus();
    };
}

function BackToList () {
    removeValidFormInsumo();
    $('#pnlForm').fadeOut(500, function () {
        $('#pnlListado').fadeIn(500, function () {

        });
    });
}

function addValidFormCategoria () {
    $('#txtNombreCategoria').rules('add', {
        required: true,
        maxlength: 150,
        remote: {
            url:  'services/categorias/check-nombre-categoria_insumo.php',
            type: 'POST',
            data: {
                idempresa: function() {
                    return $('#hdIdEmpresa').val();
                },
                idcentro: function() {
                    return $('#hdIdCentro').val();
                },
                idregistro: function() {
                    return $('#hdIdCategoria').val();
                }
            }
        }
    });
}

function removeValidFormCategoria () {
    $('#txtNombreCategoria').rules('remove');
}

function addValidFormAlmacen () {
    $('#txtNombreAlmacen').rules('add', {
        required: true,
        maxlength: 150,
        remote: {
            url:  'services/almacen/check-nombre.php',
            type: 'POST',
            data: {
                idempresa: function() {
                    return $('#hdIdEmpresa').val();
                },
                idcentro: function() {
                    return $('#hdIdCentro').val();
                },
                idregistro: function() {
                    return $('#hdIdAlmacen').val();
                }
            }
        }
    });
}

function removeValidFormAlmacen () {
    $('#txtNombreAlmacen').rules('remove');
}

function addValidFormInsumo () {
    $('#txtNombre').rules('add', {
        required: true,
        maxlength: 350,
        remote: {
            url:  'services/insumos/check-nombre.php',
            type: 'POST',
            data: {
                idempresa: function() {
                    return $('#hdIdEmpresa').val();
                },
                idcentro: function() {
                    return $('#hdIdCentro').val();
                },
                idregistro: function() {
                    return $('#hdIdPrimary').val();
                }
            }
        }
    });

    $('#txtCostoPromedio').rules('add', {
        required: true
    });
}

function removeValidFormInsumo () {
    $('#txtNombre').rules('remove');
    $('#txtCostoPromedio').rules('remove');
}

function GoToEditCategoria (idItem) {
    var selectorModal = '#modalRegCategoria';

    precargaExp(selectorModal, true);
    
    // resetForm(selectorModal);

    // removeValidFormCategoria();
    addValidFormCategoria();

    openModalCallBack(selectorModal, function () {
        LimpiarCategoria();
        
        if (idItem == '0')
            precargaExp(selectorModal, false);
        else {
            $.ajax({
                url: 'services/categorias/categoriainsumo-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idItem
                },
                success: function (data) {
                    if (data.length > 0){
                        $('#hdIdCategoria').val(data[0].tm_idcategoria_insumo);
                        $('#txtNombreCategoria').val(data[0].tm_nombre).focus();
                    };

                    precargaExp(selectorModal, false);
                },
                error: function  (data) {
                    console.log(data);
                }
            });
        };
    });
}

function GuardarCategoria () {
    var data = new FormData();

    if ($('#form1').valid()){
        var input_data = $('#modalRegCategoria :input').serializeArray();

        data.append('btnAplicarCategoria', 'btnAplicarCategoria');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/categorias/categoriainsumo-post.php',
            cache: false,
            dataType: 'json',
            data: data,
            contentType:false,
            processData: false,
            success: function(data){
                createSnackbar(data.titulomsje);

                if (data.rpta != '0'){
                    closeCustomModal('#modalRegCategoria');
                    ListarCategorias('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function EliminarCategoria () {
    indexList = 0;
    elemsSelected = $('#gvCategoria .selected');
    EliminarItemCategoria(elemsSelected[0], 'multiple');
}

function EliminarItemCategoria (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdCategoria', idmodel);

    $.ajax({
        url: 'services/categorias/categoriainsumo-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var itemSelected = $(item);
            var endqueue = false;

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemCategoria(elemsSelected[indexList], mode);
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

                if (typeof endCallback !== 'undefined')
                    endCallback();
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function ListarCategorias (pagina) {
    var selectorgrid = '#gvCategoria';
    var selector = selectorgrid + ' .gridview-content';
    var criterio = '';
    
    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: 'services/categorias/categoriainsumo-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 1,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var posmenu = '';
            var iditem = '0';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idcategoria_insumo;
                    var nombre = data[i].tm_nombre;

                    strhtml += '<li data-idmodel="' + iditem + '" class="list-group-item dato" data-baselement="' + selectorgrid + '">';
                    

                    strhtml += '<input name="chkItem[]" type="checkbox" class="filled-in" value="' + iditem + '" id="chkItem' + i + '" /><label for="chkItem' + i + '" class="check-filled"></label>';

                    strhtml += data[i].tm_nombre;
                    
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5">';
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';
                    strhtml += '<ul class="dropdown">';
                    strhtml += '<li><a href="#" data-action="edit">Editar</a></li>';
                    strhtml += '<li><a href="#" data-action="delete">Eliminar</a></li>';
                    strhtml += '</div>';

                    strhtml += '</li>';
                    ++i;
                };
                
                gvCategoria.currentPage(gvCategoria.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                // $(selector + ' .grouped-buttons a.tooltipped').tooltip();
                registerScriptMDL('#gvCategoria .mdl-js-checkbox');
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

function GoToEditInsumo (idItem) {
    var selectorModal = '#pnlForm';
    
    precargaExp(selectorModal, true);

    // resetForm(selectorModal);

    // removeValidFormInsumo();
    addValidFormInsumo();

    $('#tablePresentacion tbody').html('');

    $('#pnlListado').fadeOut(500, function () {
        $(selectorModal).fadeIn(500, function () {
            LimpiarInsumo();

            if (idItem == '0'){
                ListarCategorias_Combo('0');
                ListarUnidadMedida_Combo('#ddlUnidadMedidaReg', '0');
                
                precargaExp(selectorModal, false);
            }
            else {
                $.ajax({
                    type: "GET",
                    url: 'services/insumos/insumos-getdetails.php',
                    cache: false,
                    data: 'id=' + idItem,
                    dataType: 'json',
                    success: function (data) {
                        if (data.length > 0){
                            var idinsumo = data[0].tm_idinsumo;
                            
                            $('#hdIdPrimary').val(idinsumo);
                            $('#txtDescripcion').val(data[0].tm_descripcion);
                            $('#txtCostoPromedio').val(data[0].tm_costoPromedio);
                            $('#txtStockMinimo').val(data[0].tm_stock_min);
                            $('#txtStockMaximo').val(data[0].tm_stock_max);
                            // $('#ddlCategoriaReg').val(data[0].tm_idcategoria);
                            // $('#ddlUnidadMedidaReg').val(data[0].tm_idunidadmedida);
                            Materialize.updateTextFields();
                            
                            ListarCategorias_Combo(data[0].tm_idcategoria);
                            ListarUnidadMedida_Combo('#ddlUnidadMedidaReg', data[0].tm_idunidadmedida);
                            
                            counter_presentacion = 0;
                            ListarPresentaciones(idinsumo);

                            $('#txtNombre').val(data[0].tm_nombre).focus();
                        };

                        precargaExp(selectorModal, false);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            };
        });
    });
}

function GuardarInsumo () {
    if ($('#form1').valid()){
        var data = new FormData();  
        var input_data = $('#pnlForm :input').serializeArray();

        data.append('btnGuardar', 'btnGuardar');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: 'services/insumos/insumos-post.php',
            cache: false,
            dataType: 'json',
            data: data,
            contentType:false,
            processData: false,
            success: function(data){
                createSnackbar(data.titulomsje);

                if (data.rpta != '0'){
                    // paginaInsumo = 1;
                    BackToList();
                    ListarInsumos('#gvDatos', '1', '0', '1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function EliminarInsumo () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected').toArray();
    EliminarItemInsumo(elemsSelected[0], 'multiple');
}

function EliminarItemInsumo (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdInsumo', idmodel);

    $.ajax({
        url: 'services/insumos/insumos-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var endqueue = false;
            var itemSelected = $(item);

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemInsumo(elemsSelected[indexList], mode);
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

                if (typeof endCallback !== 'undefined')
                    endCallback();
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function ListarInsumos(selectorgrid, tipo, idalmacen, pagina) {
    var selector = selectorgrid + ' .contenedor';
    var tipobusqueda = selectorgrid == '#gvDatos' ? 'INSUMO' : 'INSUMO-STOCK';
    var selector_criterio = selectorgrid == '#gvDatos' ? '#txtSearch' : '#txtSearchStock';
    var idcategoria = $('#hdIdCategoria').val();
    
    precargaExp('#pnlListado', true);

    $.ajax({
        url: 'services/insumos/insumos-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            tipo: tipo,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idalmacen: idalmacen,
            id: idcategoria,
            criterio: $(selector_criterio).val(),
            pagina: pagina
        },
        success: function (data) {
            var countdata = data.length;
            var i = 0;
            var strhtml = '';
            
            if (countdata > 0) {
                while(i < countdata){
                    var iditem = data[i].tm_idinsumo;

                    if (selectorgrid == '#gvDatos') {
                        strhtml += '<div class="pos-rel card-panel padding10 mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--4-col-phone dato bg-gray-glass" data-idmodel="' + iditem + '" data-baselement="' + selectorgrid + '">';

                        strhtml += '<input name="chkInsumo[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<h4 class="descripcion">' + data[i].tm_nombre + '</h4>';
                        strhtml += '<strong>Unidad base:</strong> <span class="unidadmedida">' + data[i].nombre_unidad + ' (' + data[i].simbolo_unidad + ')</span>';

                        strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';

                        // if (tipobusqueda == 'INSUMO-STOCK') {
                        //     strhtml += '<h5 class="place-bottom-left no-margin padding10">Stock: ' + data[i].td_stock + '</h5>';

                        //     strhtml += '<div class="single-input-card place-bottom-left-right padding10 white">';
                        //     strhtml += '<label for="txtSaldoInicial' + i + '">Stock</label>';
                        //     strhtml += '<input id="txtSaldoInicial' + i + '" name="insumo[' + i + '][txtSaldoInicial]" type="text" class="validate no-margin text-right width-auto padding5 height-auto stock" value="' + data[i].td_stock + '">';
                        //     strhtml += '</div>';
                        // }
                        // else {
                        strhtml += '<div class="grouped-buttons place-bottom-right padding5">';
                        strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';
                        strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';
                        strhtml += '</div>';
                        // };

                        strhtml += '</div>';
                    }
                    else {
                        strhtml += '<tr data-idmodel="' + iditem + '" class="dato">';
                        strhtml += '<td>';
                        strhtml += '<input type="checkbox" class="filled-in" id="chkItemArtIns' + i + '" name="mc_articulo[' + i + '][chkItemArtIns]" value="' + iditem + '" /><label for="filled-in-box"></label>';
                        strhtml += '</td>';

                        strhtml += '<td data-title="Articulo" class="v-align-middle pos-rel">' + data[i].tm_nombre + '</td>';

                        strhtml += '<td data-title="Unidad de medida">' + data[i].UM + '</td>';

                        strhtml += '<td data-title="Saldo inicial">';
                        strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right saldoinicial" type="number" step="any" name="mc_articulo[' + i + '][saldoinicial]" id="saldoinicial' + i + '" value="' + data[i].td_stock + '"><label class="mdl-textfield__label" for="saldoinicial' + i + '"></label></div>';

                        strhtml += '</td>';
                        strhtml += '<td data-title="Costo unitario">';
                        
                        strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right costounitario" type="number" step="any" name="mc_articulo[' + i + '][costounitario]" id="costounitario' + i + '" value="' + data[i].tm_costo_unitario + '"><label class="mdl-textfield__label" for="costounitario' + i + '"></label></div>';
                        
                        strhtml += '</td>';
                        strhtml += '<td data-title="Costo total">';
                        
                        strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input readonly class="mdl-textfield__input align-right costotal" type="number" step="any" name="mc_articulo[' + i + '][costotal]" id="costotal' + i + '" value="' + data[i].tm_costo_total + '"><label class="mdl-textfield__label" for="costotal' + i + '"></label></div>';
                        
                        strhtml += '</td>';

                        strhtml += '</tr>';
                    };
                    ++i;
                };

                var objGrid;
                if (selectorgrid == '#gvDatos')
                    objGrid = datagrid;
                else
                    objGrid = gvStockInsumo;
                
                objGrid.currentPage(objGrid.currentPage() + 1);

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

function GoToEditAlmacen (idItem) {
    var selectorModal = '#modalRegAlmacen';

    precargaExp(selectorModal, true);
    
    // resetForm(selectorModal);

    // removeValidFormAlmacen();
    addValidFormAlmacen();

    openModalCallBack(selectorModal, function () {
        LimpiarAlmacen();

        if (idItem == '0')
            precargaExp(selectorModal, false);
        else {
            $.ajax({
                url: 'services/almacen/almacen-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '3',
                    id: idItem
                },
                success: function (data) {
                    if (data.length > 0){
                        $('#hdIdAlmacen').val(data[0].tm_idalmacen);
                        $('#txtDireccionAlmacen').val(data[0].tm_direccion);
                        $('#chkDefaultAlmacen')[0].checked = data[0].tm_default == '1' ? true : false;
                        $('#txtNombreAlmacen').val(data[0].tm_nombre).focus();
                        
                        Materialize.updateTextFields();
                    };

                    precargaExp(selectorModal, false);
                },
                error: function  (data) {
                    console.log(data);
                }
            });
        };
    });
}

function GuardarAlmacen () {
    var data = new FormData();

    if ($('#form1').valid()){
        var input_data = $('#modalRegAlmacen :input').serializeArray();

        data.append('btnAplicarAlmacen', 'btnAplicarAlmacen');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/almacen/almacen-post.php',
            cache: false,
            dataType: 'json',
            data: data,
            contentType:false,
            processData: false,
            success: function(data){
                createSnackbar(data.titulomsje);

                if (data.rpta != '0'){
                    closeCustomModal('#modalRegAlmacen');
                    ListarAlmacen('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function EliminarAlmacen () {
    indexList = 0;
    elemsSelected = $('#gvAlmacen .selected');
    EliminarItemAlmacen(elemsSelected[0], 'multiple');
}

function EliminarItemAlmacen (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdAlmacen', idmodel);

    $.ajax({
        url: 'services/almacen/almacen-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var itemSelected = $(item);
            var endqueue = false;

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemAlmacen(elemsSelected[indexList], mode);
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

                if (typeof endCallback !== 'undefined')
                    endCallback();
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function ListarAlmacen (pagina) {
    var selectorgrid = '#gvAlmacen';
    var selector = selectorgrid + ' .list-group';
    var idcategoria = '0';

    precargaExp('#pnlListado', true);

    $.ajax({
        url: 'services/almacen/almacen-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function (data) {
            var countdata = data.length;
            var i = 0;
            var strhtml = '';
            
            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<div data-idmodel="' + data[i].tm_idalmacen + '" class="list-group-item dato">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="filled-in" value="' + data[i].tm_idalmacen + '" id="chkItem' + i + '" /><label for="chkItem' + i + '" class="check-filled"></label>';

                    strhtml += '<h4 class="list-group-item-heading">' + data[i].tm_nombre + '</h4>';
                    strhtml += '<p class="list-group-item-text">' + data[i].tm_direccion + '</p>';

                    // strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';

                    strhtml += '<div class="grouped-buttons place-bottom-right padding5">';
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';
                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    ++i;
                };

                gvAlmacen.currentPage(gvAlmacen.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);
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

function DefaultAlmacen () {
    $.ajax({
        url: 'services/almacen/almacen-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '4'
        },
        success: function (data) {
            if (data.length > 0) {
                var idalmacen = data[0].tm_idalmacen;

                $('#hdIdAlmacen').val(idalmacen);
                $('#txtSearchAlmacen').val(data[0].tm_nombre);

                ListarInsumos('#gvStockInsumo', '1', idalmacen, '1');
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GuardarStockInicial () {
    indexList = 0;
    elemsSelected = $('#gvStockInsumo .selected');
    GuardarItemStockInicial(elemsSelected[0], 'multiple');
}

function GuardarItemStockInicial (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');
    var saldoinicial = item.getElementsByClassName('saldoinicial')[0].value;
    var costounitario = item.getElementsByClassName('costounitario')[0].value;
    var costotal = item.getElementsByClassName('costotal')[0].value;

    data.append('btnEditarStock', 'btnEditarStock');
    data.append('hdTipoInsumo', $('#hdTipoInsumo').val() == '1' ? '00' : '01');
    data.append('hdIdInsumo', idmodel);
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdAlmacen', $('#hdIdAlmacen').val());
    data.append('txtSaldoInicial', saldoinicial);
    data.append('txtCostoUnitario', costounitario);
    data.append('txtCostoTotal', costotal);

    $.ajax({
        url: 'services/insumos/insumos-post.php',
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
                titulomsje = 'No se pudo registrar';
            }
            else {
                // $(item).addClass('complete');
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        GuardarItemStockInicial(elemsSelected[indexList], mode);
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
                
                if ($('#stockinsumo-actionbar').hasClass('is-visible')){
                    gvStockInsumo.removeSelection();
                    gvStockInsumo.showAppBar(false, 'edit');
                };

                if (data.rpta != '0')
                    ListarInsumos('#gvStockInsumo', $('#hdTipoInsumo').val(), $('#hdIdAlmacen').val(), '1');
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function ListarKardex () {    
    precargaExp('#pnlKardex', true);
    
    $.ajax({
        type: "GET",
        url: 'services/almacen/kardex-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 1,
            tipoexistencia: $('#ddlTipoExistencia').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idalmacen: $('#hdIdAlmacen').val(),
            idarticulo: $('#hdIdArticulo').val()
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';
            
            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<tr>';

                    strhtml += '<td class="text-center">' + data[i].tm_fechadoc + '</td>';
                    strhtml += '<td>' + data[i].TipoComprobante + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tm_seriedoc + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tm_numerodoc + '</td>';
                    strhtml += '<td>' + data[i].TipoOperacion + '</td>';
                    strhtml += '<td class="text-right">' + data[i].cantidad_entrada + '</td>';
                    strhtml += '<td class="text-right">' + data[i].costounitario_entrada + '</td>';
                    strhtml += '<td class="text-right">' + data[i].costototal_entrada + '</td>';
                    strhtml += '<td class="text-right">' + data[i].cantidad_salida, + '</td>';
                    strhtml += '<td class="text-right">' + data[i].costounitario_salida, + '</td>';
                    strhtml += '<td class="text-right">' + data[i].costotal_salida, + '</td>';
                    strhtml += '<td class="text-right">' + data[i].cantidad_saldo + '</td>';
                    strhtml += '<td class="text-right">' + data[i].costounitario_saldo + '</td>';
                    strhtml += '<td class="text-right">' + data[i].costototal_saldo + '</td>';

                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#gvKardex tbody').html(strhtml);

            precargaExp('#pnlKardex', false);
        },
        error: function (data) {
            console.log(error);
        }
    });
}

function CerrarKardex () {
    var data = new FormData();

    data.append('btnCerrarKardex', 'btnCerrarKardex');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('ddlTipoExistencia', $('#ddlTipoExistencia').val());
    data.append('ddlAnho', $('#ddlAnho').val());
    data.append('ddlMes', $('#ddlMes').val());
    data.append('hdIdArticulo', $('#hdIdArticulo').val());

    $.ajax({
        url: 'services/almacen/kardex-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var countdata = data.length;
            var strhtml = '';
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + data[i].fecha + '</td>';
                    strhtml += '<td>' + data[i].tipo_documento + '</td>';
                    strhtml += '<td>' + data[i].serie + '</td>';
                    strhtml += '<td>' + data[i].numero + '</td>';
                    strhtml += '<td>' + data[i].tipo_operacion + '</td>';
                    strhtml += '<td>' + data[i].cantidad_entrada + '</td>';
                    strhtml += '<td>' + data[i].costo_unitario_entrada + '</td>';
                    strhtml += '<td>' + data[i].costo_total_entrada + '</td>';
                    strhtml += '<td>' + data[i].cantidad_salida + '</td>';
                    strhtml += '<td>' + data[i].costo_unitario_salida + '</td>';
                    strhtml += '<td>' + data[i].costo_total_salida + '</td>';
                    strhtml += '<td>' + Number(data[i].cantidad_saldo).toFixed(2) + '</td>';
                    strhtml += '<td>' + Number(data[i].costo_unitario_saldo).toFixed(2) + '</td>';
                    strhtml += '<td>' + Number(data[i].costo_total_saldo).toFixed(2) + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#gvKardex tbody').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function LimpiarChangeCost () {
    $('#hdIdInsumo').val('0');
    $('#txtCostoReceta').val('0.00');
}

function CambiarCostoInsumo () {
    var data = new FormData();

    data.append('btnCambiarCostoInsumo', 'btnCambiarCostoInsumo');
    data.append('hdIdInsumo', $('#hdIdInsumo').val());
    data.append('txtCostoReceta', $('#txtCostoReceta').val());

    $.ajax({
        url: 'services/insumos/insumos-post.php',
        type: 'POST',
        dataType: 'json',
        cache: false,
        contentType:false,
        processData: false,
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0'){
                LimpiarChangeCost();
                closeCustomModal('#modalChangeCost');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ActualizarStockMinMax () {
    var data = new FormData();  
    var input_data = $('#gvDatos :input').serializeArray();

    data.append('btnCambiarStockMinMax', 'btnCambiarStockMinMax');
    data.append('txtStockMin_Masivo', $('#txtStockMin_Masivo').val());
    data.append('txtStockMax_Masivo', $('#txtStockMax_Masivo').val());

    $.each(input_data, function(key, fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/insumos/insumos-post.php',
        type: 'POST',
        dataType: 'json',
        cache: false,
        contentType:false,
        processData: false,
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0'){
                $('#txtStockMax_Masivo').val('0.00');
                $('#txtStockMin_Masivo').val('0.00');
                datagrid.removeSelection();
                closeCustomModal('#modalChangeStockMinMax');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarCategorias_Combo (idcategora_default){    
    $.ajax({
        type: "GET",
        url: 'services/categorias/categoriainsumo-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    var _selected = idcategora_default == data[i].tm_idcategoria_insumo ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcategoria_insumo + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No existen categor&iacute;as registradas.</option>';

            $('#ddlCategoriaReg').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarUnidadMedida_Combo (selector, idunidadmedida_default){    
    $.ajax({
        type: "GET",
        url: 'services/unidadmedida/unidadmedida-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    var _selected = idunidadmedida_default == data[i].tm_idunidadmedida ? ' selected' : '';
                    strhtml += '<option' + _selected + ' data-simbolo="' + data[i].tm_abreviatura + '" value="' + data[i].tm_idunidadmedida + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay unidades de medida registradas.</option>';

            $(selector).html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarPresentacion_Combo (idpresentacion_default){    
    $.ajax({
        type: "GET",
        url: 'services/presentacion/presentacion-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipo: 'L',
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    var _selected = idpresentacion_default == data[i].tm_idpresentacion ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idpresentacion + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay categor&iacute;as de insumo.</option>';

            $('#ddlPresentacion').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function clearValidationsRules (idmodal) {
    if (idmodal == '#modalRegCategoria')
        removeValidFormCategoria();
    else if (idmodal == '#modalRegAlmacen')
        removeValidFormAlmacen();
}

function Buscar () {
    if ($('#gvCategoria').is(':visible'))
        ListarCategorias('1');
    else if ($('#gvAlmacen').is(':visible'))
        ListarAlmacen('1');
    else
        ListarInsumos('#gvDatos', '1', '0', '1');
}

function showAll () {
    $('#txtSearch').val('');

    if ($('#gvStockInsumo').is(':visible'))
        ListarInsumos('#gvStockInsumo', $('#hdTipoInsumo').val(), $('#hdIdAlmacen').val(), '1');
    else
        Buscar();
}

function getDataByReference (reference) {
    showAll();
}

function callBack__selectAll () {
    if ($('#gvCategoria').is(':visible'))
        $('#generic-actionbar a[data-action="change-stockminmax"]').addClass('hide');
    else if ($('#gvAlmacen').is(':visible'))
        $('#generic-actionbar a[data-action="change-stockminmax"]').addClass('hide');
    else if ($('#gvDatos').is(':visible'))
        $('#generic-actionbar a[data-action="change-stockminmax"]').removeClass('hide');
}