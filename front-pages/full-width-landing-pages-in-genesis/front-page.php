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
 * https://www.billerickson.net/full-width-landing-pages-in-genesis/
 */

// Remove 'site-inner' from structural wrap.
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\site_inner_attr' );
/**
 * Add the attributes from 'entry', since this replaces the main Entry.
 * We remove 'site-inner' from the structural wrap because the Content will go inside .site-inner and those elements
 * will have their own internal .wrap's.
 * You only have to do this if you've defined the structural wraps you want in your Theme already and included 'site-inner'.
 * If you don't have add_theme_support( 'structural-wraps' ); in your Child Theme, Genesis will add wraps to everything
 * except .site-inner (see /genesis/lib/init.php, line 63).
 * So you can leave this part out, but you'll probably want to adjust the styling of .site-inner in your stylesheet.
 *
 * Here in the Sample Theme, they exclude the structural wrap for .site-inner, but apply a max-width, so you may want to
 * change that.
 *
 * Since we're removing the <content> element which has Schema attributes, we'll want to add those attributes to .site-inner.
 *
 * @since   1.0.0
 *
 * @param $attributes Existing attributes
 *
 * @return array Amended attributes
 */
function site_inner_attr( $attributes ) {

	// Add a class of 'full' for styling this .site-inner differently.
	$attributes['class'] .= ' full';

	// Add an id of 'genesis-content' for accessible skip links.
	$attributes['id'] = 'genesis-content';

	// Add the attributes from .entry, since this replaces the main Entry.
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );

	return $attributes;

}

get_header();



get_footer();