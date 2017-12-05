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

<ul class="ul-overview-elevation">

	<?php
	//echo '<ul class="ul-overview-elevation-narrow">';

	// REPEATER - ELEVATION INFO
	if ( $count_elevation_info ) {

		for ( $i = 0; $i < $count_elevation_info; $i++ ) {

			$min_elevation			= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_min_elevation', true );
			$max_elevation			= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_max_elevation', true );
			$elevation_difference	= ( $max_elevation - $min_elevation );
			$elevation_unity		= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_elevation_unity', true );

			// Sub-Field
			if ( $max_elevation ) {

				echo '<li class="overview-elevation"><strong>Max Elevation: </strong> ' . number_format( $max_elevation, 0 ) . ' ' . $elevation_unity . ' (';

				if ( $elevation_unity == 'm' ) {
					echo number_format( $max_elevation * 3.2808, 0 ) . ' ft)';
				} elseif ( $elevation_unity == 'ft' ) {
					echo number_format( $max_elevation / 3.2808, 0 ) . ' m)';
				}

				echo '</li>';

			}

			if ( $min_elevation ) {

				echo '<li class="overview-elevation"><strong>Min Elevation: </strong> ' . number_format( $min_elevation, 0 ) . ' ' . $elevation_unity . ' (';

				if ( $elevation_unity == 'm' ) {
					echo number_format( $min_elevation * 3.2808, 0 ) . ' ft)';
				} elseif ( $elevation_unity == 'ft' ) {
					echo number_format( $min_elevation / 3.2808, 0 ) . ' m) )';
				}

				echo '</li>';

			}

			if ( $elevation_difference ) {

				echo '<li class="overview-elevation"><strong>Elev. Difference: </strong> ' . number_format( $elevation_difference, 0 ) . ' ' . $elevation_unity . ' (';

				if ( $elevation_unity == 'm' ) {
					echo number_format( $elevation_difference * 3.2808, 0 ) . ' ft)';
				} elseif ( $elevation_unity == 'ft' ) {
					echo number_format( $elevation_difference / 3.2808, 0 ) . ' m)';
				}

				echo '</li>';

			}

		}

	}
	?>

</ul>