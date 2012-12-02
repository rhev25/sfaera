<?php

//sidebars 
$args = array();
$args['name']="Side Bar";
$args['id']="side-bar";
$args['description']="Side Bar";
$args['before_widget']="";
$args['after_widget']="";
register_sidebar($args);

/*menu*/
$args = array();
$args['name']="Menu Bar";
$args['id']="menu-bar";
$args['description']="Menu Bar";
$args['before_widget']="";
$args['after_widget']="";
register_sidebar($args);


/**adding featured thumbnail for the theme post and custom post typess**/
add_theme_support( 'post-thumbnails', array( 'post', 'products') ); 

/**
function custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
**/

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more'); 

/**calling out the custom post types**/

require_once('custom/products-custom.php'); 

function _slider(){
require('embed/slider.php');
}
?>