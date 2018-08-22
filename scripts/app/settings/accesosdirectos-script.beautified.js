$(function() {
    $("#navAccesos").on("click", "a", function(event) {
        event.preventDefault();
        $(this).siblings(".btn-primary").removeClass("btn-primary").addClass("btn-default");
        $(this).addClass("btn-primary");
        navigateInFrame(this);
    }).find("a:first").trigger("click");
});

function navigateInPage(alink) {
    var idmenu = alink.getAttribute("data-idmenu");
    var modulo = alink.getAttribute("data-modulo");
    var submodulo = alink.getAttribute("data-submodulo");
    var innerIframe = $("iframe:visible")[0];
    var contentIframe = innerIframe.contentDocument.body;
    $(".page", contentIframe).addClass("hide");
    $(modulo, contentIframe).removeClass("hide");
    var iframeDocument = innerIframe.document || innerIframe.contentWindow;
    if (typeof iframeDocument.getDataByReference !== "undefined") {
        iframeDocument.getDataByReference(modulo);
    }
    if (typeof iframeDocument.ListarOpcionesDropdown !== "undefined") iframeDocument.ListarOpcionesDropdown(idmenu);
    if (typeof iframeDocument.navigateSubSite !== "undefined") iframeDocument.navigateSubSite(submodulo, $(alink).text());
}

function navigateInFrame(alink) {
    var url = alink.getAttribute("href");
    var tab = alink.getAttribute("data-tab");
    var tagIframe = '<iframe data-tab="' + tab + '" src="' + url + '" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>';
    $(".panels iframe").hide();
    if ($('.panels > iframe[data-tab="' + tab + '"]').length == 0) {
        precargaExp("#pnlAccesosDirectos", true);
        $(tagIframe).appendTo(".panels").load(function() {
            precargaExp("#pnlAccesosDirectos", false);
            navigateInPage(alink);
        });
    } else {
        $('.panels > iframe[data-tab="' + tab + '"]').show();
        navigateInPage(alink);
    }
}