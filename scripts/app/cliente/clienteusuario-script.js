$(function () {
    GetDataById($('#hdIdUsuario').val());

    $('#btnEditarClave').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalChangePassword');
    });

    $('#btnCambiarClave').on('click', function(event) {
        event.preventDefault();
        CambiarClave();
    });

    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        GuardarDatos();
    });
});

var screenmode = getParameterByName('screenmode');

function GetDataById (idData) {

    openModalCallBack('#modalRegistro', function () {
        $.ajax({
            url: 'services/usuarios/usuarios-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '4',
                idusuario: idData
            },
            success: function (data) {
                if (data.length > 0) {
                    var foto_original = data[0].tm_foto;
                    var foto_edicion = foto_original.replace("_o", "_s255");

                    $('#hdIdUsuario').val(data[0].tm_idusuario);
                    $('#txtNombre').val(data[0].tm_login);
                    $('#txtNombres').val(data[0].tm_nombres);
                    $('#txtApellidos').val(data[0].tm_apellidos);
                    $('#txtEmail').val(data[0].tm_email);
                    $('#txtTelefono').val(data[0].tm_telefono);

                    $("#ddlTipoPersona").val(data[0].ta_tipopersona);
                    $("#hdIdPersona").val(data[0].tm_idpersona);

                    $('#ddlPerfil').val(data[0].tm_idperfil);
                    $('#hdIdCentro').val(data[0].tm_idcentro);
                    if (foto_original != 'no-set')
                        setFoto(foto_edicion);
                    else
                        foto_edicion = 'images/user-nosetimg-233.jpg';

                    imgFoto.setAttribute('data-src', foto_edicion);
                    hdFoto.value = foto_original;

                    Materialize.updateTextFields();
                };
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
}

function GuardarDatos () {
    var data = new FormData();
    var input_data = $('#modalRegistro :input').serializeArray();
    var file = fileValue;

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdFoto', $('#hdFoto').val());
    data.append('archivo', file);

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/usuarios/usuarios-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            createSnackbar(data.titulomsje);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function LimpiarFormChangePassword () {
    $('#txtNewPassword').val('');
    $('#txtConfirmNewPassword').val('');
}

function CambiarClave () {
    var data = new FormData();
    var input_data = $('#modalChangePassword :input').serializeArray();

    data.append('btnCambiarClave', 'btnCambiarClave');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

     $.ajax({
        url: 'services/usuarios/usuarios-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0') {
                LimpiarFormChangePassword();
                closeCustomModal('#modalChangePassword');
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}