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

// REPEATER - NUMBER OF SKI SLOPES
$count_number_of_ski_slopes = get_post_meta( get_the_ID(), 'number_of_ski_slopes', true );

if ( $count_number_of_ski_slopes ) {

	for ( $i = 0; $i < $count_number_of_ski_slopes; $i++ ) {

		$green_slopes			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_green_slopes', true );
		$blue_slopes			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_blue_slopes', true );
		$red_slopes				= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_red_slopes', true );
		$black_slopes			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_black_slopes', true );
		$double_black_slopes	= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_double_black_slopes', true );
		$extreme_black_slopes	= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_extreme_black_slopes', true );
		$ski_routes				= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_ski_routes', true );
		$nordic_tracks			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_nordic_tracks', true );
		$off_piste_runs			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_off-piste_runs', true );
		$manual_runs			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_manual_runs', true );

		$total_slopes			= ( $green_slopes + $blue_slopes + $red_slopes + $black_slopes + $ski_routes + $nordic_tracks + $off_piste_runs );

	}

}

if ( $manual_runs ) {

	echo '<li class="open-slopes"><strong>Open Runs: </strong>' . $working_slopes . ' /  ' . $manual_runs . '</li>';

} elseif ( isset ( $working_slopes ) && $working_slopes >= 0 ) {

	echo '<li class="open-slopes"><strong>Open Slopes: </strong>' . $working_slopes . ' /  ' . $total_slopes;

	if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 || isset( $working_ski_routes ) && $working_ski_routes >= 0 || isset( $working_nordic_tracks ) && $working_nordic_tracks >= 0 || isset( $working_off_piste_runs ) && $working_off_piste_runs >= 0 ) {

		echo ' <strong>&#10142; </strong>';

		if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 ) {
				echo ' <strong><span class="working-green">' . $working_slopes_green . '</span></strong>';
		}

		if ( isset( $working_slopes_blue ) && $working_slopes_blue >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-blue">' . $working_slopes_blue . '</span></strong>';

		}

		if ( isset( $working_slopes_red ) && $working_slopes_red >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-red">' . $working_slopes_red . '</span></strong>';

		}

		if ( isset( $working_slopes_black ) && $working_slopes_black >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-black">' . $working_slopes_black . '</span></strong>';

		}

		if ( isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-black">' . $working_slopes_double_black . '</span></strong>&#9830;&#9830;';

		}

		if ( isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-black">' . $working_slopes_extreme_black . '&#9830;&#9830;</span></strong>';

		}

		if ( isset( $working_ski_routes ) && $working_ski_routes >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-ski-routes">' . $working_ski_routes . '</span></strong>';

		}

		if ( isset( $working_nordic_tracks ) && $working_nordic_tracks >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 || isset( $working_ski_routes ) && $working_ski_routes >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-nordic-tracks">' . $working_nordic_tracks . '</span></strong>';

		}

		if ( isset( $working_off_piste_runs ) && $working_off_piste_runs >= 0 ) {

			if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 || isset( $working_ski_routes ) && $working_ski_routes >= 0 || isset( $working_nordic_tracks ) && $working_nordic_tracks >= 0 ) {
				echo ' + ';
			}

			echo ' <strong><span class="working-ski-routes">' . $working_off_piste_runs . '</span></strong>';

		}

	}

	echo '</li>';

// Si no hi ha distribució de pistes per colors
} elseif ( isset( $working_slopes ) && $working_slopes = 'Not available' ) {

	echo '<li class="open-slopes"><strong>Open Slopes: </strong>' . 'Not available' . ' / ' . $total_slopes . '</li>';

} else {

	echo '<li class="open-slopes"><strong>Open Slopes: </strong>' . $working_slopes . ' /  ' . $total_slopes . '</li>';

}