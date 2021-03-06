<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Inhabitent_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function inhabitent_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'inhabitent_body_classes' );

/**
 *  login_head ( action )
 * login_headerurl ( filter )
 * login_headertitle ( filter )
 */

 add_action('login_head', 'inhabitent_login_logo');
 function inhabitent_login_logo(){
	echo '<style>
	#login h1 a {
		background: url(' . get_template_directory_uri() . 
		'/assets/images/logos/inhabitent-logo-text.svg) no-repeat !important;
		background-size: 300px 53px !important;
		width: 300px !important;
		height: 53px !important;
	}	

	#login .button.button-primary {
		background: #248A83;
	}
	</style>
	';
 }

 add_filter('login_headerurl', 'inhabitent_login_logo_url');
 function inhabitent_login_logo_url($url){
	return home_url();
 }
 add_filter('login_headertitle', 'inhabitent_login_title');
 function inhabitent_login_title(){
	 return 'inhabitent';
 }

function inhabitent_dynamic_css() {

	//MAKE SURE IT'S THE ABOUT PAGE THAT LOADED
	if ( ! is_page_template('page-templates/about.php') ) {
		return;
	}
	//GET OUR BACKGROUND IMAGE FROM OUR CUSTOM FIELD
	$image = CFS()->get('hero_image');
	//IF WE DON'T HAVE AN IMAGE IN THE FIELD, GET OUTTA THERE!
	if ( ! $image ) {
		return;
	}

	$hero_css = "
	.entry-header {
		background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.4) 100%),
		url({$image}) no-repeat center bottom;
		background-size: cover, cover;
		height: 100vh;
		display: flex;
		justify-content: center;
	}

	.entry-title {
		color: white;
		text-align: center;
		position: relative;
		top: 360px;
		margin-bottom: .5rem;
		font-family: Novecento Sans Web,sans-serif;
		letter-spacing: 2px;
		text-transform: uppercase;
		font-size: 3rem;
	}
	";

	//ADD OUR CUSTOM CSS

	wp_add_inline_style('inhabitent-style', $hero_css );
}

add_action('wp_enqueue_scripts', 'inhabitent_dynamic_css');

add_filter('get_the_archive_title', 'inhabitent_archive_title');
function inhabitent_archive_title( $title ){
	if( is_post_type_archive('product') ){
		$title = 'Shop Stuff';
	}
	elseif( is_tax('product_type')) {
		$title = single_term_title('', false);
	}

	return $title;
}

add_action('pre_get_posts', 'inhabitent_modify_archive_queries');
function inhabitent_modify_archive_queries( $query ){
	if( is_post_type_archive( array('product') ) ||
	$query->is_tax( 'product_type' ) &&
	!is_admin() &&
	$query->is_main_query()
	)
	{
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', 16);
	}
}