<?php 
require 'adata/Db.class.php';
require 'functions.php';

$scripts = '';
$path_URLEditService = '';
$path_URLListService = '';
/*** PATH MODULES ***/
$admin = "admin/";
$cliente = "cliente/";
$common = "common/";
$security = "security/";
$process = "process/";
$reports = "reports/";
$settings = "settings/";
/*******************/
/*** PATH VIEWS ***/
$views = "views/";
/*******************/
/*** NAMEPAGES ***/
/***** COMMON ***/
$p_home = "home.php";
$p_settings = "settings.php";
$p_reports = "reports.php";
$p_logout = "logout.php";
/******************/
/******ADMIN****/
$p_cambio = "cambio-$op.php";
$p_informes = "informes-$op.php";

$p_enlaces = "enlaces-$op.php";
$p_productos = "productos-$op.php";
$p_migtab = "imp-suministro-$op.php";
$p_migtabmen = "imp-mensual-$op.php";
$p_libroventas = "libroventas-$op.php";
$p_cliente = "cliente-$op.php";
$p_ventas = "imp-ventas-$op.php";
$p_rutinasocio = "rutinasocio-$op.php";
$p_seguimiento = "seguimiento-$op.php";
$p_claseseparada = "claseseparada-$op.php";
$p_dietagym = "dieta-$op.php";
$p_categories = "categories-$op.php";
$p_metas = "equilibrio-$op.php";
// $p_personal = "hierarchy-$op.php";
$p_personal = "personal-$op.php";

/******CLIENTE****/
$p_clientehorario = "clientehorario-$op.php";
$p_clienteclases = "clasescliente-$op.php";
$p_clienteevaluacion = "clienteevaluacion-$op.php";
$p_clienterutina = "clienterutina-$op.php";
$p_clientedieta = "clientedieta-$op.php";
$p_clienteusuario = "clienteusuario-$op.php";

$p_customers = "customers-$op.php";
$p_inventario = "inventario-$op.php";
$p_providers = "providers-$op.php";
$p_equipamiento = "equipo-$op.php";
$p_warehouse = "warehouse-$op.php";
$p_formapago = "formapago-$op.php";
$p_inputs   = "inputs-$op.php";
$p_areaventa    = "areaventa-$op.php";
$p_areaimpresion    = "areaimpresion-$op.php";
$p_categoryinput    = "categoryinput-$op.php";
$p_groups = "groups-$op.php";
$p_instructorgrupal = "instructorgrupal-$op.php";

$p_asistenciacliente = "asistenciacliente-$op.php";
$p_clasescliente = "clasescliente-$op.php";
$p_evaluacioncliente = "evaluacioncliente-$op.php";
$p_rutinacliente = "rutinacliente-$op.php";
$p_dietacliente = "dietacliente-$op.php";

/*/////////////////*/
/********PROCESS*******/
$p_sales = "sales-$op.php";
$p_bills = "bills-$op.php";
$p_menutoday = "programacion-$op.php";
$p_orders = "orders-$op.php";
$p_orders_customers = "gym-customers-$op.php";
$p_monitor = "monitor-display.php";
$p_cook = "cook-$op.php";
$p_buy = "buy-$op.php";
$p_kardex = "kardex-$op.php";
/*************/
/********REPORTS*******/
$p_repsales = "repsales.php";
$p_repbuy = "repbuy.php";
$p_repproductsales = "repproductssales.php";
/*************/
/********SECURITY*******/
$p_users = "users-$op.php";
$p_permissions = "access-$op.php";
/****************/
/********SETTINGS*******/
$p_empresa = "empresa.php";
$p_center = "center.php";
$p_hostpot = "hostpot.php";
$p_billticket = "billticket.php";
$p_cashlog = "cashlog.php";
$p_currency = "currency.php";
$p_waypay = "waypay.php";
$p_duty = "duty.php";
$p_documents = "documents.php";
$p_randomcode = "randomcode.php";
$p_filing = "filing.php";
$p_services = "services.php";
$p_unitmeasure = "unitmeasure.php";
$p_worksarea = "worksarea.php";
$p_tipofamilia = "tipofamilia.php";
$p_accesosdirectos = "accesosdirectos.php";
$p_geopolitics = "geopolitics.php";
$p_upexcel = "upexcel.php";
$p_tipoambiente = "tipoambiente.php";
$p_periodo = "periodo.php";
$p_centro_costo = "centrocosto.php";
$p_ctactb = "ctactb.php";
$p_enlace = "enlace.php";
$p_familia = "familia.php";

