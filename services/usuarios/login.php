<?php
ini_set('display_errors', 1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../adata/Db.class.php';
    require '../../bussiness/usuarios.php';

    $rpta = 0;
    $sesion = new sesion();
    $usuario = new clsUsuario();
    
    $login = $_POST['login'];
    $password = $_POST['password'];

    $validUsuario = $usuario->loginUsuario($login, $password);

    if (count($validUsuario) > 0){
        if ($validUsuario[0]['Activo'] == '1'){
            $codigoperfil = $validUsuario[0]['codigoperfil'];
            $tipopersona = $validUsuario[0]['ta_tipopersona'];
            $sesion->set("idusuario", $validUsuario[0]['tm_idusuario']);
            $sesion->set("login", $validUsuario[0]['tm_login']);
            $sesion->set("nombres", $validUsuario[0]['tm_nombres'] . ' ' . $validUsuario[0]['tm_apellidos']);
            $sesion->set("idperfil", $validUsuario[0]['tm_idperfil']);
            $sesion->set("idpais", $validUsuario[0]['tp_idpais']);
            $sesion->set("idregion", $validUsuario[0]['IdRegion']);
            $sesion->set("codigoperfil", $codigoperfil);
            $sesion->set("foto", $validUsuario[0]['tm_foto']);
            $sesion->set("correo", $validUsuario[0]['tm_email']);
            $sesion->set("codigo", $validUsuario[0]['tm_codigo']);
            $sesion->set("tipopersona", $validUsuario[0]['ta_tipopersona']);
            $sesion->set("idpersona", $validUsuario[0]['tm_idpersona']);
            $sesion->set("codigo", $validUsuario[0]['tm_codigo']);
            $sesion->set("idempresa", $validUsuario[0]['tm_idempresa']);
            $sesion->set("idcentro", $validUsuario[0]['tm_idcentro']);
            $sesion->set("nombreempresa", $validUsuario[0]['nombreempresa']);
            $sesion->set("datos_preliminares", $validUsuario[0]['datos_preliminares']);
            $sesion->set("idusuario_plataforma", $validUsuario[0]['idusuario_plataforma']);
            $sesion->set("default_lang", $validUsuario[0]['tm_idioma']);

            if ($tipopersona == '00'){
                $url_index = '../../';
            }
            else {
                require '../../bussiness/centro.php';
                $objCentro = new clsCentro();
                $rsCentro = $objCentro->Listar('1', $sesion->get('idempresa'), '');
                $countCentro = count($rsCentro);

                if ($countCentro > 0){
                    $_multicentro = ($countCentro > 1) ? 1 : 0;

                    $rsCentro = $objCentro->Listar('2', $rsCentro[0]['tm_idcentro'], '');
                    $nombre_centro = (count($rsCentro) > 0) ? $rsCentro[0]['tm_nombre'] : 'Centro sin especificar';
                }
                else {
                    $_multicentro = 0;
                    $nombre_centro = 'Centro sin especificar';
                }

                $sesion->set("multicentro", $_multicentro);
                $sesion->set("nombre_centro", $nombre_centro);
                
                $url_index = $validUsuario[0]['datos_preliminares'] == 0 ? '../../preliminar.php' : '../../index.php';
            }
                
           header("location: " . $url_index); 
        }
        else
            header("location: ../../inactive-login.php");
    }
    else
        header("location: ../../failed-login.php");
}
?>