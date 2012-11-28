<?php
/**
 * Edit/Create Dynamic SlideDeck form
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
 * @uses slidedeck_dir()
 * @uses slidedeck_show_message()
 * @uses slidedeck_get_dynamic_option()
 */
?>
<div class="wrap" id="dynamic_slidedeck_form">
	<div id="icon-edit" class="icon32"></div><h2><?php echo "create" == $form_action ? "Add Smart SlideDeck" : "Edit Smart SlideDeck"; ?></h2>
    
    <?php echo slidedeck_show_message(); ?>
    
	<form action="" method="post" id="dynamic_slidedeck_form">
	    <?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'slidedeck-for-wordpress', 'slidedeck-' . $form_action . '_wpnonce' ) : ''; ?>
		<input type="hidden" name="action" value="<?php echo $form_action; ?>" id="form_action" />
		<input type="hidden" name="gallery_id" value="<?php echo $slidedeck['gallery_id']; ?>" id="slidedeck_gallery_id" />
		<input type="hidden" name="dynamic" value="1" />
        <input type="hidden" name="skin" value="default" />
		<input type="hidden" name="slidedeck_options[hideSpines]" value="<?php echo $slidedeck['slidedeck_options']['hideSpines']; ?>" />
		<input type="hidden" name="slidedeck_options[cycle]" value="<?php echo $slidedeck['slidedeck_options']['cycle']; ?>" />
		<?php if( isset( $slidedeck['id'] ) && !empty( $slidedeck['id'] ) ): ?>
			<input type="hidden" name="id" value="<?php echo $slidedeck['id']; ?>" id="slidedeck_id" />
		<?php endif; ?>
		<div class="metabox-holder has-right-sidebar">
			<div class="inner-sidebar">
				<div id="slidedeck-options" class="postbox">
					<h3 class="hndle">SlideDeck Options</h3>
					<div class="inside">
                        <div class="misc-pub-section">
                            <label><input type="checkbox" name="slidedeck_options[keys]" value="true"<?php echo slidedeck_get_option( $slidedeck, 'keys' ) == 'true' ? ' checked="checked"' : ''; ?> /> Allow Keyboard Navigation</label>
                            <label><input type="checkbox" name="slidedeck_options[scroll]" value="true"<?php echo slidedeck_get_option( $slidedeck, 'scroll' ) == 'true' ? ' checked="checked"' : ''; ?> /> Allow Scroll Wheel Navigation</label>
                        </div>
                        <div class="misc-pub-section"><label>Slide Transition:
                            <select name="slidedeck_options[slideTransition]" class="select-wide" id="slide-slideTransition">
                                <?php foreach( (array) $slide_transitions as $transition_slug => $transition_name ): ?>
                                    <option value="<?php echo $transition_slug; ?>"<?php echo $transition_slug == slidedeck_get_option( $slidedeck, 'slideTransition' ) ? ' selected="selected"' : ''; ?>><?php echo $transition_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label></div>
						<?php if( $form_action != "create" ): ?>
							<div id="slidedeck-preview"><div class="ajax-masker"></div><a href="<?php echo admin_url('admin-ajax.php'); ?>?action=slidedeck_preview&preview_w=900px&preview_h=370px&slidedeck_id=<?php echo $slidedeck['id']; ?>&width=920&height=570&first_preview" class="thickbox button" onclick="closePreviewWatcher();">Preview SlideDeck</a></div>
						<?php else: ?>
							<div id="slidedeck-preview"><a href="javascript:void(null);" title="You must save first to preview" class="button disabled">Preview SlideDeck</a></div>
						<?php endif; ?>
						<p>Make sure to save your SlideDeck before you preview it.</p>
					</div>
					<div id="major-publishing-actions" class="submitbox">
						<?php if( $form_action != "create" ): ?>
							<div id="delete-action">
								<a href="<?php echo wp_nonce_url( slidedeck_action() . '&action=delete&id=' . $slidedeck['id'], 'slidedeck-delete' ); ?>" class="submitdelete deletion">Delete SlideDeck</a>
							</div>
						<?php endif; ?>
						
						<div id="publishing-action">
							<input type="submit" class="button-primary" value="<?php echo 'create' == $form_action ? 'Save SlideDeck' : 'Update'; ?>" style="float:right;" />
						</div>
						<div class="clear"></div>
					</div>
				</div>
				
                <?php if( isset( $slidedeck['id'] ) && !empty( $slidedeck['id'] ) ): ?>
                    <div id="get-slidedeck-template-snippet" class="postbox">
                        <h3 class="hndle">Theme Code Snippet</h3>
                        <div class="inside">
                            <p>Want to place this SlideDeck in your WordPress theme template? Define the dimensions you want and copy-and-paste this in the appropriate theme file.</p>
                            <textarea cols="20" rows="5" id="slidedeck-template-snippet" readonly="readonly">&lt;?php slidedeck( <?php echo $slidedeck['id']; ?>, array( 'width' => '100%', 'height' => '370px' ) ); ?></textarea>
                            <div class="misc-pub-section misc-pub-section-last">
                                <label>Dimensions:</label> 
                                <input type="text" name="width" value="100%" id="template_snippet_w" /> 
                                <input type="text" name="height" value="370px" id="template_snippet_h" />
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
				
                <div class="follow-twitter callout-button"><p>For tips, tricks &amp; discounts</p><a href="http://twitter.com/slidedeck" target="_blank" class="button"><span class="inner"><img src="<?php echo slidedeck_url( '/images/twitter.png' ); ?>" /> Follow Us on Twitter</span></a></div>
                <div class="view-screencasts callout-button"><p>For how-to's and troubleshooting</p><a href="http://www.slidedeck.com/screencasts/" target="_blank" class="button"><span class="inner"><img src="<?php echo slidedeck_url( '/images/youtube.png' ); ?>" /> View Our Screencasts</span></a></div>
                <div class="bug-report callout-button"><p>Help us squash the bugs</p><a href="http://www.getsatisfaction.com/slidedeck/topics" target="_blank" class="button"><span class="inner"><img src="<?php echo slidedeck_url( '/images/bug.png' ); ?>" /> Report a bug for SlideDeck</span></a></div>
			</div>
			
			<div class="editor-wrapper">
				<div class="editor-body">
					<div id="titlediv">
						<div id="titlewrap">
							<label for="name">Name this SlideDeck</label>
							<input type="text" name="title" size="40" maxlength="255" value="<?php echo !empty( $slidedeck['title'] ) ? $slidedeck['title'] : 'Recent Posts'; ?>" id="title" />
						</div>
					</div>
				
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="skin">Choose Skin</label>
								</th>
								<td>
									<input type="hidden" name="skin" value="<?php echo $slidedeck['skin']; ?>" id="slidedeck_skin" />
									<div class="skins-choices">
									<?php foreach( (array) $skins as $skin ): ?>
										<a href="#<?php echo $skin['slug']; ?>" class="skin-thumbnail<?php echo $skin['slug'] == $slidedeck['skin'] ? ' active' : ''; ?>">
											<img src="<?php echo $skin['thumbnail']; ?>" alt="<?php echo $skin['meta']['Skin Name']; ?>" />
											<span class="skin-name"><?php echo $skin['meta']['Skin Name']; ?></span>
										</a>
									<?php endforeach; ?>
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Total Slides to Display</th>
								<td>
									<select name="dynamic_options[total]" id="slidedeck_total_slides">
										<?php for( $i = 3; $i <= 10; $i++ ): ?>
											<option value="<?php echo $i; ?>"<?php echo $slidedeck['dynamic_options']['total'] == $i ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
										<?php endfor; ?>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Playback Options</th>
								<td>
									<label><input type="checkbox" name="slidedeck_options[autoPlay]" value="true"<?php echo $slidedeck['slidedeck_options']['autoPlay'] == 'true' ? ' checked="checked"' : ''; ?>> Autoplay</label>
									<label><input type="text" name="slidedeck_options[autoPlayInterval]" value="<?php echo intval($slidedeck['slidedeck_options']['autoPlayInterval']) / 1000; ?>" size="1" /> seconds per slide</label>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Type of Content</th>
								<td>
									<fieldset id="smart_slidedeck_type_of_content">
									    
										<legend class="screen-reader-text">Type of Content</legend>
                                        <span id="slidedeck_dynamic_options_type_posts_label"><input type="radio" name="dynamic_options_type" value="posts" id="slidedeck_dynamic_options_type_posts"<?php echo slidedeck_get_dynamic_option( $slidedeck, 'type' ) != 'rss' ? ' checked="checked"' : ''; ?> /> Use  
                                            <select name="dynamic_options[type]" id="slidedeck_dynamic_options_type_posts_select">
                                                <option value="recent"<?php echo $slidedeck['dynamic_options']['type'] == 'recent' ? ' selected="selected"' : ''; ?>>Recent</option>
                                                <option value="featured"<?php echo $slidedeck['dynamic_options']['type'] == 'featured' ? ' selected="selected"' : ''; ?>>Featured</option>
                                                <?php if( floatval( get_bloginfo( 'version' ) ) >= 2.9 ): ?>
                                                    <option value="popular"<?php echo $slidedeck['dynamic_options']['type'] == 'popular' ? ' selected="selected"' : ''; ?>>Popular</option>
                                                <?php endif; ?>
                                            </select> 
                                             entries from the 
                                            <select name="dynamic_options[post_type]" id="slidedeck_dynamic_options_post_type_select">
                                                <?php foreach( $post_types as $post_type ): ?>
                                                    <option value="<?php echo $post_type['name']; ?>"<?php echo $post_type['name'] == $slidedeck['dynamic_options']['post_type'] ? ' selected="selected"' : ''; ?>><?php echo $post_type['label']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                             post type
                                        </span>
                                        <br />
                                        
										<div id="filter_posts_by_category" class="category-filter"<?php echo slidedeck_get_dynamic_option( $slidedeck, 'post_type' ) != 'post' ? ' style="display:none;"' : ''; ?>>
											<p><label><input type="checkbox" value="1" name="dynamic_options[filter_by_category]" id="slidedeck_filter_by_category"<?php echo $slidedeck['dynamic_options']['filter_by_category'] == '1' ? ' checked="checked"' : ''; ?> /> Filter these posts by category</label></p>
											<div id="category_filter_categories"<?php echo $slidedeck['dynamic_options']['filter_by_category'] != 1 ? ' style="display:none;"' : ''; ?>>
												<?php foreach( (array) $categories as $category ): ?>
													<label><input type="checkbox" name="dynamic_options[filter_categories][]" value="<?php echo $category->cat_ID; ?>"<?php echo in_array( $category->cat_ID, (array) $slidedeck['dynamic_options']['filter_categories'] ) ? ' checked="checked"' : ''; ?> /> <?php echo $category->name; ?></label>
												<?php endforeach; ?>
											</div>
										</div>
                                        
                                        <p><strong style="margin-left:40px;">OR</strong></p>
                                        
										<label><input type="radio" name="dynamic_options_type" value="rss"<?php echo slidedeck_get_dynamic_option( $slidedeck, 'type' ) == 'rss' ? ' checked="checked"' : ''; ?> />
                                         RSS/Atom Feed
                                        </label><br />
                                        <input type="hidden" name="dynamic_options[type]" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'type' ); ?>" id="slidedeck_dynamic_options_type_hidden" />
                                        
										<div id="dynamic_rss_meta" style="display:none;">
											<p><label>Feed URL <input type="text" size="60" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'feed_url' ); ?>" name="dynamic_options[feed_url]" id="slidedeck_feed_url" /></label></p>
											<?php $cache_dir = slidedeck_dir( '/cache/' ); ?>
											<p id="cache_option_minutes" class="<?php if(!is_writable($cache_dir)){echo ' disabled';} ?>"><label>Cache for <input type="text" size="3"<?php if(!is_writable($cache_dir)){echo ' disabled="disabled"';} ?> value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'cache_minutes' ); ?>" name="dynamic_options[cache_minutes]" id="slidedeck_cache_minutes" /></label> minutes</p>
										<?php if(!is_writable($cache_dir)){ ?>
											<p><em>You need to make the SlideDeck cache folder (<?php echo $cache_dir; ?>) writable before you can cache feeds. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.</em></p>
										<?php } ?>
										</div>
                                        
                                        <label class="feed-validate">
                                            <input type="checkbox" value="1"<?php echo (boolean) slidedeck_get_dynamic_option( $slidedeck, 'validate_images' ) === true ? ' checked="checked"' : ''; ?> name="dynamic_options[validate_images]" id="slidedeck_validate_images" />
                                            Validate Images (helps with websites that include advertisement pixel images in their posts)
                                        </label>
                                        
									</fieldset>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Content Settings</th>
								<td>
									<fieldset>
										<legend class="screen-reader-text">Image Options</legend>
										<label for="slidedeck_image_source">Image Options</label>

										<select name="dynamic_options[image_source]" id="slidedeck_image_source">
											<option id="image_option_content" value="content"<?php echo slidedeck_get_dynamic_option( $slidedeck, 'image_source' ) == 'content' ? ' selected="selected"' : ''; ?>>Display First Image in Content</option>
                                            <option id="image_option_gallery" value="gallery"<?php echo slidedeck_get_dynamic_option( $slidedeck, 'image_source' ) == 'gallery' ? ' selected="selected"' : ''; ?>>Display First Image in Gallery</option>
                                            <?php if ( function_exists('current_theme_supports')){ ?>
												<?php if ( current_theme_supports('post-thumbnails') ){ ?>
													<option id="image_option_thumbnail" value="thumbnail"<?php echo $slidedeck['dynamic_options']['image_source'] == 'thumbnail' ? ' selected="selected"' : ''; ?>>Display Featured Image</option>
												<?php } ?>
											<?php } ?>
                                            <option id="image_option_none" value="none"<?php echo slidedeck_get_dynamic_option( $slidedeck, 'image_source' ) == 'none' ? ' selected="selected"' : ''; ?>>No Image</option>
										</select>
									</fieldset>
                                    <fieldset>
                                        <legend class="screen-reader-text">Title Length</legend>
                                        <label for="slidedeck_title_length_with_image">Title length in characters (with image) <input type="text" size="4" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'title_length_with_image' ); ?>" name="dynamic_options[title_length_with_image]" id="slidedeck_title_length_with_image" /></label><br />
                                        <label for="slidedeck_title_length_without_image">Title length in characters (without image) <input type="text" size="4" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'title_length_without_image' ); ?>" name="dynamic_options[title_length_without_image]" id="slidedeck_title_length_without_image" /></label>
                                    </fieldset>
                                    <fieldset>
                                        <legend class="screen-reader-text">Excerpt Length</legend>
                                        <label for="slidedeck_excerpt_length_with_image">Excerpt length in words (with image) <input type="text" size="4" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'excerpt_length_with_image' ); ?>" name="dynamic_options[excerpt_length_with_image]" id="slidedeck_excerpt_length_with_image" /></label><br />
                                        <label for="slidedeck_excerpt_length_without_image">Excerpt length in words (without image) <input type="text" size="4" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'excerpt_length_without_image' ); ?>" name="dynamic_options[excerpt_length_without_image]" id="slidedeck_excerpt_length_without_image" /></label>
                                    </fieldset>
                                    <fieldset>
                                        <legend class="screen-reader-text">Vertical Title Length</legend>
                                        <label for="slidedeck_title_length_vertical">Vertical Title Length <input type="text" size="4" value="<?php echo slidedeck_get_dynamic_option( $slidedeck, 'title_length_vertical' ); ?>" name="dynamic_options[title_length_vertical]" id="slidedeck_title_length_vertical" /></label>
                                    </fieldset>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Navigation Type</th>
								<td>
									<fieldset>
										<legend class="screen-reader-text">Navigation Type</legend>
										<input type="hidden" name="dynamic_options[navigation_type]" value="<?php echo $slidedeck['dynamic_options']['navigation_type']; ?>" id="slidedeck_navigation_type" />
										
										<a href="#simple-dots" id="navigation_simple-dots" class="navigation-type<?php echo $slidedeck['dynamic_options']['navigation_type'] == 'simple-dots' ? ' active' : ''; ?>">
											<img src="<?php echo slidedeck_url( '/images/navigation_simple-dots.png' ); ?>" alt="Simple Dots" /> Simple Dots
										</a>
										<a href="#dates" id="navigation_dates" class="navigation-type<?php echo $slidedeck['dynamic_options']['navigation_type'] == 'dates' ? ' active' : ''; ?>">
											<img src="<?php echo slidedeck_url( '/images/navigation_dates.png' ); ?>" alt="Dates" /> Dates
										</a>
										<a href="#post-titles" id="navigation_post-titles" class="navigation-type<?php echo $slidedeck['dynamic_options']['navigation_type'] == 'post-titles' ? ' active' : ''; ?>">
											<img src="<?php echo slidedeck_url( '/images/navigation_post-titles.png' ); ?>" alt="Post Titles" /> Post Titles
										</a>
									</fieldset>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>