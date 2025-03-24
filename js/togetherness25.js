$(function() {
	// Hero Rollovers
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
	
	// Login/Logout Guest
	var params = extractParams(window.location.search.substring(1));
	
	if (params['guest'] != undefined) {
		$.ajax({
			async: true,
			method: "POST",
			url: "/php/login.php",
			data: { guest: params['guest'] }
		})
		.done(function() {
			if (window.location.pathname == '/rsvp') {
				$.ajax({
					async: true,
					method: "POST",
					url: "/php/rsvp.php",
					data: { login: 'true' }
				})
				.done(function(content) {
					$('body').html(content);
				});
			}
		});
	}
	
	function extractParams(url) {
		url_dec = decodeURI(url);
		rawParams = url_dec.split("&");
		params = {}
	
		for (i = 0; i < rawParams.length; i++) {
			ft = rawParams[i].split("=");
			params[ft[0]] = ft[1]
		}
	
		return params
	}
	
	// RSVP Functions
	$('body').on('click','.rsvp__container__attending',function(e){
		e.preventDefault();
		let rsvp = $(this).attr('data-rsvp');
		let data = { action: 'save', rsvp: rsvp };
		updateRSVP(data);
	});
	
	$('body').on('click','.rsvp__container__quanity',function(e){
		e.preventDefault();
		let adults = $('select[name="adults"').find(":selected").val();
		let children = $('select[name="children"').find(":selected").val();
		let data = { action: 'save', adults: adults, children: children };
		updateRSVP(data);
	});
	
	$('body').on('click','.rsvp__container__transportation',function(e){
		e.preventDefault();
		let transportation = $(this).attr('data-transportation');
		let data = { action: 'save', transportation: transportation }
		updateRSVP(data);
	});
	
	$('body').on('click','.rsvp__container__carpool',function(e){
		e.preventDefault();
		let carpool = $(this).attr('data-carpool');
		let data = { action: 'save', carpool: carpool }
		updateRSVP(data);
	});
	
	$('body').on('click','.rsvp__container_note',function(e){
		e.preventDefault();
		let note = $('textarea[name="note"]').val();
		let data = { action: 'save', note: note };
		updateRSVP(data);
	});
	
	function updateRSVP(data) {
		$.ajax({
			async: true,
			method: "POST",
			url: "/php/rsvp-actions.php",
			data: data
		})
		.done(function(content) {
			$.ajax({
				async: true,
				method: "POST",
				url: "/php/rsvp.php",
				data: { refresh: 'true' }
			})
			.done(function(content) {
				$('body').html(content);
			});
		});
	}
});
