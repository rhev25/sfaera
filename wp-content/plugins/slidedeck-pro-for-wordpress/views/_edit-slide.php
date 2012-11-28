<?php
/**
 * Individual slide markup
 * 
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
 * 
 * @uses slidedeck_get_option()
 * @uses slidedeck_dir()
 */

$is_vertical = isset( $slide['id'] ) ? in_array( $slide['id'], explode( ',', slidedeck_get_option( $slidedeck, 'vertical_slides' ) ) ) : false;
if( $is_vertical ) {
    $vertical_data = unserialize( $slide['content'] );
    
    if( array_key_exists( 'contents', $vertical_data ) ) {
        // Support for new storage structure with titles for vertical slides
        $vertical_content = $vertical_data['contents'];
        $vertical_titles = $vertical_data['titles'];
    } else {
        // Else, legacy support
        $vertical_content = $vertical_data;
    }
}
?>
<div id="slide_editor_<?php echo $count; ?>" class="postbox slide">
    
    <div title="Click to toggle" class="handlediv">&nbsp;</div>
    
	<h3 class="hndle"><span><?php echo empty( $slide['title'] ) ? "Slide " . $slide['slide_order'] : $slide['title']; ?></span></h3>
	
	<div class="inside">
	    
		<?php if( isset( $slide['id']) && !empty( $slide['id'] ) ): ?>
			<input type="hidden" name="slide[<?php echo $count; ?>][id]" value="<?php echo $slide['id']; ?>" />
		<?php endif; ?>
        
		<div class="add-delete-controls">
            <a<?php echo $is_vertical ? ' style="display:none;"' : ''; ?> class="button slide-convert-vertical slide-toggle-vertical" title="Available in Pro version only">Convert to Vertical Slide</a>
			<a<?php echo !$is_vertical ? ' style="display:none;"' : ''; ?> class="button slide-revert-vertical slide-toggle-vertical">Revert to Standard Slide</a>
            
			<a href="#<?php echo $count; ?>" class="slide-delete">Delete Slide</a>
		</div>
        
		<input type="hidden" name="slide[<?php echo $count; ?>][slide_order]" value="<?php echo $slide['slide_order']; ?>" class="slide-order" />
		<input type="hidden" name="slide[<?php echo $count; ?>][vertical]" value="<?php echo $is_vertical ? '1' : '0' ; ?>" class="slide-vertical" />
        
		<ol class="formRows">
		    
			<li>
				<label>Slide Title:</label>
				<input type="text" name="slide[<?php echo $count; ?>][title]" value="<?php echo empty( $slide['title'] ) ? 'Slide ' . $count : $slide['title']; ?>" size="40" maxlength="255" class="slide-title" />
			</li>
            
			<li<?php echo $is_vertical ? ' style="display:none;"' : ''; ?> class="editor-area">
				<?php $editor_id = "slide_{$count}_content"; ?>

                <span class="horizontal-slide-media">
				    <?php include('_editor_media_buttons.php'); ?>
                </span>
				
				<div class="editor-container">
					<textarea name="slide[<?php echo $count; ?>][content]" cols="80" rows="10" class="horizontal<?php echo !$is_vertical ? ' slide-content' : ''; ?>" id="<?php echo $editor_id; ?>"><?php echo htmlspecialchars( slidedeck_process_slide_content( $slide['content'], true ), ENT_QUOTES ); ?></textarea>
				</div>
			</li>
            
			<li class="vertical-editor-area"<?php echo !$is_vertical ? ' style="display:none;"' : ''; ?>>
			    
				<div class="add-slide-vertical"><a class="button">Add Vertical Slide</a></div>
                
				<ul>
					<?php if( $is_vertical ): ?>
                    
    					<?php for( $i = 0; $i < count( $vertical_content ); $i++ ): ?>
                            
                        	<li class="vertical-slide">
                        	    <?php include( slidedeck_dir( '/views/_edit-vertical-slide.php' ) ); ?>
    						</li>
                            
                        <?php endfor; ?>
                        
					<?php else: ?>
                    
    					<?php for( $i = 0; $i < 2; $i++ ): ?>

							<li class="vertical-slide">
                        	    <?php include( slidedeck_dir( '/views/_edit-vertical-slide.php' ) ); ?>
							</li>
                            
					    <?php endfor; ?>
                        
					<?php endif; ?>
                    
					<li class="vertical_slide_template" style="display:none;">
                        <h3 class="hndle vertical closed">
                            <span class="name">&nbsp;</span>
                             - 
                            <span class="index">&nbsp;</span>
                        </h3>
                        <a class="slide-delete-vertical" href="#">Delete Slide</a>
                        <div class="vertical-editor-wrapper">
                            <label>Slide Title: <input type="text" name="" maxlength="255" size="40" class="vertical-slide-title" /></label>
                            
                            <span class="vertical-slide-media">
                                <?php $editor_id = ""; ?>
                                <?php include( slidedeck_dir( '/views/_editor_media_buttons.php' ) ); ?>
                            </span>
                            
                            <div class="editor-container">
                        		<textarea name="" id="" class="vertical"></textarea>
                        	</div>
                        </div>
					</li>
                    
				</ul>
                
			</li>
            
            <li class="slide-background-url">
				<label>Slide Background Image URL:</label>
				<input id="slide_background_<?php echo $count; ?>" type="text" name="slidedeck_options[slide_backgrounds][]" value="<?php echo isset( $slide['background'] ) && !empty( $slide['background'] ) ? $slide['background'] : ''; ?>" size="30" maxlength="255" />
                
                <?php
        			$uploading_iframe_ID = $slide['gallery_id'];
        			$media_upload_iframe_src = get_bloginfo( 'wpurl' ) . '/wp-admin/media-upload.php?post_id=' . $uploading_iframe_ID . '&amp;editor=slide_background_' . $count;
        			$image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', $media_upload_iframe_src . "&amp;type=image" );
                ?>
                <a href="<?php echo $image_upload_iframe_src; ?>&amp;TB_iframe=true" class="thickbox slide-background-upload button" title="Add a Background Image" onclick="return false;">Upload/Set</a>
                
                <em><strong>Beta Feature</strong> - <strong>NEW!</strong> Now upload images using the media library!</em>
            </li>
            
		</ol>
        
	</div>
    
</div>