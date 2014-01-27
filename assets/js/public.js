jQuery(window).load(function() {
	if ( jQuery('.main-content > .grid').length ) {
		jQuery('#main.main-content > .grid').masonry({
			gutter: 10,
			itemSelector: '.hentry'
		});
		jQuery('.pagination.menu').hide();
		jQuery('#loadmore').css({display: 'inline-block'});
		jQuery('#loadmore').click(function(e) {
			e.preventDefault();
			jQuery.ajax({
				type: 'POST',
				url: wp_ajax.ajax_url,
				beforeSend: function() {
					jQuery('#loadmore').addClass('loading').removeClass('hover');
				},
				complete: function() {
					jQuery('#loadmore').removeClass('loading').addClass('hover');
				},
				data: {
					action: 'load_posts',
					offset: jQuery('.hentry').length
				},
				success: function(response) {
					jQuery('#main.main-content > .grid').append(response);
					jQuery('#main .grid').masonry('reload');
				}
			});
		});
	}
});