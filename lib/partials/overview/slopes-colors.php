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

<ul class="overview-slopes-colors">
	<?php

	// REPEATER - NUMBER OF SKI SLOPES
	if ( $green_slopes ) {

		echo '<li class="overview-green"><strong>' . $green_slopes . ' GREEN SLOPE';

		if ( $green_slopes > '1' ) {
			echo 'S';
		}

		if ( $length_of_green_ski_slopes ) {

			echo ' || ' . $length_of_green_ski_slopes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_green_ski_slopes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_green_ski_slopes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $blue_slopes ) {

		echo '<li class="overview-blue"><strong>' . $blue_slopes . ' BLUE SLOPE';

		if ( $blue_slopes > '1' ) {
			echo 'S';
		}

		if ( $length_of_blue_ski_slopes ) {

			echo ' || ' . $length_of_blue_ski_slopes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_blue_ski_slopes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_blue_ski_slopes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $red_slopes ) {

		echo '<li class="overview-red"><strong>' . $red_slopes . ' RED SLOPE';

		if ( $red_slopes > '1' ) {
			echo 'S';
		}

		if ( $length_of_red_ski_slopes ) {

			echo ' || ' . $length_of_red_ski_slopes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_red_ski_slopes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_red_ski_slopes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $black_slopes ) {

		echo '<li class="overview-black"><strong>' . $black_slopes . ' BLACK SLOPE';

		if ( $black_slopes > '1' ) {
			echo 'S';
		}

		if ( $length_of_black_ski_slopes ) {

			echo ' || ' . $length_of_black_ski_slopes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_black_ski_slopes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_black_ski_slopes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $double_black_slopes ) {

		echo '<li class="overview-black"><strong>' . $double_black_slopes . ' <span class="double-diamond">&#9830;&#9830;</span> BLACK SLOPE';

		if ( $double_black_slopes > '1' ) {
			echo 'S';
		}

		if ( $length_of_double_black_ski_slopes ) {

			echo ' || ' . $length_of_double_black_ski_slopes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_double_black_ski_slopes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_double_black_ski_slopes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $extreme_black_slopes ) {

		echo '<li class="overview-black"><strong>' . $extreme_black_slopes . ' <span class="double-diamond">&#9830;&#9830;</span> EXTREME SLOPE';

		if ( $extreme_black_slopes > '1' ) {
			echo 'S';
		}

		if ( $length_of_extreme_black_ski_slopes ) {

			echo ' || ' . $length_of_extreme_black_ski_slopes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_extreme_black_ski_slopes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_extreme_black_ski_slopes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $length_of_ski_tracks && $manual_total_length_of_ski_slopes ) {

		echo '<li class="overview-total-slopes" style="margin-bottom: 5px;"><strong> Slopes length: ' . $manual_total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' || ';

		if ( $length_slopes_unity == 'km' ) {
			echo round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi</strong></li>';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km</strong></li>';
		}

	}

	if ( $ski_routes ) {

		echo '<li class="overview-ski-routes"><strong>' . $ski_routes . ' SKI ROUTE';

		if ( $ski_routes > '1' ) {
			echo 'S';
		}

		if ( $length_of_ski_routes ) {

			echo ' || ' . $length_of_ski_routes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_ski_routes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_ski_routes / 0.62137, 1 ) . ' km';
			}
		}

		echo '</strong></li>';

	}

	if ( $nordic_tracks ) {

		echo '<li class="overview-nordic-tracks"><strong>' . $nordic_tracks . ' NORDIC TRACK';

		if ( $nordic_tracks > '1' ) {
			echo 'S';
		}

		if ( $length_of_nordic_tracks ) {

			echo ' || ' . $length_of_nordic_tracks . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_nordic_tracks * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_nordic_tracks / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $off_piste_runs ) {

		echo '<li class="overview-ski-routes"><strong>' . $off_piste_runs . ' OFF-PISTE RUN';

		if ( $off_piste_runs > '1' ) {
			echo 'S';
		}

		if ( $length_of_off_piste ) {

			echo ' || ' . $length_of_off_piste . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_off_piste * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_off_piste / 0.62137, 1 ) . ' km';
			}
		}

		echo '</strong></li>';

	}

	if ( $length_of_ski_tracks && $manual_total_length_of_ski_slopes ) {

		if ( $total_slopes ) {

			echo '<li class="overview-total-slopes" itemprop="additionalType" href="http://www.productontology.org/id/Piste" /><strong>Total: <span itemprop="numberOfItems">' . $total_slopes . '</span> trail';

			if ( $total_slopes > '1' ) {
				echo 's';
			}

			echo ' || ' . $total_length_with_routes_nordic . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $total_length_with_routes_nordic * 0.62137, 1 ) . ' mi</strong></li>';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $total_length_with_routes_nordic / 0.62137, 1 ) . ' km</strong></li>';
			}

		}

	}

	if ( $manual_total_length_of_ski_slopes && !$total_length_of_ski_slopes ) {

		if ( $total_slopes ) {

			echo '<li class="overview-total-slopes" itemprop="additionalType" href="http://www.productontology.org/id/Piste" /><strong> Total: <span itemprop="numberOfItems">' . $total_slopes . '</span> trail';

			if ( $total_slopes > '1' ) {
				echo 's';
			}

			if ( $manual_total_length_of_ski_slopes ) {

				echo ' || ' . $manual_total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' || ';

				if ( $length_slopes_unity == 'km' ) {
					echo round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi';
				} elseif ( $length_slopes_unity == 'mi' ) {
					echo round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km';
				}

			}

			echo '</strong></li>';

		}

	}

	if ( $total_length_of_ski_slopes && !$manual_total_length_of_ski_slopes ) {

		if ( $total_slopes ) {

			echo '<li class="overview-total-slopes" itemprop="additionalType" href="http://www.productontology.org/id/Piste" /><strong> Total: <span itemprop="numberOfItems">' . $total_slopes . '</span> trail';

			if ( $total_slopes > '1' ) {
				echo 's';
			}

			if ( $total_length_of_ski_slopes ) {

				echo ' || ' . $total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' || ';

				if ( $length_slopes_unity == 'km' ) {
					echo round( ( float ) $total_length_of_ski_slopes * 0.62137, 1 ) . ' mi';
				} elseif ( $length_slopes_unity == 'mi' ) {
					echo round( ( float ) $total_length_of_ski_slopes / 0.62137, 1 ) . ' km';
				}

			}

			echo '</strong></li>';

		}

	}

	if ( !$total_length_of_ski_slopes && !$manual_total_length_of_ski_slopes ) {

		if ( $total_slopes ) {

			echo '<li class="overview-total-slopes" itemprop="additionalType" href="http://www.productontology.org/id/Piste" /><strong> Total: <span itemprop="numberOfItems">' . $total_slopes . '</span> trail';

			if ( $total_slopes > '1' ) {
				echo 's';
			}

			echo '</strong></li>';

		}

	}
	?>

</ul>