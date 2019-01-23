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

echo '<div class="main-webcam-image provisional">';

$ski_resort_maps       = get_post_meta( get_the_ID(), 'ski_resort_maps', true );
$count_ski_resort_maps = get_post_meta( get_the_ID(), 'ski_resort_maps', true );

if ( $count_ski_resort_maps ) {

	for ( $i = 0; $i < $count_ski_resort_maps; $i++ ) {

		$ski_resort_map_full	    = intval( get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_full', true ) );
		$ski_resort_map_thumbnail   = intval( get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_thumbnail', true ) );

		if ( $ski_resort_map_thumbnail ) {
			$image = wp_get_attachment_image_src( $ski_resort_map_thumbnail, 'full' );
		}

		if ( $image ) {
			//echo '<a href="' . get_permalink() . '" rel="bookmark"><img src="' . $image[0] . '" alt="' . the_title_attribute( 'echo=0' ) . '">';
			printf( '<a href="%s" rel="bookmark"><img src="%s" alt="%s" class="alignleft" /></a>', get_permalink(), $image[0], the_title_attribute( 'echo=0' ) );
		}

	}

}

echo '</div>';

//$ski_resort_maps = get_post_meta( get_the_ID(), 'ski_resort_maps', true );

/*echo '<div class="main-webcam-image provisional">';

	$count_ski_resort_maps = get_post_meta( get_the_ID(), 'ski_resort_maps', true );

	if ( $count_ski_resort_maps ) {

		for ( $i = 0; $i < $count_ski_resort_maps; $i++ ) {

			$ski_resort_map_200x109	= intval( get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_200x109', true ) );
			$ski_resort_map_250x136	= intval( get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_250x136', true ) );
			$ski_resort_map_300x163	= intval( get_post_meta( get_the_ID(), 'ski_resort_maps_' . $i . '_ski_resort_map_300x163', true ) );

			if ( $ski_resort_map_200x109 ) {
				$image = wp_get_attachment_image_src( $ski_resort_map_200x109, 'ski-resort-map-200x109' );
			} elseif ( $ski_resort_map_250x136 ) {
				$image = wp_get_attachment_image_src( $ski_resort_map_250x136, 'ski-resort-map-250x136' );
			} elseif ( $ski_resort_map_300x163 ) {
				$image = wp_get_attachment_image_src( $ski_resort_map_300x163, 'ski-resort-map-300x163' );
			}

			if ( $image ) {
				//echo '<a href="' . get_permalink() . '" rel="bookmark"><img src="' . $image[0] . '" alt="' . the_title_attribute( 'echo=0' ) . '">';
				printf( '<a href="%s" rel="bookmark"><img src="%s" alt="%s" class="alignleft" /></a>', get_permalink(), $image[0], the_title_attribute( 'echo=0' ) );
			}

		}

	}

echo '</div>';*/