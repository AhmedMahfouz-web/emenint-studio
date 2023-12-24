(function($){
    $.fn.is_on_screen = function(){    
        var win = $(window);
        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.bottom = viewport.top + win.height();
        var bounds = this.offset();
        bounds.bottom = bounds.top + this.outerHeight();
        return (!(viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };
    function parallax() { 
      $('.inview-section').each(function(){ 
           if ($(this).is_on_screen()) {	
              var firstTop = $(this).offset().top; 
              $('.latest--big-one').removeClass('is-100');
         } else {
            $('.latest--big-one').addClass('is-100');
         }
      });
    }
    $(window).scroll(function(e){
        parallax();
      
    });
})(jQuery);