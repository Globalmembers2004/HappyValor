$(function () {
    if (top != self)
        top.location.replace(document.location);
    
	$(".fake-autofill-fields").show();
    window.setTimeout(function () {
        $(".fake-autofill-fields").hide();
    },1);

    $('#login').on('focus', function() {
        document.body.scrollTop = $(this).offset().top;
    });

    $('#password').on('focus', function() {
        document.body.scrollTop = $(this).offset().top;
    });

    $('#btnShowPass').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('amber darken-2')) {
            $(this).removeClass('amber darken-2');
            $('#password').attr('type', 'password');
        }
        else {
            $(this).addClass('amber darken-2');
            $('#password').attr('type', 'text');
        };
    });

    $('#btnShowPass__Clave').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('amber darken-2')) {
            $(this).removeClass('amber darken-2');
            $('#clave').attr('type', 'password');
        }
        else {
            $(this).addClass('amber darken-2');
            $('#clave').attr('type', 'text');
        };
    });

    $('#btnShowPass__Confirm').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('amber darken-2')) {
            $(this).removeClass('amber darken-2');
            $('#confirma_clave').attr('type', 'password');
        }
        else {
            $(this).addClass('amber darken-2');
            $('#confirma_clave').attr('type', 'text');
        };
    });

    $('#recomendador').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            BuscarRecomendador(this.value);
            return false;
        };
    });

	$('#chkTipoPersona').on('change', function(event) {
		event.preventDefault();
		
		if (this.checked) {
			$('#rowNatural').fadeOut(400, function() {
				$('#rowJuridico').fadeIn(400);
			});
		}
		else {
			$('#rowJuridico').fadeOut(400, function() {
				$('#rowNatural').fadeIn(400);
			});
		};

        $('#helperTipoPersona').text(this.checked ? 'SI' : 'NO');
	});

    $('#btnGoToLogin').on('click', function(event) {
        event.preventDefault();
        $('#pnlMain').fadeOut(400, function() {
            $('#pnlLogin').fadeIn(400, function() {
                
            });
        });
    });

 	$('#btnGoToRegister').on('click', function(event) {
 		event.preventDefault();
 		$('#pnlMain').fadeOut(400, function() {
 			$('#pnlRegister').fadeIn(400, function() {
 				$('#recomendador').focus();
 			});
 		});
 	});

 	$('#btnBackToLogin').on('click', function(event) {
 		event.preventDefault();
 		$('#pnlRegister').fadeOut(400, function() {
 			$('#pnlLogin').fadeIn(400, function() {
 				$('#username').focus();
 			});
 		});
 	});

 	$('#pnlRegister').validate({
        lang: 'es',
        rules: {
            username: {
                required: true,
                remote: 'services/usuarios/check-username.php'
            },
            nrodocumento: {
            	required: true,
                maxlength: 11,
                minlength: 8
            },
            clave: 'required',
            confirma_clave: {
                equalTo: '#clave'
            },
            firstname: {
            	required: function(element) {
            		return !$('#chkTipoPersona').is(':checked');
			    }
            },
            lastname: {
            	required: function(element) {
            		return !$('#chkTipoPersona').is(':checked');
			    }
            },
            business_name: {
            	required: '#chkTipoPersona:checked'
            },
            email: {
                required: true,
                email: true,
                remote: 'services/usuarios/check-email.php'
            }
        },
        messages: {
            username:{
                required: 'Ingrese su nombre de usuario',
                remote: "Este usuario ya existe"
            },
            email: {
                required: 'Ingrese su correo electrónico',
                email: 'Ingrese un correo electrónico válido',
                remote: "Este correo electrónico ya existe"
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement)
                $(placement).append(error);
            else
                error.insertAfter(element);
        },
        submitHandler: function(form) {
        	form.submit();
        }
    });
});

function BuscarRecomendador (codigo) {
    $('#hdIdRecomendador').val('0');
    $('#lblNombreRecomendador').text('');
    
    $.ajax({
        type: "GET",
        url: 'services/recomendacion/recomendador-codigo.php',
        cache: false,
        dataType: 'json',
        data: 'codigo=' + codigo,
        success: function (data) {
            if (data.length > 0){
                $('#hdIdRecomendador').val(data[0].idusuario);
                $('#lblNombreRecomendador').text(data[0].descripcion);
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}