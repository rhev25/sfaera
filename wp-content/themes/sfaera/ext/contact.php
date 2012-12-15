<div class="content-wrapper">        
    <div class="global-container-left">
          <?php get_header(); ?>
          <?php get_footer(); ?>
    </div>
    <div class="global-container-left2-about">
        <div class="contact-landing-desc">
            <div class="contact-desc-container">
			<?php 
                    if(!is_search()){
                        if(have_posts()){
                            the_post();
            ?>
            	<div class="contact-desc-wrap">
               			<?php the_content(); ?>
                </div>
            <?php    
                }
							else{
								?><div id='prev_next' style='' >Page Not Found</div><?php	
							}
						}
						else{
							$count = 0;
							while(have_posts()){
								$count++;
								the_post();
								?><div class='pagetitle'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></div><?php
								?><div class='pagecontent' style='padding-bottom:20px'><?php echo word_limit(strip_tags($post->post_content), 30); ?></div><?php
							}
							?><div id='no_results' style='' ><?php
							 posts_nav_link(' &#183; ', 'Previous Page', 'Next Page');
							?></div><?php
							if(!$count){
								?><div id='prev_next' style='' >No Results</div><?php	
							}
							
						} ?>
            </div>
        </div>
    </div>
    <div class="global-container-full">
    	<div class="about-landing-img">
            <img class="imgLoaded" src="<?php echo bloginfo('template_url')?>/images/prod-landing-2.png" />
            <img class="slogo" src="<?php echo bloginfo('template_url')?>/images/ae_logo.png">
         </div>        
     </div>   