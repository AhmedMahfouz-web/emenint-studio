(function($){
    $(document).ready(function () {
        var mySwiper = new Swiper ('.info-swiper-content', {
          slidesPerView: 'auto',
          spaceBetween: 0,
          freeMode: true,
          scrollbar: {
            el: '.swiper-scrollbar',
            hide: false,
            draggable: true,
          },
        });        
    });
})(jQuery);