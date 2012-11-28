<?php
/**
 * TinyMCE plugin dialog markup
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
 * @uses slidedeck_action()
 * @uses slidedeck_url()
 */
?>
<div id="slidedeck_tinymce_dialog">
	<p>Choose a SlideDeck from the list below to embed in your post:</p>
	<?php if( isset( $slidedecks ) && !empty( $slidedecks ) ): ?>
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column column-title" scope="col">Title</th>
					<th width="90" class="manage-column column-date" scope="col">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php $alternate = 0; ?>
				<?php foreach( (array) $slidedecks as $slidedeck ): ?>
					<tr id="slidedeck_id_<?php echo $slidedeck['id']; ?>" class="author-self status-publish iedit<?php echo ( $alternate & 1 ) ? ' alternate' : ''; ?><?php echo ( $slidedeck['dynamic'] == '1' ) ? ' dynamic' : ''; ?>" valign="top">
						<td class="post-title column-title">
							<?php if( $slidedeck['dynamic'] == '1' ): ?>
								<img src="<?php echo slidedeck_url( '/images/icon_dynamic.png' ); ?>" alt="Dynamic SlideDeck" />
							<?php endif; ?>
							<?php echo $slidedeck['title']; ?>
						</td>
						<td clsss="date column-date"><?php echo date( "Y/m/d", strtotime( $slidedeck['updated_at'] ) ); ?></td>
					</tr>
					<?php $alternate++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="dialog-other-options">
			Dimensions: <input type="text" size="5" value="100%" id="slidedeck_tinymce_dimension_w" /> x <input type="text" size="5" value="300px" id="slidedeck_tinymce_dimension_h" />
		</div>
	<?php else: ?>
	<div class="message">
		<p>No SlideDecks found! <a href="<?php echo slidedeck_action( '/slidedeck_add_new' ); ?>">Create a New SlideDeck</a></p>
	</div>
	<?php endif; ?>
</div>
