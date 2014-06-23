(function ($) {
	'use strict';
	$(function () {
		$('.wrap').on('change', '.favorite-team-pick select', function() {
			var $logo = $(this).find('option:selected').last().data('logo');
			console.log($logo);
			$(this).parents('.worldcup-admin').find('img').attr('src', $logo);
		});
	});
}(jQuery));