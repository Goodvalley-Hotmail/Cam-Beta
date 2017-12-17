<?php
/**
 * Menu HTML markup structure.
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

// Swap Primary Nav to Header Right, and remove wrap.
//remove_action( 'genesis_after_header', 'genesis_do_nav' );
//add_action( 'genesis_header_right', 'genesis_do_nav' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\setup_secondary_menu_args' );
/**
 * Reduce the secondary navigation menu to one level depth.
 *
 * @since   1.0.0
 *
 * @param array $args
 *
 * @return array
 */
function setup_secondary_menu_args( array $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// UBERMENU START

add_filter( 'genesis_do_nav', __NAMESPACE__ . '\replace_genesis_primary_nav_with_ubermenu', 10, 3 );
/**
 * Replaces Genesis Primary Nav with UberMenu's.
 *
 * @since   1.0.0
 *
 * @param $nav_output
 * @param $nav
 * @param $args
 *
 * @return mixed
 */
function replace_genesis_primary_nav_with_ubermenu( $nav_output, $nav, $args ) {

	return $nav;

}

// UBERMENU END