<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php the_title(); ?></title>

<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url')?>/style.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<script src="<?php echo bloginfo('template_directory');?>/assets/cufonjs/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo bloginfo('template_directory');?>/assets/fonts/idlewild_300-idlewild_400.font.js" type="text/javascript"></script>
<script src="<?php echo bloginfo('template_directory');?>/assets/fonts/idlewild-book_325.font.js" type="text/javascript"></script>
<script type="text/javascript">// <![CDATA[
Cufon.replace('#main_menu ul li a', {fontFamily: 'idlewild-book'});
Cufon.replace('.pagehead-container .title', {fontFamily: 'idlewild-book'});
Cufon.replace('#main_menu .sub-menu a', { fontFamily: 'idlewild-book' });
Cufon.replace('.singlehead-container .single-title', {fontFamily: 'idlewild-book'});
Cufon.replace('.back-button-container', {fontFamily: 'idlewild-book'});// ]]>
</script>

</head>

<div class="content-wrapper">
   <div class="global-container-left4">
    	<div class="singlehead-container">
            <div class="single-title">
                Collections
            </div>
         </div>
    </div>
    <div class="global-container-left">
          <?php get_header(); ?>
          <?php get_footer(); ?>
    </div>
      <div class="global-container-right">
    	 <div class="back-button-container">
             <a href="<?php echo bloginfo('url')?>/products">Back</a>
         </div>
         <?php if(!is_search()){
							if(have_posts()){
								the_post();
								?>
         <div class="single-product-content">
         	<p><b><?php the_title(); ?></b></p>
           	<?php the_content(); ?>
         </div>
         
          <?php }
				else{
					?><div id='prev_next' style='' >Page Not Found</div><?php	
				}
			} ?>
    </div>
    <div class="global-container-full">
        <div class="single-product-img">
           <!-- <img class="imgLoaded" src="<?php echo bloginfo('template_url') ?>/images/prod-landing-2.png" />-->
           <img class="imgLoaded" src="<?php $image_id = get_post_thumbnail_id(); 
			   $image_url = wp_get_attachment_image_src($image_id,'large', true);
				echo $image_url[0];  ?>" />
            <img class="slogo" src="<?php echo bloginfo('template_url') ?>/images/ae_logo.png">
        </div>
    </div>   
</div>