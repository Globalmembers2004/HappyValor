<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
        <div id="pnlListado" class="inner-page with-title-window with-panel-search">
            <h1 class="title-window">
                <a id="btnBack" href="#" title="Regresar a atenci&oacute;n de mesas" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                <?php $translate->__('Documentos de venta'); ?>
            </h1>
            <div class="panel-search">
                <table class="tabla-normal">
                    <tr>
                        <td>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                            </div>
                        </td>
                        <td style="width:45px;">
                            <button id="btnFilter" type="button" title="<?php $translate->__('M&aacute;s filtros'); ?>" style="margin-left:10px; margin-bottom:0px;"><i class="icon-filter"></i></button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="divload">
                <div id="gvDatos">
                    <div class="tile-area gridview"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="appbar">
        <button id="btnEliminar" name="btnEliminar" type="button" class="cancel metro_button oculto float-right">
            <span class="content">
                <img src="images/trash.png" alt="<?php $translate->__('Eliminar'); ?>" />
                <span class="text"><?php $translate->__('Eliminar'); ?></span>
            </span>
        </button>
        <button id="btnEditar" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/edit.png" alt="<?php $translate->__('Editar'); ?>" />
                <span class="text"><?php $translate->__('Editar'); ?></span>
            </span>
        </button>
        <button id="btnCancelar" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/cancel.png" alt="<?php $translate->__('Cancelar'); ?>" />
                <span class="text"><?php $translate->__('Cancelar'); ?></span>
            </span>
        </button>
        <button id="btnBuscarItems" type="button" class="metro_button oculto float-left">
            <span class="content">
                <img src="images/boxplot.png" alt="<?php $translate->__('Buscar items'); ?>" />
                <span class="text"><?php $translate->__('Buscar items'); ?></span>
            </span>
        </button>
        <button id="btnMoreFilter" type="button" class="metro_button oculto float-left">
            <span class="content">
                <img src="images/find.png" alt="<?php $translate->__('Mostrar filtros de b&uacute;squeda'); ?>" />
                <span class="text"><?php $translate->__('Mostrar filtros de b&uacute;squeda'); ?></span>
            </span>
        </button>
        <button id="btnGuardar" name="btnGuardar" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/save.png" alt="<?php $translate->__('Guardar'); ?>" />
                <span class="text"><?php $translate->__('Guardar'); ?></span>
            </span>
        </button>
        <button id="btnNuevo" type="button" class="metro_button float-right">
            <span class="content">
                <img src="images/add.png" alt="<?php $translate->__('Nuevo'); ?>" />
                <span class="text"><?php $translate->__('Nuevo'); ?></span>
            </span>
        </button>
        <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/icon_uncheck.png" alt="<?php $translate->__('Limpiar selecci&oacute;n'); ?>" />
                <span class="text"><?php $translate->__('Limpiar selecci&oacute;n'); ?></span>
            </span>
        </button>
        <div class="clear"></div>
    </div>
</form>
<?php
include('common/libraries-js.php');
?>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/localization/messages_es.js "></script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="scripts/droparea.js"></script>
<script>
    var TipoBusqueda = '00';
    $(function () {
        $('#btnBack').on('click', function(event) {
            event.preventDefault();
            $('#pnlListVentas', parent.document).fadeOut(400, function() {
                
            });
        });

        BuscarDatos('1');
    });

    function addValidFormRegister () {
    }

    function removeValidFormRegister () {
    }

    function GetDetails (data) {
    }

    function BuscarDatos (pagina) {
        precargaExp('#gvDatos', true);

        $.ajax({
            url: 'services/ventas/ventas-search.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                tipobusqueda:'1',
                criterio: $('#txtSearch').val(),
                pagina: pagina
            },
            success: function (data) {
                var count = data.length;
                var i = 0;
                var strhtml = '';

                if (count > 0) {
                    while(i < count){
                        strhtml += '<div class="tile double shadow double-vertical bg-green" data-id="' + data[i].tm_idventa + '">';
                        strhtml += '<div class="tile-content">';
                        strhtml += '<div class="text-right padding10">';
                        strhtml += '<h2 class="white-text no-margin">' + ConvertMySQLDate(data[i].tm_fecha_emision) + '</h2>';
                        strhtml += '<h4 class="white-text">' + data[i].tm_vserie_documento + '-' + data[i].tm_vnumero_documento + '</h4>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                        strhtml += '<div class="text-background">';
                        strhtml += '<h2 class="white-text no-margin">' + data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2) + '</h2>';
                        strhtml += '</div>';
                        strhtml += '<div class="tile-status bg-dark opacity">';
                        strhtml += '<span class="label">' + data[i].Cliente + '</span>';
                        strhtml += '</div>';
                        strhtml += '</div>';

                        ++i;
                    }
                    $('#gvDatos .tile-area').on('scroll', function(){
                        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                            var pagina = $('#hdPage').val();
                            BuscarDatos(pagina);
                        }
                    });
                    $('#hdPage').val(Number($('#hdPage').val()) + 1);
                    if (pagina == '1')
                        $('#gvDatos .tile-area').html(strhtml);
                    else
                        $('#gvDatos .tile-area').append(strhtml);
                }
                else {
                    if (pagina == '1')
                        $('#gvDatos .tile-area').html('<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>');
                }
                precargaExp('#gvDatos', false);
            }
        });
    }
</script>