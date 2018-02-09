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
				echo '<li class="cog-railways" itemprop="additionalType" href="http://www.productontology.org/id/Rack_railway" /><strong><span itemprop="numberOfItems">' . $cog_railways . '</span></strong></li>';
			}

			if ( $funiculars ) {
				echo '<li class="funicular" itemprop="additionalType" href="http://www.productontology.org/id/Funicular" /><strong><span itemprop="numberOfItems">' . $funiculars . '</span></strong></li>';
			}

			if ( $aerial_tramways_reversible_ropeways ) {
				echo '<li class="aerial-cable-tramway-reversible-ropeway" itemprop="additionalType" href="http://www.productontology.org/id/Aerial_tramway" /><strong><span itemprop="numberOfItems">' . $aerial_tramways_reversible_ropeways . '</span></strong></li>';
			}

			if ( $circulating_ropeways_gondola_lifts ) {
				echo ' <li class="circulating-ropeway-gondola-lift" itemprop="additionalType" href="http://www.productontology.org/id/Gondola_lift" /><strong><span itemprop="numberOfItems">' . $circulating_ropeways_gondola_lifts . '</span></strong></li>';
			}

			if ( $combined_installations_gondola_and_chair ) {
				echo '<li class="combined-installation" itemprop="additionalType" href="http://www.productontology.org/id/Hybrid_lift" /><strong><span itemprop="numberOfItems">' . $combined_installations_gondola_and_chair . '</span></strong></li>';
			}

			if ( $total_chairlifts ) {
				echo ' <li class="chairlift" itemprop="additionalType" href="http://www.productontology.org/id/Chairlift" /><strong><span itemprop="numberOfItems">' . $total_chairlifts . '</span></strong></li>';
			}

			if ( $t_bar_lifts_platters_button_lifts ) {
				echo '<li class="t-bar-lift-platter-button-lift" itemprop="additionalType" href="http://www.productontology.org/id/Surface_lift#T-bar_and_J-bars" /><strong><span itemprop="numberOfItems">' . $t_bar_lifts_platters_button_lifts . '</span></strong></li>';
			}

			if ( $rope_tows_beginner_lifts ) {
				echo ' <li class="rope-tow-beginner-lift" itemprop="additionalType" href="http://www.productontology.org/id/Surface_lift#Rope_tows" /><strong><span itemprop="numberOfItems">' . $rope_tows_beginner_lifts . '</span></strong></li>';
			}

			if ( $magic_carpets_people_movers ) {
				echo ' <li class="magic-carpet-people-mover" itemprop="additionalType" href="http://www.productontology.org/id/Surface_lift#Magic_carpet" /><strong><span itemprop="numberOfItems">' . $magic_carpets_people_movers . '</span></strong></li>';
			}

			if ( $surface_lifts ) {
				echo '<li class="t-bar-lift-platter-button-lift" itemprop="additionalType" href="http://www.productontology.org/id/Surface_lift" /><strong><span itemprop="numberOfItems">' . $surface_lifts . '</span></strong></li>';
			}
			?>

		</ul>

		<ul class="overview-lift-totals">

			<?php
			if ( $total_lift_capacity ) {

				echo '<li itemprop="maximumAttendeeCapacity"><strong>Total lift capacity: </strong> ' . $total_lift_capacity_format . ' passengers / hour' . '</li>';

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