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

echo '<li class="snow-depth"><strong>' . $location_5 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;

if ( $snow_depth_measure == 'cm' ) {
	echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
} elseif ( $snow_depth_measure == '"' ) {
	echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
}

echo ' ' . $snow_type_5_1_english;

if ( $location_5_name_2 && !$location_5_elevation_2 ) {

	echo '<strong> || </strong>' . $snow_depth_5_2 . '  ' . $snow_depth_measure;

	if ( $snow_depth_measure == 'cm' ) {
		echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
	} elseif ( $snow_depth_measure == '"' ) {
		echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
	}

	echo ' ' . $snow_type_5_2_english;

	if ( $location_5_name_3 && !$location_5_elevation_3 ) {

		echo '<strong> || </strong>' . $snow_depth_5_3 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_5_3_english;

		if ( $location_5_name_4 && !$location_5_elevation_4 ) {

			echo '<strong> || </strong>' . $snow_depth_5_4 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_5_4_english;

			if ( $location_5_name_5 && !$location_5_elevation_5 ) {

				echo '<strong> || </strong>' . $snow_depth_5_5 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_5_5_english;

			}

		}

	}

}

echo ' ' . $snow_type_5 . '</li>';