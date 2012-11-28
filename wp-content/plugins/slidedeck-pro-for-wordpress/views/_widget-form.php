<?php
/**
 * SlideDeck Widget control form
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
 */
?>
<p>Display a SlideDeck in a widget area. <em><strong>NOTE:</strong> since most widget areas are narrow sidebars, your SlideDeck may not appear correctly. We only recommend placing SlideDecks in wider widget areas like headers and footers.</em></p>
<p><label><strong>Choose a SlideDeck:</strong><br />
<select name="<?php echo $this->get_field_name( 'slidedeck_id' ); ?>" id="<?php echo $this->get_field_id( 'slidedeck_id' ); ?>" class="widefat">
    <?php foreach( (array) $slidedecks as $slidedeck ): ?>
    <option value="<?php echo $slidedeck['id']; ?>"<?php echo $slidedeck_id == $slidedeck['id'] ? ' selected="selected"' : ''; ?>><?php echo $slidedeck['title']; ?></option>
    <?php endforeach; ?>
</select>
</label></p>
<p>Dimensions: <input type="text" name="<?php echo $this->get_field_name( 'width' ); ?>" size="4" value="<?php echo $width; ?>" /> x <input type="text" name="<?php echo $this->get_field_name( 'height' ); ?>" size="4" value="<?php echo $height; ?>" /></p>