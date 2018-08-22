$(function () {
    fileUploadImage.on('dragenter', function (event) {
        event.stopPropagation();
        event.preventDefault();
    });

    fileUploadImage.on('dragover', function (event) {
        event.stopPropagation();
        event.preventDefault();
    });

    fileUploadImage.on('change', function (event) {
        event.preventDefault();
        importFoto(this.files);
    });

    fileUploadImage.on('drop', function (event) {
        event.preventDefault();
        var files = event.originalEvent.dataTransfer.files;
        importFoto(files);
    });
    
    btnResetImage.on('click', function(event){
        event.preventDefault();
        resetFoto('edit');
    });
});

var fileValue = false;
var fileUploadImage = $('#fileUploadImage');
var hdFoto = document.getElementById('hdFoto');
var btnResetImage = $('#btnResetImage');
var imgFoto = document.getElementById('imgFoto');

function resetFoto (mode_edit) {
    if (mode_edit == 'new')
        hdFoto.value = 'no-set';
    else
        hdFoto.value = imgFoto.getAttribute('data-src');
    
    if (imgFoto.getAttribute('data-update') == 'initial'){
        if (mode_edit != 'new'){
            var return_edit = false;

            MessageBox({
                content: '¿Desea quitar esta imagen?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            hdFoto.value = 'no-set';
                            return_edit = true;
                        }
                    }
                ],
                cancelButton: true
            });

            return return_edit;
        };
    };

    imgFoto.src = '';
    imgFoto.classList.add('hide');
    imgFoto.setAttribute('data-src', 'none');
    imgFoto.setAttribute('data-update', 'initial');
    imgFoto.style.left = 0;
    imgFoto.style.top = 0;
    imgFoto.style.width = 'inherit';
    imgFoto.style.height = 'inherit';
    imgFoto.classList.remove('hide');

    fileValue = false;
    fileUploadImage.value = '';
    btnResetImage.addClass('oculto');
}

function importFoto (files) {
    var imgOverlay = $('.modal-example-overlay');
    var preload = imgOverlay.find('.mdl-spinner');
    var allowedTypes = ['jpg','png', 'jpeg', 'gif'];
    var extension = '';
    var filename = '';
    var oFReader = new FileReader();

    fileValue = files[0];
    filename = fileValue.name;
    oFReader.readAsDataURL(fileValue);

    extension = filename.split('.').pop().toLowerCase();

    if(inArray(extension, allowedTypes) == -1) {
        bootbox.dialog({
            message: 'El tipo de archivo no es compatible para la importaci&oacute;n',
            title: 'Extensi&oacute;n no v&aacute;lida',
            onEscape: function() {},
            show: true,
            backdrop: true,
            closeButton: true,
            animate: true,
            buttons: {
                success: {
                    label: "Ok",
                    className: "btn-success",
                    callback: function() {}
                }
            }
        });
        return false;
    };

    imgOverlay.removeClass('oculto');
    preload.addClass('active');

    oFReader.onload = function (oFREvent) {
        setFoto(oFREvent.target.result, 'update', url_base + '/' +filename);
    };
}

function setFoto (source, change, namefile) {
    var image = new Image();

    image.src = source;
    
    image.onload = function(event) {
        var imgOverlay = $('.modal-example-overlay');
        var preload = imgOverlay.find('.mdl-spinner');
        var img = event.currentTarget;
        var w = img.width;
        var h = img.height;
        var tw = imgFoto.parentNode.offsetWidth;
        var th = imgFoto.parentNode.offsetHeight;
        var result = ScaleImage(w, h, tw, th, false);

        change = typeof change !== 'undefined' ? change : 'initial';

        imgFoto.src = img.src;
        imgFoto.setAttribute('data-update', change);
        imgFoto.style.left = result.targetleft + 'px';
        imgFoto.style.top = result.targettop + 'px';
        imgFoto.style.width = result.width + 'px';
        imgFoto.style.height = result.height + 'px';
        imgFoto.classList.remove('hide');
        if (typeof namefile !== 'undefined') {
            console.log(img.src);
            hdFoto.value = namefile;
        };

        imgOverlay.addClass('oculto');
        preload.addClass('active');
        btnResetImage.removeClass('oculto');
    };
}