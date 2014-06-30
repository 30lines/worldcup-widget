(function ($) {
	'use strict';
	$(function () {
		$('.playerlist').on('click', '.player > a', function(e) {
			$(this).parent().find('.extra-stats').slideToggle();
			e.preventDefault();
		});
	});
}(jQuery));