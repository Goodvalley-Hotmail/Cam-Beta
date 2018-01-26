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

//add_filter( 'wp_seo_get_bc_title', __NAMESPACE__ . '\truncate_breacrumb_title' );
/**
 * Controls the length of the BreadCrumbs Title.
 *
 * @since   1.0.0
 *
 * @return bool|string
 */
function truncate_breadcrumb_title() {

	// Get the title of the current post.
	$title = get_the_title();

	// Determine the length of the title.
	$title_length = strlen( $title );

	// Set a limit for the breadcrumb title.
	$limit = 0;

	// Truncate the title.
	$truncated = substr( $title, 0, $limit );

	// Add an ellipsis if the title has been truncated.
	if ( $title_length > $limit ) {

		$truncated .= '';

	}

	$link['text'] = $truncated;
	return $link['text'];

}