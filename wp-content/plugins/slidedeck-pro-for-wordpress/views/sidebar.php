<?php
/**
 * Sidebar meta box for posts and pages
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
 * @uses wp_nonce_field()
 */
?>
<div id="slidedeck-meta-sidebar" style="overflow:hidden;position:relative;">
    <div class="misc-pub-section">
        <?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'slidedeck-for-wordpress', 'slidedeck-for-wordpress-dynamic-meta_wpnonce' ) : ''; ?>
        <p><strong>Smart SlideDeck Options</strong></p>
        <p><label for="slidedeck_slide_title">Slide Title:</label>
        <input type="text" name="_slidedeck_slide_title" value="<?php echo $slidedeck_post_meta['_slidedeck_slide_title']; ?>" size="25" maxlength="40" id="slidedeck_slide_title" class="form-input-tip" /></p>
        <p><label><input type="checkbox" name="_slidedeck_post_featured" value="1"<?php echo (boolean) $slidedeck_post_meta['_slidedeck_post_featured'] == true ? ' checked="checked"' : ''; ?> /> Feature This Post in <em>Smart SlideDecks</em></label></p>
    </div>
	<div class="misc-pub-section last">
        Place your cursor in the post body where you want to insert a SlideDeck and click the <em>Insert SlideDeck</em> button below to choose a SlideDeck and add it to your post.
    	<p style="text-align:center;margin: 10px 0;">
            <a href="#insert" class="slidedeck-sidebar-insert button">
                <span class="inner">Insert SlideDeck</span>
            </a>
        </p>
    </div>
</div>