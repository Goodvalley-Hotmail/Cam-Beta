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

echo '<li class="snow-depth"><strong>';

if ( $name_depth_3 ) {

	if ( $elevation_snow_depth_3 ) {
		echo $name_depth_3 . ' (' . number_format( $elevation_snow_depth_3 ) . ' ' . $elevation_depth_measure . '): ';
	} else {
		echo $name_depth_3 . ': ';
	}

} elseif ( $elevation_snow_depth_3 ) {

	echo 'Snow Depth (' . number_format( $elevation_snow_depth_3 ) . ' ' . $elevation_depth_measure . '): ';

} elseif ( !$name_depth_3 && !$elevation_snow_depth_3 ) {

	echo 'Snow Depth: ';

}

echo '</strong>' . $snow_depth_3 . ' ' . $snow_depth_measure;

if ( $snow_depth_measure == 'cm' ) {
	echo ' (' . round( $snow_depth_3 * 0.3937 ) . '")';
} elseif ( $snow_depth_measure == '"' ) {
	echo ' (' . round( $snow_depth_3 / 0.39370 ) . 'cm)';
}

if ( $snow_type_3 ) {
	echo ' ' . $snow_type_3_english . '</li>';
} else {
	echo '</li>';
}