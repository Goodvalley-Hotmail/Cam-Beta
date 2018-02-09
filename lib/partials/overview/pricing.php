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

    <?php

	// FLEXIBLE CONTENT - PRICING
	$rows_pricing = get_post_meta( get_the_ID(), 'pricing', true );

	foreach ( ( array ) $rows_pricing as $count_pricing => $row_pricing ) {

		switch ( $row_pricing ) {

            case 'pricing_web_page_layout':

	            $pricing_page_link = esc_url( get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_pricing_web_page', true ) );

	            if ( $pricing_page_link ) {
		            ?>
                    <li class="overview-pricing-title"><strong>PRICES </strong><span class="see-all-prices"><strong><a href="<?php echo $pricing_page_link; ?>" target="_blank"> SEE ALL PRICES</a></strong></span></li>
		            <?php
	            }

	            break;

			//case 'currency':
			//$local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
			//break;

			case 'overview_prices_layout':

				$local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
				$adult			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
				$junior			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );

				if ( $adult || $junior ) {
					echo '<li><strong>1-Day Pass Adult/Junior: </strong><span><meta itemprop="currenciesAccepted" content="EUR" /> ' . $local_currency . '</span>' . $adult . ' / <span><meta itemprop="currenciesAccepted" content="EUR" />' . $local_currency . '</span>' .  $junior . '</li>';
				}

				break;

			case 'season_pass_layout':

				$adult			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
				$junior			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );

				if ( $adult || $junior ) {
					echo '<li class="end-of-prices-tab"><strong>Season Pass Adult/Junior: </strong><span><meta itemprop="currenciesAccepted" content="EUR" /> ' . $local_currency . '</span>' .  $adult . ' / <span><meta itemprop="currenciesAccepted" content="EUR" />' . $local_currency . '</span>' .  $junior . '</li>';
				}

				break;

		}

	}
	?>

</ul>