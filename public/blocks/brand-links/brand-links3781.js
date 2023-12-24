(function($){
    var initializeBlock = function( $block ) {
        $block.find('.brand-links');
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=index-brand-links', initializeBlock );
    };
})(jQuery);