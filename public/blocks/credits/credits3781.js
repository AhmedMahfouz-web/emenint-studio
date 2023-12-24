(function($){

    var initializeBlock = function( $block ) {
        $block.find('.credits');
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        $("a.js-credits--open").click(function(e) {
            e.preventDefault();
            $(this).addClass('hidden');
            $('.credits--box').addClass('open');
        });
        $("a.js-credits--close").click(function(e) {
            e.preventDefault();
            $("a.js-credits--open").removeClass('hidden');
            $('.credits--box').removeClass('open');
        });
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=credits', initializeBlock );
    };

})(jQuery);