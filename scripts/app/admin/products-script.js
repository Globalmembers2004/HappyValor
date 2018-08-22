$(function () {    

    BuscarDatos('1');

   $('#btnGuardar').on('click', function(event) {
       event.preventDefault();
       Registrar();
       
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
                            EliminarItemArticulo(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#btnSearch').on('click', function(event) {
        event.preventDefault();
        var gridview;
        if ($('#gvCategoria').is(':visible'))
            gridview = gvCategoria;
        else if ($('#gvAlmacen').is(':visible'))
            gridview = gvAlmacen;
        else
            gridview = gvArticulo;

        gridview.showAppBar(true, 'search');
        $('#txtSearch').focus();
    });

    $('#txtNroPorciones').on('keyup', function(event) {
        event.preventDefault();
        CalcularPorciones();
        // calcularTotalCostoReceta();
    });
    
    // inputNavigation('#gvArticuloMenu tbody');
    // inputNavigation('#gvArticulo tbody');
    // inputNavigation('#tableReceta tbody');

    $('#tableReceta').on('click', 'a', function(event) {
        event.preventDefault();
        var accion = this.getAttribute('data-action');
        if (accion == 'delete') {
            var parent = getParentsUntil(this, '#tableReceta', 'tr');
            
            $(parent).fadeOut(400, function() {
                $(this).remove();
            });
        };
    });

    $('#tableReceta tbody').on('keyup', 'input:text', function(event) {
        event.preventDefault();
        
        CalcularPorciones();
    });

    $('#gvArticulo .scrollbarra').on('scroll', function(event){
        gvArticulo.listenerScroll(this, event);
    });

    $('#gvArticulo .table tbody').on('scroll', function(event){
        gvArticulo.listenerScroll(this, event);
    });


    $('#btnCloseFilter').on('click', function(event) {
        event.preventDefault();
        toggleOptions_v2('#pnlPackAsignacion', 'right');
    });

    $('#btnAsignarGrupoProducto').on('click', function(event) {
        event.preventDefault();
        AsignacionGrupoArticulo();
    });


    $('#btnProgram').on('click', function(event) {
        event.preventDefault();
        AsignarArticulosMenu();
    });

    $('#tableSeccion tbody').on('click', 'input:checkbox', function (event) {
        handlerRowCheck(this, '#tableSeccion', event);
    });
    
    $('#tableSeccion tbody').on('click', 'tr', function (event) {
        handlerRowCheck(this, '#tableSeccion', event);
    });

    $('#tableSeccion tbody').on('click', 'tr input:text', function (event) {
        event.stopPropagation();
    });

    $('#gvArticulo tbody').on('click', 'input:checkbox', function (event) {
        handlerRowCheck(this, '#gvArticulo', event);
    });
    
    $('#gvArticulo tbody').on('click', 'tr', function (event) {
        handlerRowCheck(this, '#gvArticulo', event);
    });

    $('#gvArticulo tbody').on('click', 'tr .mdl-textfield__input', function (event) {
        event.stopPropagation();
    });

    $('#gvArticuloMenu tbody').on('click', 'input:checkbox', function (event) {
        handlerRowCheck(this, '#gvArticuloMenu', event);
    });
    
    $('#gvArticuloMenu tbody').on('click', 'tr', function (event) {
        handlerRowCheck(this, '#gvArticuloMenu', event);
    });

    $('#gvArticuloMenu tbody').on('click', 'tr .mdl-textfield__input', function (event) {
        event.stopPropagation();
    });

    $('#btnSelectAll').on('click', function(event) {
        event.preventDefault();
        if ($('#gvCategoria').is(':visible')){
            gvCategoria.selectAll();

        }
        else if ($('#gvPacks').is(':visible'))
            gvPacks.selectAll();
        else {
            if ($('#hdAsignacionMenu').val() == 'true'){
                checkAllTable('#gvArticulo tbody tr', true);
                gvArticulo.showAppBar(true, 'edit');
            }
            else
                gvArticulo.selectAll();
        };
    });

    $('#btnUnSelectAll').on('click', function(event) {
        event.preventDefault();
        if (panelListado.is(':visible')) {
            if ($('#gvCategoria').is(':visible')){
                gvCategoria.removeSelection();

            }
            else if ($('#gvPacks').is(':visible'))
                gvPacks.removeSelection();
            else
                removeSelectionInMenu();
        }
        else
            removeSelectionInMenu();
    });

    $('#gvCategoria').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        // var parent = this.parentNode.parentNode.parentNode.parentNode;
        var parent = getParentsUntil(this, '#gvCategoria', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');

        if (accion == 'edit')
            GoToEditCategoria(idmodel);
        // else 
        // if (accion == 'goto')
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

    $('#btnAplicarCategoria').on('click', function(event) {
        event.preventDefault();
        GuardarCategoria();
    });


    $('#gvPacks').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        var parent = getParentsUntil(this, '#gvPacks', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');

        if (accion == 'edit')
            GoToEditPack(idmodel);
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
                            EliminarItemPack(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    btnShowCalendar.on('click touchend', function (event) {
        event.preventDefault();
        event.stopPropagation();

        pnlShowCalendar.toggleClass('is-visible');
    });

    pnlSubMenu.on('click', 'a', function(event) {
        event.preventDefault();

        pnlSubMenu.find('.active').removeClass('active');
        $(this).addClass('active');

        $('#titleMenuCarta').html(this.innerHTML);

        paginaDetalle = 1;

        if (this.getAttribute('data-type') == 'carta')
            ListarArticulos_Carta('1');
        else
            ListarArticulos_Menu('2', this.getAttribute('data-idmodel'), '1');

        showOrHideCharmOptions('#pnlSubMenu', false);
    });


    
    $('#gvArticulo').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        var parent = getParentsUntil(this, '#gvArticulo', '.dato');
        
        var dropdownParent = $(parent).find('.dropdown');
        var idmodel = $(parent).attr('data-idmodel');

        gvArticulo.removeSelection();
        if (accion == 'edit')
            GoToEditArticulo(idmodel);
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
                            EliminarItemArticulo(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };

        dropdownParent.removeClass('fixed');
    });

    $('#btnActionMenu').on('click touchend', '.mfb-component__button--child', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');

        // if (accion == 'save-changes')
        //     AsignarArticulosMenu('EDIT');
        // else 
        if (accion == 'search-articles') {
            $('#gvArticulo tbody').html('');
            $('#gvArticulo > .gridview-content > .mdl-grid').html('');

            $('#hdAsignacionMenu').val('true');
            $('#hdModeMenuEdit').val('NEW');

            $('#btnProgram').removeClass('hide');
            $('#btnGoToPacks').removeClass('show-in-select').addClass('hide');

            $('#pnlMenuCarta').addClass('hide');
            panelListado.removeClass('hide');
            
            habilitarLink('#btnMoreSites', false);
            //paginaArticulo = 1;
            ListarArticulos('1');
        }
        else if (accion == 'open-menu')
            AperturarMenu();

        $('.buttonfab-overlay').trigger('click');
    });

    btnShowSubOpciones.on('click', function(event) {
        event.preventDefault();
        showOrHideCharmOptions('#pnlSubMenu', true);
    });

    btnChooseReceta.on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        mnuTipoReceta.addClass('is-visible');
    });
    
    mnuTipoReceta.on('click', 'a', function (event) {
        var tiporeceta = this.getAttribute('data-tiporeceta');

        if ($('#hdIdArticulo').val() == '0') {
            if ($('#tableReceta tbody tr').length > 0) {
                MessageBox({
                    content: 'Si ha agregado insumos a este tipo de receta, guarde el artículo para no pderder sus cambios.',
                    width: '320px',
                    height: '130px',
                    cancelButton: true
                });

                return false;
            };
        };

        if (tiporeceta == '03'){
            $('#pnlTimePrepMenu').removeClass('hide');
            $('#pnlTimePrepCarta').addClass('hide');
        }
        else {
            $('#pnlTimePrepMenu').addClass('hide');
            $('#pnlTimePrepCarta').removeClass('hide');
        };

        btnChooseReceta.find('.text').text(this.innerHTML).attr('data-tiporeceta', tiporeceta);
        mnuTipoReceta.removeClass('is-visible');
        
        ListarReceta($('#hdIdArticulo').val(), tiporeceta);
    });

    btnAplicarGrupo.on('click', function(event) {
        event.preventDefault();
        GuardarGrupo();
    });

    btnNuevo.on('click', function (event) {
        event.preventDefault();
        Nuevo();
    });

    btnBackToArticles.on('click', function (event) {
        event.preventDefault();
        pnlRegArticulo.addClass('hide');
        panelListado.removeClass('hide');
        btnNuevo.removeClass('hide');
    });

    btnSearchInsumo.on('click', function (event) {
        event.preventDefault();
        
        hrowMain.addClass('hide');
        hrowSearchInsumo.removeClass('hide');
        btnHideSearchInsumo.removeClass('hide');
        
        var parent = hrowSearchInsumo.parent();
        parent.removeClass('blue');
        parent.addClass('white');

        var inputTextInsumo = hrowSearchInsumo.find('.taggle_input');
        inputTextInsumo.focus();
    });

    btnHideSearchInsumo.on('click', function (event) {
        event.preventDefault();

        $(this).addClass('hide');
        hrowMain.removeClass('hide');
        hrowSearchInsumo.addClass('hide');

        var parent = hrowSearchInsumo.parent();
        parent.removeClass('white');
        parent.addClass('blue');
    });

    btnAddInsumo.on('click', function (event) {
        event.preventDefault();
        addInsumoToReceta();
    });

    btnAplicarArticulo.on('click', function (event) {
        event.preventDefault();
        GuardarArticulo();
    });

    chkTieneReceta.on('click', function (event) {
        var flag = this.checked;
        helperReceta.text(flag ? 'SI' : 'NO');
        MostrarSelectUnidadMedida(flag);
    });

    chkEsAgregado.on('click', function(event) {
        helperAgregado.text(this.checked ? 'SI' : 'NO');
    });

    $('#articulos-actionbar').on('click', 'button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');

        if (accion == 'add-list') {
            // $('#articulos-actionbar .show-in-select').addClass('hide');
            // $('#btnAsignarGrupoProducto, #btnSearchPacks').removeClass('hide');
            
            $('#gvPacksAsignacion').addClass('custom');

            toggleOptions_v2('#pnlPackAsignacion', 'right');


            ListarPacks('#gvPacksAsignacion', '1');
        }
        else if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar todo lo seleccionado?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            if ($('#pnlListado').is(':visible')) {
                                if ($('#gvCategoria').is(':visible'))
                                    EliminarCategoria();
                                else if ($('#gvPacks').is(':visible'))
                                    EliminarPack();
                                else
                                    EliminarArticulo();
                            }
                            else
                                EliminarAsignados();
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    var gridview = hrowSearchInsumo.find('.gridview');
    gridview.on('click', '.icon-expand', function(event) {
        event.preventDefault();
        alert('test');
        return false;
    });

    gridview.on('click', 'li', function(event) {
        var badge_subitem = this.getElementsByClassName('badges_subitem')[0];
        insumoTag_setValues(gridview, this, badge_subitem);
        event.preventDefault();
    });

    gridview.on('click', '.badges_subitem', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var parent_item = this.parentNode.parentNode;
        //alert(this);
        insumoTag_setValues(gridview, parent_item, this);
        return false;
    });

    pnlViewAllArticles.on('click', '.view-button', function(event) {
        event.preventDefault();
        // var btnSearchArticles_FAB = $('#btnActionMenu a[data-action="search-articles"]');
        var selectorsToHide = '#titleMenuCarta, #btnShowSubOpciones';

        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');

        $('#optIndividual').removeClass('hide');

        if (this.getAttribute('data-action') == 'view-menu') {
            // btnSearchArticles_FAB.addClass('hide');
            $(selectorsToHide).removeClass('hide');
            $('#btnActionMenu').addClass('hide');

            paginaPack_lista = 1;
            ListarPacks_viewlist('1');
        }
        else {
            // btnSearchArticles_FAB.removeClass('hide');
            $(selectorsToHide).addClass('hide');
            $('#btnActionMenu').removeClass('hide');

            paginaDetalle = 1;
            ListarArticulos_Menu('1', 0, '1');
        };
    });

    $('#btnRecursosBack').on('click', listenerDefaultBackButton);

    $('#btnCerrarModalGrupo').on('click', function(event) {
        event.preventDefault();
        closeCustomModal('#modalRegPack');
    });

    $('#chkAllSeccion').on('click', function(event) {
        checkAllTable('#tableSeccion tbody tr', this.checked);
    });

    $('#btnNuevaCarta').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalRegCarta');
    });

    $('#btnAplicarCarta').on('click', function(event) {
        event.preventDefault();
        RegistrarCarta();
    });

    $('#btnCerrarModalCarta').on('click', function(event) {
        event.preventDefault();
        closeCustomModal('#modalRegCarta');
    });

    $('#btnAgregarPresentacion').on('click', function(event) {
        event.preventDefault();
        // resetForm('#pnlInfoPresentacion');
        openModalCallBack('#pnlInfoPresentacion', function () {
            ListarUnidadMedida_Combo('#ddlUnidadMedida', '0');
            ListarPresentacion_Combo('0');
        });
    });
    
    $('#btnPresentacionAdd').on('click', function(event) {
        event.preventDefault();
        AgregarPresentacion();
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
});

