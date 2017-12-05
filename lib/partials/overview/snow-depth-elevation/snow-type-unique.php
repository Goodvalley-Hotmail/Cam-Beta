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

if ( $snow_type_unique == 'Not available' ) {

	echo '<li class="snow-type"><strong>Snow type: </strong>Not available' . '</li>';

} elseif ( isset( $snow_type_unique ) ) {

	echo '<li class="snow-type"><strong>Snow type: </strong>' . $snow_type_unique_english . '</li>';

}