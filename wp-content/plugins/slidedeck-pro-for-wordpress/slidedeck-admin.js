/**
 * SlideDeck Pro for WordPress 1.4.2 - 2011-10-17
 * Copyright (c) 2011 digital-telepathy (http://www.dtelepathy.com)
 * 
 * BY USING THIS SOFTWARE, YOU AGREE TO THE TERMS OF THE SLIDEDECK 
 * LICENSE AGREEMENT FOUND AT http://www.slidedeck.com/license. 
 * IF YOU DO NOT AGREE TO THESE TERMS, DO NOT USE THE SOFTWARE.
 * 
 * More information on this project:
 * http://www.slidedeck.com/
 * 
 * Full Usage Documentation: http://www.slidedeck.com/usage-documentation 
 * 
 * @package SlideDeck
 * @subpackage SlideDeck Pro for WordPress
 * 
 * @author digital-telepathy
 * @version 1.4.2
 */

var SlideDeckSlides = {
	processing: false,
    namespace: 'slidedeck',
	
	updateTitle: function(e){
		var element = e;
		if (this.timer) {
			clearTimeout(element.timer);
		}
		this.timer = setTimeout(function(){
			jQuery('#hndle_for_' + jQuery(element).parents('.slide')[0].id).text(element.value);
			jQuery(element).parents('.slide').find('h3.hndle').text(element.value);
			document.getElementById('slide-start').options[jQuery(element).parents('.slide').find('input.slide-order')[0].value - 1].text = element.value;
		},100);
		return true;
	},
	
	addSlide: function(e){
		var self = this;
		
		if(this.processing === false){
			this.processing = true;
			
			var el = e;
			var url = typeof(ajaxurl) != 'undefined' ? ajaxurl : e.href.split('?')[0].replace(document.location.protocol + '//' + document.location.hostname, "");
            
            // Create array of existing indexes and increment if necessary to prevent ID duplication
            var slideCount = parseInt(jQuery('.slide').length);
            var existingIndexes = [];
            for(var i=0, hSlides=jQuery('.slide textarea.horizontal.slide-content'); i<hSlides.length; i++){
                existingIndexes.push(parseInt(hSlides[i].id.split('_')[1], 10));
            }
            // Descending sort to get highest present index value first 
            existingIndexes.sort(function(a, b){
                return a < b;
            });
            if(existingIndexes[0] > slideCount){
                slideCount = existingIndexes[0];
            }
    
			jQuery.ajax({
				url: url,
				type: 'get',
				data: {
                    action: 'slidedeck_add_slide',
					count: slideCount,
					gallery_id: jQuery('#slidedeck_gallery_id').val()
				},
				complete: function(data){
					var row_id = "slide_editor_" + (slideCount + 1),
						editor_id = "slide_" + (slideCount + 1) + "_content";
					
					jQuery('.slides').append(data.responseText);
					jQuery('#re-order-slides .slide-order').append('<li><a href="#' + row_id + '" class="hndle" id="hndle_for_slide_editor_' + (slideCount + 1) + '">Slide ' + (slideCount + 1) + '</a></li>');
					jQuery('#slide-start').append('<option value="' + (slideCount + 1) + '">Slide ' + (slideCount + 1) + '</option>');
					
					tinyParams = tinyMCEPreInit.mceInit;
					tinyParams.mode = "exact";
					tinyParams.elements = editor_id;
					
					tinyMCE.init(tinyParams);
	
		            tb_init(jQuery('#' + row_id + ' .horizontal-slide-media a.thickbox'));
                    tb_init(jQuery('#' + row_id + ' .vertical-slide-media a.thickbox'));
                    tb_init(jQuery('#' + row_id + ' a.slide-background-upload'));
					
					self.updateEditorControls(jQuery('#' + editor_id)); // html element textarea.

					self.processing = false;
				}
			});
		}
	},
	
	updateEditorControls: function(e,row_id){
		var slide = e.parents('.slide');
		
		slide.find('.slide-title').unbind('keyup.' + this.namespace).bind('keyup.' + this.namespace, function(){
			SlideDeckSlides.updateTitle(this);
		});
		
		slide.find('.editor-nav a.mode').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.editorNavigation(this);
		});
		
		slide.find('.slide-delete').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.deleteSlide(this);
		});
		        
        slide.find('.handlediv').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
            event.preventDefault();
            jQuery(this).parent().find('.inside').toggle();
        });
		
		slide.find('.slide-delete').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.deleteSlide(this);
		});

        slide.find('.media-buttons').show();
		slide.find('.media-buttons a.thickbox').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(){
			SlideDeckSlides.tb_click(this);
		});
        
		slide.find('.slide-toggle-vertical').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
            event.preventDefault();
			SlideDeckSlides.toggleVerticalSlides(this);
		});
        
		slide.find('.slide-delete-vertical').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.deleteVerticalSlide(this);
		});
		
		slide.find('.add-slide-vertical a').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.addVerticalSlide(this);
		});
        
		slide.find('.vertical-editor-area h3.vertical').unbind('click.' + this.namespace).bind('click.' + this.namespace, function(){
			SlideDeckSlides.toggleActiveVerticalSlide(this);
		});
	},
	
	deleteSlide: function(e){
		if(confirm("Are you sure you would like to delete this slide?")){
			var slide_id = jQuery(e).parents('.slide').attr('id').split('_')[2];
			
			jQuery('#hndle_for_slide_editor_' + slide_id).parents('li').remove();
			jQuery('#slide-start').find('option[value="' + slide_id + '"]').remove();

			jQuery(e).parents('.slide').remove();
		}		
	},
	
	addVerticalSlide: function(e){
		e = jQuery(e);
		var max = 10;
		var verticalSlides = e.parents('li.vertical-editor-area').find('li.vertical-slide');
		var parentSlide = e.parents('.slide');
        
        // Create array of existing indexes and increment if necessary to prevent ID duplication
        var nextSlideIndex = verticalSlides.length + 1;
        var existingIndexes = [];
        for(var i=0, vSlides=parentSlide.find('textarea.vertical.slide-content'); i<vSlides.length; i++){
            existingIndexes.push(parseInt(vSlides[i].id.split('_')[4], 10));
        }
        // Descending sort to get highest present index value first 
        existingIndexes.sort(function(a, b){
            return a < b;
        });
        if(existingIndexes[0] >= nextSlideIndex){
            nextSlideIndex = existingIndexes[0] + 1;
        }

		if(verticalSlides.length < max){
			// Copy the template Vertical Slide.
			// Add the new Vertical Slide
			parentSlide.find('.vertical-editor-area ul').append(parentSlide.find('.vertical_slide_template').clone());
			var verticalSlide = parentSlide.find('.vertical-editor-area ul li:last').show();
			verticalSlide.addClass('vertical-slide').removeClass('vertical_slide_template');
			verticalSlide.removeAttr('id');
			verticalSlide.find('h3 span.name').html(parentSlide.find('h3 span.name').html());
			verticalSlide.find('h3 span.index').html(nextSlideIndex);
            
            var parentSlide_index = parentSlide[0].id.split('_')[2];
            var textarea_id = 'slide_' + parentSlide_index + '_content_vertical_' + nextSlideIndex + '_parent';
            var title_id = 'slide_' + parentSlide_index + '_title_vertical_' + nextSlideIndex + '_parent';
            
			var mediaButtons = verticalSlide.find('.media-buttons a.thickbox');
			for (var i=0; i<mediaButtons.length; i++) {
				mediaButtons[i].href = mediaButtons[i].href.replace(/&editor=([a-zA-Z0-9\-_]*)/,'&editor=' + textarea_id);
			};
            
			var textarea = verticalSlide.find('textarea').addClass('slide-content');
			textarea.attr('id', textarea_id);
			textarea.attr('name', 'slide[' + parentSlide_index + '][vertical_content][]');
			
			var title = verticalSlide.find('input.vertical-slide-title');
			title.attr('id', title_id);
			title.attr('name', 'slide[' + parentSlide_index + '][vertical_title][]');
			
			var editor_id = textarea_id;
			var row_id = jQuery(textarea).parents('.postbox.slide')[0].id;
			
            if( typeof(tinyMCE) != 'undefined' ){
    			tinyParams = tinyMCEPreInit.mceInit;
    			tinyParams.mode = "exact";
    			tinyParams.elements = editor_id;
    			
    			tinyMCE.init(tinyParams);
    
    	        tb_init(verticalSlide.find('.vertical-slide-media a.thickbox'));
            }
            
			SlideDeckSlides.updateEditorControls(textarea,row_id);
		} else {
			alert("You can't add more than " + max + " slides.");
		}
	},
	
	deleteVerticalSlide: function(e){
		if(confirm("Are you sure you would like to delete this slide?")){
			var slide_id = jQuery(e).parents('.vertical-slide').remove();
			
			var verticalSlides = jQuery('.vertical-editor-area li.vertical-slide');
			if(verticalSlides.length < 2){
				jQuery('.slide-delete-vertical').remove();
			}
		}		
	},
	
	toggleActiveVerticalSlide: function(e){
		var handle = jQuery(e);
		handle.siblings('div').toggle(0,function(){
			if(jQuery(this).is(':visible')){
				handle.removeClass('closed');
			}else{
				handle.addClass('closed');
			}
		});
	},
		
	setupActiveVerticalSlides: function(){
		var handles = jQuery('.vertical-editor-area h3.vertical');
		for (var i=0; i<handles.length; i++) {
			var handle = jQuery(handles[i]);
			if(handle.siblings('div').is(':visible')){
				handle.removeClass('closed');
			}else{
				handle.addClass('closed');
			}
		};
	},
		
	toggleVerticalSlides: function(e){
		e = jQuery(e);
		var vertical;
		
		if(e.hasClass('slide-convert-vertical')){
			if(confirm("Are you sure you want to add vertical slides?\nAdding Vertical Slides will erase this slide's contents.")){
				var formRows = e.parent().siblings('.formRows');
				var textareas = formRows.find('.vertical-slide textarea.vertical');
				
				// toggle buttons
				e.hide();
				e.parent().children('.slide-revert-vertical').show();
				
				// hide existing editor
				formRows.find('.editor-area').hide();
				// show vertical editor
				formRows.find('.vertical-editor-area').show();
				
				textareas.addClass('slide-content');
                if( typeof(tinyMCE) != 'undefined' ){
    				for (var i=0; i<textareas.length; i++) {
    					if (!tinyMCE.get(textareas[i].id)) {
    						tinyParams = tinyMCEPreInit.mceInit;
    						tinyParams.mode = "exact";
    						tinyParams.elements = textareas[i].id;
    						tinyMCE.init(tinyParams);
    					}
    				};
                }

				vertical = 1;
			}
		} else if( e.hasClass('slide-revert-vertical') ){
			if( confirm("Are you sure you want to remove these vertical slides?\nRemoving the vertical slides will erase this slide's contents.") ){
				// toggle buttons
				e.hide();
				e.parent().children('.slide-convert-vertical').show();
				
				// hide vertical editor
				e.parent().siblings('.formRows').find('.vertical-editor-area').hide();
				// show standard editor
				e.parent().siblings('.formRows').find('.editor-area').show();
				
				var editor = e.parents('.inside').find('textarea')[0];
								
				jQuery(editor).addClass('slide-content');
				jQuery(editor).val('');
				
				// if there's no MCE editor we make one!
				if(!tinyMCE.get(editor.id)){
					tinyParams = tinyMCEPreInit.mceInit;
					tinyParams.mode = "exact";
					tinyParams.elements = editor.id;
					tinyMCE.init(tinyParams);
				}
				
				var row_id = jQuery(editor).parents('.postbox.slide')[0].id;
				SlideDeckSlides.updateEditorControls(jQuery(editor),row_id);
				
				tinyMCE.get(editor.id).setContent('');
				tinyMCE.get(editor.id).save();

				vertical = 0;
			}
		}
		
		// set as a standard slide
		e.parent('.add-delete-controls').siblings('.slide-vertical').val(vertical);
	},
	
	tb_click: function(e){
		if ( typeof tinyMCE != 'undefined' && tinyMCE.activeEditor ) {
			var url = 	jQuery(e).attr('href');
			url = url.split('editor=');
			if(url.length>1){
				url = url[1];
				url = url.split('&');
				if(url.length>1){
					editorid = url[0];
				}
			}
			tinyMCE.get(editorid).focus();
			tinyMCE.activeEditor.windowManager.bookmark = tinyMCE.activeEditor.selection.getBookmark('simple');
			jQuery(window).resize();
		}
	},

	editorNavigation: function(e){
		var p = jQuery(e).parents('li:eq(0)');
		var navs = p.find('.editor-nav a');
		navs.removeClass('active');
		jQuery(e).addClass('active');

		var editor = e.href.split("#")[1];
		var textarea = p.find('textarea.slide-content')[0];
		
		switch(editor){
			case "visual":
                this.switchEditorNav( textarea.id, 'tinymce' );
			break;
			
			case "html":
                this.switchEditorNav( textarea.id, 'html' );
			break;
		}
    },
    
    switchEditorNav: function( textarea_id, mode ){
        var editor = false;
        if(typeof(tinyMCE) != 'undefined'){
            editor = tinyMCE.get(textarea_id);
        }
        var textarea = jQuery('#' + textarea_id);
        
        switch(mode){
            case "tinymce":
                textarea.css('color','#fff').val(switchEditors.wpautop(textarea.val()));
                editor.show();
                tinyMCE.execCommand('mceAddControl', false, textarea_id);
                textarea.css('color','#000');
            break;
            
            case "html":
                textarea.css('color','#000');
                editor.hide();
            break;
        }
    }
};


