(function($){
	function ImageOnlyCaptionBottomNavigation(el){
		var el = $(el);
		var deck = el.find('.slidedeck').slidedeck();
        var slidedeck = el.find('.slidedeck');
		var prev = el.find('.sd-node-previous');
		var next = el.find('.sd-node-next');
        var prevNext = el.find('.sd-node-next, .sd-node-previous');
		var primaryNavs = el.find('.sd-node-nav-primary a.sd-node-nav-link');
        var showHideSpeed = 250;
        
        var sizeDeckFrame = function(){
            if( slidedeck.width() && slidedeck.height() ){
                el.css({
                    width: slidedeck.css('width'),
                    height: slidedeck.css('height')
                });
            }
        };
		
		var updateActive = function(activeSlide){
			if(deck.options.cycle == false){
				if(activeSlide == 1){
					prev.addClass('disabled');
					next.removeClass('disabled');
				}
				if(activeSlide == deck.slides.length){
					next.addClass('disabled');
					prev.removeClass('disabled');
				}
			}
			primaryNavs.removeClass('active');
			$(primaryNavs[activeSlide - 1]).addClass('active');
		};
		
		var oldNext = deck.next;
		deck.next = function(params){
			var nextSlide = Math.min(deck.slides.length,(deck.current + 1));
			if(deck.options.cycle === true){
				if(deck.current + 1 > deck.slides.length){
					nextSlide = 1;
				}
			}
			
			oldNext(params);
			updateActive(nextSlide);
		};
		var oldPrev = deck.prev;
		deck.prev = function(params){
			var prevSlide = Math.max(1,(deck.current - 1));
			if(deck.options.cycle === true){
				if(deck.current - 1 < 1){
					prevSlide = deck.slides.length;
				}
			}
			
			oldPrev(params);
			updateActive(prevSlide);
		};
		var oldGoTo = deck.goTo;
		deck.goTo = function(ind, params){
			oldGoTo(ind, params);
			updateActive(Math.min(deck.slides.length,Math.max(1,ind)));
		};
		
		el.find('.sd-node-nav-link').bind('click', function(event){
			event.preventDefault();

			var action = this.href.split('#')[1];
			
			deck.pauseAutoPlay = true;

			switch(action){
				case "previous":
					deck.prev();
				break;
				case "next":
					deck.next();
				break;
				default:
					deck.goTo(action);
				break;
			}
		});
		
		$(primaryNavs[0]).addClass('active');
        
        // add animation events to prev/next buttons
        prevNext.show().animate({ opacity: 0 }, 0);
        el.bind('mouseenter',function(){
            prevNext.stop(true).animate({
                opacity: 1
            }, showHideSpeed);
        });
        el.bind('mouseleave',function(){
            prevNext.animate({
                opacity: 0
            }, showHideSpeed);
        });
        
        // size the deck frame
        sizeDeckFrame();
		
        deck.loaded(function(){
            for(var z=0, slides=el.find('dd.slide .sd-node-container'); z<slides.length; z++){
                var thisSlide = $(slides[z]);
                var slideWidth = thisSlide.innerWidth();
                var slideHeight = thisSlide.innerHeight();
                
                if(thisSlide.find('.sd-node-image img').length){
                    
                    // strip any false image sizes
                    var img = thisSlide.find('.sd-node-image img')[0];
                    var pic_real_width;
                    var pic_real_height;
                    
                    $(img).load(function() {
                        // Remove attributes in case img-element has set width and height
                        
                        pic_real_width = $(this).width();
                        pic_real_height = $(this).height();
                        
                        $(this).removeAttr("width").removeAttr("height").css({ width: "", height: "" }); // Remove css dimensions as well
                        pic_real_width = this.width;
                        pic_real_height = this.height;
                        
                        var image_ratio = (pic_real_width / pic_real_height);
                        var deck_ratio = (slideWidth / slideHeight);
                        
                        if(image_ratio < deck_ratio){
                            // image too tall
                            var newHeight = Math.round(slideWidth / (image_ratio));
                            var newWidth = slideWidth;
                        }else if(image_ratio >= deck_ratio){
                            // image too wide
                            var newWidth = Math.round(slideHeight * (image_ratio));
                            var newHeight = slideHeight;
                        }
                        $(this).css({
                            position: 'absolute',
                            top: '50%',
                            left: '50%',
                            width: newWidth + 'px',
                            maxWidth: newWidth + 'px',
                            height: newHeight + 'px',
                            maxHeight: newHeight + 'px',
                            marginLeft: '-' + Math.round(newWidth / 2) + 'px',
                            marginTop: '-' + Math.round(newHeight / 2) + 'px'
                        });
                    });
                    
                    var src = img.src;
                    img.src = "";
                    img.src = src;
                    // fade the first image in
                    if( z == 0 ){
                        $(img).fadeIn(100);
                    }else{
                        $(img).show();
                    }
                    
                }
            }
        });
        
        // Office of redundancy office! Thanks IE! You suck!
        $(window).load(function(){
            deck.slides.find('.sd-node-image img').load();
        });
		
		return true;
	};
	
	$(document).ready(function(){
		for(var i=0, decks=$('.slidedeck_frame.skin-image_caption_bottom'); i<decks.length; i++){
			var thisDeck = decks[i];
		    
			if(typeof(thisDeck.SlideDeck_skinImageOnlyCaptionBottomNavigation) == 'undefined'){
				thisDeck.SlideDeck_skinImageOnlyCaptionBottomNavigation = ImageOnlyCaptionBottomNavigation(thisDeck);
			}
		}
	});
})(jQuery);