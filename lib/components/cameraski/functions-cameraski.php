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

//add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_genesis_page_templates' );
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

add_filter( 'option_active_plugins', __NAMESPACE__ . '\disable_acf_on_frontend' );
/**
 * Disable ACF Pro on website frontend.
 *
 * Provides a performance boost if ACF frontend functions aren't being used.
 *
 * @since   1.0.0
 * @link    https://www.billerickson.net/code/disable-acf-frontend/
 *
 */
function disable_acf_on_frontend( $plugins ) {

	if ( is_admin() ) {

		return $plugins;

	}

	foreach ( $plugins as $index => $plugin ) {

		if ( 'advanced-custom-fields-pro/acf.php' == $plugin ) {

			unset( $plugins[ $index ] );

		}

	}

	return $plugins;

}

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