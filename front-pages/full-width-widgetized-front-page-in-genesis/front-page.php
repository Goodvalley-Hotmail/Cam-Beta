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

/**
 * https://sridharkatakam.com/full-width-widgetized-front-page-genesis/
 */

// Enqueue styles.
wp_enqueue_style( 'front-styles', CHILD_URL . '/front-page-css/style-front.css', array(), CHILD_THEME_VERSION );

add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\site_inner_attr' );
function site_inner_attr( $attributes ) {

	// Add a class of 'full' for styling this .site-inner differently.
	$attributes['class'] .= ' full';

	// Add the attributes from .entry, since this replaces the main entry.
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );

	return $attributes;

}

// Header
get_header();

// Content
for ( $i = 1; $i <= 5; $i++ ) {

	genesis_widget_area( "front-page-{$i}", array(
		'before'    => '<div class="front-page-' . $i . ' front-page-section"><div class="wrap">',
		'after'     => '</div></div>',
	) );

}

// Comments
// genesis_get_comments_template();

// Footer
get_footer();