<?php
require 'bussiness/tabla.php';
// require 'bussiness/cargos.php';
// require 'bussiness/areas.php';

$objTabla = new clsTabla();
// $objArea = new clsArea();
// $objCargo = new clsCargo();

// $rowCargo = $objCargo->Listar('1', $IdEmpresa, $IdCentro, 0, '');
// $countrowCargo = count($rowCargo);

// $rowArea = $objArea->Listar('1', $IdEmpresa, $IdCentro, 0, '');
// $countRowArea = count($rowArea);

$rsDia = $objTabla->Listar('BY-FIELD', 'ta_diasemana');
$countDia = count($rsDia);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="gvDatos" class="scrollbarra gridview-content" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
            <ul class="demo-list-item mdl-list gridview">
            </ul>
        </div>
        <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div id="modalRegistro" class="modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header pink darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Horario Grupal</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
            <div class="scrollbarra padding20">
                <div class="row">
                    <div class="col-sm-6">
                            <label class="active" for="ddlRutinaGrupal"><?php $translate->__('Rutina grupal'); ?></label>
                            <select id="ddlRutinaGrupal" name="ddlRutinaGrupal" style="width: 100%;" class="browser-default">
                            </select>
                    </div>
                    <div class="col-sm-6">
                            <label for="ddlDia" class="active"><?php $translate->__('Dia'); ?></label>
                            <select id="ddlDia" name="ddlDia" class="browser-default">
                                <?php
                                if ($countDia > 0):
                                    for ($i=0; $i < $countDia; ++$i):
                                ?>
                                <option value="<?php echo $rsDia[$i]['ta_codigo']; ?>">
                                    <?php echo $rsDia[$i]['ta_denominacion']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                            <label class="active" for="ddlInstructor"><?php $translate->__('Instructor'); ?></label>
                            <select id="ddlInstructor" name="ddlInstructor" style="width: 100%;" class="browser-default">
                            </select>
                    </div>  
                </div>  
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-field">
                            <input id="txtHoraInicio" class="timepicker" name="txtHoraInicio" type="text" placeholder="Ingrese Hora Inicio" />
                            <label for="txtHoraInicio"><?php $translate->__('HoraInicio'); ?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-field">
                            <input id="txtHoraFinal" class="timepicker" name="txtHoraFinal" type="text" placeholder="Ingrese Hora Final" />
                            <label for="txtHoraFinal"><?php $translate->__('HoraFinal'); ?></label>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-6">
                        <div class="input-field">
                            <input id="txtAforo" name="txtAforo" type="text" placeholder="Ingrese Aforo" />
                            <label for="txtAforo"><?php $translate->__('Aforo'); ?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-field">
                            <input id="txtminutos" name="txtminutos" type="text" placeholder="Minutos para separación" />
                            <label for="txtminutos"><?php $translate->__('Minutos para separar'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardar" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Guardar
            </button>
            <button id="btnLimpiar" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect right">
                Limpiar
            </button>
        </div>
    </div>
</form>