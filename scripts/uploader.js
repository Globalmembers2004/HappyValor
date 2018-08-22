$(function(){
    initUploader();

    $('#drop a').click(function(){
        $(this).parent().find('input').click();
    });

    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });
});

var numberFiles = 0;

function initUploader () {
    var ul;
    var folder = '';
    
    ul = $('#upload ul');
    folder = getParameterByName('folder');

    $('#upload').fileupload({
        formData: {
            folder: folder
        },
        dropZone: $('#drop'),
        add: function (e, data) {
            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){
                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });
            });

            numberFiles = numberFiles + 1;

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },
        progress: function(e, data){
            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');
            }
        },
        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
        },
        done: function (e, data) {
            numberFiles = numberFiles - 1;

            if (numberFiles == 0){
                //alert('fuck');
                window.parent.ListarArchivos(folder);
            };
        }
    });
}

function formatFileSize(bytes) {
    if (typeof bytes !== 'number') {
        return '';
    }

    if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
    }

    if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
    }

    return (bytes / 1000).toFixed(2) + ' KB';
}