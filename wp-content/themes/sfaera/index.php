<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;
	
	if(strpos($_SERVER['REQUEST_URI'],"home.php")==false){
	wp_title( '|', true, 'right' );
	}
	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'sfaera' ), max( $paged, $page ) );
	
	

	?>
	
	</title>


<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<!--[if IE ]>
<link href="<?php bloginfo("template_url"); ?>/styleEI.css" rel="stylesheet" type="text/css" media="all" />
<![endif]--> 

<?php wp_head(); ?>

</head>
<body>
<?php
 
if(is_home() OR is_page('home')){
	include_once(dirname(__FILE__)."/ext/home.php");
}
elseif(is_page('products')){
	include_once(dirname(__FILE__)."/ext/home.php");	
}
elseif(is_page('collections')){
	include_once(dirname(__FILE__)."/ext/collections.php");	// Collections
}
elseif(is_page('furniture')){
	include_once(dirname(__FILE__)."/ext/furnitures.php");	// Furniture
}
elseif(is_page('luxury-home')){ 
	include_once(dirname(__FILE__)."/ext/lux-home.php");	// Luxury Home
}
elseif(is_page('private-commissions')){
	include_once(dirname(__FILE__)."/ext/private-com.php");	// Private Commissions
}
elseif(is_single())
{
	include_once(dirname(__FILE__)."/ext/single.php");
}
else{
	include_once(dirname(__FILE__)."/ext/page.php");
}


?>

</body>

<?php wp_footer(); ?>
</html>