<?php
/**
 * WordPress Template for Front Page.
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\site_inner_attr' );
function site_inner_attr( $attributes ) {

	// Add a class of 'full' for styling this .site-inner differently.
	$attributes['class'] .= ' full';

	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );

	return $attributes;

}

// Header
get_header();

// Content
fp_sections_display();

// Comments
genesis_get_comments_template();

// Footer
get_footer();

// genesis();