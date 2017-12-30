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