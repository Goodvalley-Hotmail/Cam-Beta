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

add_filter( 'genesis_seo_title', __NAMESPACE__ . '\replace_header_site_title_with_inline_logo', 10, 3 );
/**
 * Replaces Header Site Title with Inline Logo.
 * Fixes Genesis bug - when using static Front Page and Blog Page (admin reading settings) Home page is <p> tag and Blog Page is <h1> tag.
 * Replaces "is_home" with "is_front_page" to correctly display Home Page with <h1> tag and Blog Page with <p> tag.
 *
 * @since   1.0.0
 *
 * @param $title
 * @param $inside
 * @param $wrap
 *
 * @return string
 */
function replace_header_site_title_with_inline_logo( $title, $inside, $wrap ) {

	$logo = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/logo.png" alt="' . esc_attr( get_bloginfo( 'name' ) ) . ' Homepage" width="250" height="83" />';

	$inside = sprintf( '<a href="%s">%s<span class="screen-reader-text">%s</span></a>', trailingslashit( home_url() ), $logo, get_bloginfo( 'name' ) );

	// Determine which wrapping tags to use
	$wrap = genesis_is_root_page() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

	// A little fallback, in case an SEO plugin is active
	$wrap = genesis_is_root_page() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

	// And finally, $wrap in h1 if HTML5 & semantic headings enabled
	$wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

	return sprintf( '<%1$s %2$s>%3$s</%1$s>', $wrap, genesis_attr( 'site-title' ), $inside );

}

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

add_filter( 'genesis_footer_creds_text', __NAMESPACE__ . '\add_footer_credits' );
/**
 * Change the Credits line in the Footer.
 *
 * @since   1.0.0
 *
 * @return void
 */
function add_footer_credits() {
	echo '<div class="creds"><p>Copyright &copy; ' . date( 'Y' ) . ' &middot; <a href="https://www.cameraski.com/">CameraSki</a> &middot; All Rights reserved</a></p></div>';
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