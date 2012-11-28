<?
/** custom post types for Products **/
/**to register post types */
add_action('init', 'products_register');
 
function products_register() {
 
	$labels = array(
		'name' => _x('Products', 'post type general name'),
		'singular_name' => _x('Product', 'post type singular name'),
		'add_new' => _x('Add New', 'products'),
		'add_new_item' => __('Add New Product'),
		'edit_item' => __('Edit Product'),
		'new_item' => __('New Product'),
		'view_item' => __('View Product'),
		'search_items' => __('Search Product'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'products' , $args );
}

 
/*registering custom category box for this post type*/
register_taxonomy("products_category", 
				   array("products"), 
				   array("hierarchical" => true, 
				   "label" => "Product Category", 
				   "singular_label" => "Product Category",
				   "add_new_item" => "New Category",
				   "rewrite" => true
				   
				   )
				   );
				   
/**displaying the fields in columns from the post types contents **/

add_action("manage_posts_custom_column",  "products_custom_columns");
add_filter("manage_edit-products_columns", "products_edit_columns");
 
function products_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Product Name",
    "description" => "Description",
	"productscat" => "Product Category"
  );
 
  return $columns;
}
function products_custom_columns($column){
  global $post;
 
  switch ($column) {
    case "description":
      the_excerpt();
      break;
    case "productscat":
      echo get_the_term_list($post->ID, 'product_category', '', ', ','');
      break;
  }
}

?>