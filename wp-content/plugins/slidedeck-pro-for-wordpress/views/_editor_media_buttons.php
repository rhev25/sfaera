<?php
/**
 * Multimedia Upload/Insert buttons for slide editors
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
 * @uses apply_filters()
 * @uses get_bloginfo()
 */
?>
<div class="editor-nav">
    <?php if( 'true' == get_user_option( 'rich_editing' ) ){ ?>
	<a href="#html" class="editor-html mode">HTML</a>
	<a href="#visual" class="editor-visual mode active">Visual</a>
    <?php } ?>

	<div class="media-buttons hide-if-no-js">
		<?php
			$uploading_iframe_ID = $slide['gallery_id'];
			$context = apply_filters( 'media_buttons_context', __( 'Upload/Insert  %s' ) );
			$media_upload_iframe_src = get_bloginfo( 'wpurl' ) . '/wp-admin/media-upload.php?post_id=' . $uploading_iframe_ID . '&amp;editor=' . $editor_id;
			$media_title = __( 'Add Media' );
			$image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', $media_upload_iframe_src . "&amp;type=image" );
			$image_title = __( 'Add an Image' );
			$video_upload_iframe_src = apply_filters( 'video_upload_iframe_src', $media_upload_iframe_src . "&amp;type=video" );
			$video_title = __( 'Add Video' );
			$audio_upload_iframe_src = apply_filters( 'audio_upload_iframe_src', $media_upload_iframe_src . "&amp;type=audio" );
			$audio_title = __( 'Add Audio' );
			
			$out = '<a href="' . $image_upload_iframe_src . '&amp;TB_iframe=true" class="thickbox" title="' . $image_title . '" onclick="return false;"><img src="' . get_bloginfo('wpurl') . '/wp-admin/images/media-button-image.gif" alt="' . $image_title . '" /></a>';
			$out.= '<a href="' . $video_upload_iframe_src . '&amp;TB_iframe=true" class="thickbox" title="' . $video_title . '" onclick="return false;"><img src="' . get_bloginfo('wpurl') . '/wp-admin/images/media-button-video.gif" alt="' . $video_title . '" /></a>';
			$out.= '<a href="' . $audio_upload_iframe_src . '&amp;TB_iframe=true" class="thickbox" title="' . $audio_title . '" onclick="return false;"><img src="' . get_bloginfo('wpurl') . '/wp-admin/images/media-button-music.gif" alt="' . $audio_title . '" /></a>';
			$out.= '<a href="' . $media_upload_iframe_src . '&amp;TB_iframe=true" class="thickbox" title="' . $media_title . '" onclick="return false;"><img src="' . get_bloginfo('wpurl') . '/wp-admin/images/media-button-other.gif" alt="' . $media_title . '" /></a>';
			
			printf($context, $out);
		?>
	</div>

</div>