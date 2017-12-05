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

$included_options = get_post_meta( get_the_ID(), 'included_options', true );

include_once ( $_SERVER['DOCUMENT_ROOT'] . $included_options );

// TODAY
//$skiresort_data			= get_post_meta( get_the_ID(), 'ski_resort_data', true );
//$snow					= get_post_meta( get_the_ID(), 'snow', true );
//$snow_depth				= get_post_meta( get_the_ID(), 'snow_depth', true );
//$name_depth				= get_post_meta( get_the_ID(), 'name_depth', true );
//$location_depth_1		= get_post_meta( get_the_ID(), 'location_depth_1', true );
//$location_depth_2		= get_post_meta( get_the_ID(), 'location_depth_2', true );
//$location_depth_3		= get_post_meta( get_the_ID(), 'location_depth_3', true );
//$location_depth_4		= get_post_meta( get_the_ID(), 'location_depth_4', true );
//$location_depth_5		= get_post_meta( get_the_ID(), 'location_depth_5', true );
//$pricing				= get_post_meta( get_the_ID(), 'pricing', true );