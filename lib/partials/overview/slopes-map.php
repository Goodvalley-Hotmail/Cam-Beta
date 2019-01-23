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
$count_ski_resort_maps = get_post_meta( get_the_ID(), 'ski_resort_maps', true );

if ( $count_ski_resort_maps ) {

	for ( $i = 0; $i < $count_ski_resort_maps; $i++ ) {

		$ski_resort_map_full		= (int) get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_full', true );
		$ski_resort_map_thumbnail	= (int) get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_thumbnail', true );

		if ( $ski_resort_map_thumbnail ) {
			echo '<p class="overview-slopes-map-mini"><a href="' . wp_get_attachment_url( $ski_resort_map_full, 'ski_resort_maps' ) . '">' . wp_get_attachment_image( $ski_resort_map_thumbnail, 'ski_resort_maps' ) . '</a></p>';
		}

	}

}

// REPEATER - SLOPES MAPS
/*$count_slopes_maps  = get_post_meta( get_the_ID(), 'ski_resort_maps', true );

if ( $count_slopes_maps ) {

	for ( $i = 0; $i < $count_slopes_maps; $i++ ) {

		$ski_resort_map_200x109	= get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_200x109', true );
		$ski_resort_map_250x136	= get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_250x136', true );
		$ski_resort_map_300x163	= get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_300x163', true );
		$ski_resort_map_full	= get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_full', true );

		if ( $ski_resort_map_200x109 ) {

			//echo '<p class="overview-slopes-map-mini">' . wp_get_attachment_image( $slope_map_200x109, 'slopes_maps' ) . '</p>';
			echo '<p class="overview-slopes-map-mini"><a href="' . wp_get_attachment_url( $ski_resort_map_full ) . '">' . wp_get_attachment_image( $ski_resort_map_200x109, 'ski-resort-map-200x109', false, array( 'itemprop' => 'image' ) ) . '</a></p>';

		} elseif ( $ski_resort_map_250x136 ) {

			//echo '<p class="overview-slopes-map-mini">' . wp_get_attachment_image( $slope_map_250x136, 'slopes_maps' ) . '</p>';
			echo '<p class="overview-slopes-map-mini"><a href="' . wp_get_attachment_url( $ski_resort_map_full ) . '">' . wp_get_attachment_image( $ski_resort_map_250x136, 'ski-resort-map-250x136', false, array( 'itemprop' => 'image' ) ) . '</a></p>';

		} elseif ( $ski_resort_map_300x163 ) {

			//echo '<p class="overview-slopes-map-mini">' . wp_get_attachment_image( $slope_map_300x163, 'slopes_maps' ) . '</p>';
			echo '<p class="overview-slopes-map-mini"><a href="' . wp_get_attachment_url( $ski_resort_map_full ) . '">' . wp_get_attachment_image( $ski_resort_map_300x163, 'ski-resort-map-300x163', false, array( 'itemprop' => 'image' ) ) . '</a></p>';

		}

	}

}*/