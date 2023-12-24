(function($){

    var initializeBlock = function( $block ) {
        $block.find('.keynotes');
    };

    // Initialize each block on page load (front end).
    $(document).ready(function () {
        /*
        $('.output').each(function() {
            var elem = $(this);
            var ctnt = elem.data('output').toString();
            console.log(ctnt);
            var theLetters = "abcdefghijklmnopqrstuvwxyzABCGDEFGHIJLMNOPQRSTUVWXYZ1234567890+-=#%";
            var speed = 65;
            var increment = 12;
            var clen = ctnt.length;       
            var si = 0;
            var stri = 0;
            var block = "";
            var fixed = "";
            
            //Call self x times, whole function wrapped in setTimeout
            (function rustle (i) {          
                setTimeout(function () {
                    if (--i){
                        rustle(i);
                    }
                    nextFrame(i);
                    si = si + 1;        
                }, speed);
            })(clen*increment+1);
            
            function nextFrame(pos){
                for (var i=0; i<clen-stri; i++) {
                    var num = Math.floor(theLetters.length * Math.random());
                    var letter = theLetters.charAt(num);
                    block = block + letter;
                }
                if (si == (increment-1)){
                    stri++;
                }
                if (si == increment){
                    fixed = fixed +  ctnt.charAt(stri - 1);
                    si = 0;
                }
                if(elem.parent().hasClass('visible')){
                    elem.html(fixed + block);
                }
                block = "";
            };
        });
        */
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=keynotes', initializeBlock );
    };

})(jQuery);