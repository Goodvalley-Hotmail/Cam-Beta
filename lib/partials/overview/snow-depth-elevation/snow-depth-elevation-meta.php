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

// REPEATER - ELEVATION INFO
$count_elevation_info = get_post_meta( get_the_ID(), 'elevation_info', true );

if ( $count_elevation_info ) {

	for ( $i = 0; $i < $count_elevation_info; $i++ ) {

		$snow_depth_measure			= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_snow_depth_measure', true );
		$elevation_depth_measure	= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_elevation_depth_measure', true );

	}

}

// REPEATER - SNOW DEPTH
$count_snow_depth = get_post_meta( get_the_ID(), 'snow_depth', true );

if ( $count_snow_depth ) {

	for ( $i = 0; $i < $count_snow_depth; $i++ ) {

		$elevation_snow_unique		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_unique', true );
		$elevation_snow_depth_min	= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_min', true );
		$elevation_snow_depth_max	= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_max', true );
		$elevation_snow_depth_1		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_1', true );
		$elevation_snow_depth_2		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_2', true );
		$elevation_snow_depth_3		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_3', true );
		$elevation_snow_depth_4		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_4', true );
		$elevation_snow_depth_5		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_5', true );
		$elevation_snow_depth_6		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_6', true );
		$elevation_snow_depth_7		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_depth_7', true );

	}

}

// REPEATER - NAME DEPTH
$count_name_depth = get_post_meta( get_the_ID(), 'name_depth', true );

if ( $count_name_depth ) {

	for ( $i = 0; $i < $count_name_depth; $i++ ) {

		$name_depth_unique	= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_unique', true );
		$name_depth_min		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_min', true );
		$name_depth_max		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_max', true );
		$name_depth_1		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_1', true );
		$name_depth_2		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_2', true );
		$name_depth_3		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_3', true );
		$name_depth_4		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_4', true );
		$name_depth_5		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_5', true );
		$name_depth_6		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_6', true );
		$name_depth_7		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_7', true );
		$name_depth_8		= get_post_meta( get_the_ID(), 'name_depth_' . $i . '_name_depth_8', true );

	}

}

// REPEATER - LOCATION_DEPTH_1
$count_location_depth_1 = get_post_meta( get_the_ID(), 'location_depth_1', true );

if ( $count_location_depth_1 ) {

	for ( $i = 0; $i < $count_location_depth_1; $i++ ) {

		$location_1				= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1', true );
		$location_1_name_1		= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_name_1', true );
		$location_1_elevation_1	= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_elevation_1', true );
		$location_1_name_2		= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_name_2', true );
		$location_1_elevation_2	= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_elevation_2', true );
		$location_1_name_3		= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_name_3', true );
		$location_1_elevation_3	= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_elevation_3', true );
		$location_1_name_4		= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_name_4', true );
		$location_1_elevation_4	= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_elevation_4', true );
		$location_1_name_5		= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_name_5', true );
		$location_1_elevation_5	= get_post_meta( get_the_ID(), 'location_depth_1_' . $i . '_location_1_elevation_5', true );

	}

}

// REPEATER - LOCATION_DEPTH_2
$count_location_depth_2 = get_post_meta( get_the_ID(), 'location_depth_2', true );

if ( $count_location_depth_2 ) {

	for ( $i = 0; $i < $count_location_depth_2; $i++ ) {

		$location_2				= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2', true );
		$location_2_name_1		= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_name_1', true );
		$location_2_elevation_1	= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_elevation_1', true );
		$location_2_name_2		= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_name_2', true );
		$location_2_elevation_2	= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_elevation_2', true );
		$location_2_name_3		= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_name_3', true );
		$location_2_elevation_3	= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_elevation_3', true );
		$location_2_name_4		= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_name_4', true );
		$location_2_elevation_4	= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_elevation_4', true );
		$location_2_name_5		= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_name_5', true );
		$location_2_elevation_5	= get_post_meta( get_the_ID(), 'location_depth_2_' . $i . '_location_2_elevation_5', true );

	}

}

// REPEATER - LOCATION_DEPTH_3
$count_location_depth_3 = get_post_meta( get_the_ID(), 'location_depth_3', true );

if ( $count_location_depth_3 ) {

	for ( $i = 0; $i < $count_location_depth_3; $i++ ) {

		$location_3				= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3', true );
		$location_3_name_1		= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_name_1', true );
		$location_3_elevation_1	= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_elevation_1', true );
		$location_3_name_2		= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_name_2', true );
		$location_3_elevation_2	= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_elevation_2', true );
		$location_3_name_3		= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_name_3', true );
		$location_3_elevation_3	= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_elevation_3', true );
		$location_3_name_4		= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_name_4', true );
		$location_3_elevation_4	= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_elevation_4', true );
		$location_3_name_5		= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_name_5', true );
		$location_3_elevation_5	= get_post_meta( get_the_ID(), 'location_depth_3_' . $i . '_location_3_elevation_5', true );

	}

}

// REPEATER - LOCATION_DEPTH_4
$count_location_depth_4 = get_post_meta( get_the_ID(), 'location_depth_4', true );

if ( $count_location_depth_4 ) {

	for ( $i = 0; $i < $count_location_depth_4; $i++ ) {

		$location_4				= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4', true );
		$location_4_name_1		= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_name_1', true );
		$location_4_elevation_1	= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_elevation_1', true );
		$location_4_name_2		= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_name_2', true );
		$location_4_elevation_2	= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_elevation_2', true );
		$location_4_name_3		= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_name_3', true );
		$location_4_elevation_3	= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_elevation_3', true );
		$location_4_name_4		= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_name_4', true );
		$location_4_elevation_4	= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_elevation_4', true );
		$location_4_name_5		= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_name_5', true );
		$location_4_elevation_5	= get_post_meta( get_the_ID(), 'location_depth_4_' . $i . '_location_4_elevation_5', true );

	}

}

// REPEATER - LOCATION_DEPTH_5
$count_location_depth_5 = get_post_meta( get_the_ID(), 'location_depth_5', true );

if ( $count_location_depth_5 ) {

	for ( $i = 0; $i < $count_location_depth_5; $i++ ) {

		$location_5				= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5', true );
		$location_5_name_1		= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_name_1', true );
		$location_5_elevation_1	= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_elevation_1', true );
		$location_5_name_2		= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_name_2', true );
		$location_5_elevation_2	= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_elevation_2', true );
		$location_5_name_3		= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_name_3', true );
		$location_5_elevation_3	= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_elevation_3', true );
		$location_5_name_4		= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_name_4', true );
		$location_5_elevation_4	= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_elevation_4', true );
		$location_5_name_5		= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_name_5', true );
		$location_5_elevation_5	= get_post_meta( get_the_ID(), 'location_depth_5_' . $i . '_location_5_elevation_5', true );

	}

}