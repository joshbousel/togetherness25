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
		let adults = $('select[name="adults"]').find(":selected").val();
		let children = $('select[name="children"]').find(":selected").val();
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
	
	$('body').on('click','.rsvp__container__edit',function(e){
		e.preventDefault();
		$.ajax({
			async: true,
			method: "POST",
			url: "/php/rsvp-actions.php",
			data: { action: 'edit' }
		})
		.done(function(content) {
			$('.rsvp__container').html(content);
			setRSVP();
		});
	});
	
	$('body').on('click','.rsvp__container__rsvp-cancel',function(e){
		e.preventDefault();
		let data = { action: 'cancel' };
		updateRSVP(data);
	});
	
	$('body').on('change','input[name="rsvp"]',function(e){
		setRSVP();
	});
	
	$('body').on('change','input[name="transportation"]',function(e){
		setRSVP();
	});
	
	$('body').on('click','.rsvp__container__rsvp-save',function(e){
		e.preventDefault();
		let rsvp = $('input[name="rsvp"]:checked').val();
		let adults = $('select[name="adults"]').find(":selected").val();
		let children = $('select[name="children"]').find(":selected").val();
		let transportation = $('input[name="transportation"]:checked').val();
		let carpool = $('input[name="carpool"]:checked').val();
		let note = $('textarea[name="note"]').val();
		let data = { action: 'update', rsvp: rsvp, adults: adults, children: children, transportation: transportation, carpool: carpool, note: note };
		updateRSVP(data);
	});
	
	function setRSVP() {
		let rsvp = $('input[name="rsvp"]:checked').val();
		let transportation = $('input[name="transportation"]:checked').val();

		if (rsvp == "No") {
			$('fieldset[name="quantity"],fieldset[name="transportation"],fieldset[name="carpool"]').addClass('hidden');
		} else {
			$('fieldset[name="quantity"],fieldset[name="transportation"]').removeClass('hidden');
			
			if (transportation == "Bus") {
				$('fieldset[name="carpool"]').addClass('hidden');
			} else if (transportation == "Car") {
				$('fieldset[name="carpool"]').removeClass('hidden');
			}
			
			if (carpool != "") {
				$('fieldset[name="carpool"]').removeClass('hidden');
			}
		}
	}
	
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
