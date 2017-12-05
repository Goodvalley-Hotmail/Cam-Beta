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

if ( $name_depth_1 ) {

	if ( $elevation_snow_depth_6 ) {
		echo $name_depth_6 . ' (' . number_format( $elevation_snow_depth_6 ) . ' ' . $elevation_depth_measure . '): ';
	} else {
		echo $name_depth_6 . ': ';
	}

} elseif ( $elevation_snow_depth_6 ) {

	echo 'Snow Depth (' . number_format( $elevation_snow_depth_6 ) . ' ' . $elevation_depth_measure . '): ';

} elseif ( !$name_depth_6 && !$elevation_snow_depth_6 ) {

	echo 'Snow Depth: ';

}

echo '</strong>' . $snow_depth_6 . ' ' . $snow_depth_measure;

if ( $snow_depth_measure == 'cm' ) {
	echo ' (' . round( $snow_depth_6 * 0.3937 ) . '")';
} elseif ( $snow_depth_measure == '"' ) {
	echo ' (' . round( $snow_depth_6 / 0.39370 ) . 'cm)';
}

if ( $snow_type_6 ) {
	echo ' ' . $snow_type_6_english . '</li>';
} else {
	echo '</li>';
}