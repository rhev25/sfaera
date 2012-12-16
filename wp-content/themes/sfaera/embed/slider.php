    <meta name="description" content="Camera a free jQuery slideshow with many effects, transitions, adaptive layout, easy to customize, using canvas and mobile ready"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Styles
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    <link rel='stylesheet' id='camera-css'  href='<?php bloginfo('template_url')?>/assets/camerajs/css/camera.css' type='text/css' media='all'> 
    <style>
		body {
			margin: 0;
			padding: 0;
		}
		a {
			color: #09f;
		}
		a:hover {
			text-decoration: none;
		}
		#back_to_camera {
			clear: both;
			display: block;
			height: 80px;
			line-height: 40px;
			padding: 20px;
		}
		.fluid_container {
			margin: 0 auto;
			width: 100%;
			height:100%;
			min-width:777px;
			min-height:600px;
		}
		
	</style>

    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Scripts
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    
    <script type='text/javascript' src='<?php bloginfo('template_url')?>/assets/camerajs/scripts/jquery.min.js'></script>
    <script type='text/javascript' src='<?php bloginfo('template_url')?>/assets/camerajs/scripts/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='<?php bloginfo('template_url')?>/assets/camerajs/scripts/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='<?php bloginfo('template_url')?>/assets/camerajs/scripts/camera.js'></script>
    <script src="<?php bloginfo('template_url')?>assets/cufonjs/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url')?>assets/fonts/idlewild-book_325.font.js" type="text/javascript"></script>
    <script type="text/javascript">
    	Cufon.replace('.camera_caption', { fontFamily: 'idlewild-book' });
    </script>
    <script>
		jQuery(function(){
			jQuery('#camera_wrap_1').camera({
				alignment:'centerRight',
				thumbnails: false,
				loader: false,
				minHeight:'600px'
			});
		});
	</script>
 
</head>
<body>
	<div class="fluid_container">
        <div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
         <?php query_posts( array( 'post_type' => 'products', 'posts_per_page' => 4 ) );
						  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div data-src="<?php $image_id = get_post_thumbnail_id(); 
			   $image_url = wp_get_attachment_image_src($image_id,'large', true);
				echo $image_url[0];?>" data-link=<?php the_permalink();?>"">
                <div class="camera_caption fadeFromBottom">
                  <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                </div>
            </div>
           
            
        <?php endwhile; endif;?>
        </div>
        
    </div><!-- .fluid_container -->
</body> 
</html>