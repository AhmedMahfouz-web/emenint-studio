/* inview */
function kerimine() {
    var waitTimer = 1;		
    var waitTimeItem = 100;
    var waitTimerHide = 2*waitTimeItem;
    /*
    jQuery('.inview').each(function( index, value ){
        var dpPos = jQuery(this).offset().top-jQuery(window).scrollTop()-jQuery( window ).height();
        if(dpPos<-20 && !jQuery(this).data('timing') ) {
            if(!jQuery(this).data('visible')) {
                jQuery(this).data('visible', 1);
                jQuery(this).data('timing', 1);
                var _this = this;
                setTimeout(function(){
                    jQuery(_this).addClass('visible');						
                    jQuery(_this).data('timing', 0);
                }, waitTimer);
                waitTimer = waitTimer + waitTimeItem;
            }				
        } else if(jQuery(this).data('visible') && !jQuery(this).data('timing') ) {
                jQuery(this).data('visible', 0);
                jQuery(this).data('timing', 1);
                var _this = this;
                setTimeout(function(){
                    jQuery(_this).removeClass('visible');		
                    jQuery(_this).data('timing', 0);
                }, waitTimerHide);
                waitTimerHide = waitTimerHide - waitTimeItem;
        };
    });
    */
    jQuery('.inview2').each(function( index, value ){
        var dpPos = jQuery(this).offset().top-jQuery(window).scrollTop()-jQuery( window ).height();
        if(dpPos < 20 && !jQuery(this).data('timing') ) {
            if(!jQuery(this).data('visible')) {
                jQuery(this).data('visible', 1);
                jQuery(this).data('timing', 1);
                var _this = this;
                setTimeout(function(){
                    jQuery(_this).addClass('visible');						
                    jQuery(_this).data('timing', 0);
                }, waitTimer);
                waitTimer = waitTimer + waitTimeItem;
            }				
        } else if(jQuery(this).data('visible') && !jQuery(this).data('timing') ) {
            jQuery(this).data('visible', 0);
            jQuery(this).data('timing', 1);
            var _this = this;
            setTimeout(function(){
                jQuery(_this).removeClass('visible');		
                jQuery(_this).data('timing', 0);
            }, waitTimerHide);
            waitTimerHide = waitTimerHide - waitTimeItem;
        };
    });
    jQuery('.js-seperator').each(function( index, value ){
        var dpPos = jQuery(this).offset().top-jQuery(window).scrollTop()-jQuery( window ).height();
        var hp = jQuery(window).height()/2;
        if(dpPos < -hp && !jQuery(this).data('timing') ) {
            if(!jQuery(this).data('switch')) {
                jQuery(this).data('switch', 1);
                jQuery(this).data('timing', 1);
                var _this = this;
                setTimeout(function(){
                    jQuery(_this).addClass('switch');						
                    jQuery(_this).data('timing', 0);
                }, waitTimer);
                waitTimer = waitTimer + waitTimeItem;
            }				
        } else if(jQuery(this).data('switch') && !jQuery(this).data('timing') ) {
                jQuery(this).data('switch', 0);
                jQuery(this).data('timing', 1);
                var _this = this;
                setTimeout(function(){
                    jQuery(_this).removeClass('switch');		
                    jQuery(_this).data('timing', 0);
                }, waitTimerHide);
                waitTimerHide = waitTimerHide - waitTimeItem;
        };
    });
};