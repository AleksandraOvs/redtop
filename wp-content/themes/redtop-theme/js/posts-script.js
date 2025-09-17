jQuery(document).ready(function ($) {
	console.log('JS загружен!');
	console.log(ajaxurlObj.ajaxurl); // для проверки

	$('#category-filter a').on('click', function (e) {
		e.preventDefault();

		let $this = $(this);
		let termId = $this.data('term');

		// Устанавливаем класс active на кликнутую ссылку
		$('#category-filter a').removeClass('active');
		$this.addClass('active');

		$.ajax({
			url: ajaxurlObj.ajaxurl,
			type: 'POST',
			data: {
				action: 'filter_recipes',
				term_id: termId
			},
			beforeSend: function () {
				$('#recipes-list').html('<div class="loader"></div>');
			},
			success: function (response) {
				$('#recipes-list').html(response);
			}
		});
	});
});
