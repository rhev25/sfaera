(function($){
	function VerticalLight(el){
		var el = $(el);
		var deck = el.find('.slidedeck').slidedeck();
        var slidedeck = el.find('.slidedeck');
		
        var sizeDeckFrame = function(){
            if( slidedeck.width() && slidedeck.height() ){
                el.css({
                    width: slidedeck.width()+'px',
                    height: slidedeck.height()+'px'
                });
            }
        };
        
        sizeDeckFrame();
		
        deck.loaded(function(){
            for(var z=0, slides=el.find('dd.slide .sd-node-container'); z<slides.length; z++){
                var thisSlide = $(slides[z]);
                var slideWidth = thisSlide.innerWidth();
                var slideImage = thisSlide.find('img');
                
                if(thisSlide.find('.sd-node-image').length){
                    thisSlide.find('.sd-node-content').css({
                        width: Math.floor((slideWidth - 260)) + "px"
                    });
                    
                    if(navigator.userAgent.toLowerCase().match(/msie 7/) ? true : false){
                        slideImage.css({
                            position: 'relative',
                            top: ((216 - slideImage[0].height) / 2) + "px"
                        });
                    }
                } else {
                    thisSlide.find('.sd-node-content').css({
                        width: Math.floor(slideWidth * 0.9) + "px"
                    });
                }
            }
        });
		
        $(window).load(function(){
            el.find('dd.slide .sd-node-container .sd-node-image-child img').each(function(){
                $(this).attr('width', this.width).css({
                    top: (216 - this.height) + "px"
                });
            });
        });
		
		return true;
	};
	
	$(document).ready(function(){
		for(var i=0, decks=$('.slidedeck_frame.skin-vertical-light'); i<decks.length; i++){
			var thisDeck = decks[i];
		    
			if(typeof(thisDeck.SlideDeck_skinVerticalLight) == 'undefined'){
				thisDeck.SlideDeck_skinVerticalLight = VerticalLight(thisDeck);
			}
		}
	});
})(jQuery);