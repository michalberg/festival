<?php

if (! isset($content_width)) {
	
	$content_width = 660;
}

function festival_setup() {

	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	
	// Register Custom Navigation Walker
	require_once('wp_bootstrap_navwalker.php');

	register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'FestivalPSP' ),
	'footer' => __( 'Footer Menu', 'FestivalPSP' ),
	) );

	

}

add_action('after_setup_theme','festival_setup');


function  festival_scripts () {

/* add styles and bootstrap */

wp_enqueue_style('bootstrap-core', 
	get_template_directory_uri() . '/css/bootstrap.min.css');

wp_enqueue_style('custom', 
	get_template_directory_uri() . '/style.css');

/* add scripts */

wp_enqueue_script('bootstrap-js', 
	get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true);


}

add_action ('wp_enqueue_scripts', 'festival_scripts');


function wpdocs_excerpt_more( $more ) {
    return '... (<b><a href="'.get_the_permalink().'" rel="nofollow">Více</a></b>)';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );


/* funkce pro výukové účely, prakticky nepoužita
vkládá odlišný text do headeru podle toho, zda jsme na frontpage nebo na home či jiné strnce
 */

function vlastni_text() {
	if ( is_front_page()) {
		echo('PÍSNĚ S PŘÍBĚHEM');
	} elseif (is_home()) {
		echo('PÍSNĚ S PŘÍBĚHEM');
	} else {
		echo('PÍSNĚ S PŘÍBĚHEM');
	}

}

?>