/****************/
$pathview = "";
$subcontent = "";
$pathcontroller = "";

if ($pag == "inicio"){
    $scripts = '<script src="scripts/underscore-min.js"></script><script src="scripts/html2canvas.min.js"></script><script src="scripts/app/common/home.js"></script>';
    if ($tipopersona != '00')
        $scripts .= '<script>$(function () { ListarOcionesMenu(); });</script>';

    $pathview = $common.$p_home;
}
elseif ($pag == "admin") {
    if ($subpag == "claseseparada") {
        $subcontent = $p_claseseparada;
        $scripts = '<script src="scripts/underscore-min.js"></script><script src="scripts/app/admin/claseseparada-script.js"></script>';
    }
    elseif ($subpag == "productos"){
        $subcontent = $p_productos;
        $scripts = '<script src="scripts/app/admin/productos-script.js"></script>';
    }
    elseif ($subpag == "imp-suministro"){
        $subcontent = $p_migtab;
        $scripts = '<script src="scripts/app/admin/imp-suministro-script.js"></script>';
    }
    elseif ($subpag == "imp-mensual"){
        $subcontent = $p_migtabmen;
        $scripts = '<script src="scripts/app/admin/imp-mensual-script.js"></script>';
    }
    elseif ($subpag == "inventario"){
        $subcontent = $p_inventario;
        $scripts = '<script src="scripts/app/admin/inventario-script.js"></script>';
    }
    elseif ($subpag == "personal"){
        $subcontent = $p_personal;
        $scripts = '<script src="scripts/mdl-selectfield.js"></script><script src="scripts/scale-image.js"></script><script src="scripts/upload-photo-script.js"></script><script src="scripts/app/admin/personal-script.js"></script>';
    }
    elseif ($subpag == "proveedores"){
        $subcontent = $p_providers;
        $scripts = '<script src="scripts/scale-image.min.js"></script><script src="scripts/upload-photo-script.min.js"></script><script src="scripts/app/admin/proveedores-script.js"></script>';
    }
    elseif ($subpag == "equipamiento"){
        $subcontent = $p_equipamiento;
        $scripts = '<script src="scripts/scale-image.js"></script><script src="scripts/upload-photo-script.js"></script><script src="scripts/app/admin/equipo-script.js"></script>';
    }
    elseif ($subpag == "dieta"){
        $subcontent = $p_dietagym;
        $scripts = '<script src="scripts/scale-image.min.js"></script><script src="scripts/upload-photo-script.min.js"></script><script src="scripts/app/admin/dieta-script.js"></script>';
    }
    elseif ($subpag == "imp-ventas"){
        $subcontent = $p_ventas;
        $scripts = '<script src="scripts/app/admin/imp-ventas-script.js"></script>';
    }
    elseif ($subpag == "cliente"){
        $subcontent = $p_cliente;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/jquery/jquery.ui.datepicker-es.js"></script><script src="scripts/scale-image.min.js"></script><script src="scripts/upload-photo-script.min.js"></script><script src="scripts/app/admin/cliente-script.js"></script>';
    }
     elseif ($subpag == "equilibrio"){
        $subcontent = $p_metas;
        $scripts = '<script type="text/javascript" src="plugins/canvas/canvasjs.min.js"></script><script src="scripts/app/admin/equilibrio-script.js"></script>';
    }
    elseif ($subpag == "productos"){
        $subcontent = $p_productos;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/jquery/jquery.ui.datepicker-es.js"></script><script src="scripts/scale-image.min.js"></script><script type="text/javascript" src="plugins/canvas/canvasjs.min.js"></script><script src="scripts/app/admin/productos-script.js"></script>';
    }
    elseif ($subpag == "libroventas"){
        $subcontent = $p_libroventas;
        $scripts = '<script type="text/javascript" src="plugins/canvas/canvasjs.min.js"></script><script src="scripts/app/admin/libroventas-script.js"></script>';
    }

    elseif ($subpag == "enlaces"){
        $subcontent = $p_enlaces;
        $scripts = '<script type="text/javascript" src="plugins/canvas/canvasjs.min.js"></script><script src="scripts/app/admin/enlaces-script.js"></script>';
    }
    elseif ($subpag == "informes"){
        $subcontent = $p_informes;
        $scripts = '<script type="text/javascript" src="plugins/canvas/canvasjs.min.js"></script><script src="scripts/app/admin/informes-script.js"></script>';
    }

    elseif ($subpag == "seguimiento"){
        $subcontent = $p_seguimiento;
        $scripts = '<script src="scripts/app/admin/seguimiento-script.js"></script>';
    }
    elseif ($subpag == "instructorgrupal"){
        $subcontent = $p_instructorgrupal;
        $scripts = '<script src="scripts/scale-image.js"></script><script src="scripts/upload-photo-script.js"></script><script src="scripts/app/admin/instructorgrupal-script.js"></script>';
    }
    elseif ($subpag == "asistenciacliente"){
        $subcontent = $p_asistenciacliente;
        $scripts = '<script src="scripts/app/admin/asistenciacliente-script.js"></script>';
    }
    elseif ($subpag == "clasescliente"){
        $subcontent = $p_clasescliente;
        $scripts = '<script src="scripts/app/admin/clasescliente-script.js"></script>';
    }
    elseif ($subpag == "evaluacioncliente"){
        $subcontent = $p_evaluacioncliente;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/app/admin/evaluacioncliente-script.js"></script>';
    }
    elseif ($subpag == "rutinacliente"){
        $subcontent = $p_rutinacliente;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/app/admin/rutinacliente-script.js"></script>';
    }
    elseif ($subpag == "dietacliente"){
        $subcontent = $p_dietacliente;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/app/admin/dietacliente-script.js"></script>';
    }
    elseif ($subpag == "almacen")
        $subcontent = $p_warehouse;
    elseif ($subpag == "insumos"){
        $subcontent = $p_inputs;
        $scripts = '<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script><script src="scripts/app/admin/insumos-script.js"></script>';
    }
    $pathview = $admin.$subcontent;
}
elseif ($pag == "cliente") {
    if ($subpag == "evaluacioncliente"){
        $subcontent = $p_evaluacioncliente;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/app/admin/evaluacioncliente-script.js"></script>';

        $pathview = $admin.$subcontent;        
    }
    elseif ($subpag == "clasescliente") {
        $subcontent = $p_clasescliente;
        $scripts = '<script src="scripts/app/admin/clasescliente-script.js"></script>';

        $pathview = $admin.$subcontent;
    }
    elseif ($subpag == "dietacliente"){
        $subcontent = $p_dietacliente;
        $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="scripts/app/admin/dietacliente-script.js"></script>';
        
        $pathview = $admin.$subcontent;
    }
    else {
        if ($subpag == "horariocliente") {
            $subcontent = $p_clientehorario;
            $scripts = '<script src="scripts/app/cliente/clientehorario-script.js"></script>';
        }
        elseif ($subpag == "rutinacliente"){
            $subcontent = $p_clienterutina;
            $scripts = '<script src="scripts/app/cliente/clienterutina-script.js"></script>';
        }
        
        elseif ($subpag == "usuariocliente"){
            $subcontent = $p_clienteusuario;
            $scripts = '<script src="scripts/scale-image.min.js"></script><script src="scripts/upload-photo-script.min.js"></script><script src="scripts/app/cliente/clienteusuario-script.js"></script>';
        }
        $pathview = $cliente.$subcontent;
    }
}
elseif ($pag == "procesos") {
	if ($subpag == "atencion"){
        if ($screenmode == 'cliente') {
            $subcontent = $p_orders_customers;
            $scripts = '<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCVoEKRg3FeajtqDppLEVar2AosegyHW8&libraries=geometry&language=es&sensor=true"></script><script src="scripts/underscore-min.js"></script><script src="scripts/spinner.js"></script><script src="scripts/swipe__listitem.js"></script><script src="scripts/app/process/orders-customers-script.js"></script>';
        }
        else {
            $subcontent = $p_orders;
            $scripts = '<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCVoEKRg3FeajtqDppLEVar2AosegyHW8&libraries=geometry&language=es"></script><script src="scripts/underscore-min.js"></script><script src="scripts/app/process/orders-script.js"></script>';
        }
    }
    elseif ($subpag == "ventas"){
        $subcontent = $p_sales;
        $scripts = '<script src="scripts/app/process/sales-script.min.js"></script>';
    }
    elseif ($subpag == "compras"){
        $subcontent = $p_buy;
        $scripts = '<script src="scripts/underscore-min.js"></script><script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script><script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="plugins/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script><script src="scripts/app/process/buy-script.js"></script>';
    }
    elseif ($subpag == "kardex")
        $subcontent = $p_kardex;
    elseif ($subpag == "monitor"){
        $subcontent = $p_monitor;
        $scripts = '<script src="scripts/underscore-min.js"></script><script src="http://www.youtube.com/iframe_api"></script><script src="scripts/app/process/monitor-display-script.js"></script>';
    }
    elseif ($subpag == "cocina"){
        $subcontent = $p_cook;
        $scripts = '<script src="scripts/underscore-min.js"></script><script src="scripts/app/process/cook-script.js"></script>';
    }
    
	$pathview = $process.$subcontent;
}
elseif ($pag == "reports") {
    if (strlen(trim($subpag)) == 0){
        $pathview = $common.$p_reports;
        $scripts = '<script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script><script src="scripts/underscore-min.js"></script><script src="plugins/jquery-ui/js/jquery.ui.datepicker-es.js"></script><script src="scripts/app/reports/reports-script.js"></script>';
    }
    else {
        if ($subpag == "ventas")
            $subcontent = $p_repsales;
        elseif ($subpag == "compras")
            $subcontent = $p_repbuy;
        elseif ($subpag == "productos")
            $subcontent = $p_repproductsales;
        $pathview = $reports.$subcontent;
    }
}
elseif ($pag == "seguridad") {
	if ($subpag == "usuarios"){
		$subcontent = $p_users;
        $scripts = '<script src="scripts/scale-image.min.js"></script><script src="scripts/upload-photo-script.min.js"></script><script src="plugins/easy-autocomplete/js/jquery.easy-autocomplete.js"></script><script src="scripts/app/security/users-script.js"></script>';
    }
    else if ($subpag == "permisos"){
		$subcontent = $p_permissions;
        $scripts = '<script src="scripts/app/security/perfil-script.js"></script>';
    }
	$pathview = $security.$subcontent;
}
elseif ($pag == "settings"){
    if (strlen(trim($subpag)) == 0){
        $pathview = $common.$p_settings;
        $scripts = '<script src="scripts/app/settings/settings-script.js"></script>';
    }
    else {
        if ($subpag == 'empresa'){
            $subcontent = $p_empresa;
            $scripts = '<script src="scripts/scale-image.js"></script><script src="scripts/upload-photo-script.js"></script><script src="scripts/app/settings/empresa-script.js"></script>';
        }
        elseif ($subpag == 'centro'){
            $subcontent = $p_center;
            $scripts = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCVoEKRg3FeajtqDppLEVar2AosegyHW8&language=es"></script><script src="scripts/app/settings/centro-script.js"></script>';
        }
        elseif ($subpag == 'terminal'){
            $subcontent = $p_hostpot;
            $scripts = '<script src="scripts/app/settings/hostpot-script.js"></script>';
        }
        elseif ($subpag == 'tipo-comprobante'){
            $subcontent = $p_billticket;
            $scripts = '<script src="scripts/app/settings/billticket-script.js"></script>';
        }
        elseif ($subpag == 'tipomovcaja'){
            $subcontent = $p_cashlog;
            $scripts = '<script src="scripts/app/settings/cashlog-script.js"></script>';
        }
        elseif ($subpag == 'moneda'){
            $subcontent = $p_currency;
            $scripts = '<script src="scripts/app/settings/currency-script.js"></script>';
        }
        elseif ($subpag == 'forma-pago'){
            $subcontent = $p_waypay;
            $scripts = '<script src="scripts/app/settings/waypay-script.js"></script>';
        }
        elseif ($subpag == 'impuestos'){
            $subcontent = $p_duty;
            $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="plugins/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script><script src="scripts/app/settings/duty-script.js"></script>';
        }
        elseif ($subpag == 'documentos'){
            $subcontent = $p_documents;
            $scripts = '<script src="scripts/app/settings/documents-script.js"></script>';
        }
        elseif ($subpag == 'presentaciones'){
            $subcontent = $p_filing;
            $scripts = '<script src="scripts/app/settings/filing-script.js"></script>';
        }
        elseif ($subpag == 'servicios'){
            $subcontent = $p_services;
            $scripts = '<script src="scripts/app/settings/services-script.js"></script>';
        }
        elseif ($subpag == 'unidadmedida'){
            $subcontent = $p_unitmeasure;
            $scripts = '<script src="scripts/app/settings/unitmeasure-script.js"></script>';
        }
        elseif ($subpag == 'areas-trabajo'){
            $subcontent = $p_worksarea;
            $scripts = '<script src="scripts/app/settings/worksarea-script.js"></script>';
        }
        elseif ($subpag == 'tipofamilia'){
            $subcontent = $p_tipofamilia;
            $scripts = '<script src="scripts/app/settings/tipofamilia-script.js"></script>';
        }
        elseif ($subpag == 'periodo'){
            $subcontent = $p_periodo;
            $scripts = '<script src="plugins/datetimepicker/moment-with-locales.min.js"></script><script src="plugins/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script><script src="scripts/app/settings/periodo-script.js"></script>';
        }
        elseif ($subpag == 'centrocosto'){
            $subcontent = $p_centro_costo;
            $scripts = '</script><script src="scripts/app/settings/centrocosto-script.js"></script>';
        }
        elseif ($subpag == 'familia'){
            $subcontent = $p_familia;
            $scripts = '</script><script src="scripts/app/settings/familia-script.js"></script>';
        }
        elseif ($subpag == 'tipoambiente'){
            $subcontent = $p_tipoambiente;
            $scripts = '<script src="scripts/app/settings/tipoambiente-script.js"></script>';
        }
        elseif ($subpag == 'ctactb'){
            $subcontent = $p_ctactb;
            $scripts = '<script src="scripts/app/settings/ctactb-script.js"></script>';
        }
        elseif ($subpag == 'enlace'){
            $subcontent = $p_enlace;
            $scripts = '<script src="scripts/app/settings/enlace-script.js"></script>';
        }

        elseif ($subpag == 'accesosdirectos'){
            $subcontent = $p_accesosdirectos;
            $scripts = '<script src="scripts/app/settings/accesosdirectos-script.js"></script>';
        }
        elseif ($subpag == 'ubicaciones')
            $subcontent = $p_geopolitics;
        elseif ($subpag == 'subirexcel')
            $subcontent = $p_upexcel;
        $pathview = $settings.$subcontent;   
    }
}

