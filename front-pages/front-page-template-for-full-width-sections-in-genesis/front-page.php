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
 * https://sridharkatakam.com/front-page-template-for-full-width-sections-in-genesis/
 */

// Remove div .wrap from div .site-inner.
add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\attributes_site_inner' );
/**
 * Adds attributes for .site-inner element.
 *
 * @since   1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function attributes_site_inner( $attributes ) {

	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';

	return $attributes;

}

get_header();

echo 'Això seria el Contingut.';

get_footer();