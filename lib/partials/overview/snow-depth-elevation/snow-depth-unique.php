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

if ( isset( $snow_depth_unique ) && $snow_depth_unique >= 0 ) {

	echo '<li class="snow-depth"><strong>';

	if ( $name_depth_unique ) {

		if ( $elevation_snow_unique ) {
			echo $name_depth_unique . ' (' . number_format( $elevation_snow_unique ) . ' ' . $elevation_depth_measure . '): ';
		} else {
			echo $name_depth_unique . ': ';
		}

	} elseif ( $elevation_snow_unique ) {

		echo 'Snow Depth (' . number_format( $elevation_snow_unique ) . ' ' . $elevation_depth_measure . '): ';

	} elseif ( !$name_depth_unique && !$elevation_snow_unique ) {

		echo 'Snow Depth: ';

	}

	echo '</strong>' . $snow_depth_unique . ' ' . $snow_depth_measure;

	if ( $snow_depth_measure == 'cm' ) {
		echo ' (' . round( $snow_depth_unique * 0.3937 ) . '")';
	} elseif ( $snow_depth_measure == '"' ) {
		echo ' (' . round( $snow_depth_unique / 0.39370 ) . 'cm)';
	}

} elseif ( $snow_depth_unique == 'Not available' ) {

	echo '<li class="snow-depth"><strong>Snow Depth: </strong>Not available</li>';

}