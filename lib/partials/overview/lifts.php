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

$count_lifts = get_post_meta( get_the_ID(), 'lifts', true );

if ( $count_lifts ) {

	for ( $i = 0; $i < $count_lifts; $i++ ) {

		$total_chairlifts			= ( $detachable_chairlifts + $fixed_grip_chairlifts + $chairlifts );
		$total_lift_capacity		= get_post_meta( get_the_ID(), 'lifts_' . $i . '_total_lift_capacity', true );
		$total_lift_capacity_format	= number_format( $total_lift_capacity, 0 );
		$total_lift_length			= get_post_meta( get_the_ID(), 'lifts_' . $i . '_total_lift_length', true );
		$lift_length_unity			= get_post_meta( get_the_ID(), 'lifts_' . $i . '_lift_length_unity', true );
		?>

		<ul class="overview-lifts">

			<?php
			if ( $cog_railways ) {
				echo '<li class="cog-railways"><strong>' . $cog_railways . '</strong></li>';
			}

			if ( $funiculars ) {
				echo '<li class="funicular"><strong>' . $funiculars . '</strong></li>';
			}

			if ( $aerial_tramways_reversible_ropeways ) {
				echo '<li class="aerial-cable-tramway-reversible-ropeway"><strong>' . $aerial_tramways_reversible_ropeways . '</strong></li>';
			}

			if ( $circulating_ropeway_gondola_lift ) {
				echo ' <li class="circulating_ropeway-gondola-lift"><strong>' . $circulating_ropeway_gondola_lift . '</strong></li>';
			}

			if ( $combined_installations_gondola_and_chair ) {
				echo '<li class="combined-installation"><strong>' . $combined_installations_gondola_and_chair . '</strong></li>';
			}

			if ( $total_chairlifts ) {
				echo ' <li class="chairlift"><strong>' . $total_chairlifts . '</strong></li>';
			}

			if ( $t_bar_lifts_platters_button_lifts ) {
				echo '<li class="t-bar-lift-platter-button-lift"><strong>' . $t_bar_lifts_platters_button_lifts . '</strong></li>';
			}

			if ( $rope_tow_beginner_lift ) {
				echo ' <li class="rope-tow-beginner-lift"><strong>' . $rope_tow_beginner_lift . '</strong></li>';
			}

			if ( $magic_carpet_people_mover ) {
				echo ' <li class="magic-carpet-people-mover"><strong>' . $magic_carpet_people_mover . '</strong></li>';
			}

			if ( $surface_lifts ) {
				echo '<li class="t-bar-lift-platter-button-lift"><strong>' . $surface_lifts . '</strong></li>';
			}
			?>

		</ul>

		<ul class="overview-lift-totals">

			<?php
			if ( $total_lift_capacity ) {

				echo '<li><strong>Total lift capacity: </strong> ' . $total_lift_capacity_format . ' passengers / hour' . '</li>';

			}

			if ( $total_lift_length ) {

				echo '<li><strong>Total lift length: </strong> ' . $total_lift_length . ' ' . $lift_length_unity . ' (';

				if ( $lift_length_unity == 'km' ) {

					echo number_format( $total_lift_length * 0.62137, 1 ) . ' mi)';

				} elseif ( $lift_length_unity == 'mi' ) {

					echo number_format( $total_lift_length / 0.62137, 1 ) . ' km)';

				}

				echo '</li><p class="divi-horizontal-half"></p>';

			}
			?>

		</ul>
		<?php

	}

}