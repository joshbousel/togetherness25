$(function() {
	$('.hero__faqs').on('click',function(e){
		e.preventDefault();
		$('.faqs').addClass('faqs--active');
	});
	
	$('.faqs__close').on('click',function(e){
		e.preventDefault();
		$('.faqs').removeClass('faqs--active');
	});
});
