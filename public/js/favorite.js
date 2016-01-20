$(document).ready(function () {

	$('.favorite').click(handleFavorite);

	$('[data-toggle="tooltip"]').tooltip();

	function handleFavorite() {
		var star = $(this);
		var starCont = star.closest('span');

		if(star.hasClass('active')) {
			deleteFavorite(star);
			var tooltipMessage = 'В избранные';
			var tooltipClass = '';
		} else {
			addFavorite(star);
			var tooltipMessage = 'Удалить из избранных';
			var tooltipClass = 'active';
		}

		var newStar = $('<a href="" class="favorite ' + tooltipClass + '" data-toggle="tooltip" data-placement="top" title="" data-original-title="' + tooltipMessage +'"><span class="glyphicon glyphicon-star"></span></a>');

		newStar.data('id', star.data('id'));

		star.remove();
		starCont.append(newStar);

		newStar.click(handleFavorite);
		$('.tooltip').remove();
		newStar.tooltip('show');

		return false;
	}

	function addFavorite(star) {
		var post_id = star.data('id');

		if(!post_id) return;

		var address = window.location.origin + '/profiles/add-favorite?post_id=' + post_id;

		$.ajax({
			url: address,
			success: function() {
				console.log('favorite added!');
			}
		});
	}

	function deleteFavorite(star) {
		var post_id = star.data('id');

		if(!post_id) return;

		var address = window.location.origin + '/profiles/delete-favorite?post_id=' + post_id;

		$.ajax({
			url: address,
			success: function() {
				console.log('favorite deleted!');
			}
		});
	}

});