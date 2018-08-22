<?php
include('bussiness/ambientes.php');

$IdEmpresa = 1;
$IdCentro = 1;

$objAmbiente = new clsAmbiente();
$rowAmbiente = $objAmbiente->Listar('GroupAmbiente', $IdEmpresa, $IdCentro);
$countRowAmbiente = count($rowAmbiente);
?>
<form id="form1" name="form1" method="post" action="services/atencion/atencion-post.php">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="lang" name="lang" value="<?php echo $lang; ?>" />
    <input type="hidden" id="hdTipoSeleccion" name="hdTipoSeleccion" value="00" />
    <input type="hidden" id="hdTipoSave" name="hdTipoSave" value="00" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <input type="hidden" id="hdIdVenta" name="hdIdVenta" value="0" />
    <input type="hidden" id="hdIdAmbiente" name="hdIdAmbiente" value="0" />
    <input type="hidden" id="hdIdMesa" name="hdIdMesa" value="0" />
    <input type="hidden" id="hdIdMoneda" name="hdIdMoneda" value="0" />
    <input type="hidden" id="hdIdPersonal" name="hdIdPersonal" value="0" />
    <input type="hidden" id="hdIdPerfil" name="hdIdPerfil" value="<?php echo $idperfil; ?>" />
    <input type="hidden" id="hdTotalPedido" name="hdTotalPedido" value="0" />
    <input type="hidden" id="hdIdGrupo" name="hdIdGrupo" value="0" />
    <input type="hidden" id="hdIdOrden" name="hdIdOrden" value="0" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageCli" name="hdPageCli" value="1" />
    <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="0" />
    <input type="hidden" id="hdIdSubCategoria" name="hdIdSubCategoria" value="0" />
    <input type="hidden" id="hdEstadoMesa" name="hdEstadoMesa" value="00" />
    <input type="hidden" id="hdTipoAgrupacion" name="hdTipoAgrupacion" value="00" />
    <input type="hidden" id="hdVista" name="hdVista" value="MESAS" />
    <div class="page-region">
        <div id="sliderCuentas" class="slider">
            <button id="btnTodoUnaCuenta">Todo a esta cuenta</button>
            <a href="#" class="control_next"><i class="icon-arrow-right-3"></i></a>
            <a href="#" class="control_prev"><i class="icon-arrow-left-3"></i></a>
            <ul>
                <li data-idcontainer="1">
                    <h3 class="slider-header"><?php $translate->__('Cuenta 1'); ?></h3>
                    <div class="slider-content">
                        <div class="slider-content-scroll"></div>
                    </div>
                </li>
                <li data-idcontainer="2">
                    <h3 class="slider-header"><?php $translate->__('Cuenta 2'); ?></h3>
                    <div class="slider-content">
                        <div class="slider-content-scroll"></div>
                    </div>
                </li>
                <li data-idcontainer="3">
                    <h3 class="slider-header"><?php $translate->__('Cuenta 3'); ?></h3>
                    <div class="slider-content">
                        <div class="slider-content-scroll"></div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- <div id="pnlMesas" class="inner-page">
            <h1 class="title-window">
                Atenci&oacute;n de mesas
            </h1>
            <div class="divContent modern-wrappanel">
                <div id="sliderAmbientes" class="slider">
                    <a href="#" class="control_next"><i class="icon-arrow-right-3"></i></a>
                    <a href="#" class="control_prev disabled"><i class="icon-arrow-left-3"></i></a>
                    <ul>
                        <?php
                        for ($counterAmbiente=0; $counterAmbiente < $countRowAmbiente; $counterAmbiente++):
                        ?>
                        <li data-idcontainer="<?php echo $rowAmbiente[$counterAmbiente]['tm_idambiente']; ?>">
                            <h2 class="slider-header"><?php echo $rowAmbiente[$counterAmbiente]['tm_nombre']; ?></h2>
                            <div class="slider-content">
                                <div class="mesas tile-area gridview"></div>
                            </div>
                        </li>
                        <?php
                        endfor;
                        ?>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script>
    $(window).load(function () {
        //initSlider('#sliderAmbientes', '#pnlMesas', MostrarMesas);
        //MostrarMesas(1);
        //initSlider('#sliderCuentas', '#pnlCuentas .modal-example-body', makeCuentaDroppable);

        //$(window).resize(function () {
            //resizeSlider('#sliderAmbientes', '#pnlMesas');
            //resizeSlider('#sliderCuentas', '#pnlCuentas .modal-example-body', makeCuentaDroppable);
        //});

        MostrarMesas($('#sliderAmbientes ul li:first').attr('data-idcontainer'));
        
        $('#sliderAmbientes').on('click', '.control_prev', function(event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')){
                $('#sliderAmbientes ul li:visible').fadeOut(300, function () {
                    $(this).prev().fadeIn(300, function () {
                        var flag;
                        var idcontainer = '0';
                        
                        flag = $(this).is(':first-child');
                        idcontainer = $(this).attr('data-idcontainer');
                        
                        MostrarMesas(idcontainer);
                        
                        habilitarLink('#sliderAmbientes a.control_prev', !flag);
                        if (!flag)
                            habilitarLink('#sliderAmbientes a.control_next', true);
                    });
                });
            };
        });

        $('#sliderAmbientes').on('click', '.control_next', function(event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')){
                $('#sliderAmbientes ul li:visible').fadeOut(300, function () {
                    $(this).next().fadeIn(300, function () {
                        var flag;
                        var idcontainer = '0';
                        
                        flag = $(this).is(':last-child');
                        idcontainer = $(this).attr('data-idcontainer');
                        
                        MostrarMesas(idcontainer);
                        
                        habilitarLink('#sliderAmbientes a.control_next', !flag);
                        if (!flag)
                            habilitarLink('#sliderAmbientes a.control_prev', true);
                    });
                });
            };
        });

        makeCuentaDroppable($('#sliderCuentas ul li:first').attr('data-idcontainer'));
        
        $('#sliderCuentas').on('click', '.control_prev', function(event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')){
                $('#sliderCuentas ul li:visible').fadeOut(300, function () {
                    $(this).prev().fadeIn(300, function () {
                        var flag;
                        var idcontainer = '0';
                        
                        flag = $(this).is(':first-child');
                        idcontainer = $(this).attr('data-idcontainer');
                        
                        makeCuentaDroppable(idcontainer);
                        
                        habilitarLink('#sliderCuentas a.control_prev', !flag);
                        if (!flag)
                            habilitarLink('#sliderCuentas a.control_next', true);
                    });
                });
            };
        });

        $('#sliderCuentas').on('click', '.control_next', function(event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')){
                $('#sliderCuentas ul li:visible').fadeOut(300, function () {
                    $(this).next().fadeIn(300, function () {
                        var flag;
                        var idcontainer = '0';
                        
                        flag = $(this).is(':last-child');
                        idcontainer = $(this).attr('data-idcontainer');
                        
                        makeCuentaDroppable(idcontainer);
                        
                        habilitarLink('#sliderCuentas a.control_next', !flag);
                        if (!flag)
                            habilitarLink('#sliderCuentas a.control_prev', true);
                    });
                });
            };
        });
        
    });

    function makeCuentaDroppable (IdCuenta) {
        var slider = $('#sliderCuentas ul');
        slider.on('mouseover', $('li:first-child').next().find('.slider-content-scroll'), function() {
            if (!$(this).data("init")) {
                $(this).data("init", true).droppable({
                    drop: function (event, ui) {
                        var html_item_section = '';
                        var item = ui.draggable;
                        var i = 0;
                        var j = 0;
                        var idproductoIng = 0;
                        var cantidadIng = 0;
                        var cantidadTotal = 0;
                        var cuentas = $('#sliderCuentas ul li');

                        idproductoIng = item.attr('data-referer');
                        cantidadIng = Number(item.attr('data-cantidad'));

                        for (i = 0; i < cuentas.length; i++) {
                            var items = $(cuentas[i]).find('.item-section');
                            if (items.length > 0){
                                for (j = 0; j < items.length; j++) {
                                    if ($(items[j]).attr('data-referer') == idproductoIng)
                                        cantidadTotal = cantidadTotal + Number($(items[j]).find('.cantidad').text());
                                };
                            };
                        };

                        if (cantidadTotal < cantidadIng){
                            html_item_section = '<div data-referer="' + item.attr('data-referer') + '" data-idproducto="' + item.attr('data-idproducto') + '" class="item-section">';
                            html_item_section += '<span class="nombreProducto">' + item.find('.nombreProducto').text() + '</span>';
                            html_item_section += '<span class="cantidad">1</span>';
                            html_item_section += '<span class="precio">'+item.attr('data-precio')+'</span>';
                            html_item_section += '<span class="delete">&times;</span>';
                            html_item_section += '</div>';
                            $('#sliderCuentas ul li:first-child').next().find('.slider-content-scroll').append(html_item_section);
                            
                            //CalcularTotalPorCuenta();
                        }
                        else {
                            MessageBox('<?php $translate->__('No se pudo agregar'); ?>', '<?php $translate->__('Todas las cantidades de este articulo han sido cubiertas.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                                
                            });
                        }
                    }
                });
            }
        });
        //CalcularTotalPorCuenta();
    }

    function MostrarMesas (idambiente) {
        var selector = '';
        selector = '#sliderAmbientes.slider ul li[data-idcontainer="' + idambiente + '"] .tile-area';
        
        precargaExp('#sliderAmbientes.slider ul li[data-idcontainer="' + idambiente + '"]', true);
       
        $.ajax({
            type: "GET",
            url: "services/atencion/atencion-search.php",
            cache: false,
            dataType: 'json',
            data: "tipobusqueda=ATENCION-AMBIENTE&idambiente=" + idambiente,
            success: function(data){
                var countdata = 0; 
                var selectedState = '';
                var i = 0;
                var strhtml = '';
                var csssize = '';
                var tagheader = '';
                var stylehide = '';

                countdata = data.length;
                
                //selectedState = $('#pnlEstadoMesa .tile.selected').attr('data-codigo');

                if (countdata > 0){
                    while(i < countdata){
                        if (data[i].ta_tipoubicacion == '01'){
                            csssize = ' double';
                            tagheader = 'h3';
                        }
                        else {
                            csssize = '';
                            tagheader = 'h1';
                        }
                        
                        /*if (selectedState != '*'){
                            if (data[i].ta_estadoatencion != selectedState)
                                stylehide = 'none';
                            else
                                stylehide = 'block';
                        }
                        else
                            stylehide = 'block';*/

                        strhtml += '<div class="tile dato ' + csssize + '" ';
                        strhtml += 'data-idmesa="' + data[i].tm_idmesa + '" ';
                        strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                        strhtml += 'data-state="' + data[i].ta_estadoatencion + '" ';
                        strhtml += 'data-tipoubicacion="' + data[i].ta_tipoubicacion + '" ';
                        strhtml += 'style="background-color: ' + data[i].ta_colorleyenda + '; display: ' + stylehide + ';">';

                        strhtml += '<div class="tile-content">';
                        strhtml += '<div class="text-right padding10 ntp">';
                        strhtml += '<' + tagheader + ' class="white-text">' + data[i].tm_codigo + '</' + tagheader + '>';
                        strhtml += '</div></div>';
                        strhtml += '<div class="brand"><span class="badge bg-dark">' + data[i].tm_nrocomensales + '</span></div>';
                        
                        strhtml += '</div>';
                        ++i;
                    }
                }
                else
                    strhtml = '<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>';
                
                $(selector).html(strhtml);
                precargaExp('#sliderAmbientes.slider ul li[data-idcontainer="' + idambiente + '"]', false);
            }
        });
    }

    function resizeSlider (idLayout, parentLayout) {
        var slideItems = $(idLayout + '.slider ul li');
        var slideCount = slideItems.length;
        var slideWidth = 0;
        var sliderUlWidth = 0;
        var parentLayoutWidth = $(parentLayout).width();
        var i = 0;
        while (i < slideCount){
            slideItems[i].setAttribute("style","width:" + parentLayoutWidth + "px;");
            ++i;
        }
        slideWidth = slideItems.first().width();
        sliderUlWidth = slideCount * slideWidth;
        $(idLayout + '.slider').css({ width: slideWidth });
        $(idLayout + '.slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
    }

    function initSlider (idLayout, parentLayout, callback) {
        var slideWidth = 0;
        resizeSlider(idLayout, parentLayout);
        
        var firstLi = $(idLayout + '.slider ul li:first-child');
        
        slideWidth = firstLi.width();
        $(idLayout + '.slider ul li:last-child').prependTo(idLayout + '.slider ul');
        firstLi = $(idLayout + '.slider ul li:first').next();
        
        if (typeof callback == 'function')
            callback(firstLi.attr('data-idcontainer'));
        
        $(idLayout).on({
            click: function () {
                $(idLayout + '.slider ul').animate({
                    left: + slideWidth
                }, 200, function () {
                    var IdContainer = '0';
                    $(idLayout + '.slider ul li:last-child').prependTo(idLayout + '.slider ul');
                    $(idLayout + '.slider ul').css('left', '');
                    if (typeof callback == 'function'){
                        IdContainer = $(idLayout + '.slider ul li:first-child').next().attr('data-idcontainer');
                        callback(IdContainer);
                    }
                });
            },
            mouseover: function () {
                if (!$(this).data("init")) {
                    $(this).data("init", true).droppable({
                        drop: function (event, ui) {
                            $('a.control_prev').trigger('click');
                        }
                    });
                }
            }
        }, 'a.control_prev');

        $(idLayout).on({
            click: function () {
                $(idLayout + '.slider ul').animate({
                    left: - slideWidth
                }, 200, function () {
                    var IdContainer = '0';
                    $(idLayout + '.slider ul li:first-child').appendTo(idLayout + '.slider ul');
                    $(idLayout + '.slider ul').css('left', '');
                    
                    if (typeof callback == 'function'){
                        IdContainer = $(idLayout + '.slider ul li:first-child').next().attr('data-idcontainer');
                        callback(IdContainer);
                    }
                });
            },
            mouseover: function () {
                if (!$(this).data("init")) {
                    $(this).data("init", true).droppable({
                        drop: function (event, ui) {
                            alert('fuck');
                            $('a.control_next').trigger('click');
                        }
                    });
                }
            }
        }, 'a.control_next');
    }
</script>