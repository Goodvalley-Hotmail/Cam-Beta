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
 * Initialize the Theme's constants.
 *
 * @since   1.0.0
 *
 * @return void
 */
function init_constants() {

	$child_theme = wp_get_theme();

	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
	define( 'CHILD_TEXT_DOMAIN', $child_theme->get( 'TextDomain' ) );

	// With this, we don't need to call get_stylesheet_directory() anywhere, anymore,
	// because we've set it up as a constant.
	define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

	// Example of the one above: we define our Config dir without the expensive get_stylesheet_directory() expensive call.
	define( 'CHILD_CONFIG_DIR', CHILD_THEME_DIR . '/config/' );

	/*
	 * We don't need to define all the constants. The rule of thumb is to set a constant if we need to call the file
	 * more than one time.
	 */

}

init_constants();