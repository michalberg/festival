<?php

if (! isset($content_width)) {
	
	$content_width = 660;
}

function festival_setup() {

	load_theme_textdomain('FestivalPSP', get_template_directory() . '/languages/');

	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails' ); 

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

function wpdocs_scripts_method() {
    wp_enqueue_script( 'hlasovani', get_stylesheet_directory_uri() . '/js/hlasovani.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_scripts_method' );



function wpdocs_excerpt_more( $more ) {
    return '... (<b><a href="'.get_the_permalink().'" rel="nofollow">Více</a></b>)';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );


/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'Footer widget area',
		'id'            => 'footer_widget_area',
		'before_widget' => '<div  class="footer_widget_area">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="rounded">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => 'Banner dole vlevo',
		'id'            => 'bannery_dole_vlevo',
		'before_widget' => '<div class="col-md-5 bg-interpret col-md-offset-1 custom-offset-left  bannery">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );

		register_sidebar( array(
		'name'          => 'Banner dole vpravo',
		'id'            => 'bannery_dole_vpravo',
		'before_widget' => '<div class="col-md-5 bg-interpret custom-offset-right bannery">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );



}
add_action( 'widgets_init', 'arphabet_widgets_init' );




/* funkce vkládá odlišný text do headeru podle toho, zda jsme na frontpage nebo na home či jiné strnce
 */
function vlastni_text() {
	if ( is_front_page()) {
	echo('<img src="' . esc_url(get_template_directory_uri()) . '/img/logo.png" data-rjs="3" alt="Logo" class="logo">');
		echo('<h2>PÍSNĚ S PŘÍBĚHEM</h2>');
		echo('<h4>Hudební festival Michala Horáčka a jeho přátel</h4>');
		echo('<h4>26. - 27. května 2017, Roudnice nad Labem</h4>');
	} elseif (is_home()) {
		echo('<h2>NOVINKY</h2>');
	} elseif (is_page('vstupenky')) {
		echo('<h2>VSTUPENKY</h2>');
	} elseif (is_page('hlasovani')) {
		echo('<h2>HLASOVÁNÍ</h2>');
	} elseif (is_page('program')) {
		echo('<h2>PROGRAM</h2>');
	} elseif (is_page('prakticke-informace')) {
		echo('<h2>PRAKTICKÉ INFORMACE</h2>');
	} else 
	{
		echo('<h2>PÍSNĚ S PŘÍBĚHEM</h2>');
	} 

}


/* funkce pro výukové účely - vkládá na výpis článků podle kategorie nebo měsíce vlatní text */

function archivy() {
	if ( is_archive()) {
		single_term_title('Archiv článků - ');
	} 

	if ( is_month()) {
		$monthNum = get_query_var('monthnum');
		$month = date("F", mktime(0, 0, 0, $monthNum));
		$year = get_query_var('year');
		echo 'Příspěvky pro měsíc '. $month . ' ' . $year;
	} 

}

$args = array(
	'default-image' => get_template_directory_uri() . '/img/cover.jpg',
	'uploads' => true,
);
add_theme_support( 'custom-header', $args );


?>