var url_base = 'media/images';

var listenerDefaultBackButton = function (event) {
    $('#btnUnSelectAll').trigger('click');

};

var listenerAsignaPackInBack = function (event) {
    event.preventDefault();

    var selector = '#gvPacksAsignacion';

    if (typeof $(selector + ' .dato.selected') !== 'undefined')
        $(selector + ' .dato.selected').removeClass('selected');
    
    [].forEach.call($(selector + ' input[type="checkbox"]'), function(el){
        el.checked = false;
    });

    // $('#articulos-actionbar .show-in-select').removeClass('hide');
    // $('#btnAsignarGrupoProducto, #btnSearchPacks').addClass('hide');
    
    // $('#gvPacks').addClass('hide');
    // $('#gvArticulo').removeClass('hide');
    
    $('#btnRecursosBack').off('click', listenerAsignaPackInBack);
    $('#btnRecursosBack').on('click', listenerDefaultBackButton);

    //this.addClass('hide');
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
            if (_checkbox != null) {
                _checkbox.checked = !_checkbox.checked;
                // _checkbox.parentNode.MaterialCheckbox.checkToggleState();
            };
        }
        else {
            _parent = getParentsUntil(_checkbox, selectorgrid, 'tr');
            // _parent = _parent[0];
        };

        if (selectorgrid == '#gvArticulo' || selectorgrid == '#gvArticuloMenu') {
            if (selectorgrid == '#gvArticuloMenu') {

                if (_parent.getAttribute('data-estadomenudia') == '01')
                    return false;

                var modo_vista_menu = $('#pnlViewAllArticles .view-button.active').attr('data-action');
                if (modo_vista_menu != 'view-list')
                    return false;
            };

            var inputStock = _parent.getElementsByClassName('stock')[0];
            var inputPrecio = _parent.getElementsByClassName('precio')[0];
            
            _gridview = selectorgrid == '#gvArticulo' ? gvArticulo : gvArticuloMenu;
            _controlsEnable = $('#hdTipoCarta').val() == '03' ? [inputStock, inputPrecio] : inputPrecio;
            
            if (_checkbox != null){
                habilitarControl(_controlsEnable, _checkbox.checked);

                if (_checkbox.checked) {
                    _parent.classList.add('selected');
                    _showAppbar = true;
                    
                    inputPrecio.parentNode.classList.remove('is-disabled');

                    if ($('#hdTipoCarta').val() == '03') {
                        inputStock.parentNode.classList.remove('is-disabled');                    
                        inputStock.focus();
                        inputStock.select();
                    }
                    else {
                        inputPrecio.focus();
                        inputPrecio.select();
                    };
                }
                else {
                    _parent.classList.remove('selected');
                    
                    inputStock.parentNode.classList.add('is-disabled');
                    inputPrecio.parentNode.classList.add('is-disabled');
                    
                    if ($(selectorgrid).find('.selected').length == 0)
                        _showAppbar = false;
                };
            };

            _gridview.showAppBar(_showAppbar, 'edit');
        }
        else if (selectorgrid == '#tableSeccion') {
            var inputSeccion = _parent.getElementsByClassName('seccion')[0];

            habilitarControl(inputSeccion, _checkbox.checked);

            if (_checkbox.checked) {
                _parent.classList.add('selected');
                
                inputSeccion.parentNode.classList.remove('is-disabled');                    
                inputSeccion.focus();
                inputSeccion.select();
            }
            else {
                _parent.classList.remove('selected');
                inputSeccion.parentNode.classList.add('is-disabled');
            };
        }
        else if (selectorgrid == '#gvCategoria') {
            var layerInput = _parent.getElementsByClassName('mdl-textfield')[0];
            var titleCategoria = _parent.getElementsByClassName('title')[0];
            
            if (_checkbox != null) {
                var flag = _checkbox.checked;
                
                if (flag) {
                    _parent.classList.add('selected');
                    titleCategoria.classList.add('hide');
                    layerInput.classList.remove('hide');
                    
                    var inputCategoria = layerInput.getElementsByClassName('categoria')[0];
                    
                    inputCategoria.focus();
                    //inputCategoria.select();

                    $('#btnCategoriaEdit').removeClass('hide');
                }
                else {
                    _parent.classList.remove('selected');
                    titleCategoria.classList.remove('hide');
                    layerInput.classList.add('hide');

                    flag = ($('#gvCategoria .selected').length == 0) ? false : true;
                };

                gvCategoria.showAppBar(flag, 'edit');
                if (flag === false)
                    $('#btnCategoriaEdit').addClass('hide');
            };
        };
    };
};

var calendario;
// var paginaCategoria = 1;
// var paginaArticulo = 1;
var paginaPack_lista = 1;
//var paginaPack_grilla = 1;
var paginaCarta_lista = 1;
var paginaCarta_grilla = 1;
var paginaDetalle = 1;
// var paginaInsumo = 1;
// var //selectorSelection = '#gvArticulo';
var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var completado = true;
var intervalProgress = new Interval(function(){
    var progressBar = elemsSelected[indexList].querySelector('.progress .determinate');
    
    ++progress;
    if (progress == 1)
        progressBar.addClass('teal lighten-1');
    
    progressBar.style.width = progress + '%';

    if (progress == 100)
        intervalProgress.stop();
}, 100);

var _idinsumo = 0;
var UnidadMedida = {
    id: 0,
    simbolo: '',
    idpresentacion: 0
};

var messagesValid = {
    txtNombreCategoria: {
        remote: "Este nombre de categoría ya existe"
    }
};

var gvArticuloMenu = new DataList('#gvArticuloMenu', {
    actionbar: '#articulos-actionbar',
    onSearch: function () {
        getDataMenu('1');
    }
});

var gvCategoria = new DataList('#gvCategoria', {
    typeview: 'checklist',
    actionbar: '#articulos-actionbar',
    onSearch: function () {
        ListarCategorias(gvCategoria.currentPage());
    }
});

var gvPacks = new DataList('#gvPacks', {
    actionbar: '#articulos-actionbar',
    onSearch: function () {
        ListarPacks('#gvPacks', gvPacks.currentPage());
    }
});

var gvPacksAsignacion = new DataList('#gvPacksAsignacion', {
    actionbar: '#articulos-actionbar',
    onSearch: function () {
        ListarPacks('#gvPacksAsignacion', gvPacksAsignacion.currentPage());
    },
    oneItemClick: function (event) {
        var container = gvPacksAsignacion.getContainer();

        if (container.hasClass('custom')) {
            var elem = event.target;
            var parent = getParentsUntil(elem, '#gvPacksAsignacion', '.dato');
            
            if (elem.nodeName.toLowerCase() === 'li') {        
                $(elem).siblings().removeClass('subitem-selected');
                $(elem).toggleClass('subitem-selected');
                
                if ($(elem).hasClass('subitem-selected'))
                    $(parent).addClass('selected');
                else
                    $(parent).removeClass('selected');
            }
            else {
                $(parent).toggleClass('selected');

                if ($(parent).hasClass('select-in-details')) {
                    var itemsLi = $(parent).find('li')
                    var subLi = itemsLi[0];

                    itemsLi.removeClass('subitem-selected');
                    if ($(parent).hasClass('selected'))
                        $(subLi).addClass('subitem-selected');
                    else
                        $(subLi).removeClass('subitem-selected');
                };
            };
        };
    }
});

var datagrid = new DataList('#gvDatos', {
    onSearch: function () {
        BuscarDatos(datagrid.currentPage());
    }
});

var pnlRegArticulo = $('#pnlRegArticulo');
var panelListado = $('#pnlListado');
var hdIdPack = $('#hdIdPack');
var lblFechaCompleta = $('#lblFechaCompleta');
var lblFechaCorta = $('#lblFechaCorta');
var btnChooseReceta = $('#btnChooseReceta');
var mnuTipoReceta = $('#mnuTipoReceta');
var btnAddInsumo = $('#btnAddInsumo');
var btnNuevo = $('#btnNuevo');
var btnSearchInsumo = $('#btnSearchInsumo');
var hrowMain = $('#hrowMain');
var hrowSearchInsumo = $('#hrowSearchInsumo');
var btnHideSearchInsumo = $('#btnHideSearchInsumo');
var btnBackToArticles = $('#btnBackToArticles');
var btnShowSubOpciones = $('#btnShowSubOpciones');
var btnAplicarArticulo = $('#btnAplicarArticulo');
var btnAplicarGrupo = $('#btnAplicarGrupo');
var chkTieneReceta = $('#chkTieneReceta');
var helperReceta = $('#helperReceta');
var chkEsAgregado = $('#chkEsAgregado');
var helperAgregado = $('#helperAgregado');
var btnShowCalendar = $('#btnShowCalendar');
var pnlShowCalendar = $('#pnlShowCalendar');
var pnlSubMenu = $('#pnlSubMenu');
var pnlViewAllArticles = $('#pnlViewAllArticles');

var fila_Receta = 0;