if ($pathview != "") {
	$pathview = $views.$pathview;
	include($pathview);
}
?>
<div class="modal-example-overlay" style="display:none;"></div>
<div class="buttonfab-overlay" style="display:none;"></div>
<div class="overlay-charm" style="display:none;"></div>

<span id="spnIdPerfil" class="oculto"><?php echo $idperfil; ?></span>
<input type="hidden" name="hdCodigoPerfil" id="hdCodigoPerfil" value="<?php echo $codigoperfil; ?>">
<input type="hidden" name="hdIdRegion" id="hdIdRegion" value="<?php echo $idregion; ?>">
<input type="hidden" name="hdNombrePersonal" id="hdNombrePersonal" value="<?php echo $login; ?>">

<script src="scripts/config-menus.min.js"></script>
<script src="scripts/jquery/jquery-2.1.3.min.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
<script src="plugins/jquery-ui/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<?php 
// <script>
//   $.widget.bridge('uibutton', $.ui.button);
// </script>
 ?>
<script src="scripts/jquery/jquery.widget.min.js"></script>
<script src="scripts/jquery/jquery.mousewheel.min.js"></script>
<script src="plugins/materialize/js/materialize.min.js"></script>
<script src="scripts/material.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/bootbox/js/bootbox.min.js"></script>
<script src="scripts/datalist-jquery.js"></script>
<script src="scripts/jquery.numeric.min.js"></script>
<script src="plugins/jquery-validate/jquery.validate.min.js"></script>
<script src="plugins/jquery-validate/additional-methods.min.js"></script>
<script src="plugins/jquery-validate/localization/messages_es.min.js"></script>
<script src="scripts/functions-jquery.js"></script>
<script src="scripts/WebNotifications.min.js"></script>
<script src="plugins/snackbar/js/snackbar.min.js"></script>
<script src="scripts/app/common/contents-jquery.js"></script>
<?php echo $scripts; ?>