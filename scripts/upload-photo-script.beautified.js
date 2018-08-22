$(function() {
    fileUploadImage.on("dragenter dragover", function(event) {
        event.stopPropagation();
        event.preventDefault();
    });
    fileUploadImage.on("change", function(event) {
        event.preventDefault();
        importFoto(this.files);
    });
    fileUploadImage.on("drop", function(event) {
        event.preventDefault();
        var files = event.dataTransfer.files;
        importFoto(files);
    });
    btnResetImage.on("click", function(event) {
        event.preventDefault();
        resetFoto("edit");
    });
});

var fileValue = false;

var imgFoto = document.getElementById("imgFoto");

var hdFoto = document.getElementById("hdFoto");

var btnResetImage = document.getElementById("btnResetImage");

var fileUploadImage = $("#fileUploadImage");

function resetFoto(mode_edit) {
    var photoDefault = "";
    if (mode_edit == "new") hdFoto.value = "no-set"; else hdFoto.value = imgFoto.getAttribute("data-src");
    if (imgFoto.getAttribute("data-update") == "initial" && imgFoto.getAttribute("src") != "images/user-nosetimg-233.jpg") {
        if (mode_edit != "new") {
            confirmar = confirm("¿Desea quitar esta imagen?");
            if (confirmar) {
                photoDefault = "images/user-nosetimg-233.jpg";
                hdFoto.value = "no-set";
            } else return false;
        }
    } else {
        if (imgFoto.getAttribute("data-update") == "initial") hdFoto.value = "no-set";
    }
    photoDefault = hdFoto.value == "no-set" ? "images/user-nosetimg-233.jpg" : imgFoto.getAttribute("data-src");
    setFoto(photoDefault);
    imgFoto.setAttribute("data-src", photoDefault);
    fileValue = false;
    fileUploadImage.val("");
    btnResetImage.addClass("hide");
}

function importFoto(files) {
    var imgOverlay = $(".imgoverlay");
    var preload = imgOverlay.find(".mdl-spinner");
    var allowedTypes = [ "jpg", "png", "jpeg", "gif" ];
    var extension = "";
    var filename = "";
    var oFReader = new FileReader();
    fileValue = files[0];
    filename = fileValue.name;
    oFReader.readAsDataURL(fileValue);
    extension = filename.split(".").pop().toLowerCase();
    if (inArray(extension, allowedTypes) == -1) {
        bootbox.dialog({
            message: "El tipo de archivo no es compatible para la importaci&oacute;n",
            title: "Extensi&oacute;n no v&aacute;lida",
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
    }
    imgOverlay.removeClass("hide");
    preload.addClass("is-active");
    oFReader.onload = function(oFREvent) {
        setFoto(oFREvent.target.result, "update");
    };
}

function setFoto(source, change) {
    var image = new Image();
    image.src = source;
    image.onload = function(event) {
        var imgOverlay = $(".imgoverlay");
        var preload = imgOverlay.find(".mdl-spinner");
        var img = event.currentTarget;
        var w = img.width;
        var h = img.height;
        var tw = imgFoto.parentNode.offsetWidth;
        var th = imgFoto.parentNode.offsetHeight;
        var result = ScaleImage(w, h, tw, th, false);
        change = typeof change !== "undefined" ? change : "initial";
        imgFoto.setAttribute("data-update", change);
        imgFoto.setAttribute("src", img.src);
        imgFoto.style.left = result.targetleft + "px";
        imgFoto.style.top = result.targettop + "px";
        imgFoto.style.width = result.width + "px";
        imgFoto.style.height = result.height + "px";
        hdFoto.value = source;
        imgOverlay.addClass("hide");
        preload.removeClass("is-active");
        if (change !== "initial") btnResetImage.removeClass("hide");
    };
}