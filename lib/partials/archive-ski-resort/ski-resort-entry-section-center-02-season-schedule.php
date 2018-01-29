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

//namespace CameraSki;

$count_season_schedule = get_post_meta( get_the_ID(), 'season_schedule', true );

if ( $count_season_schedule ) {

	for ( $i = 0; $i < $count_season_schedule; $i++ ) {

		$timezone = get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_time_zone', true );

		$opening_date       = get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_opening_date', true );
		$closing_date       = get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_closing_date', true );
		$full_year_round    = get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_full_year_round', true );
		$operating_schedule = get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_operating_schedule', true );

		if ( $opening_date ) {
			$opening_date = date( 'F d', strtotime( $opening_date ) );
		}

		if ( $closing_date ) {
			$closing_date = date( 'F d', strtotime( $closing_date ) );
		}

		if ( $opening_date || $closing_date ) {

			echo '<p class="archive-season">Season from ' . $opening_date . ' to ' . $closing_date . '<strong> | </strong>' . $operating_schedule;

		} elseif ( $full_year_round ) {

			echo '<p class="archive-season">' . $full_year_round . '<strong> | </strong>' . $operating_schedule . '</p>';

		}

		/*if ( $operating_status == 'OPEN' ) {

			echo '<span class="operating-status-open"><strong> ' . $operating_status_english . '</strong></span></p>';

		} elseif ( $operating_status == 'CLOSED' ) {

			echo '<span class="operating-status-closed"><strong> ' . $operating_status_english . '</strong></span></p>';

		}*/

	}

}