function Registrar () {

    var data = new FormData();
    var input_data = $('#pnlForm :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');
    data.append('archivo', fileValue);

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/productos/productos-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        contentType:false,
        processData:false,
        success: function (data) {
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

function LimpiarPacks () {
    $('#txtNombreGrupo').val('');
    $('#ddlMoneda')[0].selectedIndex = 0;
    $('#txtPrecioVigente').val('0.00');
}

function LimpiarCategoria () {
    $('#hdIdCategoria').val('0');
    $('#txtNombreCategoria').val('').focus();
}

function LimpiarArticulo () {
    $('#hdIdArticulo').val('0');
    $('#txtPrecioVenta').val(0);
    $('#txtPrecioCompra').val(0);

    $('#txtNombreProducto').val('').focus();
}

function addValidFormCategoria () {
    $('#txtNombreCategoria').rules('add', {
        required: true,
        maxlength: 150,
        remote: {
            url:  'services/categorias/check-nombre-categoria_articulo.php',
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

function addValidFormArticulo () {
    $('#txtNombre').rules('add', {
        required: true,
        maxlength: 150,
        remote: {
            url:  'services/productos/check-nombre.php',
            type: 'POST',
            data: {
                idempresa: function() {
                    return $('#hdIdEmpresa').val();
                },
                idcentro: function() {
                    return $('#hdIdCentro').val();
                },
                idregistro: function() {
                    return $('#hdIdArticulo').val();
                }
            }
        }
    });
}

function checkAllTable (selectorgrid, flag) {
    //var selectorgrid = $('#hdModeMenuEdit').val() == 'EDIT' ? '#gvArticuloMenu' : '#gvArticulo';
    var rows = document.querySelectorAll(selectorgrid);

    if (rows != null) {
        [].forEach.call(rows, function(el){
            var _checkbox = el.getElementsByClassName('filled-in');

            if (selectorgrid == '#tableSeccion tbody tr') {
                var inputSeccion = el.getElementsByClassName('seccion');

                if (flag === true)
                    inputSeccion[0].parentNode.classList.remove('is-disabled');
                else
                    inputSeccion[0].parentNode.classList.add('is-disabled');

                habilitarControl(inputSeccion[0], flag);
            }
            else {
                var inputStock = el.getElementsByClassName('stock');
                var inputPrecio = el.getElementsByClassName('precio');

                if (flag === true) {
                    inputStock[0].parentNode.classList.remove('is-disabled');
                    inputPrecio[0].parentNode.classList.remove('is-disabled');
                }
                else {
                    inputStock[0].parentNode.classList.add('is-disabled');
                    inputPrecio[0].parentNode.classList.add('is-disabled');
                };
                
                habilitarControl([inputStock[0], inputPrecio[0]], flag);
            };

            _checkbox[0].checked = flag;
            // _checkbox[0].parentNode.MaterialCheckbox.checkToggleState();
        });

        if (flag) {
            $(rows).addClass('selected is-selected');
            
            if (selectorgrid != '#tableSeccion tbody tr') {
                $('#btnSelectAll').addClass('hide');
                $('#btnUnSelectAll').removeClass('hide');
            };
        }
        else {
            $(rows).removeClass('selected is-selected');

            if (selectorgrid != '#tableSeccion tbody tr') {
                $('#btnSelectAll').removeClass('hide');
                $('#btnUnSelectAll').addClass('hide');
            };
        };
    };
}

function removeSelectionInMenu () {
    var gridview, selectorgrid = '';

    if ($('#hdModeMenuEdit').val() == 'EDIT') {
        gridview = gvArticuloMenu;
        selectorgrid = '#gvArticuloMenu';
    }
    else {
        gridview = gvArticulo;
        selectorgrid = '#gvArticulo';
    };

    if ($('#hdAsignacionMenu').val() == 'true'){
        gridview.showAppBar(false, 'edit');
    }
    else {
        gridview.removeSelection();
    };

    checkAllTable(selectorgrid + ' tbody tr', false);
}



function EliminarAsignados () {
    var data = new FormData();
    var tipocarta = $('#hdTipoCarta').val();
    var selectordata = '#gvArticuloMenu .table-responsive-vertical :input';

    var input_data = $(selectordata).serializeArray();

    data.append('btnEliminarAsignados', 'btnEliminarAsignados');
    data.append('hdTipoCarta', tipocarta);

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        dataType: 'json',
        data: data,
        contentType:false,
        processData:false,
        success: function(data){
            createSnackbar(data.titulomsje);
            $('#btnUnSelectAll').trigger('click');
            
            if ($('#hdTipoCarta').val() == '00')
                ListarArticulos_Carta('1');
            else
                showMenuWhenView();
        },
        error: function(data){
            console.log(data);
        }
    });
}

function buildRowReceta (idreceta, idunidadmedida, idinsumo, nombreInsumo, unidadmedida, costoinsumo, cantidad, nroporciones, avgxporcion, costoreceta) {
    var strhtml = '';
    
    strhtml = '<tr>';
    strhtml += '<td class="nombreInsumo">' + nombreInsumo;
    strhtml += '<input type="hidden" name="receta[' + fila_Receta + '][hdIdreceta]" id="hdIdreceta' + fila_Receta + '" value="' + fila_Receta + '" />';
    strhtml += '<input type="hidden" name="receta[' + fila_Receta + '][hdIdinsumo]" id="hdIdinsumo' + fila_Receta + '" value="' + idinsumo + '" />';
    strhtml += '<input type="hidden" name="receta[' + fila_Receta + '][hdIdunidadmedida]" id="hdIdunidadmedida' + fila_Receta + '" value="' + idunidadmedida + '" />';

    strhtml += '<input type="hidden" class="hdCostoInsumo" name="receta[' + fila_Receta + '][hdCostoInsumo]" id="hdCostoInsumo' + fila_Receta + '" value="' + costoinsumo + '" />';

    strhtml += '<input type="hidden" class="hdCostoReceta" name="receta[' + fila_Receta + '][hdCostoReceta]" id="hdCostoReceta' + fila_Receta + '" value="' + Number(costoreceta).toFixed(3) + '" />';

    strhtml += '<input class="avgxporcion" type="hidden" name="receta[' + fila_Receta + '][txtPromedioPorcion]" id="txtPromedioPorcion' + fila_Receta + '" value="' + Number(avgxporcion).toFixed(3) + '">';
    strhtml += '</td>';
    strhtml += '<td class="unidadmedida">' + unidadmedida + '</td>';
    
    strhtml += '<td><div class="mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right cantidad" type="text" name="receta[' + fila_Receta + '][txtCantidad]" id="txtCantidad' + fila_Receta + '" value="' + Number(cantidad).toFixed(3) + '"><label class="mdl-textfield__label" for="txtCantidad' + fila_Receta + '"></label></div></td>';

    // strhtml += '<td class="nroporciones"><div class="mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right" type="text" name="receta[' + fila_Receta + '][txtNroPorcion]" id="txtNroPorcion' + fila_Receta + '" value="' + nroporciones + '"><label class="mdl-textfield__label" for="txtNroPorcion' + fila_Receta + '"></label></div></td>';

    // strhtml += '<td><div class="mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right avgxporcion" type="text" name="receta[' + fila_Receta + '][txtPromedioPorcion]" id="txtPromedioPorcion' + fila_Receta + '" value="' + Number(avgxporcion).toFixed(3) + '"><label class="mdl-textfield__label" for="txtPromedioPorcion' + fila_Receta + '"></label></div></td>';
    strhtml += '<td class="text-right cell-avgxporcion">' + Number(avgxporcion).toFixed(3) + '</td>';

    // var _costoreceta_eval = avgxporcion * costoinsumo;

    strhtml += '<td class="text-right costoreceta">' + Number(costoreceta).toFixed(3) + '</td>';

    // strhtml += '<td><div class="mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right costoreceta" type="text" name="receta[' + fila_Receta + '][txtCostoReceta]" id="txtCostoReceta' + fila_Receta + '" value="' + Number(_costoreceta_eval).toFixed(2) + '"><label class="mdl-textfield__label" for="txtCostoReceta' + fila_Receta + '"></label></div></td>';

    strhtml += '<td class="text-center"><a class="padding5 mdl-button mdl-button--icon center-block tooltipped" data-placement="left" data-toggle="tooltip" title="Eliminar" href="#" data-action="delete"><i class="material-icons">&#xE872;</i></a></td>';

    strhtml += '</tr>';

    return strhtml;
}

function ListarReceta (idproducto, tiporeceta) {
    $.ajax({
        type: 'GET',
        url: 'services/recetas/recetas-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idproducto: idproducto,
            tipomenudia: tiporeceta
        },
        success: function (data) {
            var strhtml = '';
            var countdata = data.length;
            var totalcostoreceta = 0;
            
            fila_Receta = 0;

            if (countdata > 0){
                while(fila_Receta < countdata){
                    strhtml += buildRowReceta(data[fila_Receta].td_idreceta, data[fila_Receta].tm_idunidadmedida, data[fila_Receta].tm_idinsumo, data[fila_Receta].tm_nombre, data[fila_Receta].UnidadMedida, data[fila_Receta].tm_costoPromedio, data[fila_Receta].td_cantidad, data[fila_Receta].td_nroporciones, data[fila_Receta].td_avgxporcion, data[fila_Receta].td_costoreceta);

                    totalcostoreceta += Number(data[fila_Receta].td_costoreceta);

                    ++fila_Receta;
                };
            };

            $('#tableReceta tbody').html(strhtml);
            registerScriptMDL('#tableReceta .mdl-js-textfield');

            $('.tooltipped').tooltip({delay: 50});

            // var _nroporciones = $('#txtNroPorciones').val();
            // var costo_por_porcion = totalcostoreceta / _nroporciones;

            $('#lblTotalCostoReceta').text('S/. ' + totalcostoreceta.toFixed(2));
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function addInsumoToReceta () {
    /*var i = 0;
    var strhtml = '';
    var tagItems = pnlInsumo.getTagElements();
    var countTags = tagItems.length;

    if (countTags > 0) {
        while (i < countTags){
            var tagItem = tagItems[i];
            var idinsumo = tagItem.getAttribute('data-idinsumo');
            var idunidadmedida = tagItem.getAttribute('data-idunidadmedida');
            var idpresentacion = tagItem.getAttribute('data-idpresentacion');
            var costoinsumo = tagItem.getAttribute('data-costoinsumo');
            var tagContent = tagItem.getElementsByClassName('taggle_text')[0];
            var contenidoTag = tagContent.innerHTML;
            var arrContent = contenidoTag.toString().split('|');

            var nombreInsumo = arrContent[0];
            var simboloUnidad = arrContent[1];

            strhtml += buildRowReceta(0, idunidadmedida, idinsumo, nombreInsumo, simboloUnidad, costoinsumo, 0, 0, 0, 0);
            ++i;
            fila_Receta += i;
        };

        $('#tableReceta tbody').append(strhtml);
        registerScriptMDL('#tableReceta .mdl-js-textfield');
        pnlInsumo.removeAll();
    };*/
}

function insumoTag_setValues (owner, parentItem, subItem) {
    /*var descripcion = parentItem.getElementsByClassName('descripcion')[0];

    _idinsumo = parentItem.getAttribute('data-idmodel');
    UnidadMedida.id = subItem.getAttribute('data-idunidadmedida');
    UnidadMedida.simbolo = subItem.getAttribute('data-simbolo');
    UnidadMedida.idpresentacion = subItem.getAttribute('data-idpresentacion');

    pnlInsumo.add(descripcion.textContent + ' | ' + subItem.textContent);
    owner.addClass('hide');*/
}

function ListarInsumos (data) {
    var gridview = hrowSearchInsumo.find('.gridview');
    var element_collection = gridview.find('.collection');
    var element_empty = gridview.find('.empty-temp');
    
    var i = 0;
    var strhtml = '';
    // var count_presentaciones = 0;

    // var groups = _.groupBy(result, function(value){
    //     return value.tm_idinsumo + '#' + value.nombre_insumo;
    // });

    // var data = _.map(groups, function(group){
    //     return {
    //         tm_idinsumo: group[0].tm_idinsumo,
    //         nombre_insumo: group[0].nombre_insumo,
    //         list_presentaciones: group
    //     }
    // });

    var countdata = data.length;

    if (countdata > 0) {
        while (i < countdata){
            var iditem = data[i].tm_idinsumo;
            // var presentaciones = data[i].list_presentaciones;
            // var j = 0;

            // if (presentaciones.length == 1){
            //     if (presentaciones[0].presentacion.trim().length == 0){
            //         count_presentaciones = 0;
            //     }
            //     else {
            //         count_presentaciones = presentaciones.length;
            //     };
            // }
            // else {
            //     count_presentaciones = presentaciones.length;
            // };

            strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '">';
            strhtml += '<i class="icon-expand material-icons circle white-text">&#xE8A0;</i>';
            strhtml += '<span class="title descripcion grey-text text-darken-4">' + data[i].nombre_insumo + '</span>';
            
            strhtml += '<div>';
            // if (count_presentaciones > 0){
            //     while (j < count_presentaciones){
            strhtml +=  '<span data-idunidadmedida="' + data[i].tm_idunidadmedida + '" data-costoinsumo="' + data[i].costo_insumo + '" class="badges_subitem right padding5 grey lighten-2 grey-text text-darken-4 margin5">' + data[i].simbolo_unidad + '</span>';
            //         ++j;
            //     };
            // };
            strhtml += '</div>';
            strhtml += '</li>';

            ++i;
        };

        // var expand_items = element_collection.getElementsByClassName('icon-expand');
        // i = 0;
        // while(i < countdata){
        //     expand_items[i].addEventListener('click', function (event) {
        //         event.preventDefault();
        //         alert('test');
        //         return false;
        //     });
        //     ++i;
        // };

        // var main_items = element_collection.getElementsByTagName('LI');
        // i = 0;
        // while(i < countdata){
        //     var main_item = main_items[i];
        //     var badgesUM = main_item.getElementsByClassName('badges_subitem');

        //     var countBadgesUM = badgesUM.length;

        //     var j = 0;

        //     while(j < countBadgesUM){
        //         badgesUM[j].addEventListener('click', function (event) {
        //             event.preventDefault();
        //             event.stopPropagation();

        //             var parent_item = this.parentNode.parentNode;

        //             insumoTag_setValues(gridview, parent_item, this);
        //             return false;
        //         });
        //         ++j;
        //     };

        //     main_item.addEventListener('click', function (event) {
        //         event.preventDefault();

        //         var badge_subitem = this.getElementsByClassName('badges_subitem')[0];

        //         insumoTag_setValues(gridview, this, badge_subitem);
        //     });

        //     ++i;
        // };

        element_collection.html(strhtml);

        element_collection.removeClass('hide');
        element_empty.addClass('hide');
    }
    else {
        element_collection.addClass('hide');
        element_empty.removeClass('hide');
    };
}

// function packsEvents_Asignacion () {


    // $('#gvPacks.custom').on('click', '.dato.select-in-item', function(event) {
    //     event.preventDefault();

    //     this.toggleClass('selected');
    // });

    // $('#gvPacks.custom').on('click', '.dato.select-in-details li', function(event) {
    //     event.preventDefault();

    //     var parent = this.parentNode.parentNode.parentNode;
        
    //     $(this).siblings().removeClass('subitem-selected');
    //     this.toggleClass('subitem-selected');
        
    //     if (this.hasClass('subitem-selected'))
    //         parent.addClass('selected');
    //     else
    //         parent.removeClass('selected');
    // });
// }

// function eventButtonBack (evento) {
//     //$('.back-button').off();

//     if (evento == 'asignacion') {
//         $('.back-button').on('click touchend', function(event) {
//             event.preventDefault();

//             var selector = '#gvPacks';

//             $(selector + ' .dato.selected').removeClass('selected');
//             $(selector + ' input[type="checkbox"]').removeAttr('checked');

//             setSelecting(selector, 'false', 'none');

//             $('#articulos-actionbar .show-in-select').removeClass('hide');
//             $('#btnAsignarGrupoProducto, #btnSearchPacks').addClass('hide');
            
//             fadeOut($('#gvPacks'), 400, function() {
//                 fadeIn($('#gvArticulo'), 400, function() {
//                     eventButtonBack('default');
//                 });
//             });
//         });
//     }
//     else {
//         defaultBackEvent();
//     };
// }

function getDataMenu (pagina) {
    var menu_viewmode = $('#hdModeMenuView').val();
    if (menu_viewmode == 'VIEW-LIST-MENU')
        ListarArticulos_Menu('1', 0, pagina);
    else if (menu_viewmode == 'VIEW-LIST-PACK')
        ListarPacks_viewlist(pagina);
    else if (menu_viewmode == 'VIEW-LIST-CARTA')
        ListarCartas('lista', pagina);
}

function getDataByReference (referencia) {
    $('#hdAsignacionMenu').val('false');

    if (referencia == '#gvMenu' || referencia == '#gvCarta') {
        var menu_viewmode = '';

        $('#hdModeMenuEdit').val('EDIT');
        btnNuevo.addClass('hide');

        $('#pnlMenuCarta').removeClass('hide');

        $('#btnProgram').addClass('show-in-select').removeClass('hide');
        $('#btnGoToPacks').removeClass('show-in-select').addClass('hide');

        if (referencia == '#gvMenu') {
            $('#hdTipoCarta').val('03');
            
            $('#lblTitulo, #btnNuevaCarta').addClass('hide');
            $('.view-button, #btnShowCalendar, #optIndividual').removeClass('hide');
            if ($('.view-button[data-action="view-list"]').hasClass('active')) {
                $('#titleMenuCarta, #btnShowSubOpciones').addClass('hide');
                //paginaDetalle = 1;
                //ListarArticulos_Menu('1', 0, '1');
                menu_viewmode = 'VIEW-LIST-MENU';
            }
            else {
                $('#titleMenuCarta, #btnShowSubOpciones').removeClass('hide');
                //paginaPack_lista = 1;
                //ListarPacks_viewlist('1');
                menu_viewmode = 'VIEW-LIST-PACK';
            };
        }
        else if (referencia == '#gvCarta') {
            $('#hdTipoCarta').val('00');

            $('.view-button, #btnShowCalendar, #optIndividual').addClass('hide');
            $('#lblTitulo, #titleMenuCarta, #btnShowSubOpciones, #btnNuevaCarta').removeClass('hide');
            //paginaCarta_lista = 1;
            // ListarCartas('lista', '1');
            menu_viewmode = 'VIEW-LIST-CARTA';
        };

        $('#hdModeMenuView').val(menu_viewmode);
        getDataMenu('1');
    }
    else {
        btnNuevo.removeClass('hide');
        $('#btnNuevaCarta').addClass('hide');

        if (referencia == '#gvCategoria'){
            $('#gvArticuloPack').addClass('hide');
            $('#btnGoToPacks').removeClass('show-in-select').addClass('hide');
            // $('#btnAsignarGrupoProducto, #btnSearchPacks').addClass('hide');
            $('#btnProgram').removeClass('show-in-select').addClass('hide');
            habilitarLink('#btnMoreSites', true);
            
            if ($(referencia + ' .dato').length == 0)
                ListarCategorias('1');
        }
        else if ((referencia == '#pnlListado') || (referencia == '#gvArticulo')){
            $('#hdModeMenuEdit').val('ART');
            $('#hdAsignacionMenu').val('false');

            // $('#gvArticuloPack').removeClass('hide');
            // $('#gvArticulo').parent().removeClass('hide mdl-cell--6-col').addClass('mdl-cell--12-col');
            // $('#gvPacks').parent().addClass('mdl-cell--6-col').removeClass('mdl-cell--12-col hide');
            $('#btnGoToPacks').addClass('show-in-select').removeClass('hide');
            // $('#btnAsignarGrupoProducto, #btnSearchPacks').addClass('hide');
            $('#btnProgram').removeClass('show-in-select').addClass('hide');

            habilitarLink('#btnMoreSites', true);

            if ($(referencia + ' .dato').length == 0)
                ListarArticulos('1');
        }
        else if (referencia == '#gvPacks'){
            // $('#gvArticuloPack').removeClass('hide');
            // $('#gvArticulo').parent().addClass('mdl-cell--6-col').removeClass('mdl-cell--12-col hide');
            // $('#gvPacks').parent().removeClass('mdl-cell--6-col hide').addClass('mdl-cell--12-col');

            $('#btnProgram').removeClass('show-in-select').addClass('hide');
            habilitarLink('#btnMoreSites', true);
            $('#btnGoToPacks').removeClass('show-in-select').addClass('hide');
            
            if ($(referencia + ' .dato').length == 0)
                ListarPacks('#gvPacks', '1');
        };
    };

    //selectorSelection = referencia;
}

// function CancelarNuevaCategoria (item) {
//     var lista = $('#gvCategoria li:not([data-idmodel="0"])');
//     enableListCategoria(lista, true);

//     item.remove();
//     btnNuevo.removeClass('hide');
// }

// function NuevaCategoria () {
//     var contentgrid = $('#gvCategoria .gridview-content');
//     var lista = contentgrid.find('li');
//     var i = lista.length;
//     var strhtml = createItemCategoria('#gvCategoria',  '0', '', i);
    
//     enableListCategoria(lista, false);
    
//     contentgrid.append(strhtml);
    
//     registerScriptMDL('#gvCategoria .mdl-input-js');
//     contentgrid.find('.dato[data-idmodel="0"] input[type="text"]').focus();
// }

function enableListCategoria (lista, flag) {
    [].forEach.call(lista, function (el) {
        //el.onclick = function() { return false; };​
        if (flag)
            el.removeAttribute('onclick');
        else
            el.setAttribute('onclick', 'return false;');
    });
}

function Nuevo () {
    GoToEdit("0");
}

function FiltrarPorIdItem (iditem) {
    $('#hdIdCategoria').val(iditem);
    navigateSubSite('#gvArticulo', 'Artículos');
    //paginaArticulo = 1;
    ListarArticulos('1');
}

function AsignacionGrupoArticulo () {
    var selectorSelected = '#gvPacksAsignacion .dato.selected';
    indexList = 0;
    $(selectorSelected + ' .progress').removeClass('hide');

    elemsSelected = document.querySelectorAll(selectorSelected);
    AsignacionGrupoArticulo_transferencia(elemsSelected[0]);
}

function AsignacionGrupoArticulo_transferencia (item) {
    var data = new FormData();
    var idseccion = '0';
    var itemsArticulos = document.querySelectorAll('#gvArticulo .dato.selected');
    var progressBar = item.querySelector('.progress .determinate');
    var idgrupo = item.getAttribute('data-idmodel');
    var listaProductos = [].map.call(itemsArticulos, function(obj) {
        return obj.getAttribute('data-idmodel');
    }).join(',');

    if (item.classList.contains('select-in-details')){
        var selectedSection = item.querySelector('.list-options li.subitem-selected');
        idseccion = selectedSection.getAttribute('data-idseccion');
    };

    progressBar.classList.add('teal', 'lighten-1');
    
    data.append('btnAsignarGrupoProducto', 'btnAsignarGrupoProducto');
    data.append('listaProductos', listaProductos);
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdPack', idgrupo);
    data.append('hdIdSeccion', idseccion);

    $.ajax({
        url: 'services/grupos/grupos-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            ++indexList;
            progressError = false;

            progressBar.classList.remove('teal', 'lighten-1');
            progressBar.classList.add('light-green');
            progressBar.style.width = '100%';

            if (intervalProgress.isRunning())
                intervalProgress.stop();

            if (indexList <= elemsSelected.length - 1)
                AsignacionGrupoArticulo_transferencia(elemsSelected[indexList]);
            else {
                completado = true;

                createSnackbar(data.titulomsje);
                
                if (data.rpta != '0'){
                    $('#btnSearch, #btnOpciones').removeClass('hide');
                    // $('#articulos-actionbar .show-in-select').removeClass('hide');
                    // $('#btnAsignarGrupoProducto, #btnSearchPacks').addClass('hide');
                    
                    $('#gvPacksAsignacion .progress').addClass('hide');
                    $('#gvPacksAsignacion .subitem-selected').removeClass('subitem-selected');
                    
                    //eventButtonBack('default');
                    $('#btnRecursosBack').off('click', listenerDefaultBackButton);
                    $('#btnRecursosBack').on('click', listenerAsignaPackInBack);
                    
                    gvPacksAsignacion.removeSelection();
                    gvArticulo.removeSelection();
                    
                    $('#gvPacksAsignacion').removeClass('custom');
                    // $('#gvArticulo').removeClass('hide');
                    
                    getDataByReference('#gvArticulo');
                };
            };
        },
        beforeSend: function () {
            completado = false;
            intervalProgress.start();
        },
        complete: function () {
            progress = 0;
            
            if (progressError){
                if (completado == false){
                    setTimeout(function () {
                        if (intervalProgress.isRunning())
                            intervalProgress.stop();
                        progressBar.style.width = '100%';
                        AsignacionGrupoArticulo_transferencia(elemsSelected[indexList]);
                    }, 10000);
                };
            };
        },
        error:function (data){
            progress = 0;
            progressBar.classList.remove('teal', 'lighten-1');
            progressBar.classList.add('red');
            progressError = true;
            console.log(data);
        }
    });
}

// function GuardarCategoria (item, mode, endCallback) {
//     var data = new FormData();
    
//     //if ($('#form1').valid()){
//         //var input_data = $('#modalRegCategoria').serializeArray();

//     var idcategoria = item.getAttribute('data-idmodel');
//     var nombre = item.find('.categoria').val();

//     data.append('btnAplicarCategoria', 'btnAplicarCategoria');
//     data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
//     data.append('hdIdCentro', $('#hdIdCentro').val());
//     data.append('hdIdCategoria', idcategoria);
//     data.append('txtNombreCategoria', nombre);

//     $.ajax({
//         type: "POST",
//         url: 'services/categorias/categoria-post.php',
//         cache: false,
//         dataType: 'json',
//         data: data,
//         contentType:false,
//         processData: false,
//         success: function(data){
//             var titulomsje = '';
//             var endqueue = false;

//             if (data.rpta == '0'){
//                 endqueue = true;
//                 titulomsje = 'No se pueden guardar los cambios';
//             }
//             else {                
//                 if (mode == 'multiple'){
//                     ++indexList;
                    
//                     if (indexList <= elemsSelected.length - 1){
//                         GuardarCategoria(elemsSelected[indexList], mode, endCallback);
//                     }
//                     else {
//                         endqueue = true;
//                         titulomsje = data.titulomsje;
//                     };
//                 }
//                 else if (mode == 'single') {
//                     endqueue = true;
//                     titulomsje = data.titulomsje;
//                 };
//             };
            
//             if (endqueue) {
//                 createSnackbar(titulomsje);
//                 if (typeof endCallback !== 'undefined')
//                     endCallback();
//             };
//         },
//         error: function (data) {
//             console.log(data);
//         }
//     });
//     //};
// }

// function AplicarCambiosCategoria () {
//     var selectorSelected = '#gvCategoria .dato.selected';
//     indexList = 0;
//     $(selectorSelected + ' .progress').removeClass('hide');

//     elemsSelected = document.querySelectorAll(selectorSelected);

//     GuardarCategoria(elemsSelected[0], 'multiple', function () {
//         ListarCategorias('1');
//     });
// }

function AsignarArticulosMenu () {
    var data = new FormData();
    var editmode = $('#hdModeMenuEdit').val();
    var tipocarta = $('#hdTipoCarta').val();
    var idcarta = '0';
    var selectordata = editmode == 'NEW' ? '#gvArticulo' : '#gvArticuloMenu';

    selectordata += ' .table-responsive-vertical :input';
    
    if (tipocarta == '00')
        idcarta = $('#optSubMenu').find('.active').attr('data-idmodel');

    var input_data = $(selectordata).serializeArray();

    data.append('btnAsignarArticulos', 'btnAsignarArticulos');
    data.append('hdTipoCarta', tipocarta);
    data.append('hdEditMode', editmode);
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdCarta', idcarta);
    data.append('hdFecha', $('#hdFecha').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        dataType: 'json',
        data: data,
        contentType:false,
        processData:false,
        success: function(data){
            createSnackbar(data.titulomsje);
            $('#btnUnSelectAll').trigger('click');
            
            if ($('#hdTipoCarta').val() == '00')
                ListarArticulos_Carta('1');
            else
                showMenuWhenView();

            ListarArticulos('1');
        },
        error: function(data){
            console.log(data);
        }
    });
}
// function CalcularAvgCantidad () {
//     var cantidad = ($('#txtCantidad').val().trim().length == 0 ? 1 : Number($('#txtCantidad').val()));
//     var nroporciones = ($('#txtNroPorciones').val().trim().length == 0 ? 1 : Number($('#txtNroPorciones').val()));
//     var avgxporcion = 0;

//     avgxporcion = cantidad / nroporciones;

//     $('#txtAvgPorPorcion').val(avgxporcion.toFixed(0));
// }

// function GoToEditCategoria (idItem) {
//     var selectorModal = '#modalRegCategoria';

//     precargaExp(selectorModal, true);
    
    // resetForm(selectorModal);

//     openCustomModal(selectorModal, function () {
//         if (idItem == '0'){
//             precargaExp(selectorModal, false);
//             $('#txtNombreCategoria').focus();
//         }
//         else {
// /             $.ajax({
//                 url: 'services/categorias/categoria-search.php',
//                 type: 'GET',
//                 dataType: 'json',
//                 data: {
//                     tipobusqueda: '2',
//                     id: idItem
//                 },
//                 success: function (data) {
//                     if (data.length > 0){
//                         $('#hdIdCategoria').value = data[0].tm_idcategoria;
//                         $('#txtNombreCategoria').val(data[0].tm_nombre).focus();
//                     };

//                     precargaExp(selectorModal, false);
//                 },
//                 error: function  (data) {
//                     console.log(data);
//                 }
//             });
//         };
//     });
// }

function GetInfoPeriod (idproducto, tipomenu) {
    $.ajax({
        type: "GET",
        url: 'services/productos/productos-getperiods.php',
        cache: false,
        dataType: 'json',
        data: {
            'idempresa': $('#hdIdEmpresa').val(),
            'idcentro': $('#hdIdCentro').val(),
            'idproducto': idproducto,
            'tipomenu': tipomenu
        },
        success: function (data) {
            if (data.length > 0){
                if (tipomenu == '03')
                    $('#txtTiempoPreparacionMenu').val(data[0].td_tiempo);
                else
                    $('#txtTiempoPreparacionCarta').val(data[0].td_tiempo);
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GetInfoPrice (idproducto, tipomenu) {
    $.ajax({
        type: "GET",
        url: 'services/productos/productos-getprices.php',
        cache: false,
        dataType: 'json',
        data: {
            'idempresa': $('#hdIdEmpresa').val(),
            'idcentro': $('#hdIdCentro').val(),
            'idproducto': idproducto,
            'tipomenu': tipomenu
        },
        success: function (data) {
            if (data.length > 0){
                if (tipomenu == '03')
                    $('#txtPrecioArticuloMenu').val(data[0].td_precio);
                else
                    $('#txtPrecioArticuloCarta').val(data[0].td_precio);
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GoToEditArticulo (idItem) {

    var selectorPnlRegArticulo = '#pnlRegArticulo';

    $('#hdIdArticulo').val('0');
    hdFoto.value = 'no-set';

    precargaExp(selectorPnlRegArticulo, true);

    $('#tableReceta tbody').html('');
    
    //$('#pnlTimePrepMenu').removeClass('hide');
    //$('#pnlTimePrepCarta').addClass('hide');

    //$('#txtTiempoPreparacionMenu').val('0.00');
    //$('#txtTiempoPreparacionCarta').val('0.00');

    resetFoto('new');


    // resetForm(selectorPnlRegArticulo);
    
    // helperReceta.text('NO');
    // helperAgregado.text('NO');

    panelListado.addClass('hide');
    pnlRegArticulo.removeClass('hide');

    btnNuevo.addClass('hide');
    LimpiarArticulo();

    ///$('#chkTieneReceta')[0].checked = true;

    if (idItem == '0'){
        ListarCategorias_Combo('0');
        ListarAreasTrabajo('0');
        ///ListarUnidadMedida_Combo('#ddlUnidadMedidaReg', '0');
        
        precargaExp(selectorPnlRegArticulo, false);
    }
    else {
        $.ajax({
            type: "GET",
            url: 'services/productos/productos-getdetails.php',
            cache: false,
            dataType: 'json',
            data: 'id=' + idItem,
            success: function (data) {
                var countdata = data.length;
                var foto_edicion = '';
                
                if (countdata > 0){
                    var idproducto = data[0].tm_idproducto;
                    var foto_original = data[0].tm_foto;
                    var tienereceta = data[0].tm_tienereceta == 1 ? true : false;
                    var esagregado = data[0].tm_esagregado == 1 ? true : false;
                    
                    if (foto_original != 'no-set')
                        foto_edicion = foto_original.replace("_o", "_s255");
                    
                    $('#hdIdArticulo').val(idproducto);

                    // $('#ddlCategoriaReg').changeMaterialSelect(data[0].tm_idcategoria);
                    // $('#ddlAreaDespacho').changeMaterialSelect(data[0].tm_idareadespacho);

                    $('#txtPrecioArticulo').val(data[0].tm_precioVenta);
                    $('#txtNroPorciones').val(data[0].tm_nroporciones);
                    // $('#ddlUnidadMedidaReg').val(data[0].tm_idunidadmedida);
                    
                    $('#txtNombreArticulo').val(data[0].tm_nombre).focus();
                    Materialize.updateTextFields();
                    
                    ListarCategorias_Combo(data[0].tm_idcategoria);

                    if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                    imgFoto.setAttribute('data-src', foto_edicion);
                    hdFoto.value = foto_original;

                    if (tienereceta) {
                        ListarReceta(idproducto, '03');
                        
                        GetInfoPeriod(idproducto, '03');
                        GetInfoPeriod(idproducto, '00');
                        
                        GetInfoPrice(idproducto, '03');
                        GetInfoPrice(idproducto, '00');
                    }
                    else {
                        counter_presentacion = 0;
                        ListarPresentaciones(idproducto);
                    };

                    MostrarSelectUnidadMedida(tienereceta);
                };
                
                precargaExp(selectorPnlRegArticulo, false);
                // $('#txtCodigo').focus();
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function GuardarArticulo () {
    precargaExp('#pnlRegArticulo', true);

    var tipomenudia = btnChooseReceta.attr('data-tiporeceta');
    var file = fileValue;
    var data = new FormData();
    var input_data = $('#pnlRegArticulo :input').serializeArray();

    data.append('btnAplicarArticulo', 'btnAplicarArticulo');
    data.append('TipoMenuDia', tipomenudia);
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('archivo', file);

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/productos/productos-post.php',
        cache: false,
        dataType: 'json',
        data: data,
        contentType:false,
        processData:false,
        success: function(data){
            precargaExp('#pnlRegArticulo', false);
            createSnackbar(data.titulomsje);
            
            if (Number(data.rpta) > 0){
                pnlRegArticulo.addClass('hide');
                panelListado.removeClass('hide');
                // $('#hdIdArticulo').val(data.rpta);
                ListarArticulos('1');
            };
        },
        error: function(data){
            console.log(data);
        }
    });
}

function GoToEditPack (idItem) {
    var selectorModal = '#modalRegPack';

    hdIdPack.val('0');
    precargaExp(selectorModal, true);
    // resetForm(selectorModal);
    LimpiarPacks();
    openModalCallBack(selectorModal, function () {
        ListarSeccionesPack(idItem);

        if (idItem == '0'){
            precargaExp(selectorModal, false);
            $('#txtNombreGrupo').focus();
        }
        else {
            $.ajax({
                url: 'services/grupos/grupos-search.php',
                cache: false,
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '4',
                    id: idItem
                },
                success: function(data) {
                    if (data.length > 0) {
                        hdIdPack.val(data[0].tm_idgrupoarticulo);
                        
                        $('#ddlMoneda').val(data[0].tm_idmoneda);
                        $('#txtPrecioVigente').val(data[0].td_precio);
                        $('#txtNombreGrupo').val(data[0].tm_nombre).focus();
                    };

                    precargaExp(selectorModal, false);
                },
                error: function(data){
                    console.log(data);
                }
            });
        };
    });
}

function GuardarGrupo () {
    var data = new FormData();

    //if ($('#form1').valid()){
        var input_data = $('#modalRegPack :input').serializeArray();

        data.append('btnAplicarGrupo', 'btnAplicarGrupo');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: 'services/grupos/grupos-post.php',
            cache: false,
            dataType: 'json',
            data: data,
            contentType:false,
            processData: false,
            success: function(data){
                createSnackbar(data.titulomsje);

                if (Number(data.rpta) > 0){
                    //removeValidFormGrupo();
                    closeCustomModal('#modalRegPack');
                    //paginaPack_grilla = 1;
                    ListarPacks('#gvPacks', '1');
                };
            },
            error: function(data){
                console.log(data);
            }
        });
    //};
}

function createItemCategoria (selectorgrid, iditem, nombre, i) {
    var strhtml = '';
    var btn_action_right = '';
    var btn_action_left = '';
    var str_selected = '';
    var str_checked = '';
    var str_check_disabled = '';
    var str_hide_title = '';
    var str_hide_input = '';

    if (iditem == '0') {
        btn_action_right += '<a data-action="cancel" class="option-edit margin20 padding5 mdl-button mdl-button--icon tooltipped place-top-right grey-text" href="#" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE5CD;</i></a>';

        str_selected = ' selected';
        str_checked = ' checked';
        str_check_disabled = ' disabled';
        str_hide_title = ' hide';
        str_hide_input = '';

        btn_action_left = '<a data-action="save-changes" class="option-edit margin20 padding5 mdl-button mdl-button--icon tooltipped place-top-left green-text" href="#" data-delay="50" data-position="bottom" data-tooltip="Guardar"><i class="material-icons">&#xE5CA;</i></a>';
    }
    else {
        btn_action_right += '<div class="grouped-buttons place-bottom-right padding5">';
        btn_action_right += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';
        btn_action_right += '<ul class="dropdown">';
        btn_action_right += '<li><a href="#" data-action="goto">Ver art&iacute;culos</a></li>';
        btn_action_right += '<li><a href="#" data-action="delete">Eliminar</a></li>';
        //btn_action_right += '<li><a href="#" data-action="stats">Ir a estad&iacute;sticas</a></li></ul>';
        btn_action_right += '</div>';

        str_selected = '';
        str_checked = '';
        str_check_disabled = '';
        str_hide_title = '';
        str_hide_input = ' hide';

        btn_action_left = '<label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkItem' + i + '"><input name="chkItem[]" type="checkbox" id="chkItem' + i + '" class="mdl-checkbox__input" value="' + iditem + '"><span class="mdl-checkbox__label"></span></label>';
    };

    strhtml = '<li data-idmodel="' + iditem + '" class="mini-collection-item avatar dato pos-rel grey lighten-5 padding-right60' + str_selected + '" data-baselement="' + selectorgrid + '">';
    
    //strhtml += '<label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkItem' + i + '"><input name="chkItem[]" type="checkbox" id="chkItem' + i + '" class="mdl-checkbox__input"' + str_checked + str_check_disabled + ' value="' + iditem + '"><span class="mdl-checkbox__label"></span></label>';

    strhtml += btn_action_left;

    strhtml += '<div class="circle">' + (nombre.length > 0 ? nombre[0] : '') + '</div>';
    strhtml += '<h5 class="title descripcion all-height v-align-middle no-margin' + str_hide_title + '">' + nombre + '</h5>';
    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding' + str_hide_input + '"><input class="mdl-textfield__input categoria" type="text" name="seccion[' + i + '][txtNombreCategoria]" id="txtNombreCategoria' + i + '" value="' + nombre + '"><label class="mdl-textfield__label" for="txtNombreCategoria' + i + '"></label></div>';

    strhtml += btn_action_right + '</li>';

    return strhtml;
}

function ListarCategorias (pagina) {
    var selectorgrid = '#gvCategoria';
    var selector = selectorgrid + ' .gridview-content';
    var criterio = '';
    
    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: 'services/categorias/categoria-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 1,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: criterio,
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            // var posmenu = '';
            // var iditem = '0';
            // var nombre = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idcategoria;
                    
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
                
                //paginaCategoria = paginaCategoria + 1;

                //$('#hdPageCategoria').val(paginaCategoria);
                gvCategoria.currentPage(gvCategoria.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                // $(selector + ' .grouped-buttons a.tooltipped').tooltip();
                registerScriptMDL('#gvCategoria .mdl-input-js');
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

function ListarCategorias_Combo (idcategora_default){    
    $.ajax({
        type: "GET",
        url: 'services/categorias/categoria-search.php',
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
                    var _selected = idcategora_default == data[i].tm_idcategoria ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcategoria + '">' + data[i].tm_nombre + '</option>';
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

function ListarAreasTrabajo (idarea_default) {
    $.ajax({
        type: "GET",
        url: 'services/areas/areas-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    var _selected = idarea_default == data[i].tp_idarea ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tp_idarea + '">' + data[i].tp_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay &aacute;reas de trabajo registradas.</option>';

            $('#ddlAreaDespacho').html(strhtml);
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
                strhtml = '<option value="0">No hay presentaciones registradas.</option>';

            $('#ddlPresentacion').html(strhtml);
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
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idunidadmedida + '">' + data[i].tm_nombre + '</option>';
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
                url: 'services/categorias/categoria-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idItem
                },
                success: function (data) {
                    if (data.length > 0){
                        $('#hdIdCategoria').val(data[0].tm_idcategoria);
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

function buildArticulos_edicion (pagina, data) {
    var strhtml = '';
    var countdata = data.length;

    if (countdata > 0) {
        var i = 0;

        while(i < countdata){
            //var imagen = data[i].tm_foto;
            strhtml += '<div class="demo-card-square mdl-card dato articulo mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--2-col-phone" data-idmodel="' + data[i].tm_idproducto + '">';
            strhtml += '<input name="chkItem[]" type="checkbox" class="hide" value="' + data[i].tm_idproducto + '" />';

            strhtml += '<div class="mdl-card__media pos-rel">';
            strhtml += '<i class="icon-select centered material-icons white-text circle">done</i>';
            
            if (data[i].tm_foto != 'no-set')
                strhtml += '<img src="' + data[i].tm_foto.replace('_o', '_s225') + '" width="100%" height="140px" border="0" alt="">';

            strhtml += '</div>';

            strhtml += '<div class="layer-select"></div>';

            strhtml += '<div class="mdl-card__title">';
            strhtml += '<div class="grouped-buttons mdl-grid mdl-grid--no-spacing full-size no-margin pos-rel">';
            strhtml += '<div class="mdl-cell mdl-cell--9-col mdl-cell--3-col-phone">';

            strhtml += '<h5 class="text-ellipsis" title="' + data[i].tm_nombre + '">' + data[i].tm_nombre + '</h5>';

            strhtml += '</div>';
            

            strhtml += '<div data-action="more" class="mdl-cell mdl-cell--3-col mdl-cell--1-col-phone"><a href="#" class="mdl-button mdl-button--icon right tooltipped" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a></div>';

            strhtml += '<ul class="dropdown">';
            strhtml += '<li><a href="#" data-action="edit">Editar</a></li>';
            strhtml += '<li><a href="#" data-action="delete">Eliminar</a></li>';
            // strhtml += '<li><a href="#" data-action="additem">Ver receta</a></li>';
            // strhtml += '<li><a href="#" data-action="stats">Ir a estad&iacute;sticas</a></li>';
            strhtml += '</ul>';

            strhtml += '</div>';

            strhtml += '</div>';

            strhtml += '</div>';

            ++i;
        };
    }
    else {
        if (pagina == '1')
            strhtml = '<h2>No se encontraron resultados.</h2>';
    };

    return strhtml;
}

function buildArticulos_asignacion (pagina, data) {
    var strhtml = '';
    var countdata = data.length;

    if (countdata > 0) {
        var i = 0;
        while(i < countdata){
            strhtml += '<tr>';
            
            // strhtml += '<td><label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkDetalle' + i + '"><input name="mc_articulo[' + i + '][chkDetalle]" type="checkbox" id="chkDetalle' + i + '" class="mdl-checkbox__input" value="0"><span class="mdl-checkbox__label"></span></label></td>';
            strhtml += '<td><input type="checkbox" class="filled-in" id="chkDetalle' + i + '" name="mc_articulo[' + i + '][chkDetalle]" /><label for="chkDetalle' + i + '"></label></td>';
            
            strhtml += '<td data-title="Articulo" class="v-align-middle"><input name="mc_articulo[' + i + '][iddetalle]" type="hidden" id="iddetalle' + i + '" value="0" /><input name="mc_articulo[' + i + '][idproducto]" type="hidden" id="idproducto' + i + '" value="' + data[i].tm_idproducto + '" />' + data[i].tm_nombre + '</td>';
            strhtml += '<td data-title="Stock">';
            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right no-margin stock" type="number" step="any" name="mc_articulo[' + i + '][stock]" id="stock' + i + '" value="10" disabled><label class="mdl-textfield__label" for="stock' + i + '"></label></div>';
            strhtml += '</td>';
            strhtml += '<td data-title="Precio">';

            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right no-margin precio" type="number" step="any" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + Number(data[i].td_precio).toFixed(2) + '" disabled><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
            
            strhtml += '</td>';
            strhtml += '</tr>';
            ++i;
        };
    }
    else {
        if (pagina == '1')
            strhtml = '<h2>No se encontraron resultados.</h2>';
    };

    return strhtml;
}

function BuscarDatos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .collection';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/productos/productos-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
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
                    var iditem = data[i].tm_idproducto;
                    var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                     if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion">' + data[i].tm_nombre + ' - Precio Venta: <span class="preciovta">' + data[i].tm_precioVenta +'</span>';
                    
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

function ListarPacks (selectorgrid, pagina) {
    // var criterio = $('#txtSearch').val();

    precargaExp('#pnlListado', true);

    $.ajax({
        type: 'GET',
        url: 'services/grupos/grupos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 55,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: '',
            pagina: pagina
        },
        success: function(result){
            var i = 0;
            // var countdata = 0;
            var strhtml = '';
            var count_secciones = 0;
            var selector = selectorgrid + ' .gridview-content';

            var groups = _.groupBy(result, function(value){
                return value.tm_idgrupoarticulo + '#' + value.tm_nombre;
            });
            var data = _.map(groups, function(group){
                return {
                    tm_idgrupoarticulo: group[0].tm_idgrupoarticulo,
                    tm_nombre: group[0].tm_nombre,
                    tm_idmoneda: group[0].tm_idmoneda,
                    tm_simbolo: group[0].tm_simbolo,
                    td_precio: group[0].td_precio,
                    list_secciones: group
                }
            });

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var j = 0;
                    var iditem = data[i].tm_idgrupoarticulo;
                    var secciones = data[i].list_secciones;

                    if (secciones.length == 1){
                        if (secciones[0].td_nombreseccion.trim().length == 0)
                            count_secciones = 0;
                    }
                    else
                        count_secciones = secciones.length;

                    var preselect_class = count_secciones > 0 ? 'select-in-details' : 'select-in-item';

                    var _css_width = selectorgrid == '#gvPacks' ? ' mdl-cell--2-col' : ' mdl-cell--12-col';

                    strhtml += '<div data-idmodel="' + iditem + '" data-idMoneda="' + data[i].tm_idmoneda + '" class="dato card mdl-cell' + _css_width + ' mdl-shadow--2dp left ' + preselect_class + '" data-baselement="' + selectorgrid + '">';

                    strhtml += '<input type="checkbox" style="display:none;" name="chkItem[]" value="' + iditem + '">';

                    strhtml += '<i class="icon-select place-top-right margin10 material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<div class="card-content">';
                    strhtml += '<span class="card-title descripcion">' + data[i].tm_nombre + '</span>';

                    if (count_secciones > 0){
                        strhtml += '<ul class="list-options">';
                        while (j < count_secciones){
                            strhtml +=  '<li data-idseccion="' + secciones[j].tp_idseccionpack + '">' + secciones[j].td_nombreseccion + '</li>';
                            ++j;
                        };
                        strhtml += '</ul>';
                    };

                    strhtml += '<div class="progress hide"><div class="determinate" style="width: 0%"></div></div>';
                    strhtml += '</div>';

                    strhtml += '<div class="card-action">';
                    strhtml += '<h4 class="black-text no-margin"><span class="moneda">' + data[i].tm_simbolo + ' </span><span class="precio">' + Number(data[i].td_precio).toFixed(2) + '</span></h4>';
                    strhtml += '</div>';

                    if (selectorgrid == '#gvPacks') {
                        strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5">';
                        strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';
                        strhtml += '<ul class="dropdown">';
                        strhtml += '<li><a href="#" data-action="edit">Editar</a></li>';
                        strhtml += '<li><a href="#" data-action="delete">Eliminar</a></li>';
                        //strhtml += '<li><a href="#" data-action="stats">Ir a estad&iacute;sticas</a></li>';
                        strhtml += '</ul>';
                        strhtml += '</div>';
                    };

                    strhtml += '</div>';
                    ++i;
                };

                gvPacks.currentPage(gvPacks.currentPage() + 1);
                
                // paginaPack_grilla = paginaPack_grilla + 1;

                // $('#hdPageGrupo').val(paginaPack_grilla);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                // $(selector + ' .grouped-buttons a.tooltipped').tooltip();

                if (selectorgrid != '#gvPacksAsignacion')
                    initMasonry(selector, '.mdl-cell--2-col', '.dato');
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

function ListarPacks_viewlist (pagina) {
    var selector = '#optSubMenu';

    $.ajax({
        type: 'GET',
        url: 'services/grupos/grupos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 5,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: '',
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<li><a class="pos-rel padding20 grey-text text-darken-4 row no-margin" data-idmodel="' + data[i].tm_idgrupoarticulo + '" data-type="menu" href="#">';
                    strhtml += '<div class="col s6 v-align-middle">' + data[i].tm_nombre + '</div>';
                    strhtml += '<div class="col s6 v-align-middle">' + data[i].tm_simbolo + ' ' + data[i].td_precio + '</div>';
                    strhtml += '</a></li>';
                    ++i;
                };

                paginaPack_lista = paginaPack_lista + 1;

                $('#hdPageGrupo_lista').val(paginaPack_lista);

                if (pagina == '1'){
                    $(selector).html(strhtml);
                    $('#pnlSubMenu').find('a:first').trigger('click');
                }
                else
                    $(selector).append(strhtml);                
            }
            else {
                if (pagina == '1')
                    $(selector).html('');
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarSeccionesPack (idpack) {
    var selector = '#tableSeccion tbody';

    // precargaExp('.mini-details', true);

    $.ajax({
        type: 'GET',
        url: 'services/grupos/grupos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipo: 'TEMP-SECCIONPACK',
            tipobusqueda: '4',
            id: idpack
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var checking = '';

            if (countdata > 0){
                while(i < countdata){
                    if (data[i].td_idgruposeccion == '0') {
                        checking = '';
                        disabled = ' disabled';
                    }
                    else {
                        checking = ' checked';
                        disabled = '';
                    };

                    strhtml +=  '<tr data-idmodel="' + data[i].td_idgruposeccion +  '" data-idpackseccion="' + data[i].tp_idseccionpack + '">';
                    
                    // strhtml +=  '<td class="no-padding align-center v-align-middle width70"><input type="checkbox" class="filled-in" name="seccion[' + i + '][chkSeccion]" id="chkSeccion' + i + '"' + checking + ' value="' + data[i].tp_idseccionpack + '" /><label for="chkSeccion' + i + '"></label></td>';

                    // strhtml +=  '<td class="padding5"><input type="text" name="seccion[' + i + '][txtNombreSeccion]" id="txtNombreSeccion' + i + '" class="no-margin"' + disabled + ' value="' + data[i].tp_nombre + '" /></td>';

                    strhtml += '<td><input type="checkbox" class="filled-in" id="chkSeccion' + i + '" name="seccion[' + i + '][chkSeccion]"' + checking + ' value="' + data[i].tp_idseccionpack + '" /><label for="chkSeccion' + i + '"></label></td>';

                    // strhtml += '<td><input name="seccion[' + i + '][hdIdSeccion]" type="hidden" id="hdIdSeccion' + i + '" value="' + data[i].tp_idseccionpack + '" />';

                    strhtml += '<td><div class="mdl-input-js mdl-textfield mdl-js-textfield no-padding"><input class="mdl-textfield__input seccion no-margin"' + disabled + ' type="text" name="seccion[' + i + '][txtNombreSeccion]" id="txtNombreSeccion' + i + '" value="' + data[i].tp_nombre + '"><label class="mdl-textfield__label" for="txtNombreSeccion' + i + '"></label></div></td>';

                    strhtml +=  '</tr>';
                    ++i;
                };

                $(selector).html(strhtml);
                
                registerScriptMDL('#tableSeccion .mdl-input-js');
                //$(selector).enableCellNavigation();
            }
            else
                $(selector).html('<h5>No se encontraron resultados.</h5>');
            
            // precargaExp('.mini-details', false);
        },
        error: function (data) {
            console.log(data);
        }
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
            url: 'services/categorias/categoria-post.php',
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
        url: 'services/categorias/categoria-post.php',
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

function EliminarPack () {
    indexList = 0;
    elemsSelected = $('#gvPacks .selected');
    EliminarItemPack(elemsSelected[0], 'multiple');
}

function EliminarItemPack (item, mode, endCallback) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPack', idmodel);

    $.ajax({
        url: 'services/grupos/grupos-post.php',
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
                        EliminarItemPack(elemsSelected[indexList], mode);
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

function EliminarArticulo (selector, url, data, callback) {
    indexList = 0;
    elemsSelected = $(selector + ' .selected').toArray();
    EliminarItemArticulo(elemsSelected[0], 'multiple', callback);
}

function EliminarItemArticulo (item, mode, endCallback) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPrimary', idmodel);

    $.ajax({
        url: 'services/productos/productos-post.php',
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
                        EliminarItemArticulo(elemsSelected[indexList], mode);
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

function setDateFromCalendar (calendar_obj) {
    var fecha_corta_SLASH = calendar_obj.getCurrentDate();
    var fecha_corta_SCORE = calendar_obj.getCurrentDate('-');

    lblFechaCompleta.text(calendar_obj.getCurrentDate('large'));
    lblFechaCorta.text(fecha_corta_SLASH);
    $('#hdFecha').val(fecha_corta_SCORE);
}

function showMenuWhenView () {
    var tipobusqueda = '1';
    var idgrupo = '0';
    if (pnlViewAllArticles.find('.view-button[data-action="view-menu"]').hasClass('active')) {
        tipobusqueda = '2';
        var menuActive = document.querySelector('#pnlSubMenu a.active');
        if (typeof menuActive !== 'undefined')
            idgrupo = menuActive.getAttribute('data-idmodel');
    };
    //paginaDetalle = 1;
    ListarArticulos_Menu(tipobusqueda, idgrupo, '1');
}

function settingCalendar () {
    var calendar = new Calendar('#pnlCalendarioIndividual', {
        onInit: function (that) {
            var anho = that.year;
            var mes = that.month + 1;
            var dia = that.day;

            ListarDiasAsignados(anho, mes);
            
            //setTimeout(function () {
                // setDateFromCalendar(calendario);
                // showMenuWhenView();

            //}, 1000);
        },
        onDayClick: function (day) {
            var estado = day.getAttribute('data-estadomenudia');
            
            $('#hdEstadoApertura').val(estado);
            
            setDateFromCalendar(calendario);
            showMenuWhenView();

            if (estado == '01') {
                $('#btnActionMenu').addClass('hide');
            }
            else {
                $('#btnActionMenu').removeClass('hide');
            };

            pnlShowCalendar.removeClass('is-visible');
        },
        onMonthChange: function (that) {
            var anho = that.year;
            var mes = that.month + 1;

            ListarDiasAsignados(anho, mes);
        }
    });

    return calendar;
}

function ListarDiasAsignados (anho, mes) {
   $.ajax({
        url: 'services/cartadia/cartadia-dias.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            anho: anho,
            mes: mes
        },
        success: function  (data) {
            // var open = '';
            var countdata = data.length;
            var i = 0;
            var idcalendar = '#pnlCalendarioIndividual';

            if (countdata > 0) {
                while (i < countdata){
                    //var open = (data[i].estado == '01' ? 'open' : '');

            //         open = (data[i].estado == '01' ? ' open' : '');
                    
                    var dia = $(idcalendar + ' .day[data-day="' + data[i].dia + '"][data-month="' + data[i].mes + '"][data-year="' + data[i].anho + '"]');

                    dia.attr('data-estadomenudia', data[i].estado);

                    if (data[i].estado == '01')
                        dia.addClass('open');
                    
                    ++i;
                };
            };

            $(idcalendar + ' .selected:first').find('button').trigger('click');
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function buildCarta_lista (data, pagina) {
    var selector = '#optSubMenu';
    var i = 0;
    var countdata = data.length;
    var strhtml = '';
    var carta_Actual = false;

    if (countdata > 0){
        while(i < countdata){
            carta_Actual = data[i].Actual == 1;

            strhtml += '<li><a class="grey-text text-darken-4" data-idmodel="' + data[i].tm_idcarta + '" data-actual="' + carta_Actual + '"data-type="carta" href="#"><i class="material-icons icon v-align-middle">';
            strhtml += carta_Actual ? '&#xE838;' : '&#xE83A;';
            strhtml += '</i><span class="text v-align-middle">' + data[i].tm_nombre + '</span></a></li>';
            ++i;
        };

        $('#btnActionMenu').removeClass('hide');
        
        paginaCarta_lista = paginaCarta_lista + 1;

        $('#hdPageCarta_lista').value = paginaCarta_lista;

        if (pagina == '1')
            $(selector).html(strhtml);
        else
            $(selector).append(strhtml);

        setCartaSelected(selector);
    }
    else {
        if (pagina == '1')
            $(selector).html('');
    };
}

function buildCarta_grilla (data, pagina) {
    var selectorgrid = '#gvCarta';
    var selector = selectorgrid + ' .gridview-content';
    var i = 0;
    var countdata = data.length;
    var strhtml = '';
    var carta_Actual = false;

    if (countdata > 0){
        while(i < countdata){
            carta_Actual = data[i].Actual == 1;
            
            strhtml += '<li data-idmodel="' + data[i].tm_idcarta + '" class="collection-item dato pos-rel expandable no-border" data-baselement="' + selectorgrid + '"data-actual="' + carta_Actual + '">';

            strhtml += '<input type="checkbox" name="chkItemCarta[]" value="' + data[i].tm_idcarta + '" />';

            //strhtml += '<a href="#!" class="secondary-content left margin5"><i class="material-icons">grade</i></a>';
            
            strhtml += '<h4 class="left">' + data[i].tm_nombre + '</h4>';

            strhtml += '<i class="icon-select height-centered material-icons white-text circle place-top-right">done</i><div class="layer-select"></div>';

            strhtml += '<div class="grouped-buttons place-bottom-right padding5">';
            
            strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';

            strhtml += '<ul class="dropdown">';

            strhtml += '<li><a href="#" data-action="view-content">Ver contenido</a></li>';
            strhtml += '<li><a href="#" data-action="activate">Activar carta</a></li>';
            strhtml += '<li><a href="#" data-action="edit">Editar</a></li>';
            strhtml += '<li><a href="#" data-action="delete">Eliminar</a></li>';
            strhtml += '<li><a href="#" data-action="stats">Ir a estad&iacute;sticas</a></li>';

            strhtml += '</ul>';

            strhtml += '</div>';

            strhtml += '</li>';
            ++i;
        };
        
        paginaCarta_lista = paginaCarta_lista + 1;

        $('#hdPageCarta_grilla').value = paginaCarta_lista;

        if (pagina == '1')
            $(selector).html(strhtml);
        else
            $(selector).append(strhtml);

        // $(selector + ' .grouped-buttons a.tooltipped').tooltip();
        setCartaSelected(selector);
    }
    else {
        if (pagina == '1')
            $(selector).html('');
    };
}

function ListarCartas (view, pagina) {
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartas-search.php',
        cache: false,
        dataType: 'json',
        data: {
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: '',
            pagina: pagina
        },
        success: function(data){
            if (view == 'lista')
                buildCarta_lista(data, pagina);
            else
                buildCarta_grilla(data, pagina);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function setCartaSelected (selector) {
    var selectorActive = $(selector).find('a[data-actual="true"]');
    
    if (selectorActive.length > 0)
        selectorActive.trigger('click');
    else
        $(selector).find('a').first().trigger('click');
}

function buildMenu (data, pagina) {
    var strhtml = '';
    var i = 0;
    var countdata = data.length;
    var selector = '#gvArticuloMenu tbody';
    var modo_vista_menu = $('#pnlViewAllArticles .view-button.active').attr('data-action');

    if (countdata > 0){
        while(i < countdata){
            //var color_estado = data[i].ta_estadomenudia == '00' ? '' : 'blue lighten-3';
            var estado_menudia = typeof data[i].ta_estadomenudia === 'undefined' ? '00' : data[i].ta_estadomenudia;

            strhtml += '<tr data-iddetalle="' + data[i].iddetalle + '" data-estadomenudia="' + estado_menudia + '">';
            strhtml += '<td>';

            if (estado_menudia == '00'){
                // strhtml += '<label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkDetalle' + i + '"><input name="mc_articulo[' + i + '][chkDetalle]" type="checkbox" id="chkDetalle' + i + '" class="mdl-checkbox__input" value="' + data[i].iddetalle + '"><span class="mdl-checkbox__label"></span></label></td>';
                if (modo_vista_menu == 'view-list')
                    strhtml += '<input type="checkbox" class="filled-in" id="chkDetalle' + i + '" name="mc_articulo[' + i + '][chkDetalle]" value="' + data[i].iddetalle + '" /><label for="chkDetalle' + i + '"></label>';
            };

            strhtml += '</td>';

            strhtml += '<td data-title="Articulo" class="v-align-middle pos-rel"><input name="mc_articulo[' + i + '][iddetalle]" type="hidden" id="iddetalle' + i + '" value="' + data[i].iddetalle + '" /><input name="mc_articulo[' + i + '][idproducto]" type="hidden" id="idproducto' + i + '" value="' + data[i].tm_idproducto + '" />' + data[i].nombreProducto;
            
            if (estado_menudia == '01')
                strhtml += '<div class="place-top-right margin10 padding5 rounded blue white-text">APERTURADO</div>';

            strhtml += '</td>';
            
            strhtml += '<td data-title="Stock">';
            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right no-margin stock" type="number" step="any" name="mc_articulo[' + i + '][stock]" id="stock' + i + '" value="' + data[i].td_stockdia + '"><label class="mdl-textfield__label" for="stock' + i + '"></label></div>';

            strhtml += '</td>';
            //strhtml += '<td data-title="Precio"><h4 class="margin5">' + data[i].simboloMoneda + '</h4></td>';
            strhtml += '<td data-title="Precio">';
            
            // strhtml += '<input type="text" name="mc_articulo[' + i + '][precio]" id="precio' + data[i].iddetalle + '" class="align-right no-margin" value="' + data[i].td_precio + '" />';

            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right no-margin precio" type="number" step="any" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + Number(data[i].td_precio).toFixed(2) + '"><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
            
            strhtml += '</td>';
            strhtml += '</tr>';
            ++i;
        };

        paginaDetalle = paginaDetalle + 1;

        $('#hdPageDetalle').val(paginaDetalle);

        if (pagina == '1'){
            $(selector).html(strhtml);
            $('#pnlViewAllArticles').removeClass('hide');
        }
        else
            $(selector).append(strhtml);

        //$(selector).enableCellNavigation();
        registerScriptMDL(selector + ' .mdl-input-js');
    }
    else {
        if (pagina == '1')
            $(selector).html('');
    };
}

function ListarArticulos_Menu (tipobusqueda, idgrupo, pagina) {
    var criterio = ''; //$('#txtSearch').val();
    var fecha = $('#hdFecha').val();
    
    precargaExp('#pnlMenuCarta', true);

    tipobusqueda = idgrupo == '0' ? '1' : tipobusqueda;

    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            tipomenu: '03',
            fecha: fecha,
            idgrupo: idgrupo,
            criterio: criterio,
            pagina: pagina
        },
        success: function(data){
            buildMenu(data, pagina);

            precargaExp('#pnlMenuCarta', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarArticulos_Carta (pagina) {
    var criterio = $('#txtSearch').val();
    var idcarta = $('#pnlSubMenu a.active').attr('data-idmodel');

    precargaExp('#pnlMenuCarta', true);
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            tipomenu: '00',
            idcarta: idcarta,
            criterio: criterio,
            pagina: pagina
        },
        success: function(data){
            buildMenu(data, pagina);

            precargaExp('#pnlMenuCarta', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function AperturarMenu () {
    MessageBox({
        content: '¿Realmente desea aperturar en esta fecha?',
        width: '320px',
        height: '130px',
        buttons: [
            {
                primary: true,
                content: 'Aperturar',
                onClickButton: function (event) {
                    var data = new FormData();

                    data.append('btnAperturarMenu', 'btnAperturarMenu');
                    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
                    data.append('hdIdCentro', $('#hdIdCentro').val());
                    data.append('hdTipoCarta', '03');
                    data.append('hdFecha', $('#hdFecha').val());

                    $.ajax({
                        type: 'POST',
                        url: 'services/cartadia/cartadia-post.php',
                        cache: false,
                        contentType:false,
                        processData: false,
                        dataType: 'json',
                        data: data,
                        success: function(data){
                            createSnackbar(data.titulomsje);
                            getDataMenu('1');
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        ],
        cancelButton: true
    });
}

function CalcularPorciones(){
    var _tableReceta = $('#tableReceta tbody tr');

    var i = 0;
    var countdata = _tableReceta.length;
    var _nroporciones = Number($('#txtNroPorciones').val());
    var totalcostoreceta = 0;
    var _costoreceta_eval = 0;

    if (countdata > 0) {
        while (i < countdata){
            var _costoinsumo_input = Number(_tableReceta[i].getElementsByClassName('hdCostoInsumo')[0].value);
            var _cantidad = Number(_tableReceta[i].getElementsByClassName('cantidad')[0].value);
            var input_avgxporcion = _tableReceta[i].getElementsByClassName('avgxporcion')[0];
            var _cell_avgxporcion = _tableReceta[i].getElementsByClassName('cell-avgxporcion')[0];
            
            var _costoreceta = _tableReceta[i].getElementsByClassName('costoreceta')[0];
            var _costoreceta_input = _tableReceta[i].getElementsByClassName('hdCostoReceta')[0];

            if ($('#txtNroPorciones').val().trim().length > 0){
                var _avgxporcion = _cantidad / _nroporciones;
                _costoreceta_eval = _costoinsumo_input * _avgxporcion;

                input_avgxporcion.value = _avgxporcion;
                _cell_avgxporcion.innerHTML = _avgxporcion.toFixed(3);
                _costoreceta.innerHTML = _costoreceta_eval.toFixed(2);
                _costoreceta_input.value = _costoreceta_eval.toFixed(2);
            }
            else {
                input_avgxporcion.value = '0';
                _cell_avgxporcion.innerHTML = '0.00';
                _costoreceta.innerHTML = '0.00';
                _costoreceta_input.value = '0.00';
            };

            totalcostoreceta += Number(_costoreceta_eval);
            
            ++i;
        };
    };

    $('#lblTotalCostoReceta').text('S/. ' + totalcostoreceta.toFixed(2));
}

// function calcularTotalCostoReceta () {
//      var _tableReceta = $('#tableReceta tbody tr');

//     var i = 0;
//     var countdata = _tableReceta.length;
//     var _nroporciones = Number($('#txtNroPorciones').val());
//     var totalcostoreceta = 0;

//     if (countdata > 0) {
//         while (i < countdata){
//             var input_costoreceta = _tableReceta[i].getElementsByClassName('costoreceta')[0];

//             if (Number(input_costoreceta.innerHTML) > 0)
//                 totalcostoreceta += Number(input_costoreceta.innerHTML);
            
//             ++i;
//         };
//     };

//     $('#lblTotalCostoReceta').text('S/. ' + totalcostoreceta.toFixed(2));
//     // $('#lblTotalCostoReceta_Porcion').val((totalcostoreceta * _nroporciones).toFixed(2));
// }

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

function clearFormPresentacion () {
    $('#ddlPresentacion')[0].selectedIndex = 0;
    $('#ddlUnidadMedida')[0].selectedIndex = 0;
    $('#txtMedida').val('0');
}

function AgregarPresentacion () {
    var rowSelected = $('#tablePresentacion tbody tr.selected');
    
    var idpresentacion = $('#ddlPresentacion').val();
    var presentacion = $('#ddlPresentacion option:selected').text();
    var idunidadmedida = $('#ddlUnidadMedida').val();
    var unidadmedida = $('#ddlUnidadMedida option:selected').attr('data-simbolo');
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

function ListarPresentaciones (idinsumo) {
    $.ajax({
        type: "GET",
        url: 'services/presentacion/presentacion-search.php',
        cache: false,
        data: 'tipobusqueda=1&idinsumo=' + idinsumo + '&tipoinsumo=01',
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
                };
            };
            
            $('#tablePresentacion tbody').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GetInfoPresentacion () {
    var rowSelected = $('#tablePresentacion tbody tr.selected:first');

    var idpresentacion = rowSelected[0].getAttribute('data-idpresentacion');
    var idunidadmedida = rowSelected[0].getAttribute('data-idunidadmedida');
    var medida = rowSelected.find('.medida').text();

    $('#ddlPresentacion').val(idpresentacion);
    $('#ddlUnidadMedida').val(idunidadmedida);
    $('#txtMedida').val(medida);
}

function MostrarSelectUnidadMedida (flag) {
    if (flag) {
        $('#pnlReceta').removeClass('hide');
        $('#pnlPresentacion, #rowUnidadMedida').addClass('hide');
    }
    else {
        $('#pnlReceta').addClass('hide');
        $('#pnlPresentacion, #rowUnidadMedida').removeClass('hide');
    };
}

function Buscar () {
    if ($('#gvCategoria').is(':visible'))
        ListarCategorias('1');
    else if ($('#gvAlmacen').is(':visible'))
        ListarAlmacen('1');
    else
        ListarArticulos('1');
}

function showAll () {
    $('#txtSearch').val('');
    Buscar();
}


function LimpiarForm () {
    $('#hdIdPrimary').val("0");
    $('#txtNombreProducto').val("");
    $('#txtPrecioVenta').val("");
    $('#txtPrecioCompra').val("");
    $('#ddlCategoriaReg')[0].selectedIndex = 0;
}

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';
    document.getElementById('hdFoto').value = 'no-set';

    precargaExp(selectorModal, true);

    resetFoto('new');
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
                url: 'services/productos/productos-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idproducto);
                        $('#txtNombreProducto').val(data[0].tm_nombre);
                        $('#txtPrecioVenta').val(data[0].tm_precioVenta);
                        $('#txtPrecioCompra').val(data[0].tm_precioCompra);
                        $('#ddlCategoriaReg').val(data[0].tm_idcategoria);

                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        hdFoto.value = foto_original;
                        
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