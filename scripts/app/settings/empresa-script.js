$(function () {
	 var foto_original = hdFoto.value;

	if (foto_original == 'no-set') {
	    imgFoto.classList.add('hide');
	    imgFoto.setAttribute('data-src', 'none');
	}
	else {
		var foto_edicion = foto_original.replace("_o", "_s640");
	    setFoto(foto_edicion);
	    imgFoto.classList.remove('hide');
	};

	$('#btnGuardar').on('click', function(event) {
		event.preventDefault();
		GuardarDatos();
	});

    addValidEmpresa();
});

var messagesValid = {
    txtNumeroDoc:{
        remote: "Este número de documento ya existe"
    },
    txtEmail: {
        email: 'Ingrese un correo electrónico válido',
        remote: "Este correo electrónico ya existe"
    }
};

function GuardarDatos () {
    if ($('#form1').valid()) {
        var data = new FormData();
        var file = fileValue;
        var input_data = $('#form1 :input').serializeArray();

        data.append('btnGuardar', 'btnGuardar');
        data.append('archivo', file);

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/empresa/empresa-post.php',
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
    };
}

function addValidEmpresa () {
    $('#txtNumeroDoc').rules('add', {
        required: true,
        minlength: 11,
        remote: {
            url:  'services/empresa/check-numerodoc.php',
            type: 'POST',
            data: {
                idregistro: function() {
                    return $('#hdIdPrimary').val();
                }
            }
        }
    });

    $('#txtRazonSocial').rules('add', {
        required: true
    });

    $('#txtDireccionFiscal').rules('add', {
        required: true
    });

    $('#txtNombreComercial').rules('add', {
        required: true
    });


    $('#txtEmail').rules('add', {
        required: true,
        email: true,
        remote: {
            url:  'services/empresa/check-email.php',
            type: 'POST',
            data: {
                idregistro: function() {
                    return $('#hdIdPrimary').val();
                }
            }
        }
    });
}