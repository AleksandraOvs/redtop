jQuery(document).ready(function ($) {
	console.log('JS загружен!');
	console.log(ajaxurlObj.ajaxurl); // для проверки

	$('#category-filter a').on('click', function (e) {
		e.preventDefault();
		
		let termId = $(this).data('term');

		$.ajax({
			url: ajaxurlObj.ajaxurl,
			type: 'POST',
			data: {
				action: 'filter_works_by_category',
				term_id: termId
			},
			beforeSend: function () {
				$('#works-list').html('<div class="loader"></div>');
			},
			success: function (response) {
				$('#works-list').html(response);
			}
		});
	});
});