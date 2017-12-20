$(document).ready(function() {
	// + /- для блока водка
	$('body').on('click', '.card-help .cucumber .plus', function() {
		var qty = parseFloat($('.cucumber input').val())+1;
		$('.cucumber input').val(qty > parseFloat($('.cucumber .max-count').html().replace('/', '')) ? parseFloat($('.cucumber .max-count').html().replace('/', '')) : qty);

		return false;
	});
	$('body').on('click', '.card-help .cucumber .minus', function() {
		var qty = parseFloat($('.cucumber input').val())-1;
		$('.cucumber input').val(qty <= 0 ? 1 : qty);

		return false;
	});

	// + /- для блока огурчики
	$('body').on('click', '.card-help .vodka .plus', function() {
		var qty = parseFloat($('.vodka input').val())+1;
		$('.vodka input').val(qty > parseFloat($('.vodka .max-count').html().replace('/', '')) ? parseFloat($('.vodka .max-count').html().replace('/', '')) : qty);

		return false;
	});
	$('body').on('click', '.card-help .vodka .minus', function() {
		var qty = parseFloat($('.vodka input').val())-1;
		$('.vodka input').val(qty <= 0 ? 1 : qty);

		return false;
	});

	// активация / деактивация блоков "Водка" и "Огурчики"
	$('body').on('click', '.card-help .name', function() {
		if ($(this).parent().hasClass('selected'))
			$(this).parent().removeClass('selected');
		else
			$(this).parent().addClass('selected');
	});
});