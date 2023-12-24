(function($){

	/* gobal vars */
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;	
	var isMobile = false;

	/* detect device */
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
		isMobile = true;
		$('body').addClass('is-device');
	};

	/* browser size */
	function resizeW() {
		var browserheight = $(window).height();
		$('.bh').css({'height': Math.round(browserheight)});
		$('.hbh').css({'height': Math.round(browserheight/2)});
		$('.mhbh').css({'min-height': Math.round(browserheight/2)});
		$('.svgh-bh').css({'height': Math.round(browserheight/3)});
		$('.mt-onethird').css({'margin-top': Math.round(browserheight/3.5)});
		$('.top-onethird').css({'top': Math.round(browserheight/3.5)});
	};

	/* inview parallax */
	function parallax() {
		$scrolled = $(window).scrollTop();
		$('.parallax-section').each(function(){
			if ($(this).hasClass('visible')) {
				$firstTop = $(this).offset().top;
				$move = $(this).find('div');
				$moveTop = ($firstTop-$scrolled)*0.025;
				$move.css("transform","translateY("+-$moveTop+"px)");
		   };
		});		
	};

	/* inview */
	$.fn.is_on_screen = function(){    
		var win = $(window);
		var viewport = {
			top : win.scrollTop(),
			left : win.scrollLeft()
		};
		//viewport.right = viewport.left + win.width();
		viewport.bottom = viewport.top + win.height();

		var bounds = this.offset();
		//bounds.right = bounds.left + this.outerWidth();
		bounds.bottom = bounds.top + this.outerHeight();

		return (!(viewport.bottom < bounds.top || viewport.top > bounds.bottom));
	};

	/* inview addclass */
	function inviewaddclass() {
		$scrolled = $(window).scrollTop();
		$('.inview').each(function(){
			if ($(this).is_on_screen()) {	
				//$firstTop = $(this).offset().top;
				//$move = $(this).find("img");
				//$moveTop = ($firstTop-$scrolled)*0.05;
				//$move.css("transform","translateY("+-$moveTop+"px)");
				$(this).addClass('visible');
		   };
		});	
	};

	/* lazy bg */
	document.addEventListener('lazybeforeunveil', function(e){
		var bg = e.target.getAttribute('data-bg');
		if(bg){
			e.target.style.backgroundImage = 'url(' + bg + ')';
		};
	});

	/* magnetic button & cursor 
	function magnetic(){
		if(!isMobile){
			const cursor = document.querySelector('.cursor');
			
			const btn = document.querySelectorAll('.btn');
			const update = function(e) {
				const span = this.querySelector('span');
				const magnet = this.closest('.magnet');
				if(e.type === 'mouseleave') {
					span.style.cssText = '';
					magnet.style.cssText = '';
				} else {
					const { offsetX: x, offsetY: y } = e,
							{ offsetWidth: width, offsetHeight: height } = this,
							walk = 10,
							xWalk = (x / width) * (walk * 2) - walk,
							yWalk = (y / height) * (walk * 2) - walk;
					span.style.cssText = `transform: translate(${xWalk}px, ${yWalk}px);`;
					magnet.style.cssText = `transform: translate(${xWalk}px, ${yWalk}px);`;
				};
			};
			
			const handleCurosr = (e) => {
				const { clientX: x, clientY: y } = e;
				cursor.style.cssText =`left: ${x}px; top: ${y}px;`;
			};
			
			$('a, #burger').mouseenter(function() {
				$('.cursor').addClass('hover');
			}).mouseleave(function() {
				$('.cursor').removeClass('hover');
			});
			$('.btn, .brand-login, .icon-social').mouseenter(function() {
				$('.cursor').addClass('hidde');
			}).mouseleave(function() {
				$('.cursor').removeClass('hidde');
			});
			
			btn.forEach(b => b.addEventListener('mousemove', update));
			btn.forEach(b => b.addEventListener('mouseleave', update));
			
			window.addEventListener('mousemove', handleCurosr);	
		};
	};
	*/

	function customcursor(){
		if(!isMobile){
			var cursor = $(".cursor");
			$(window).mousemove(function(e) {cursor.css({top: e.clientY - cursor.height() / 2, left: e.clientX - cursor.width() / 2});});
			$("a").mouseenter(function() {cursor.addClass('hover')}).mouseleave(function() {cursor.removeClass('hover')});
			$(".btn, .brand-login, .icon-social").mouseenter(function() {cursor.addClass('hidde')}).mouseleave(function() {cursor.removeClass('hidde')});
			$(window).mousedown(function() {cursor.css({transform: "scale(.2)"});}).mouseup(function() {cursor.css({transform: "scale(1)"});});
		};
	};

	/* detect sroll */
	function hasScrolled() {
		var navbarHeight = $('header').outerHeight();
		var st = $(this).scrollTop();
		if(Math.abs(lastScrollTop - st) <= delta)
			return;
		if (st > lastScrollTop && st > navbarHeight){
			$('header').removeClass('nav-down').addClass('nav-up');
			$('.main-menu').removeClass('open');
			$('#burger').removeClass('active');
			$('body').removeClass('mega-menu--open');
			$('#mega-menu').removeClass('open');
		} else {
			if(st + $(window).height() < $(document).height()) {
				$('header').removeClass('nav-up').addClass('nav-down');
				$('.main-menu').removeClass('open');
				$('#burger').removeClass('active');
			};
		};
		lastScrollTop = st;
	};

	/* play video on inview */
	function playvideo() {
		$('video.inview2').each(function() {
			if ($(this).hasClass('visible')) {
				$(this).get(0).play();
			} else {
				$(this).get(0).pause();
			}
		});
	};
	if(!isMobile){
		$(window).unload(function () {
			//fix page transition 4 browser back button
		});
	};

	$(window).load(function() {
		$('html').removeClass('no-js');
		inviewaddclass();
		resizeW();
		parallax();
		kerimine();
		customcursor();
	});

	$(window).resize(function() {
		console.log('resized');
		resizeW();
		inviewaddclass();
		parallax();
		kerimine();
	});

	$(document).ready(function() {
		$('body').addClass('is-negative-menu');
		setTimeout(function(){
			$('body').addClass('loaded');
		}, 250);

		inviewaddclass();
		parallax();
		resizeW();
		setTimeout(function(){
			kerimine();
		}, 1);

		/* no page change for credit links */
		$('section.credits a').addClass('nopagechange');
		$('#selectionSharerPopover-inner a').addClass('nopagechange');
		
		/* page transition */
		if(!isMobile){
			$('a').click(function(e) {
				if($(this).hasClass('nopagechange')){
					return;
				} else {
					e.preventDefault();
					var goTo = this.getAttribute("href");
					$('.inview.visible, .inview2.visible').each(function(){
						$(this).removeClass('visible');
					});
					setTimeout(function(){
						window.location = goTo;
					}, 750);
				};
			});
		};

		/* share text */
		$('body.single p').selectionSharer();
			

		/* email protection */
		$(function() {
			$('a[href^="mailto:"]').each(function() {
				this.href = this.href.replace('(at)', '@').replace(/\(dot\)/g, '.');
				this.innerHTML = this.innerHTML.replace('(at)', '@').replace(/\(dot\)/g, '.');
			});
		});

		/* brand-slider */
		if(!isMobile){
            wwidth = $(window).width();
            wwwidth = wwidth/2;
            $(window).mousemove(function(move){
                var moveMouse = -move.pageX+wwwidth;
                $('#js-brandslider .brandslid').css({
                    'transform': ' translateX('+moveMouse + 'px)'
                });
            });
        };
		 
		/* mobile menu */
		$('#burger').on('click', function(e) {
			e.preventDefault();
			$(this).toggleClass('active');
			$('#mega-menu').toggleClass('open');
			$('body').toggleClass('mega-menu--open');
		});

		/* main menu hover 
		$('.main-menu ul a').each(function() {
			var text = $(this).html();
			$(this).append(text);
		});
		*/

		/* mega menu equal height */
		var bigheight = $('#menu-big-one, #menu-big-one-en').height();
		$('#js-menu-height').css({'height': Math.round(bigheight)});		

		/* tag btn */
		$('.tags-wrapper--btn').on('click', function(e) {
			e.preventDefault();
			$(this).toggleClass('active');
			$('.tags-wrapper--cloud').toggleClass('open');
			$(this).find('span').text(function(i, text){
				return text === "Tags" ? "..." : "Tags";
			})
		});

		/* draw svg */
		setTimeout(function(){
			$('.draw').zPath({
                drawTime:1250
            });
		}, 250);

		/* projekte filter back button */
		$('#menu-pcats .current-menu-item a').attr("href", "/projekte");

	});/* ready end */

	/* detect Sroll */
	$(document).scroll(function() {
		didScroll = true;
		//$winScrollTop = $(this).scrollTop();
		
		inviewaddclass();
		parallax();
		kerimine();
		playvideo();
		resizeW();

		/*
		$('.js-parallaxheader').css("transform","translate3d(0, "+($winScrollTop*.35)+"px, 0)");
		$('.js-parallaxheader-2').css("transform","translate3d(0, "+($winScrollTop*.15)+"px, 0)");
		$('.js-parallaxsvg').css("transform","translate3d(0, "+($winScrollTop*.35)+"px, 0)");
		$('.js-parallaxheader-text').css("transform","translate3d(0, "+($winScrollTop*.3)+"px, 0)");
		if(isMobile){
			$('.js-parallaxheader-text.magazin-header--text--inner').css("transform","translate3d(0, "+($winScrollTop*.1)+"px, 0)");
		};
		*/

		if (didScroll) {
			hasScrolled();
			didScroll = false;
		};

		if ($(document).scrollTop() > 1) {
			$('header').removeClass('isontop');
			$('.gradient-blur').addClass('show')
			$('.gradient-blur').removeClass('hide')
		};
		if ($(document).scrollTop() == 0) {
			$('header').addClass('isontop');
			$('.gradient-blur').addClass('hide')
			$('.gradient-blur').removeClass('show')
		};

	});

})(jQuery);