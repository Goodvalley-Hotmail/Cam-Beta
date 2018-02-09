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

<ul id="ul-season" class="background-boxes">

	<?php
	// REPEATER - SEASON
	$count_season = get_post_meta( get_the_ID(), 'season_schedule', true );

	if ( $count_season ) {

		for ( $i= 0; $i < $count_season; $i++ ) {

			$operating_schedule = '<time itemprop="openingHours" datetime="Mo-Su ' . get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_operating_schedule', true ) . '">' . get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_operating_schedule', true ) . '</time>';
			//$operating_schedule = '<meta itemprop="openingHours" content="Mo-Su ' . get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_operating_schedule', true ) . '" />' . get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_operating_schedule', true );
            $opening_date		= get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_opening_date', true );

			if ( $opening_date ) {
				$opening_date		= date( 'F d', strtotime( $opening_date ) );
			}

			$closing_date		= get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_closing_date', true );

			if ( $closing_date ) {
				$closing_date		= date( 'F d', strtotime( $closing_date ) );
			}

			$full_year_round	= get_post_meta( get_the_ID(), 'season_schedule_' . $i . '_full_year_round', true );

			// Sub-Field
			if ( $opening_date || $closing_date ) {

				echo '<li class="season"><strong>SEASON: </strong><br /> ' .  $opening_date . ' - ' . $closing_date . '<strong> | </strong>' . $operating_schedule . '</li>';

			} elseif ( $full_year_round ) {

				echo '<li class="season"><strong>SEASON: </strong><br /> ' .  $full_year_round . '<strong> | </strong>' . $operating_schedule . '</li>';

			}

		}

	}
	?>

</ul>