(function($){

    var initializeBlock = function( $block ) {
        $block.find('.infiniteslid');
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        
        var $wrapperHeight = $('.infiniteslid-wrapper').outerHeight();
        $('.infiniteslid-wrapper').css({
            height: $wrapperHeight+'px'
        });

        $('.infiniteslid-grid').infiniteslide({
            speed: 60,
            direction: 'up'
		});
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=infiniteslid', initializeBlock );
    };

})(jQuery);