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

// REPEATER - LENGTH OF SKI SLOPES
$count_length_slopes = get_post_meta( get_the_ID(), 'length_of_ski_slopes', true );

if ( $count_length_slopes ) {

	for ( $i = 0; $i < $count_length_slopes; $i++ ) {

		$length_of_green_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_green_slopes', true );
		$length_of_blue_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_blue_slopes', true );
		$length_of_red_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_red_slopes', true );
		$length_of_black_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_black_slopes', true );
		$length_of_double_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_double_black_slopes', true );
		$length_of_extreme_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_extreme_black_slopes', true );
		$length_of_ski_routes		        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_ski_routes', true );
		$length_of_nordic_tracks	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_nordic_tracks', true );
		$length_of_off_piste	            = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_off_piste_runs', true );
		$length_only_ski_slopes	            = ( $length_of_green_ski_slopes + $length_of_blue_ski_slopes + $length_of_red_ski_slopes + $length_of_black_ski_slopes + $length_of_double_black_ski_slopes + $length_of_extreme_black_ski_slopes );
		$length_of_ski_tracks 	            = ( $length_of_ski_routes + $length_of_nordic_tracks + $length_of_off_piste );
		$total_length_of_ski_slopes			= ( $length_only_ski_slopes + $length_of_ski_tracks );
		$manual_total_length_of_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_manual_total_length_of_ski_slopes', true );
		$total_length_with_routes_nordic 	= $manual_total_length_of_ski_slopes + $length_of_ski_tracks;
		$length_slopes_unity	            = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_slopes_unity', true );

	}

}

if ( $manual_total_length_of_ski_slopes && $total_length_of_ski_slopes ) {

	if ( $working_slopes_length ) {

		echo '<li class="open-length"><strong>Open Length: </strong>' . $working_slopes_length . ' /  ' . $total_length_with_routes_nordic . ' ' . $length_slopes_unity . ' (';

		if ( $length_slopes_unity == 'km' ) {

			echo round( ( float ) $working_slopes_length * 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi)';

		} elseif ( $length_slopes_unity == 'mi' ) {

			echo round( ( float ) $working_slopes_length / 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km)';

		}

		echo '</li>';

	}

} elseif ( $manual_total_length_of_ski_slopes && !$total_length_of_ski_slopes ) {

	if ( $working_slopes_length ) {

		if ( $working_slopes_length == 'Not available' ) {

			echo '<li class="open-length"><strong>Open Length: </strong>Not available</li>';

		} elseif ( $working_slopes_length == 'Undisclosed data' ) {

			echo '<li class="open-length"><strong>Open Length: </strong>Undisclosed data</li>';

		} elseif ( $working_slopes_length == 'Not provided' ) {

			echo '<li class="open-length"><strong>Open Length: </strong>Not provided</li>';

		} else {

			echo '<li class="open-length"><strong>Open Length: </strong>' . $working_slopes_length . ' /  ' . $manual_total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' (';

			if ( $length_slopes_unity == 'km' ) {

				echo round( ( float ) $working_slopes_length * 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi)';

			} elseif ( $length_slopes_unity == 'mi' ) {

				echo round( ( float ) $working_slopes_length / 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km)';

			}

			echo '</li>';

		}

	}

} elseif ( $total_length_of_ski_slopes && !$manual_total_length_of_ski_slopes ) {

	if ( $working_slopes_length ) {

		echo '<li class="open-length"><strong>Open Length: </strong>' . $working_slopes_length . ' /  ' . $total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' (';

		if ( $length_slopes_unity == 'km' ) {

			echo round( ( float ) $working_slopes_length * 0.62137, 1 ) . ' / ' . round( ( float ) $total_length_of_ski_slopes * 0.62137, 1 ) . ' mi)';

		} elseif ( $length_slopes_unity == 'mi' ) {

			echo round( ( float ) $working_slopes_length / 0.62137, 1 ) . ' / ' . number_format( ( float ) $total_length_of_ski_slopes / 0.62137, 1 ) . ' km)';

		}

		echo '</li>';

	}

}