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

?>

<ul class="ul-overview-other-slopes">

	<?php
	// REPEATER - ADDITIONAL SKI SLOPES
	$count_number_of_additional_ski_slopes = get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes', true );

	if ( $count_number_of_additional_ski_slopes ) {

		for ( $i = 0; $i < $count_number_of_additional_ski_slopes; $i++ ) {

			$additional_ski_routes		= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_number_of_additional_ski_routes', true );
			$additional_nordic_tracks	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_number_of_additional_nordic_tracks', true );
			$additional_off_piste_runs	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_number_of_additional_off_piste_runs', true );

		}

	}

	$count_length_of_additional_ski_slopes = get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes', true );

	if ( $count_length_of_additional_ski_slopes ) {

		for ( $i = 0; $i < $count_length_of_additional_ski_slopes; $i++ ) {

			$length_of_additional_ski_routes			= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_ski_routes', true );
			$length_of_additional_nordic_tracks			= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_nordic_tracks', true );
			$length_of_additional_off_piste				= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_off_piste_runs', true );
			$manual_length_of_additional_ski_routes		= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_ski_routes', true );
			$manual_length_of_additional_nordic_tracks	= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_nordic_tracks', true );
			$manual_length_of_additional_off_piste_runs	= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_off_piste_runs', true );
		}

	}

	// Additional Ski Routes / Nordic Tracks / Off-Piste
	if ( $manual_length_of_additional_ski_routes ) {

		echo '<li class="overview-ski-routes"><strong>SKI ROUTES: ' . $manual_length_of_additional_ski_routes . ' ' . $length_slopes_unity;

		if ( $length_slopes_unity == 'km' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_ski_routes * 0.62137, 1 ) . ' mi';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_ski_routes / 0.62137, 1 ) . ' km';
		}

		echo ')</strong></li>';

	}

	if ( $additional_ski_routes ) {

		echo '<li class="overview-ski-routes"><strong>' . $additional_ski_routes . ' SKI ROUTE';

		if ( $additional_ski_routes > '1' ) {
			echo 'S';
		}

		if ( $length_of_additional_ski_routes ) {

			echo ' || ' . $length_of_additional_ski_routes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_additional_ski_routes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_additional_ski_routes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $manual_length_of_additional_nordic_tracks ) {

		echo '<li class="overview-nordic-tracks"><strong>CROSS COUNTRY / NORDIC TRACKS: ' . $manual_length_of_additional_nordic_tracks . ' ' . $length_slopes_unity;

		if ( $length_slopes_unity == 'km' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_nordic_tracks * 0.62137, 1 ) . ' mi';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_nordic_tracks / 0.62137, 1 ) . ' km';
		}

		echo ')</strong></li>';

	}

	if ( $additional_nordic_tracks ) {

		echo '<li class="overview-nordic-tracks"><strong>' . $additional_nordic_tracks . ' CROSS COUNTRY / NORDIC TRACK';

		if ( $additional_nordic_tracks > '1' ) {
			echo 'S';
		}

		if ( $length_of_additional_nordic_tracks ) {

			echo ' || ' . $length_of_additional_nordic_tracks . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_additional_nordic_tracks * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_additional_nordic_tracks / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';
	}

	if ( $manual_length_of_additional_off_piste_runs ) {

		echo '<li class="overview-ski-routes"><strong>OFF-PISTE RUNS: ' . $manual_length_of_additional_off_piste_runs . ' ' . $length_slopes_unity;

		if ( $length_slopes_unity == 'km' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_off_piste_runs * 0.62137, 1 ) . ' mi';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_off_piste_runs / 0.62137, 1 ) . ' km';
		}

		echo ')</strong></li>';

	}

	if ( $additional_off_piste_runs ) {

		echo '<li class="overview-ski-routes"><strong>' . $additional_off_piste_runs . ' OFF-PISTE RUN';

		if ( $additional_off_piste_runs > '1' ) {
			echo 'S';
		}

		if ( $length_of_additional_off_piste ) {

			echo ' || ' . $length_of_additional_off_piste . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_additional_off_piste * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_additional_off_piste / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}
	?>

</ul>