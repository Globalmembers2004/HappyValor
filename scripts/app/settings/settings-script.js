$(function(){
	$('.collection').on('click', 'a', function (event) {
		event.preventDefault();

		$(this).siblings('.active').removeClass('active');
		$(this).addClass('active');
		
		navigateInFrame(this);
	}).find('a:first').trigger('click');
});

function navigateInFrame (alink) {	
	var url = alink.getAttribute('href');
	var tab = alink.getAttribute('data-tab');

	var tagIframe = '<iframe data-tab="' + tab + '" src="' + url + '" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>';

	$('.panels iframe').hide();
	
	if ($('.panels > iframe[data-tab="' + tab + '"]').length == 0){
		precargaExp("#pnlConfiguracion", true);
		
		$(tagIframe).appendTo('.panels').load(function () {
			precargaExp("#pnlConfiguracion", false);
		});
	}
	else
		$('.panels > iframe[data-tab="' + tab + '"]').show();
}