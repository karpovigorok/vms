$ = jQuery;
$(document).ready(function(){
	$('.ajax').click(function(e){
		e.preventDefault();
		url = $(this).attr('href');
		$('#main-admin-content').load(url);
	});
});