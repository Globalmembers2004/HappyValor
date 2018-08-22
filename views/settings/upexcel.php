<?php 
include("bussiness/insumos.php");

$objInsumo = new clsInsumo();

$IdEmpresa = 1;
$IdCentro = 1;
$IdCanal = 1;
$flagValidation = '';
$nombreproveedor = '';
$nombrecontacto = '';
$cargocontacto = '';
$numerodoc = '';
$direccion = '';
$telefono = '';
$fax = '';
$celular = '';
$email = '';
$iddocident = 0;
$foto = '';
$pais = 0;
$razsocial = '';
$paterno = '';
$materno = '';
$nombres = '';
$dni = '';
$idcodigo = '';
$idcategoria = 0;
$idsubcategoria = 0;
$idproducto = 0;
$idinsumo = 0;
$idunidadmedida = 0;
$cantidad = 0.000;
$porciones = 0;
$promporcion = 0.000;
$contenido = '';
$tipomenu = '';
$peso = 0;

$i = 0;
$flagValidation = '';
$sqlInsertFields = '';

$sqlInsertValues = '';
$tipodata = (isset($_GET['tipodata'])) ? $_GET['tipodata'] : 'insumos' ;

if ($_POST){
	$filename = 'media/xls/'.$tipodata.'.xls';
	$hdTipoData = (isset($_POST['hdTipoData'])) ? $_POST['hdTipoData'] : 'insumos' ;

	if (file_exists ($filename)){
	    require_once('common/PHPExcel.php');
	    require_once('common/PHPExcel/Reader/Excel2007.php');

        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($filename);
        $objFecha = new PHPExcel_Shared_Date();
	    
	    if ($hdTipoData == 'insumos'){

	        $sqlInsertFields = 'INSERT INTO tm_insumo (';
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
	        $sqlInsertFields .= 'tm_idcategoria, tm_nombre, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['idcategoria'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['nombre'] = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
                
                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }


		if ($hdTipoData == 'proveedores'){

	        $sqlInsertFields = 'INSERT INTO tm_proveedor (';
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
	        $sqlInsertFields .= 'tm_nombreproveedor, tm_nombrecontacto, ';
	        $sqlInsertFields .= 'tm_cargocontacto, tm_numerodoc, ';
	        $sqlInsertFields .= 'tm_direccion, tm_telefono, ';
	        $sqlInsertFields .= 'tm_celular, tm_email, ';
	        $sqlInsertFields .= 'tm_fax, tm_foto, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['nombreproveedor'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['nombrecontacto'] = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['cargocontacto'] = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['numerodoc'] = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['direccion'] = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['telefono'] = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['celular'] = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());;
                $_DATOS_EXCEL[$i]['email'] = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());;
                $_DATOS_EXCEL[$i]['fax'] = trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['foto'] = trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue());                
                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }

	    if ($hdTipoData == 'clientes_juridico'){

	        $sqlInsertFields = 'INSERT INTO tm_cliente_juridica (';
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
			$sqlInsertFields .= 'tm_iddocident, tm_numerodoc, ';
	        $sqlInsertFields .= 'tm_razsocial, tm_direccion, ';
	        $sqlInsertFields .= 'tm_telefono, tm_fax, ';
	        $sqlInsertFields .= 'tm_representante, tm_email, ';
	        $sqlInsertFields .= 'tm_foto, td_idpais, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['iddocident'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['numerodoc'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['razsocial'] = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['direccion'] = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['telefono'] = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['fax'] = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['representante'] = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['email'] = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());;
                $_DATOS_EXCEL[$i]['foto'] = trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());;
                $_DATOS_EXCEL[$i]['pais'] = trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue());
                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }


        if ($hdTipoData == 'clientes_natural'){

	        $sqlInsertFields = 'INSERT INTO tm_cliente_natural (';
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
			$sqlInsertFields .= 'tm_iddocident, tm_numerodoc, ';
			$sqlInsertFields .= 'tm_nombres, tm_apepaterno, ';
	        $sqlInsertFields .= 'tm_apematerno, tm_direccion, ';
	        $sqlInsertFields .= 'tm_telefono, tm_fax, ';
	        $sqlInsertFields .= 'tm_email, ';
	        $sqlInsertFields .= 'tm_foto, td_idpais, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['iddocident'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['numerodoc'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['nombres'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['paterno'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['materno'] = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['direccion'] = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['telefono'] = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['fax'] = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['email'] = trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());;
                $_DATOS_EXCEL[$i]['foto'] = trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue());;
                $_DATOS_EXCEL[$i]['pais'] = trim($objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue());
                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }

		if ($hdTipoData == 'personal'){

	        $sqlInsertFields = 'INSERT INTO tm_personal (';
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
			$sqlInsertFields .= 'tm_codigo, tp_idcargo, ';
			$sqlInsertFields .= 'tm_nombres, tm_apellidopaterno, ';
	        $sqlInsertFields .= 'tm_apellidomaterno, tm_nrodni, ';
	        $sqlInsertFields .= 'tm_email, tm_foto, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['codigo'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['idcargo'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['nombres'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['paterno'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['materno'] = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['dni'] = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['email'] = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['foto'] = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());
                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }


		if ($hdTipoData == 'recetas'){

	        $sqlInsertFields = 'INSERT INTO tm_recetas (';
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
			$sqlInsertFields .= 'tm_idproducto, tm_idinsumo_orig, ';
			$sqlInsertFields .= 'tm_idunidadmedida, ta_tipomenudia, ';
	        $sqlInsertFields .= 'td_descripcion, td_cantidad, ';
	        $sqlInsertFields .= 'td_nroporciones, td_avgxporcion, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['idproducto'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['idinsumo'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['idunidadmedida'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['tipomenu'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['nombre'] = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['cantidad'] = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['porciones'] = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['promporcion'] = trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue());
	       

                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }


        if ($hdTipoData == 'productos'){

	        $sqlInsertFields = 'INSERT INTO tm_producto (';	
	        $sqlInsertFields .= 'tm_idempresa, tm_idcentro, ';
	        $sqlInsertFields .= 'tm_codigo, tm_nombre, ';
	        $sqlInsertFields .= 'tm_idcategoria, tm_idsubcategoria, ';
	        $sqlInsertFields .= 'td_contenido, tm_peso, ';
	        $sqlInsertFields .= 'tm_foto, ';
	        $sqlInsertFields .= ' Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';

	        $objPHPExcel->setActiveSheetIndex(0);
	        $countRowsExcel = $objPHPExcel->getActiveSheet()->getHighestRow();
	        
	        for ($i = 1; $i <= $countRowsExcel; $i++){
	            // $flagValidation .= ' and tm_numerodoc = \''.$getNumeroDoc.'\'';

	            // $rsVal = $objCliente->Listar('VALID-'.$getTipoCliente, $flagValidation);
	            // $countRsVal = count($rsVal);

	            // if ($countRsVal <= 0){
                $_DATOS_EXCEL[$i]['idempresa'] = $IdEmpresa;
                $_DATOS_EXCEL[$i]['idcentro'] = $IdCentro;
                $_DATOS_EXCEL[$i]['idcodigo'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['nombres'] = trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['idcategoria'] = trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['idsubcategoria'] = trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['contenido'] = trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['peso'] = trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
                $_DATOS_EXCEL[$i]['foto'] = trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue());
                
                foreach($_DATOS_EXCEL as $campo => $valor){
                    $sqlInsertValues.= ' (\'';
                    foreach ($valor as $campo2 => $valor2){
                        $campo2 == 'nombre' ? $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2)))."', '1', '1', NOW(), '1', NOW()),\n" : $sqlInsertValues.= str_replace("'", "\'", trim(preg_replace('/\s+/', ' ', $valor2))).'\',\'';
                    }
                }
	            //}
	        }

	        $sqlInsertValues = substr($sqlInsertValues, 0, strlen(trim($sqlInsertValues)) - 1);

	        if (strlen($sqlInsertValues) > 0)
            	$objInsumo->MultiInsert($sqlInsertFields.$sqlInsertValues);
	    }

	    unlink($filename);
	}



	$jsondata = array('rpta' => $rpta, 'items_valid' => '');
    echo json_encode($jsondata);
	exit(0);
}
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" name="hdTipoData" id="hdTipoData" value="" />
	<div class="page-region without-appbar">
		<div class="generic-panel gp-no-header">
		    <div class="gp-body">
				<div class="grid">
					<div class="row">
						<div id="area">
							<input id="fileExcel" type="file" class="droparea spot" name="xfile" data-post="upload-excel.php" data-crop="true"/>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		    <div class="gp-footer">
		    	<button id="btnImportar" type="button" disabled="" class="command-button mode-add disabled">Importar datos</button>
		    </div>
	    </div>
	</div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script src="scripts/droparea.js"></script>
