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

$rows_pricing = get_post_meta( get_the_ID(), 'pricing', true );

foreach ( ( array ) $rows_pricing as $count_pricing => $row_pricing ) {

	switch ( $row_pricing ) {

		case 'overview_prices_layout':

			$local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
			$adult          = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
			$junior         = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );

			if ( $adult || $junior ) {
				echo '<p class="archive-pricing-day"><strong>1-Day Pass Adult/Junior: </strong>' . $local_currency, $adult . ' / ' . $local_currency, $junior . '</p>';
			}

			break;

		case 'season_pass_layout':

			$adult          = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
			$junior         = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );

			if ( $adult || $junior ) {
				echo '<p class="archive-pricing-season"><strong>Season Pass Adult/Junior: </strong>' . $local_currency, $adult . ' / ' . $local_currency, $junior . '</p>';
			}

			break;

	}

}