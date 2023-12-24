(function($){

    var initializeBlock = function( $block ) {
        $block.find('.team');
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        /* play video on hover */
		$(".onhover").on("mouseover", function() {
			this.play();
		}).on('mouseout', function() {
			$(this).get(0).currentTime = 0
    		$(this).get(0).pause();
		});
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=team', initializeBlock );
    };

})(jQuery);