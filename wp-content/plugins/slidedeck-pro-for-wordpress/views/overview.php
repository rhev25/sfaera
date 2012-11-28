<?php
/**
 * Overview list of SlideDecks
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
 * @uses slidedeck_show_message()
 * @uses wp_nonce_url()
 */
?>
<div class="slidedeck-wrapper">
    <div id="callout-sidebar">
        <div class="follow-twitter callout-button"><p>For tips, tricks &amp; discounts</p><a href="http://twitter.com/slidedeck" target="_blank" class="button"><span class="inner"><img src="<?php echo slidedeck_url( '/images/twitter.png' ); ?>" /> Follow Us on Twitter</span></a></div>
        <div class="view-screencasts callout-button"><p>For how-to's and troubleshooting</p><a href="http://www.slidedeck.com/screencasts/" target="_blank" class="button"><span class="inner"><img src="<?php echo slidedeck_url( '/images/youtube.png' ); ?>" /> View Our Screencasts</span></a></div>
        <div class="bug-report callout-button"><p>Help us squash the bugs</p><a href="http://www.getsatisfaction.com/slidedeck/topics" target="_blank" class="button"><span class="inner"><img src="<?php echo slidedeck_url( '/images/bug.png' ); ?>" /> Report a bug for SlideDeck</span></a></div>
    </div>
    <div class="wrap" id="slidedeck_overview">
    	<div id="icon-edit" class="icon32"></div>
        <h2>Edit SlideDecks 
            <a class="button add-new-h2" href="<?php echo slidedeck_action( '/slidedeck_add_new' ); ?>">Add New</a>
            <a class="button add-new-h2" href="<?php echo slidedeck_action( '/slidedeck_dynamic' ); ?>" style="margin-left:0;"><img src="<?php echo slidedeck_url( '/images/icon_dynamic.png' ); ?>" alt="Smart SlideDeck" /> Add Smart SlideDeck</a>
        </h2>
    	
        <?php echo slidedeck_show_message(); ?>
        
        <?php if( (boolean) SLIDEDECK_LEGACY_IMPORT_COMPLETE !== true ): ?>
            <div class="intro-text">
                <p>It doesn't look like you have run the plugin upgrade yet to import your legacy SlideDecks. Please go to the <a href="<?php echo clean_url( admin_url( 'plugins.php' ) ); ?>">plugins section</a> to deactivate and reactivate this plugin.</p>
            </div>
        <?php endif; ?>
        
    	<?php if( !empty( $slidedecks ) ): ?>
    		<table id="slidedecks" class="widefat post fixed" cellspacing="0">
    			<thead>
    				<tr>
    					<th class="manage-column column-title" scope="col"><a href="<?php echo slidedeck_orderby( 'title' ); ?>"<?php echo slidedeck_get_current_orderby( 'title' ) !== false ? ' class="order ' . slidedeck_get_current_orderby( 'title' ) . '"' : ''; ?>>Title</a></th>
    					<th width="150" class="manage-column" scope="col">Actions</th>
    					<th width="80" class="manage-column column-date" scope="col"><a href="<?php echo slidedeck_orderby( 'modified' ); ?>"<?php echo slidedeck_get_current_orderby( 'modified' ) !== false ? ' class="order ' . slidedeck_get_current_orderby( 'modified' ) . '"' : ''; ?>>Modified</a></th>
    				</tr>
    			</thead>
    			<tfoot>
    				<tr>
    					<th class="manage-column column-title" scope="col">Title</th>
    					<th class="manage-column" scope="col">Actions</th>
    					<th class="manage-column column-date" scope="col">Modified</th>
    				</tr>
    			</tfoot>
    			<tbody>
    				<?php $alternate = 0; ?>
    				<?php foreach( (array) $slidedecks as $slidedeck ): ?>
    					<tr class="author-self status-publish iedit<?php echo ( $alternate & 1 ) ? ' alternate' : ''; ?>" valign="top">
    						<td class="post-title column-title">
    							<a href="<?php echo slidedeck_action( $slidedeck['dynamic'] == '1' ? '/slidedeck_dynamic' : '' ); ?>&action=edit&id=<?php echo $slidedeck['id']; ?>">
        							<?php if( $slidedeck['dynamic'] == '1' ): ?>
        								<img src="<?php echo slidedeck_url( '/images/icon_dynamic.png' ); ?>" alt="Smart SlideDeck" />
        							<?php endif; ?>
                                    <?php echo $slidedeck['title']; ?>
                                </a> <span class="slidedeck-id">[<?php echo $slidedeck['id']; ?>]</span>
    						</td>
    						<td class="manage-column" scope="col">
    							<a href="<?php echo slidedeck_action( $slidedeck['dynamic'] == '1' ? '/slidedeck_dynamic' : '' ); ?>&action=edit&id=<?php echo $slidedeck['id']; ?>" class="slidedeck-action">Edit</a>
    							<a href="<?php echo wp_nonce_url( slidedeck_action() . '&action=delete&id=' . $slidedeck['id'], 'slidedeck-delete' ); ?>" class="slidedeck-action delete">Delete</a>
    						</td>
    						<td class="date column-date"><?php echo date( "Y/m/d", strtotime( $slidedeck['updated_at'] ) ); ?></td>
    					</tr>
    					<?php $alternate++; ?>
    				<?php endforeach; ?>
    			</tbody>
    		</table>
    	<?php else: ?>
    	<div id="message" class="updated">
    		<p>No SlideDecks found! <a href="<?php echo slidedeck_action( '/slidedeck_add_new' ); ?>">Create a New SlideDeck</a> or <a href="<?php echo slidedeck_action( '/slidedeck_dynamic' ); ?>">Create a New Smart SlideDeck</a></p>
    	</div>
    	<?php endif; ?>
    	
    	<div class="overview-options">
			<div class="rss-feed">
			    <div id="slidedeck_blog_feed">
			        <h3>Product Blog <span>news, tips &amp; trends</span></h3>
			        <div id="slidedeck-blog-rss-feed">Fetch RSS Feed...</div>
			    </div>
			</div>
			
			<?php if( current_user_can('manage_options') ){ ?>
            <form action="" method="post" id="overview_options_form">
            <div>
                <h3>Advanced SlideDeck Options</h3>
                <p class="intro">These options are for situations where SlideDeck might not be working correctly. Only change them if you are having difficulty with your SlideDeck installation, or if you are certain of what they do.</p>
                <?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'slidedeck-for-wordpress', 'slidedeck-' . $form_action . '_wpnonce' ) : ''; ?>
                <input type="hidden" name="action" value="<?php echo $form_action; ?>" id="action" />
                    <ul>
                        <li>
                            <label><input type="checkbox" name="disable_wpautop" value="1"<?php echo $slidedeck_global_options['disable_wpautop'] == true ? ' checked="checked"' : ''; ?> /> Disable the <code>wpautop()</code> function?</label>
                        </li>
                        <li>
                            <label><input type="checkbox" name="enable_ssl_check" value="1"<?php echo $slidedeck_global_options['enable_ssl_check'] == true ? ' checked="checked"' : ''; ?> /> Enable SSL Support? (can be buggy on some servers)</label>
                        </li>
                        <li>
                            <label><input type="checkbox" name="dont_enqueue_scrollwheel_library" value="1"<?php echo $slidedeck_global_options['dont_enqueue_scrollwheel_library'] == true ? ' checked="checked"' : ''; ?> /> Don't enqueue the jquery.mousewheel.js library (if you have your own solution)</label>
                        </li>
						<li>
							<label><input type="checkbox" name="disable_edit_create" value="1"<?php echo $slidedeck_global_options['disable_edit_create'] == true ? ' checked="checked"' : ''; ?> /> Disable the ability to Add New and Edit SlideDecks for non Admins</label>
						</li>
                    </ul>
                <input type="submit" class="button-primary" value="Update Options" />
            </div>
            </form>
			<?php } ?>
        </div>
    </div>
</div>
