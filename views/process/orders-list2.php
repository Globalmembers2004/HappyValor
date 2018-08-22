<?php
include('bussiness/ventas.php');
$IdEmpresa = 1;
$IdCentro = 1;
$Id = 0;
$Codigo = '';
$Nombre = '';
$IdCargo = 0;
$IdSubCategoria = 0;
$counterCategoria = 0;
$counterProducto = 0;
$counterValidItems = 0;
$parametros = array(
'criterio' => '',
'idcargo' => '0',
'lastid' => '1' );
$strListItems = '';
$strListDelete = '';
$strListValids = '';
$validItems = false;
$arrayValid = array();
$arrayDelete = array();
$objData = new clsVenta();
$rowData = $objData->Listar('1', '0', date("Y-m-d h:i:s"), date("Y-m-d h:i:s"), '');
$countrow = count($rowData);
$counter = 0;
$rpta = '0';
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
        <div id="pnlListado" class="inner-page">
            <h1 class="title-window">
                <?php $translate->__('Ventas realizadas'); ?>
            </h1>
            <div class="divload">
                <div id="gvDatos">
                    <div class="tile-area gridview">
                        <?php
                        $colorList = '';
                        $Estado = '';
                        if ($countrow > 0){
                            for ($counter=0; $counter < $countrow; $counter++) { 
                        ?>
                        <div class="tile double bg-cyan">
                            <div class="tile-content">
                                <div class="text-right padding10 ntp">
                                    <h1 class="white-text no-margin"></h1>
                                    <p class="white-text"></strong></p>
                                </div>
                            </div>
                            <div class="brand bg-dark opacity">
                                <span class="text">
                                    
                                </span>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <?php
                        }
                        else {
                        ?>
                        <h2><?php $translate->__('No hay ventas por el momento.'); ?></h2>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
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
    });
    function clearImagenForm () {
    }
    function addValidFormRegister () {
    }
    function removeValidFormRegister () {
    }
    function GetDetails (data) {
    }
    function BuscarDatos (pagina) {
    }
</script>