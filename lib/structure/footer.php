<?php
/**
 * Footer HTML markup structure.
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

add_filter( 'genesis_footer_creds_text', __NAMESPACE__ . '\add_footer_credits' );
/**
 * Change the Credits line in the Footer.
 *
 * @since   1.0.0
 *
 * @return void
 */
function add_footer_credits() {
	echo '<div class="creds"><p>Copyright &copy; ' . date( 'Y' ) . ' &middot; <a href="https://cameraski.com/">CameraSki</a> &middot; All Rights reserved</a></p></div>';
}

