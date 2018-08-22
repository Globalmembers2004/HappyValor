<script>
    $(function  () {
        $('#btnBack').on('click', function(event) {
            event.preventDefault();
            window.top.showDesktop();
        });

        <?php
        if ($pag == 'admin' || $pag == 'seguridad' || $pag == 'settings'):
            if ($subpag == 'usuarios' || $subpag == 'productos' || $subpag == 'insumos' || $subpag == 'personal' || $subpag == 'proveedores' || $subpag == 'clientes' || $subpag == 'moneda' || $subpag == 'forma-pago' || $subpag == 'documentos' || $subpag == 'presentaciones' || $subpag == 'impuestos' || $subpag == 'series' || $subpag == 'terminal' || $subpag == 'tipo-comprobante' || $subpag == 'tipomovcaja' || $subpag == 'grupoarticulo' || $subpag == 'categoriainsumo'):
        ?>
        $('#gvDatos').on('click', '.dato', function(event) {
            var checkBox = $(this).find('input:checkbox');
            event.preventDefault();
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvDatos .dato.selected').length == 0){
                    $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
                    $('#btnLimpiarSeleccion, #btnEditar, #btnEliminar').addClass('oculto');
                }
                else {
                    if ($('#gvDatos .dato.selected').length == 1){
                        $('#btnLimpiarSeleccion, #btnEditar').removeClass('oculto');
                    }
                }
            }
            else {
                $(this).addClass('selected');
                checkBox.attr('checked', '');
                $('#btnNuevo, #btnUploadExcel').addClass('oculto');
                $('#btnLimpiarSeleccion, #btnEliminar').removeClass('oculto');
                if ($('#gvDatos .dato.selected').length == 1){
                    $('#btnEditar').removeClass('oculto');
                }
                else {
                    $('#btnEditar').addClass('oculto');
                }
            }
        });
        <?php
            endif;
        endif;
        ?>
        
        $('.close-modal-example').on('click', function(event) {
            event.preventDefault();
            closeCustomModal(this);
        });

        ApplyValidNumbers();
	});
    
    function clearSelection () {
        $('.contentPedido ul li.selected').removeClass('selected');
        clearOnlyListSelection();
    }

    function clearOnlyListSelection () {
        $('.gridview .selected').removeClass('selected');
        $('.gridview .tile input:checkbox').removeAttr('checked');
        $('.tile .input_spinner').hide();
        setButtonState("03");
    }

    function setButtonState (state) {
        if (state == "01"){
            <?php
            if ($subpag != 'menu-hoy'):
            ?>
            $('#btnEliminar').removeClass('oculto');
            <?php
            endif;
            ?>
            $("#btnAddOrder, #btnEditar, #btnEditRooms, #btnAsignar, #btnDelRooms, #btnClearSelection, #btnLimpiarSeleccion, #btnMiniBack, #btnVerDetalle, #btnContactar").removeClass("oculto");
            $("#btnNuevo, #btnUploadExcel, #btnNuevaMesa,  #btnNuevoAmbiente, #btnDescargar, #btnReporte").addClass("oculto");
        }
        else if (state == "02"){
            <?php
            if ($subpag != 'menu-hoy'):
            ?>
            $('#btnEliminar').removeClass('oculto');
            <?php
            endif;
            ?>
            $("#btnContactar, #btnEditar, #btnEditRooms, #btnNuevo, #btnUploadExcel, #btnNuevoAmbiente, #btnNuevaMesa, #btnMiniBack, #btnDescargar, #btnReporte, #btnVerDetalle").addClass("oculto");
            $("#btnAddOrder, #btnDelRooms, #btnAsignar, #btnClearSelection, #btnLimpiarSeleccion").removeClass("oculto");
        }
        else if (state == "03"){
            $("#btnSelectAll, #btnDescargar, #btnReporte, #btnModelos, #btnMiniBack, #btnNuevoAmbiente, #btnNuevaMesa, #btnNuevo,  #btnUploadExcel").removeClass("oculto");
            $("#btnGuardarCambios, #btnApplyFavorite, #btnQuitarFavorito, #btnAddOrder, #btnVerDetalle, #btnClearSelection, #btnLimpiarSeleccion, #btnContactar, #btnEditar, #btnEditRooms, #btnAsignar, #btnEliminar, #btnDelRooms, #btnQuitarItem").addClass("oculto");
        }
    }

    function initEventGridview(){
        $('.gridview').on('click', '.tile .tile_true_content', function(){
            selectingTile(this);
        });
    }

    function stateButtonsAppBar (state) {
        if (state){
            if ($('.gridview .dato.selected').length > 0){
                if ($('.gridview .dato.selected').length == 1)
                    setButtonState("01");
                else {
                    $("#btnEditar, #btnEditRooms").addClass("oculto");
                    <?php
                    if ($subpag != 'menu-hoy'):
                    ?>
                    $('#btnEliminar').removeClass('oculto');
                    <?php
                    endif;
                    ?>
                    $("#btnDelRooms").removeClass("oculto");
                }
            }
            else
                setButtonState("03");
        }
        else {
            if ($('.gridview .dato.selected').length > 0){
                if ($('.gridview .dato.selected').length == 1)
                    setButtonState("01");
                else
                    setButtonState("02");
            }
        }
    }

    function stateShowAppBar (state) {
        if (typeof showAppBar == 'function'){
            if (state == true){
                if ($('.gridview .dato.selected').length == 1)
                    showAppBar(state);
            }
            else {
                if ($('.gridview .dato.selected').length == 0)
                    showAppBar(state);
            }
        }
    }

    function selectInTile (obj) {
        var checkBox = $(obj).find('input:checkbox');
        
        if($(obj).hasClass("selected")){
            $(obj).removeClass("selected");
            stateButtonsAppBar(true);
            checkBox.removeAttr('checked');
            //stateShowAppBar(false);
        }
        else {
            $(obj).addClass("selected");
            stateButtonsAppBar(true);
            checkBox.attr('checked', '');
            //stateShowAppBar(true);
        }       
    }
    
    function selectingTile (obj) {
        if($(obj).parent().hasClass("selected")){
            $(obj).parent().removeClass("selected");
            stateButtonsAppBar(true);
        }
        else {
            $(obj).parent().addClass("selected");
            stateButtonsAppBar(true);
        }
    }
</script>