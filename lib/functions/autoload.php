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
 * Loads nonadmin files.
 *
 * @since   1.0.0
 *
 * @return void
 */
function load_nonadmin_files() {

	$filenames = array(
		'setup.php',
		'components/customizer/css-handler.php',
		'components/customizer/helpers.php',
		'functions/formatting.php',
		'functions/load-assets.php',
		'functions/markup.php',
		'structure/archive.php',
		'structure/comments.php',
		'structure/footer.php',
		'structure/header.php',
		'structure/menu.php',
		'structure/post.php',
		'structure/sidebar.php',
	);

	load_specified_files( $filenames );

}

add_action( 'admin_init', __NAMESPACE__ . '\load_admin_files' );
/**
 * Loads admin files.
 *
 * @since   1.0.0
 *
 * @return void
 */
function load_admin_files() {

	$filenames = array(
		'components/customizer/customizer.php',
	);

	load_specified_files( $filenames );

}

/**
 * Load each of the specified files.
 *
 * @since   1.0.0
 *
 * @param array $filenames
 * @param string $folder_root
 *
 * @return void
 */
function load_specified_files( array $filenames, $folder_root = '' ) {

	// If we have a folder root, we load it up. Otherwise, load our default.
	$folder_root = $folder_root ?: CHILD_THEME_DIR . '/lib/';

	foreach ( $filenames as $filename ) {

		include ( $folder_root . $filename );

	}

}

load_nonadmin_files();