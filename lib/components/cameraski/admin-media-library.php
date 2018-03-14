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
 * https://sridharkatakam.com/add-time-admin-column-wordpress-media-library/
 */
add_filter( 'manage_media_columns', __NAMESPACE__ . '\media_columns_time' );
/**
 * Filters the Media list table columns to add a Time column.
 *
 * @since   1.0.0
 *
 * @param array     $posts_columns  Existing array of columns displayed in the Media list table.
 *
 * @return array    Amended array of columns to be displayed in the Media list table.
 */
function media_columns_time( $posts_columns ) {

	$posts_columns['time'] = _x( 'Time', 'column_name' );

	return $posts_columns;

}

add_action( 'manage_media_custom_column', __NAMESPACE__ . '\media_custom_column_time' );
/**
 * Displays attachment uploaded time under 'Time' custom column in the Media list table.
 *
 * @since   1.0.0
 *
 * @param string    $column_name    Name of the custom column.
 *
 * @return void
 */
function media_custom_column_time( $column_name ) {

	if ( 'time' !== $column_name ) {
		return;
	}

	//the_time( 'g:i:s:a' ); // In hh:mm:ss am/pm format.
	the_time();

}

add_action( 'admin_print_styles-upload.php', __NAMESPACE__ . '\time_column_css' );
/**
 * Adds custom CSS on Media library page in WP admin.
 *
 * @since   1.0.0
 *
 * @return void
 */
function time_column_css() {

	echo '<style>
					.fixed .column-time {
						width: 10%;
					}
			</style>';

}

/*********************************************************************************************************************/

/**
 * https://sridharkatakam.com/add-url-admin-column-wordpress-media-library/
 */

add_filter( 'manage_media_columns', __NAMESPACE__ . '\media_columns_url' );
/**
 * Filters the Media list table columns to add a URL column.
 *
 * @since   1.0.0
 *
 * @param array     $posts_columns  Existing array of columns displayed in the Media list table.
 *
 * @return array    Amended array of columns to be displayed in the Media list table.
 */
function media_columns_url( $posts_columns ) {

	$posts_columns['media_url'] = 'URL';
	return $posts_columns;

}

add_action( 'manage_media_custom_column', __NAMESPACE__ . '\media_custom_column_url' );
/**
 * Displays URL custom column in the Media list table.
 *
 * @since   1.0.0
 *
 * @param string    $column_name    Name of the custom column.
 *
 * @return void
 */
function media_custom_column_url( $column_name ) {

	if ( 'media_url' !== $column_name ) {
		return;
	}

	echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="' . wp_get_attachment_url() . '" />';

}

add_action( 'admin_print_styles-upload.php', __NAMESPACE__ . '\url_column_css' );
/**
 * Adds custom CSS on Media Library page in WP Admin.
 *
 * @since   1.0.0
 *
 * @return void
 */
function url_column_css() {

	echo '<style>
				@media only screen and ( min-width: 1400px ) {
					.fixed .column-media-url {
						width: 15%;
					}
				}
			</style>';

}

/*********************************************************************************************************************/

/**
 * https://sridharkatakam.com/add-file-size-admin-column-wordpress-media-library/
 */

add_filter( 'manage_media_columns', __NAMESPACE__ . '\media_columns_filesize' );
/**
 * Filters the Media list table columns to add a File Size column.
 *
 * @since   1.0.0
 *
 * @param array     $posts_columns  Existing array of columns displayed in the Media list table.
 *
 * @return array    Amended array of columns to be displayed in the Media list table.
 */
function media_columns_filesize( $posts_columns ) {

	$posts_columns['filesize'] = __( 'File Size', CHILD_TEXT_DOMAIN );

	return $posts_columns;

}

add_action( 'manage_media_custom_column', __NAMESPACE__ . '\media_custom_column_filesize', 10, 2 );
/**
 * Displays File Size custom column in the Media list table.
 *
 * @since   1.0.0
 *
 * @param string    $column_name    Name of the custom column.
 * @param int       $post_id        Current Attachment ID.
 *
 * @return void
 */
function media_custom_column_filesize( $column_name, $post_id ) {

	if ( 'filesize' !== $column_name ) {
		return;
	}

	$bytes = filesize( get_attached_file( $post_id ) );

	echo size_format( $bytes, 2 );

}

add_action( 'admin_print_styles-upload.php', __NAMESPACE__ . '\filesize_column_filesize' );
/**
 * Adjusts File Size column on Media Library page in WP Admin.
 *
 * @since   1.0.0
 *
 * @return void
 */
function filesize_column_filesize() {

	echo '<style>
				.fixed .column-filesize {
					width: 10%;
				}
			</style>';

}