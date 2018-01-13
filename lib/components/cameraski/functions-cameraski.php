<?php
/**
 * Description
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_genesis_page_templates' );
/**
 * Removes Genesis Page Templates.
 *
 * @since   1.0.0
 *
 * @param $page_templates
 *
 * @return mixed
 */
function remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

// Add Primary Menu to Header Right
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );

add_filter( 'widget_text', __NAMESPACE__ . '\execute_php_in_widgets', 100 );
/**
 * Executes PHP Code on any Text Widget, if we add the PHP tags
 *
 * @since   1.0.0
 *
 * @param $html
 *
 * @return string
 */
function execute_php_in_widgets( $html ) {

	if ( strpos( $html, "<" . "?php" ) !== false ) {

		ob_start();

		eval( "?" . ">" . $html );
		$html = ob_get_contents();

		ob_end_clean();

	}

	return $html;

}

/**
 * [All SkiResort pages] Display Post meta only if the Entry has been assigned to any Location term.
 * Removes empty markup, '<p class="entry-meta"></p>' for Entries that have not been assigned to any Location.
 *
 * @since   1.0.0
 *
 * @return void
 */
function custom_post_meta() {

	if ( has_term( '', 'locations' ) ) {
		genesis_post_meta();
	}

}

//add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\meteo_stylesheet' );
/**
 * Registers YrNo Styles.
 *
 * @since   1.0.0
 *
 * @return void
 */
function meteo_stylesheet() {
	wp_enqueue_style( 'meteo-stylesheet', CHILD_URL . '/lib/meteo/yrno.css', array(), CHILD_THEME_VERSION );
}

// Enqueue YrNo Styles
//wp_enqueue_style( 'meteo-styles' );

add_filter( 'gettext', __NAMESPACE__ . '\remove_lostpassword_text' );
/**
 * Removes the "Lost your password?" from the WordPress login.
 *
 * @since   1.0.0
 *
 * @param $text
 *
 * @return string
 */
function remove_lostpassword_text ( $text ) {

	if ( $text == 'Lost your password?' ) {
		$text = '';
	}

	return $text;

}

add_filter( 'genesis_post_title_text', __NAMESPACE__ . '\add_tabs_after_cpt_title' );
function add_tabs_after_cpt_title( $title ) {

	$cameraski_ski_resort           = 'http://beta-01.com/ski-resort/';
	$cameraski_ski_resort_webcams   = 'http://beta-01.com/ski-resort-webcams/';
	$cameraski_weather_forecast     = 'http://beta-01.com/weather-forecast/';


	$tab = get_post_meta( get_the_ID(), 'tab', true );

	if ( is_singular( 'ski-resort' ) ) {

		$title = $title . '<span id="tabbed"><span id="tab-first" class="tab-active"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></span>';

	} elseif ( is_singular( 'ski-resort-webcams' ) ) {

		$title = $title . '<span id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></span>';

	} elseif ( is_singular( 'weather-forecast' ) ) {

		$title = $title . '<span id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></span>';

	}

	return $title;

}

//* Add Overview-Main image sizes
//add_image_size( 'overview-main', 495, 279, TRUE );
//add_image_size( 'slope-map-200x109', 200, 109, TRUE );
//add_image_size( 'slope-map-250x136', 250, 136, TRUE );
//add_image_size( 'slope-map-300x163', 300, 163, TRUE );

add_action( 'admin_bar_menu', __NAMESPACE__ . '\show_template' );
/**
 *
 * Shows which Template is being used for every Post/Page.
 * https://wpbeaches.com/how-to-find-out-what-wordpress-template-is-being-used-in-a-theme/
 *
 * @since   1.0.0
 *
 * @return string
 */
function show_template() {

	global $template;
	print_r( $template );

}