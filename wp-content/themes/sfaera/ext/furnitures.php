<div class="content-wrapper">        
    <div class="global-container-left">
          <?php get_header(); ?>
          <?php get_footer(); ?>
    </div>
    <div class="global-container-left3">
        <div class="pagehead-container">
            <div class="title">
                Furniture
            </div>
        </div>
        <div class="collection-wrapper">
        
        <?php
                        if  ( empty($paged) ) {
							if ( !empty( $_GET['paged'] ) ) {
									$paged = $_GET['paged'];
							} elseif ( !empty($wp->matched_query) && $args = wp_parse_args($wp->matched_query) ) {
									if ( !empty( $args['paged'] ) ) {
											$paged = $args['paged'];
									}
							}
							if ( !empty($paged) )
									$wp_query->set('paged', $paged);
					}      
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
					$wp_query->query('paged='.$paged.'&post_type=products&products_category=furniture&showposts=12');
                    
					while ($wp_query->have_posts()) : $wp_query->the_post();?>
        
            <div class="prod-box">
            	<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                <?php //the_post_thumbnail('medium');
				 $image_id = get_post_thumbnail_id(); 
				 $image_url = wp_get_attachment_image_src($image_id,$size); ?>
				 <img src="<?php bloginfo('template_directory'); ?>/scripts/timthumb.php?src=<?php echo $image_url[0]; ?>" alt="<?php the_title(); ?>" />
            </div>
            <?php endwhile;?>
        </div>
    </div>
</div>
