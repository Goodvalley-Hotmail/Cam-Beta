<?php
/**
 * Header HTML markup structure.
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

add_filter( 'genesis_attr_site-description', 'genesis_attributes_screen_reader_class' );