function send_to_editor(h){
    var ed;
    var editorid;
    var url = jQuery('#TB_window iframe').attr('src');
    url = url.split('editor=');
    if (url.length > 1) {
        url = url[1];
        url = url.split('&');
        if (url.length > 1) {
            editorid = url[0];
        }
    }
    
    if (typeof(tinyMCE) != 'undefined' && (ed = tinyMCE.get(editorid)) && !ed.isHidden()) {
        ed.focus();
        if (tinymce.isIE) 
            ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
        
        if (h.indexOf('[caption') === 0) {
            if (ed.plugins.wpeditimage) 
                h = ed.plugins.wpeditimage._do_shcode(h);
        }
        else 
            if (h.indexOf('[gallery') === 0) {
                if (ed.plugins.wpgallery) 
                    h = ed.plugins.wpgallery._do_gallery(h);
            }
        
        ed.execCommand('mceInsertContent', false, h);
        
    }
    else {
        if(editorid.indexOf('_background') != -1 ){
            if(h.indexOf('<img ') != -1) {
                h = h.match(/src\=\"([a-zA-Z0-9\/\#\&\=\|\-_\+\%\!\?\:\;\.\(\)\~\s]*)\"/)[1];
            }
            jQuery('#' + editorid).val(h);
        }else if (typeof(edInsertContent) == 'function') {
            edInsertContent(document.getElementById(editorid), h);
        }else if(editorid.indexOf('_content') != -1 ) {
            jQuery('#' + editorid).val( jQuery('#' + editorid).val() + h);
        }
    }

	tb_remove();
}


function updateSlideDeckPreview(el){
    var btn = document.getElementById('btn_slidedeck_preview_submit');
    
    var params_raw = btn.href.split('?')[1].split('&');
    var params = {};
    for(var p in params_raw){
        var param = params_raw[p].split('=');
        params[param[0]] = param[1];
    }
    
    params[el.id] = el.value;
    switch(el.id){
        case "preview_w":
            params['width'] = Math.max(630,params[el.id].match(/([0-9]+)/g)[0]) + 20;
        break;
        case "preview_h":
            params['height'] = parseInt(params[el.id].match(/([0-9]+)/g)[0]) + 200;
        break;
    }

    var href = btn.href.split('?')[0];
    var sep = "?";
    for(var k in params){
        href += sep + k + "=" + params[k];
        sep = "&";
    }

    btn.href = href;
}


function closePreviewWatcher(){
    var timer;
    timer = setInterval(function(){
        if(document.getElementById('TB_closeWindowButton')){
            clearInterval(timer);
            jQuery('#TB_closeWindowButton, #TB_overlay').bind('mouseup', function(event){
                cleanUpSlideDecks();
            });
        }
    }, 20);
    
    var SlideDeckSkinTimer;
    SlideDeckSkinTimer = setInterval(function(){
        var slideDeckPreviewWindow = jQuery('#slidedeck_preview_window');
        if(slideDeckPreviewWindow.find('.slidedeck .slide_1').length){
            clearInterval(SlideDeckSkinTimer);
            var classes = slideDeckPreviewWindow.find('.slidedeck_frame')[0].className;
            var classes = classes.split(' ');
            var namespace = "";
            for(var i = 0; i < classes.length; i++){
                if(classes[i].match('skin-([a-zA-Z0-9\-_]+)')){
                    namespace = classes[i].replace('skin-', "");
                }
            }
            if(typeof(SlideDeckSkin) != 'undefined'){
                if(typeof(SlideDeckSkin[namespace]) == 'function'){
                    slideDeckPreviewWindow.find('.slidedeck').each(function(){
                        new SlideDeckSkin[namespace](this);
                    });
                }
            }
        }
    }, 20);
}


function cleanUpSlideDecks(){
    jQuery('body > a').filter(function(){
        return (this.id.indexOf('SlideDeck_Bug') != -1);
    }).remove();
}


var updateImageOptions = {
    options: [],
    
    values: {
        post: ['none', 'content', 'gallery', 'thumbnail'],
        rss: ['none', 'content']
    },
    
    getSelected: function(){
        this.selected = jQuery(this.el).val();
    },
    
    removeOptions: function(){
        // Array must loop backwards since items are being removed from it as the loop runs
        for(var i=this.el_options.length - 1; i>=0; i--){
            this.el.remove(i);
        }
    },
    
    update: function(){
        this.getSelected();
        this.removeOptions();
        
        var post_type = jQuery('input[name*="type"]:checked').val() == "rss" ? "rss" : "post";

        for(var i=0; i<this.options.length; i++){
            var option = this.options[i];
            if(jQuery.inArray(option.value, this.values[post_type]) != -1){
                var newOption = document.createElement('OPTION');
                    newOption.text = option.text;
                    newOption.value = option.value;
                
                if(this.selected == option.value){
                    newOption.selected = "selected";
                }
                
                try {
                    this.el.add(newOption, null);    // Standards compliant, non-IE browsers
                } catch(e) {
                    this.el.add(newOption);          // IE browsers only
                }
            }
        }
    },
    
    initialize: function(){
        var self = this;
        
        this.namespace = SlideDeckSlides.namespace;
        this.el = document.getElementById('slidedeck_image_source');

        if(this.el){
            this.el_options = this.el.options;
            this.getSelected();
            
            for(var i=0; i<this.el_options.length; i++){
                var option = this.el_options[i];
                this.options.push({
                    id: option.id,
                    value: option.value,
                    text: option.text
                });
            };
            
            jQuery(this.el).bind('change.' + this.namespace, function(event){
                self.selected = jQuery(this).val();
            });
            
            jQuery('#smart_slidedeck_type_of_content input[type="radio"]').bind('click.' + this.namespace, function(event){
                self.update();
                this.blur();
            });

            this.update();
        }
    }
};


function updateTBSize(){
	var tbWindow = jQuery('#TB_window'), width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
	if (tbWindow.size()) {
		if (tbWindow.find('#slidedeck_preview_window').length){
			return false;
		}
		tbWindow.width(W - 50).height(H - 45);
		jQuery('#TB_iframeContent').width(W - 50).height(H - 75);
		tbWindow.css({
			'margin-left': '-' + parseInt(((W - 50) / 2), 10) + 'px'
		});
		if (typeof document.body.style.maxWidth != 'undefined') {
            tbWindow.css({
                'top': '20px',
                'margin-top': '0'
            });
        }
	};
	
	return jQuery('.media-buttons a.thickbox, a.slide-background-upload').each(function(){
		var href = this.href;
		if (!href) 
			return;
		href = href.replace(/&width=[0-9]+/g, '');
		href = href.replace(/&height=[0-9]+/g, '');
		this.href = href + '&width=' + (W - 80) + '&height=' + (H - 85);
	});
    alert("Update jQuery Size");
};


(function($){
    window.SkinOptions = {
        elems: {},
        
        previousSkin: "",
        selectedSkin: "",
        
        defaultOptions: {
            autoPlay: false,
            autoPlayInterval: 5,
            cycle: false,
            keys: false,
            scroll: true,
            continueScrolling: false,
            useNewVertical: true,
            hideSpines: false,
            slideTransition: 'slide'
        },
        
        skinOptions: {
            'stacked-nav': {
                activeCorners: false,
                hideSpines: true,
                useNewVertical: true
            },
            'stacked-nav-arrow': {
                activeCorners: false,
                hideSpines: true,
                useNewVertical: true
            },
            'flip': {
                hideSpines: true,
                slideTransition: 'flip'
            },
            'flip-chrome': {
                hideSpines: true,
                slideTransition: 'flip'
            },
            'flip-glass': {
                hideSpines: true,
                slideTransition: 'flip'
            },
            'flip-wood': {
                hideSpines: true,
                slideTransition: 'flip'
            },
            'fullwidth-sexy': {
                hideSpines: true
            },
            'fullwidth-sexy-black': {
                hideSpines: true
            },
            'fullwidth-sexy-brown': {
                hideSpines: true
            },
            'fullwidth-sexy-cyan': {
                hideSpines: true
            },
            'fullwidth-sexy-gray': {
                hideSpines: true
            },
            'fullwidth-sexy-green': {
                hideSpines: true
            },
            'fullwidth-sexy-light-gray': {
                hideSpines: true
            },
            'fullwidth-sexy-orange': {
                hideSpines: true
            },
            'fullwidth-sexy-red': {
                hideSpines: true
            },
            'fullwidth-sexy-silver': {
                hideSpines: true
            },
            'fullwidth-sexy-white': {
                hideSpines: true
            },
            'pagecurl': {
                hideSpines: true,
                slideTransition: 'stack'
            },
            'pagecurl-variation-1': {
                hideSpines: true,
                slideTransition: 'stack'
            },
            'pagecurl-variation-2': {
                hideSpines: true,
                slideTransition: 'stack'
            },
            'simple-slider': {
                hideSpines: true
            },
            'simple-slider-chrome': {
                hideSpines: true
            },
            'simple-slider-elegant': {
                hideSpines: true
            },
            'simple-slider-paper': {
                hideSpines: true
            },
            'simple-slider-ruby': {
                hideSpines: true
            },
            'simple-slider-smoke': {
                hideSpines: true
            },
            'thumbnail': {
                hideSpines: true
            },
            'thumbnail-silver': {
                hideSpines: true
            },
            'thumbnail-slate': {
                hideSpines: true
            },
            'thumbnail-snow': {
                hideSpines: true
            },
            'thumbnail-wood': {
                hideSpines: true
            }
        },
        
        resetOptions: function(){
            if(typeof(this.skinOptions[this.previousSkin]) != 'undefined'){
                for(var k in this.skinOptions[this.previousSkin]){
                    if(typeof(this.elems[k]) != 'undefined'){
                        this.setOption(k, this.defaultOptions[k]);
                        
                        this.elems[k].next('input[type="hidden"][name="' + this.elems[k].attr('name') + '"]').remove();
                        this.elems[k].removeClass('disabled')[0].disabled = false;
                        this.elems[k].closest('label').removeClass('disabled');
                    }
                }
            }
        },
        
        setOption: function(fieldName, value){
            if(typeof(this.elems[fieldName]) != 'undefined'){
                var field = this.elems[fieldName];
                var fieldVal = field.val();
                
                switch(field[0].nodeName){
                    case "INPUT":
                        switch(field.attr('type')){
                            case "checkbox":
                            case "radio":
                                if(value == true){
                                    field.attr('checked', 'checked')[0].checked = true;
                                } else {
                                    field.removeAttr('checked')[0].checked = false;
                                }
                            break;
                            
                            case "text":
                                field.val(value);
                            break;
                        }
                    break;
                    
                    case "SELECT":
                        field.find('option').removeAttr('selected', 'selected').each(function(){
                            if(this.value == value){
                                this.selected = true;
                            }
                        });
                        
                        fieldVal = field.find('option:selected').val();
                    break;
                }
                
                field.attr('disabled', 'disabled')[0].disabled = true;
                if(field.next('input[type="hidden"][name="' + field.attr('name') + '"]').length){
                    field.next('input[type="hidden"][name="' + field.attr('name') + '"]').val(fieldVal);
                } else {
                    field.after('<input type="hidden" name="' + field.attr('name') + '" value="' + fieldVal + '" />');
                }
                field.closest('label').addClass('disabled');
            }
        },
        
        updateOptions: function(skin){
            var self = this;
            this.updateSelectedSkin();
            
            this.resetOptions();
            
            if(typeof(this.skinOptions[this.selectedSkin]) != 'undefined'){
                for(var k in this.skinOptions[this.selectedSkin]){
                    if(typeof(this.elems[k]) != 'undefined'){
                        this.setOption(k, this.skinOptions[this.selectedSkin][k]);
                    }
                }
            }
        },
        
        updateSelectedSkin: function(){
            this.previousSkin = this.selectedSkin;
            this.selectedSkin = this.elems.skinSelector.find('option:selected').val();
        },
        
        initialize: function(){
            var self = this;
            
            this.elems.skinSelector = $('#slide-skin');
            
            // Fail silently if this page does not have the skin selector
            if(this.elems.skinSelector.length < 1){
                return false;
            }
            
            for(var k in this.defaultOptions){
                this.elems[k] = $('[name="slidedeck_options[' + k + ']"]');
            }
            
            this.updateSelectedSkin();
            
            this.elems.skinSelector.bind('change', function(event){
                self.updateOptions();
            });
            
            // Set initial options based off the chosen skin
            this.updateOptions();
        }
    };
    

	function overviewWrap(){
        if($('.overview-options').length){
            if($(document).width() < 1240) {
                $('.overview-options').find('.rss-feed').css({
                    width: 'auto',
                    'float': 'none'
                })
                $('#overview_options_form')[0].style.width = '100%';
            } else {
                $('.overview-options').find('.rss-feed').css({
                    width: "45%",
                    'float': "right"
                })
                $('#overview_options_form')[0].style.width = '';
            }
        }
	}
	
	$(document).ready(function(){
        updateImageOptions.initialize();
        
        SkinOptions.initialize();
        
		$('.slide-title').bind('keyup.' + SlideDeckSlides.namespace, function(){
			SlideDeckSlides.updateTitle(this);
		});

		$('.editor-nav a.mode').bind('click.' + SlideDeckSlides.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.editorNavigation(this);
		});

		$('.slide-delete').bind('click.' + SlideDeckSlides.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.deleteSlide(this);
		});
        
        $('.slide .handlediv').bind('click.' + SlideDeckSlides.namespace, function(event){
            event.preventDefault();
            $(this).parent().find('.inside').toggle();
        });

		$('.media-buttons a.thickbox').bind('click.' + SlideDeckSlides.namespace, function(){
			SlideDeckSlides.tb_click(this);
		});
		
		$('.add-slide-vertical a').bind('click.' + SlideDeckSlides.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.addVerticalSlide(this);
		});
		
		$('.slide-delete-vertical').bind('click.' + SlideDeckSlides.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.deleteVerticalSlide(this);
		});
		
		$('.slide-toggle-vertical').bind('click.' + SlideDeckSlides.namespace, function(event){
            event.preventDefault();
			SlideDeckSlides.toggleVerticalSlides(this);
		});

		SlideDeckSlides.setupActiveVerticalSlides();
		$('.vertical-editor-area h3.vertical').bind('click.' + SlideDeckSlides.namespace, function(){
			SlideDeckSlides.toggleActiveVerticalSlide(this);
		});

		$('#btn_add-another-slide').bind('click.' + SlideDeckSlides.namespace, function(event){
			event.preventDefault();
			SlideDeckSlides.addSlide(this);
		});
		
		if($('.slide-order').length){
			$('.slide-order').sortable({
				update: function(event,ui){
					$('ul.slide-order').find('li:not(.ui-sortable-helper)').each(function(inc){
						var target = $(this).find('a.hndle').attr('href').split("#")[1];
						$('#' + target).find('input.slide-order').val(inc + 1);
					});
				}
			});
		}
		
		$('a.navigation-type').bind('click', function(event){
			event.preventDefault();
			if(!$(this).hasClass('disabled')){
				var slug = this.href.split("#")[1];
				$('a.navigation-type').removeClass('active');
				$(this).addClass('active');
				$('#slidedeck_navigation_type').val(slug);
			}
		});
		
		// Event listener for showing/hiding RSS feed entry field.
		$('#smart_slidedeck_type_of_content :radio').change(function(event){
            
			if($(this).val() == 'rss'){
				$('#dynamic_rss_meta').slideDown();
				// hide the filter posts by category option and children.
				$('#filter_posts_by_category').slideUp();
				
				// Hide the additional image options
				$('#image_option_gallery, #image_option_thumbnail').hide();
				if(($('#slidedeck_image_source').val() == 'thumbnail') || ($('#slidedeck_image_source').val() == 'gallery')){
					$('#slidedeck_image_source').attr('value','content');
				}
                $('#slidedeck_dynamic_options_type_hidden').val("rss");
			} else {
				// Show the filter posts by category option and children.
				if($('#slidedeck_dynamic_options_post_type_select').val() == 'post'){
                    $('#filter_posts_by_category').slideDown();
                } else {
                    $('#filter_posts_by_category').slideUp();
                }
		        
                $('#dynamic_rss_meta').slideUp();
                
                $('#slidedeck_dynamic_options_type_hidden').val($('#slidedeck_dynamic_options_type_posts_select').val());
			}
		});
        
        if(document.getElementById('slidedeck_dynamic_options_type_posts_select')){
            $('#slidedeck_dynamic_options_type_posts_select').change(function(event){
                if($('#slidedeck_dynamic_options_type_posts').is(':checked')){
                    $('#slidedeck_dynamic_options_type_hidden').val($(this).val());
                }
            });
        }
        
        if(document.getElementById('slidedeck_dynamic_options_post_type_select')){
            $('#slidedeck_dynamic_options_post_type_select').change(function(event){
				if($(this).val() == 'post'){
                    $('#filter_posts_by_category').slideDown();
                } else {
                    $('#filter_posts_by_category').slideUp();
                }
            });
        }
		
        if(document.getElementById('slidedeck_dynamic_options_type_posts_label')){
            $('#slidedeck_dynamic_options_type_posts_label').click(function(event){
				if($('#slidedeck_dynamic_options_post_type_select').val() == 'post'){
                    $('#filter_posts_by_category').slideDown();
                } else {
                    $('#filter_posts_by_category').slideUp();
                }
                $('#dynamic_rss_meta').slideUp();
                $('#slidedeck_dynamic_options_type_hidden').val($('#slidedeck_dynamic_options_type_posts_select').val());
                $('#slidedeck_dynamic_options_type_posts')[0].checked = true;
            });
        }
        
		// Check to see if RSS is the selected option.
		if($('#smart_slidedeck_type_of_content input[type="radio"]:checked').val() == 'rss'){
            // Show the URL field for RSS Dynamic SlideDeck.
			$('#dynamic_rss_meta').show();
			
            // hide the filter posts by category option and children.
            $('#filter_posts_by_category').hide();
            
		} else {
			// Hide the URL field for RSS Dynamic SlideDeck.
			$('#dynamic_rss_meta').hide();

			// Show the filter posts by category option and children.
			if ($('#slidedeck_dynamic_options_post_type_select').val() == 'post') {
                $('#filter_posts_by_category').show();
            }
		}
		
		// Replace empty excerpt length fields with zero
		if($('#slidedeck_excerpt_length_with_image, #slidedeck_excerpt_length_without_image').length){
			$('#slidedeck_excerpt_length_with_image, #slidedeck_excerpt_length_without_image').blur(function(event){
				if($(this).val() == ''){
					$(this).attr('value',0);
				}
			});
		}
        
        // Save editor tab states when saving the deck.
        $('#slidedeck-options #publishing-action input').bind('click', function(event){
            var editors = jQuery('.editor-area:not(:hidden), .vertical-editor-wrapper:not(:hidden)');
            var editorStates = [];
            for ( var i=0 ; i < editors.length ; i++ ) {
                editorStates.push( jQuery(editors[i]).find('.editor-nav .mode.active').attr('href').split('#')[1] );
            };
            jQuery.cookie( 'slidedeck_editor_state_' + jQuery('#slidedeck_id').val(), editorStates, { expires: 365 } );
        });
		
		$('#slidedeck_filter_by_category').bind('click.' + SlideDeckSlides.namespace, function(event){
			if(this.checked == true){
				$('#category_filter_categories').slideDown();
			} else {
				$('#category_filter_categories').slideUp();
			}
		});
		
		$('#slidedeck_total_slides').bind('change.' + SlideDeckSlides.namespace, function(){
			if(this.value > 5){
				$('#navigation_simple-dots').click();
				$('#navigation_dates, #navigation_post-titles').addClass('disabled');
			} else {
				$('#navigation_dates, #navigation_post-titles').removeClass('disabled');
			}
		});
		$('#slidedeck_total_slides').trigger('change');
		
		$('a.skin-thumbnail').bind('click', function(event){
			event.preventDefault();
			var slug = this.href.split("#")[1];
			$('a.skin-thumbnail').removeClass('active');
			$(this).addClass('active');
			$('#slidedeck_skin').val(slug);
			setNavigation(slug);
		});
		$('a.skin-thumbnail.active').each(function(){
			var slug = this.href.split("#")[1];
			setNavigation(slug);
		});
		
		function setNavigation(slug){
		    switch(slug){
		        case "image_caption_bottom":
		        case "image_caption_top":
		        case "image_no_caption":
		        case "vertical-dark":
		        case "vertical-light":
		        case "vertical-stacked-arrow":
		        case "vertical-stacked":
		        case "simple-slider":
		        case "thumbnail":
		          $('a.navigation-type').addClass('disabled');
		        break;
		        
		        default:
    				if($('#slidedeck_total_slides').val() > 5){
    					$('#navigation_simple-dots').click();
    					$('#navigation_simple-dots').removeClass('disabled');
    					$('#navigation_dates, #navigation_post-titles').addClass('disabled');
    				} else {
    					$('a.navigation-type').removeClass('disabled');
    				}
		        break;
		    }
		};		
		
		if($('#form_action').val() == "create"){
			$('#titlewrap #title').css({
				color: '#999',
				fontStyle: 'italic'
			}).focus(function(event){
                this.style.color = "";
				this.style.fontStyle = "";
				if(this.value == this.defaultValue){
    				this.value = "";
                }
			});
		}

		$('a.slidedeck-action.delete, a.submitdelete.deletion').bind('click.' + SlideDeckSlides.namespace, function(event){
			event.preventDefault();
			
			if(confirm("Are you sure you want to delete this SlideDeck?\nThis CANNOT be undone.")){
				var callback;
				if($(this).hasClass('submitdelete')){
					var href = this.href.split("&")[0];
					callback = function(){
						document.location.href = href;
					};
				} else {
					var row = $(this).parents('tr');
					callback = function(){
						row.fadeOut(500,function(){
							row.remove();
						});
					};
				}
				$.get(this.href,function(){
					callback();
				});
			}
		});
		
		$('#template_snippet_w, #template_snippet_h').bind('keyup.' + SlideDeckSlides.namespace, function(event){
			var element = this;
			if (this.timer) {
				clearTimeout(element.timer);
			}
			this.timer = setTimeout(function(){
				var w = $('#template_snippet_w').val(),
					h = $('#template_snippet_h').val(),
					slidedeck_id = $('#slidedeck_id').val();
				
				var snippet = "<" + "?php slidedeck( " + slidedeck_id + ", array( 'width' => '" + w + "', 'height' => '" + h + "' ) ); ?" + ">";
				
				$('#slidedeck-template-snippet').val(snippet);
			},100);
			return true;
		});
		
		$('#slidedeck-template-snippet').focus(function(){
			this.select();
		});
        
        updateTBSize();
        
        overviewWrap();
        
        var overviewFeed = $('.overview-options .rss-feed');
        if(overviewFeed.length){
        	$.ajax({
        		url: ajaxurl,
        		data: "action=slidedeck_blog_feed",
        		type: 'GET',
        		complete: function(data){
        			var response = data.responseText;
        			var feedBlock = $('#slidedeck-blog-rss-feed');
        			
        			if(response != "false"){
        				feedBlock.html(data.responseText);
        			} else {
        				feedBlock.text("Unable to connect to feed!");
        				setTimeout(function(){
        					overviewFeed.fadeOut();
        				}, 1000);
        			}
        		}
        	});
        }
	});
    
    
    $(window).load(function(){
        // Load editor states when the dom is ready.
        var editors = jQuery('.editor-area:not(:hidden), .vertical-editor-wrapper:not(:hidden)');
        var editorModeCookie = jQuery.cookie( 'slidedeck_editor_state_' + jQuery('#slidedeck_id').val() );
        if( editorModeCookie ){
            editorModeCookie = editorModeCookie.split(',');
        }
        if( editorModeCookie ){
            for ( var i=0 ; i < editors.length ; i++ ) {
                jQuery(editors[i]).find('.editor-nav a.editor-' + editorModeCookie[i] ).trigger('click');
            };
        }
        $('.ajax-masker').hide();
    });
    
	// thickbox settings
	$(window).resize(function() {
        updateTBSize();
        overviewWrap();
	});
})(jQuery);

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
