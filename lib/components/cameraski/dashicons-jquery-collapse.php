<?php
/**
 * Enqueue Dashicons and jQuery Collapse.
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\load_dashicons_jquery_collapse_scripts' );
function load_dashicons_jquery_collapse_scripts() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'jquery-collapse', CHILD_URL . '/assets/js/jquery.collapse.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'collapse-init', CHILD_URL . '/assets/js/jquery.collapse.init.js', array( 'jquery-collapse' ), CHILD_THEME_VERSION, true );

}