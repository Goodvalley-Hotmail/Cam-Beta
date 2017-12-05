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

//if ( isset( $snow_depth_max ) && $snow_depth_max >= 0 ) {

	echo '<li class="snow-depth"><strong>';

	if ( $name_depth_max ) {

		if ( $elevation_snow_depth_max ) {

			echo $name_depth_max . ' (' . number_format( $elevation_snow_depth_max ) . ' ' . $elevation_depth_measure . '): ';

		} else {

			echo $name_depth_max . ': ';

		}

	} elseif ( $elevation_snow_depth_max ) {

		echo 'Snow Depth (' . number_format( $elevation_snow_depth_max ) . ' ' . $elevation_depth_measure . '): ';

	} elseif ( ! $name_depth_max && ! $elevation_snow_depth_max ) {

		echo 'Max Snow Depth: ';

	}

	echo '</strong>' . $snow_depth_max . ' ' . $snow_depth_measure;

	if ( $snow_depth_measure == 'cm' ) {

		echo ' (' . round( $snow_depth_max * 0.3937 ) . '")';

	} elseif ( $snow_depth_measure == '"' ) {

		echo ' (' . round( $snow_depth_max / 0.39370 ) . 'cm)';

	}

	if ( $snow_type_max_english ) {

		echo ' ' . $snow_type_max_english . '</li>';

	} else {

		echo '</li>';
	}

//}