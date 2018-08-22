<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require "../../common/sesion.class.php";
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../common/functions.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $realIp = getRealIP();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'lang';

    $translate = new Translator($lang);
    
    if (isset($_POST['btnCrearCuentaCorriente'])) {
        require '../../bussiness/cuentacorriente.php';
        $objCuentaCorriente = new clsCuentaCorriente();
        $idmoneda = 0;

        $objCuentaCorriente->Registrar(0, $IdEmpresa, $IdCentro, $hdIdCliente, $idmoneda, $facturado, $cancelado, $saldo, $idusuario, $rpta, $titulomsje, $contenidomsje);

    }
    // elseif (isset($_POST['btnCobrarDeuda'])) {
    //     require '../../bussiness/cobranza.php';
    //     $objCobranza = new clsCobranza();

    //     $hdIdCobranza = isset($_POST['hdIdCobranza']) ? $_POST['hdIdCobranza'] : '0';
    //     $hdIdCuentaCorriente = isset($_POST['hdIdCuentaCorriente']) ? $_POST['hdIdCuentaCorriente'] : '0';
    //     $txtImportePago = isset($_POST['txtImportePago']) ? $_POST['txtImportePago'] : '0';
    //     $txtFechaPago = isset($_POST['txtFechaPago']) ? $_POST['txtFechaPago'] : '0';

    //     $objCobranza->Registrar($hdIdCobranza, $hdIdCuentaCorriente, $txtImportePago, $txtFechaPago, $idusuario, $rpta, $titulomsje, $contenidomsje);
    // }
    else {
        require '../../bussiness/clientes.php';
        $objCliente = new clsCliente();

        if (isset($_POST['btnGuardar'])){
            $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
            $hdIdContactoEmpresa = (isset($_POST['hdIdContactoEmpresa'])) ? $_POST['hdIdContactoEmpresa'] : '0';
            $hdTipoCliente = (isset($_POST['hdTipoCliente'])) ? $_POST['hdTipoCliente'] : 'NA';
            $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';
            $ddlTipoDocNatural = (isset($_POST['ddlTipoDocNatural'])) ? $_POST['ddlTipoDocNatural'] : '0';
            $txtNroDocNatural = isset($_POST['txtNroDocNatural']) ? $_POST['txtNroDocNatural'] : '';
            $txtApePaterno = isset($_POST['txtApePaterno']) ? $_POST['txtApePaterno'] : '';
            $txtApeMaterno = isset($_POST['txtApeMaterno']) ? $_POST['txtApeMaterno'] : '';
            $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
            $txtDireccionNatural = isset($_POST['txtDireccionNatural']) ? $_POST['txtDireccionNatural'] : '';
            $txtTelefonoNatural = isset($_POST['txtTelefonoNatural']) ? $_POST['txtTelefonoNatural'] : '';
            $txtEmailNatural = isset($_POST['txtEmailNatural']) ? $_POST['txtEmailNatural'] : '';
            $ddlPaisNatural = isset($_POST['ddlPaisNatural']) ? $_POST['ddlPaisNatural'] : '0';
            $ddlRegionNatural = isset($_POST['ddlRegionNatural']) ? $_POST['ddlRegionNatural'] : '0';
            
            $ddlTipoDocJuridica = (isset($_POST['ddlTipoDocJuridica'])) ? $_POST['ddlTipoDocJuridica'] : '0';
            $txtRucEmpresa = isset($_POST['txtRucEmpresa']) ? $_POST['txtRucEmpresa'] : '';
            $txtRazonSocial = isset($_POST['txtRazonSocial']) ? $_POST['txtRazonSocial'] : '';
            $txtRepresentante = isset($_POST['txtRepresentante']) ? $_POST['txtRepresentante'] : '';
            $txtDireccionEmpresa = isset($_POST['txtDireccionEmpresa']) ? $_POST['txtDireccionEmpresa'] : '';
            $txtTelefonoEmpresa = isset($_POST['txtTelefonoEmpresa']) ? $_POST['txtTelefonoEmpresa'] : '';
            $txtEmailEmpresa = isset($_POST['txtEmailEmpresa']) ? $_POST['txtEmailEmpresa'] : '';
            $txtWebEmpresa = isset($_POST['txtWebEmpresa']) ? $_POST['txtWebEmpresa'] : '0';
            $ddlPaisEmpresa = isset($_POST['ddlPaisEmpresa']) ? $_POST['ddlPaisEmpresa'] : '0';
            $ddlRegionEmpresa = isset($_POST['ddlRegionEmpresa']) ? $_POST['ddlRegionEmpresa'] : '0';

            $IdDocIdent = ($hdTipoCliente == 'JU') ? $ddlTipoDocJuridica : $ddlTipoDocNatural;
            $NroDocIdent = ($hdTipoCliente == 'JU') ? $txtRucEmpresa : $txtNroDocNatural;
            $Direccion = ($hdTipoCliente == 'JU') ? $txtDireccionEmpresa : $txtDireccionNatural;
            $Telefono = ($hdTipoCliente == 'JU') ? $txtTelefonoEmpresa : $txtTelefonoNatural;
            $Email = ($hdTipoCliente == 'JU') ? $txtEmailEmpresa : $txtEmailNatural;
            $IdPais = ($hdTipoCliente == 'JU') ? $ddlPaisEmpresa : $ddlPaisNatural;
            $IdRegion = ($hdTipoCliente == 'JU') ? $ddlRegionEmpresa : $ddlRegionNatural;

            $chkCrearUsuario = isset($_POST['chkCrearUsuario']) ? $_POST['chkCrearUsuario'] : '0';

            // $ddlTipoDocUE = (isset($_POST['ddlTipoDocUE'])) ? $_POST['ddlTipoDocUE'] : '0';
            // $txtNroDocUE = isset($_POST['txtNroDocUE']) ? $_POST['txtNroDocUE'] : '';
            // $txtApePaternoUE = isset($_POST['txtApePaternoUE']) ? $_POST['txtApePaternoUE'] : '';
            // $txtApeMaternoUE = isset($_POST['txtApeMaternoUE']) ? $_POST['txtApeMaternoUE'] : '';
            // $txtNombresUE = isset($_POST['txtNombresUE']) ? $_POST['txtNombresUE'] : '';
            // $txtEmailUE = isset($_POST['txtEmailUE']) ? $_POST['txtEmailUE'] : '';
            // $ddlPaisUE = isset($_POST['ddlPaisUE']) ? $_POST['ddlPaisUE'] : '';

            // if (empty($_FILES['archivo']['name'])) {
            //     $urlLogo = $hdFoto;
            // }
            // else {
            //     $upload_folder  = '../../media/images/';
            //     $url_folder  = 'media/images/';

            //     $nombre_archivo = $_FILES['archivo']['name'];
            //     $tipo_archivo = $_FILES['archivo']['type'];
            //     $tamano_archivo = $_FILES['archivo']['size'];
            //     $tmp_archivo = $_FILES['archivo']['tmp_name'];

            //     $nombre_archivo = trim($nombre_archivo);
            //     $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            //     $archivador = $upload_folder.$nombre_archivo;

            //     if (move_uploaded_file($tmp_archivo, $archivador)) {
            //         $urlLogo = $url_folder.$nombre_archivo;
            //     }
            //     else {
            //         $urlLogo = $hdFoto;
            //     }
            // }

            if (empty($_FILES['archivo']['name'])) {
                $urlFoto = $hdFoto;
            }
            else {
                $upload_folder  = '../../media/avatar/'.$IdEmpresa.'_'.$IdCentro.'/';
                $url_folder  = 'media/avatar/'.$IdEmpresa.'_'.$IdCentro.'/';

                if (!is_dir($upload_folder))
                    mkdir($upload_folder);

                $nombre_archivo = $_FILES['archivo']['name'];
                $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
                $tipo_archivo = $_FILES['archivo']['type'];
                $tamano_archivo = $_FILES['archivo']['size'];
                $tmp_archivo = $_FILES['archivo']['tmp_name'];

                $original = $upload_folder.generateRandomString().'_o.'.$extension;

                $size42 = str_replace('_o', '_s42', $original);
                $size255 = str_replace('_o', '_s255', $original);
                $size640 = str_replace('_o', '_s640', $original);

                if (move_uploaded_file($tmp_archivo, $original)) {
                    make_thumb($original, $size42, 42);
                    make_thumb($original, $size255, 255);
                    make_thumb($original, $size640, 640);

                    $urlFoto = str_replace($upload_folder, $url_folder, $original);
                }
                else {
                    $urlFoto = $hdFoto;
                }
            }
            
            $objCliente->Registrar($hdTipoCliente, $hdIdPrimary, $IdEmpresa, $IdCentro, 1, $IdDocIdent, $NroDocIdent, $txtRazonSocial, $txtRepresentante, $txtNombres, $txtApePaterno, $txtApeMaterno, $Direccion, $Telefono, '', $Email, $urlFoto, $txtWebEmpresa, $IdPais, $IdRegion, $idusuario, $rpta, $titulomsje, $contenidomsje);

            if ($rpta > 0){
                if ($chkCrearUsuario != '0') {
                    require '../../bussiness/usuarios.php';
                    require '../../bussiness/perfil.php';
                    
                    $objUsuario = new clsUsuario();
                    $objPerfil = new clsPerfil();
                    
                    $rsUsuario = $objUsuario->IfExists__UsuarioPersona('00', $rpta);
                    $countUsuario = $rsUsuario[0]['CountUsuario'];

                    if ($countUsuario == 0) {
                        $rsPerfil = $objPerfil->GetPerfil__PorCodigo('PRF00006');
                        $countPerfil = count($rsPerfil);

                        if ($countPerfil > 0) {
                            $IdPerfil_Cliente = $rsPerfil[0]['tm_idperfil'];
                            
                            if ($hdTipoCliente == 'JU'){
                                $nombres = $txtRazonSocial;
                                $apellidos = '';
                                $nrodni = '';
                                $nroruc = $NroDocIdent;

                                $nombre_completo = $nombres;

                                $_esempresa = 1;
                            }
                            else {
                                $nombres = $txtNombres;
                                $apellidos = $txtApePaterno . ' ' . $txtApeMaterno;
                                $nrodni = $NroDocIdent;
                                $nroruc = '';

                                $nombre_completo = $nombres . ' ' . $apellidos;

                                $_esempresa = 0;
                            }

                            mt_srand(time());
                            $rand = mt_rand(1000000,9999999);

                            $codigo = $IdPerfil_Cliente.$rpta.$IdEmpresa.$IdCentro.$hdIdPrimary;
                            $login = $codigo . substr($nombres, 0, 3) . substr($apellidos, 0, 3);
                            $clave = $login . $rand;

                            $user_rpta = '0';
                            $user_titulomsje = '';
                            $user_contenidomsje = '';
                            
                            $objUsuario->Registrar_Plataforma__StandAlone($rpta, $login, $clave, $_esempresa, $IdRegion, $NroDocIdent, $txtRazonSocial, $txtNombres, $apellidos, $Email, $idusuario, $user_rpta, $user_titulomsje, $user_contenidomsje);

                            if ($user_rpta > 0) {
                                $objUsuario->Registrar('0', $IdEmpresa, $IdCentro, $IdPerfil_Cliente, $rpta, '00', $NroDocIdent, $login, $nombres, $apellidos, $clave, '00', $nrodni, $nroruc, $IdPais, $Direccion, $Email, $Telefono, $urlFoto, 'CLIENTES', $user_rpta, $user_rpta, $user_titulomsje, $user_contenidomsje);

                                if ($user_rpta > 0) {
                                    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

                                    $subject = '=?UTF-8?B?'.base64_encode($nombre_completo . ", tu cuenta de Tambo está casi lista!").'?=';

                                    $message = '<html><head>';
                                    $message .= '</head><body>';
                                    $message .= '<p>Hola, ' . ucfirst($nombre_completo) . ', su cuenta de Tambo está casi lista, sólo falta un paso más para verificarla, para hacerlo haga click en el siguiente enlace: </p>';
                                    $message .= '<a class="btn btn-primary btn-lg center-block" href="'.$root.'/regconfirm.php?iuser=' . $login . '&ipass=' . $clave . '" target="_blank" role="button">Ir a Tamboapp.com</a>';
                                    $message .= '</div></body></html>';

                                    require '../../common/PHPMailerAutoload.php';
                                    require '../../common/simply_email.php';

                                    $objEmail = new clsSimplyEmail();
                                    $resultMail = $objEmail->EnvioEmail('info@tamboapp.com', $Email, $subject, $message, false, false);
                                }
                            }
                        }
                    }
                }
            }

            // if ($hdTipoCliente == 'JU'){
            //     if ($rpta > 0){
            //         $objCliente->RegistrarContactoEmpresa($hdIdContactoEmpresa, $rpta, $ddlTipoDocUE, $txtNroDocUE, $txtNombresUE, $txtApePaternoUE, $txtApeMaternoUE, $txtEmailUE, $ddlPaisUE, $idusuario);
            //     }
            // }
        }
        elseif (isset($_POST['btnEliminar'])) {
            /*$chkItem = $_POST['chkItem'];
            if (isset($chkItem)){
                if (is_array($chkItem)) {
                    $countCheckItems = count($chkItem);
                    $strListItems = implode(',', $chkItem);
                    $objCliente->MultiDelete($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
                }
            }*/
            $hdIdCliente = $_POST['hdIdCliente'];
            $rpta = $objCliente->EliminarStepByStep($hdIdCliente, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
    }
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>