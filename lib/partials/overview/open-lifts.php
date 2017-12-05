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

// REPEATER - LIFTS
$count_lifts = get_post_meta( get_the_ID(), 'lifts', true );

if ( $count_lifts ) {

	for ( $i = 0; $i < $count_lifts; $i++ ) {

		$cog_railways							    = get_post_meta( get_the_ID(), 'lifts_' . $i . '_cog_railways', true );
		$funiculars								    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_funiculars', true );
		$aerial_tramways_reversible_ropeways	    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_aerial_tramways_reversible_ropeways', true );
		$cage_lifts								    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_cage_lifts', true );
		$circulating_ropeway_gondola_lift		    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_circulating_ropeway_gondola_lift', true );
		$combined_installations_gondola_and_chair	= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_combined_installations_gondola_and_chair', true );
		$detachable_chairlifts					    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_detachable_chairlifts', true );
		$fixed_grip_chairlifts					    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_fixed_grip_chairlifts', true );
		$chairlifts								    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_chairlifts', true );
		$t_bar_lifts_platters_button_lifts		    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_t_bar_lifts_platters_button_lifts', true );
		$rope_tow_beginner_lift					    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_rope_tow_beginner_lift', true );
		$magic_carpet_people_mover				    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_magic_carpet_people_mover', true );
		$surface_lifts							    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_surface_lifts', true );

		$total_lifts = ( $cog_railways + $funiculars + $aerial_tramways_reversible_ropeways + $cage_lifts + $circulating_ropeway_gondola_lift + $combined_installations_gondola_and_chair + $detachable_chairlifts + $fixed_grip_chairlifts + $chairlifts + $t_bar_lifts_platters_button_lifts + $rope_tow_beginner_lift + $magic_carpet_people_mover + $surface_lifts );

	}

}

if ( isset( $working_lifts ) && $working_lifts >= 0 ) {

	echo '<li class="open-lifts"><strong>Open Lifts: </strong>' . $working_lifts . ' / ' . $total_lifts . '</li>';

} elseif ( isset( $working_lifts ) && $working_lifts == 'Not available' ) {

	echo '<li class="open-lifts"><strong>Open Lifts: </strong>' . 'Not available' . ' / ' . $total_lifts . '</li>';

}