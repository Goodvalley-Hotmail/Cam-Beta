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
		$circulating_ropeways_gondola_lifts		    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_circulating_ropeways_gondola_lifts', true );
		$combined_installations_gondola_and_chair	= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_combined_installations_gondola_and_chair', true );
		$detachable_chairlifts					    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_detachable_chairlifts', true );
		$fixed_grip_chairlifts					    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_fixed_grip_chairlifts', true );
		$chairlifts								    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_chairlifts', true );
		$t_bar_lifts_platters_button_lifts		    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_t_bar_lifts_platters_button_lifts', true );
		$rope_tows_beginner_lifts					= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_rope_tows_beginner_lifts', true );
		$magic_carpets_people_movers				= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_magic_carpets_people_movers', true );
		$surface_lifts							    = get_post_meta ( get_the_ID(), 'lifts_' . $i . '_surface_lifts', true );

		$total_lifts = ( $cog_railways + $funiculars + $aerial_tramways_reversible_ropeways + $cage_lifts + $circulating_ropeways_gondola_lifts + $combined_installations_gondola_and_chair + $detachable_chairlifts + $fixed_grip_chairlifts + $chairlifts + $t_bar_lifts_platters_button_lifts + $rope_tows_beginner_lifts + $magic_carpets_people_movers + $surface_lifts );

	}

}

if ( isset( $working_lifts ) && $working_lifts >= 0 ) {

	echo '<li class="open-lifts"><strong>Open Lifts: </strong>' . $working_lifts . ' / ' . $total_lifts . '</li>';

} elseif ( isset( $working_lifts ) && $working_lifts == 'Not available' ) {

	echo '<li class="open-lifts"><strong>Open Lifts: </strong>' . 'Not available' . ' / ' . $total_lifts . '</li>';

}