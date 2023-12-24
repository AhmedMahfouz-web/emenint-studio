(function($){
    var initializeBlock = function( $block ) {
        $block.find('.index-intro');
    };
    // Initialize each block on page load (front end).
    $(document).ready(function () {
       /* wrapp text lines
        var arr = $('.js-splitlines').html().split('\n');
        $('.js-splitlines').empty();
        $.each(arr, function( index, value ) {
          if ( index > 0 && index < arr.length) 
          $('.js-splitlines').append("<span class='inview inview--row'>"+arr[index]+"</span><br />");
        });
         */
    });
    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=index-intro', initializeBlock );
    };

})(jQuery);