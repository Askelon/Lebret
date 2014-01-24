(function($) {
	
	$(window).load(function() {
		if ( $('.main-content > .grid').length )
			$('.main-content > .grid').masonry({itemSelector: '.hentry'});
	});
})(jQuery);