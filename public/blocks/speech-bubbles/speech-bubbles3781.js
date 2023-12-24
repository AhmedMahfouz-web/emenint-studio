(function($){

    var initializeBlock = function( $block ) {
        $block.find('.speech-bubbles');
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {

      $('.bubble').on("click", function(e) {
        e.preventDefault();
        $('.bubble').removeClass('active');
        $(this).toggleClass('active');
      });
      

    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=speech-bubbles', initializeBlock );
    };

})(jQuery);