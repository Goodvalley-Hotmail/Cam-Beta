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

echo '<li class="snow-depth"><strong>' . number_format( $location_3_elevation_1 ) . ': </strong>' . $snow_depth_3_1 . '  ' . $snow_depth_measure;

if ( $snow_depth_measure == 'cm' ) {
	echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
} elseif ( $snow_depth_measure == '"' ) {
	echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
}

echo ' ' . $snow_type_3_1_english;

if ( $location_3_elevation_2 && !$location_3_name_2 ) {

	echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_2 ) . ': </strong>' . $snow_depth_3_2 . '  ' . $snow_depth_measure;

	if ( $snow_depth_measure == 'cm' ) {
		echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
	} elseif ( $snow_depth_measure == '"' ) {
		echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
	}

	echo ' ' . $snow_type_3_2_english;

	if ( $location_3_elevation_3 && !$location_3_name_3 ) {

		echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_3 ) . ': </strong>' . $snow_depth_3_3 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_3_3_english;

		if ( $location_3_elevation_4 && !$location_3_name_4 ) {

			echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_4 ) . ': </strong>' . $snow_depth_3_4 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_3_4_english;

			if ( $location_3_elevation_5 && !$location_3_name_5 ) {

				echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_5 ) . ': </strong>' . $snow_depth_3_5 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_3_5_english;

			}

		}

	}

}

echo ' ' . $snow_type_3 . '</li>';