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

// REPEATER - SLOPES MAPS
$count_slopes_maps  = get_post_meta( get_the_ID(), 'slopes_maps', true );

/*if ( $count_slopes_maps ) {

	for ( $i = 0; $i < $count_slopes_maps; $i++ ) {

		$slope_map_200x109	= get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slope_map_200x109', true );
		$slope_map_250x136	= get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slope_map_250x136', true );
		$slope_map_300x163	= get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slope_map_300x163', true );

		if ( $slope_map_200x109 ) {

			echo '<p class="overview-slopes-map-mini">' . wp_get_attachment_image( $slope_map_200x109, 'slopes_maps' ) . '</p>';

		} elseif ( $slope_map_250x136 ) {

			echo '<p class="overview-slopes-map-mini">' . wp_get_attachment_image( $slope_map_250x136, 'slopes_maps' ) . '</p>';

		} elseif ( $slope_map_300x163 ) {

			echo '<p class="overview-slopes-map-mini">' . wp_get_attachment_image( $slope_map_300x163, 'slopes_maps' ) . '</p>';

		}

	}

}*/

if ( $count_slopes_maps ) {

	for ( $i = 0; $i < $count_slopes_maps; $i++ ) {

		$slopes_map_full		= (int) get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slopes_map_full', true );
		$slopes_map_thumbnail	= (int) get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slopes_map_thumbnail', true );

		if ( $slopes_map_thumbnail ) {
			echo '<p class="overview-slopes-map-mini"><a href="' . wp_get_attachment_url( $slopes_map_full ) . '">' . wp_get_attachment_image( $slopes_map_thumbnail, 'slopes_maps' ) . '</a></p>';
		}

	}

}