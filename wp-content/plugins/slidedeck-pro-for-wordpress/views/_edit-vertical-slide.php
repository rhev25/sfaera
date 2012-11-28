<?php
/**
 * Vertical slide template
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
 * @uses slidedeck_dir()
 */

$is_template = (boolean) !isset( $i );
if( $is_template ) {
    $is_vertical = false;
}
$editor_id = $is_template ? "" : ('slide_' . $count . '_content_vertical_' . ( $i + 1 ) . '_parent');
?>

<h3 class="hndle vertical">
    <span class="name"><?php echo $is_template ? '&nbsp;' : ( empty( $slide['title'] ) ? "Slide " . $slide['slide_order'] : $slide['title'] ); ?></span>
     - 
    <span class="index"><?php echo $is_template ? '&nbsp;' : ( $i + 1 ); ?></span>
</h3>
<a class="slide-delete-vertical" href="#<?php echo $i + 1 ?>">Delete Slide</a>

<div class="vertical-editor-wrapper">
    <label>Slide Title: <input type="text" name="<?php echo !$is_template ? 'slide[' . $count . '][vertical_title][]' : ''; ?>" maxlength="255" size="40" class="vertical-slide-title" value="<?php echo empty( $vertical_titles[$i] ) ? 'Vertical Slide ' . ( $i + 1 ) : $vertical_titles[$i]; ?>" /></label>
    
    <span class="vertical-slide-media">
	    <?php include( slidedeck_dir( '/views/_editor_media_buttons.php' ) ); ?>
    </span>
    
	<div class="editor-container">
		<textarea class="vertical<?php echo $is_vertical ? ' slide-content' : ''; ?>" id="<?php echo $editor_id; ?>" name="<?php echo !$is_template ? 'slide[' . $count . '][vertical_content][]' : ''; ?>"><?php echo htmlspecialchars( slidedeck_process_slide_content( $vertical_content[$i], true ), ENT_QUOTES ); ?></textarea>
	</div>
</div>