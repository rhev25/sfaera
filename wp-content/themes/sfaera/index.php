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
<link rel="shortcut icon" href="<?php echo get_bloginfo("template_directory")."/images/ae_logo.png" ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
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
elseif(is_page('about')){
	include_once(dirname(__FILE__)."/ext/about.php");	
}
elseif(is_page('mission')){
	include_once(dirname(__FILE__)."/ext/mission.php");	
}
elseif(is_page('expertise')){
	include_once(dirname(__FILE__)."/ext/expertise.php");	
}
elseif(is_page('concept')){
	include_once(dirname(__FILE__)."/ext/concept.php");	
}
elseif(is_page('contact')){
	include_once(dirname(__FILE__)."/ext/contact.php");	
}
elseif(is_page('products')){
	include_once(dirname(__FILE__)."/ext/product.php");	
}
elseif(is_page('collection')){
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
elseif(is_page('privacy-legal')){
	include_once(dirname(__FILE__)."/ext/privacy-legal.php");	// Privacy Legal
}
elseif(is_page('partners')){
	include_once(dirname(__FILE__)."/ext/partners.php");	//Partners
}
elseif(is_404()){
	include_once(dirname(__FILE__)."/ext/404.php");	//404
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