<script>
	$(function () {
		$('.droparea').droparea({
            'instructions': '<?php $translate->__('Arrastre el archivo o haga click aqu&iacute;'); ?>',
            'init' : function(result){
                //clearImagenForm();
            },
            'start' : function(area){
                area.find('.error').remove(); 
            },
            'error' : function(result, input, area){
            	$('<div class="error">').html(result.error).prependTo(area); 
                return 0;
            },
            'complete' : function(result, file, input, area){
                habilitarControl('#btnImportar', true);
                $('#btnImportar').removeClass('disabled');
                $('#hdFileExcel').val(result.filename);
            }
        });

        $('#btnImportar').on('click', function(event) {
        	event.preventDefault();
        	Importar();
        });
	});

	function Importar () {
		$.ajax({
            type: "POST",
            url: '?pag=<?php echo $pag; ?>&subpag=<?php echo $subpag; ?>',
            cache: false,
            data: $(form).serialize() + '&hdTipoData=' + $('#hdTipoData').val() + '&hdFileExcel=' + $('#hdFileExcel').val(),
            success: function(data){
                datos = eval( "(" + data + ")" );
                if (Number(datos.rpta) > 0){
                    MessageBox('<?php $translate->__('Datos importados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {

                    });
                }
            }
        });
	}
</script>