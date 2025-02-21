$(function() {
	$('.info__heart').on('mouseover',function(e){
		e.preventDefault();
		$('.info').addClass('info--active');
	});
	
	$('.info__heart').on('click',function(e){
		e.preventDefault();
		
		if ($('.info').hasClass('info--active')) {
			$('.info').removeClass('info--active');	
		} else {
			$('.info').addClass('info--active');	
		}
	});
});
