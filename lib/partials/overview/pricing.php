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

<ul class="overview-pricing">

	<li class="overview-pricing-title"><strong>PRICES </strong><span class="see-all-prices"><strong> SEE ALL PRICES</strong></span></li>

	<?php
	// FLEXIBLE CONTENT - PRICING
	$rows_pricing = get_post_meta( get_the_ID(), 'pricing', true );

	foreach ( ( array ) $rows_pricing as $count_pricing => $row_pricing ) {

		switch ( $row_pricing ) {

			//case 'currency':
			//$local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
			//break;

			case 'overview_prices_layout':

				$local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
				$adult			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
				$junior			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );

				if ( $adult || $junior ) {
					echo '<li><strong>1-Day Pass Adult/Junior: </strong> ' . $local_currency, $adult . ' / ' . $local_currency, $junior . '</li>';
				}

				break;

			case 'season_pass_layout':

				$adult			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
				$junior			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );

				if ( $adult || $junior ) {
					echo '<li class="end-of-prices-tab"><strong>Season Pass Adult/Junior: </strong> ' . $local_currency, $adult . ' / ' . $local_currency, $junior . '</li>';
				}

				break;

		}

	}
	?>

</ul>