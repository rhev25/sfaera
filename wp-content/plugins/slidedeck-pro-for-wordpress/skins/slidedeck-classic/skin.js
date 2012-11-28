(function($){
    function Fancyvert( thisDeck ){
        var el = $(thisDeck);
        var slidedeck = el.find('.slidedeck');
        var deck = slidedeck.slidedeck();
        
        var sizeDeckFrame = function(){
            if( slidedeck.width() && slidedeck.height() ){
                el.css({
                    width: slidedeck.width(),
                    height: slidedeck.height()
                });
            }
        };
        
        function updateVerticalCallback( deck ){
            if (typeof(deck.vertical()) != 'undefined') {
                if (deck.vertical().navChildren) {
                    if (typeof(deck.vertical().options.complete) != 'function') {
                        // Vertical complete function
                        deck.vertical().options.complete = function(deck){
                            if (deck.current == 0) {
                                $(deck.navChildren.context).find('a.vertical-prev-next.previous').hide();
                            }
                            else {
								if( typeof($(deck.navChildren.context).find('a.vertical-prev-next.previous')[0]) != 'undefined' ){
	                                $(deck.navChildren.context).find('a.vertical-prev-next.previous')[0].style.display = "";
								}
                            }
                            if (deck.current == (deck.slides.length - 1)) {
                                $(deck.navChildren.context).find('a.vertical-prev-next.next').hide();
                            }
                            else {
								if( typeof($(deck.navChildren.context).find('a.vertical-prev-next.next')[0]) != 'undefined' ){
	                                $(deck.navChildren.context).find('a.vertical-prev-next.next')[0].style.display = "";
								}
                            }
                        }
                    }
                }
            }
        }

		deck.loaded(function(){
			// Add the square navigation to the spine as the dot navigation.
	        slidedeck.find('.verticalSlideNav').each(function(){
	            $(this).parents('dd.slide').prevAll('dt.spine:first').append(this);
	        });
	        
			// Offset the dot navigation so it can be aligned to the bottom of the dt.
	        slidedeck.find('.verticalSlideNav').each(function(){
				var liHeight = $(this).find('li').height();
				var ulOffset = ( 62 + ( ($(this).find('li').length - 1) * liHeight ) ) + 'px';
	            $(this).css({
	                left: ulOffset
	            });
	        });
	        
			// Add the prev/next buttons.
	        slidedeck.find('.slide .slidesVertical').after('<a href="#previous" class="vertical-prev-next previous">Previous</a><a href="#next" class="vertical-prev-next next">Next</a>');
	        // Bind click events to all the prev/next buttons.
	        slidedeck.find('a.vertical-prev-next').bind('click', function(event){
	            event.preventDefault();
	            deck.pauseAutoPlay = true;
	            switch (this.href.split('#')[1]) {
	                case "previous":
	                    deck.vertical().prev();
	                    break;
	                case "next":
	                    deck.vertical().next();
	                    break;
	            }
	        });
	        
	        // hide the up/prev arrows
	        slidedeck.find('a.vertical-prev-next.previous').hide();
	        
	        // adjust the deck frame to fit the deck (if not 100%)
	        sizeDeckFrame();
		});
        
        deck.options.complete = function(deck){
            updateVerticalCallback( deck );
            // Horizontal complete...
        };
        // once now and again on every horiz slide change.
        updateVerticalCallback( deck );
        
        return true;
    };
    
    
    $(document).ready(function(){
        for(var i=0, decks=$('.slidedeck_frame.skin-slidedeck-classic'); i<decks.length; i++){
            var thisDeck = decks[i];
            
            if(typeof(thisDeck.SlideDeck_skinFancyvert) == 'undefined'){
                thisDeck.SlideDeck_skinFancyvert = Fancyvert(thisDeck);
            }
        }
    });    
})(jQuery);
