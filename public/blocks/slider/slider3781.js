(function($){

    var initializeBlock = function( $block ) {
        $block.find('.slider');
    };
    // Initialize each block on page load (front end).
    $(document).ready(function () {
        var mySwiper = new Swiper ('.swiper-content', {
          spaceBetween: 0,
          centeredSlides: true,
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          768: {
            spaceBetween: 0
          }
        });       
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=slider', initializeBlock );
    };

})(jQuery);