<?php
/**
 * Asset loader handler.
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ .  '\enqueue_assets' );
/**
 * Enqueue Scripts and Styles.
 *
 * @since   1.0.0
 *
 * @return void
 */
function enqueue_assets() {

	wp_enqueue_style( CHILD_TEXT_DOMAIN . '-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	// Hem afegit: |Droid|Sans
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato|Droid+Sans:300,400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
	// Registers YrNo Styles.
	//wp_enqueue_style( 'meteo-stylesheet', CHILD_URL . '/lib/meteo/yrno.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( CHILD_TEXT_DOMAIN . '-responsive-menu', CHILD_URL . '/js/responsive-menu.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	$localized_script_args = array(
		'mainMenu' => __( 'Menu', CHILD_TEXT_DOMAIN ),
		'subMenu'  => __( 'Menu', CHILD_TEXT_DOMAIN ),
	);

	//wp_localize_script( CHILD_TEXT_DOMAIN . '-responsive-menu', 'genesisSampleL10n', $localized_script_args );
	wp_localize_script( CHILD_TEXT_DOMAIN . '-responsive-menu', 'cameraskiL10n', $localized_script_args );

}

add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_genesis_page_templates' );
/**
 * Removes Genesis Page Templates.
 *
 * @since   1.0.0
 *
 * @param $page_templates
 *
 * @return mixed
 */
function remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_genesis_page_templates' );
/**
 * Removes Genesis Page Templates.
 *
 * @since   1.0.0
 *
 * @param $page_templates
 *
 * @return mixed
 */
function remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}