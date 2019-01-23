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

$count_number_of_ski_slopes = get_post_meta( get_the_ID(), 'number_of_ski_slopes', true );
$count_length_slopes        = get_post_meta( get_the_ID(), 'length_of_ski_slopes', true );

if ( $count_number_of_ski_slopes || $count_length_slopes ) {

	for ( $i = 0; $i < $count_number_of_ski_slopes; $i ++ ) {

		$green_slopes         = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_green_slopes', true );
		$blue_slopes          = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_blue_slopes', true );
		$red_slopes           = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_red_slopes', true );
		$black_slopes         = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_black_slopes', true );
		$double_black_slopes  = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_double_black_slopes', true );
		$extreme_black_slopes = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_extreme_black_slopes', true );
		$ski_routes           = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_ski_routes', true );
		$nordic_tracks        = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_nordic_tracks', true );
		$off_piste_runs       = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_off_piste_runs', true );
		$manual_runs          = get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_number_of_manual_runs', true );

		$total_slopes = ( $green_slopes + $blue_slopes + $red_slopes + $black_slopes + $double_black_slopes + $extreme_black_slopes + $ski_routes + $nordic_tracks + $off_piste_runs );

	}

	for ( $i = 0; $i < $count_length_slopes; $i++ ) {

		$length_of_green_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_green_slopes', true );
		$length_of_blue_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_blue_slopes', true );
		$length_of_red_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_red_slopes', true );
		$length_of_black_ski_slopes	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_black_slopes', true );
		$length_of_double_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_double_black_slopes', true );
		$length_of_extreme_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_extreme_black_slopes', true );
		$length_of_ski_routes		        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_ski_routes', true );
		$length_of_nordic_tracks	        = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_nordic_tracks', true );
		$length_of_off_piste	            = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_off_piste_runs', true );
		$length_only_ski_slopes	            = ( $length_of_green_ski_slopes + $length_of_blue_ski_slopes + $length_of_red_ski_slopes + $length_of_black_ski_slopes + $length_of_double_black_ski_slopes + $length_of_extreme_black_ski_slopes );
		$length_of_ski_tracks 	            = ( $length_of_ski_routes + $length_of_nordic_tracks + $length_of_off_piste );
		$total_length_of_ski_slopes			= ( $length_only_ski_slopes + $length_of_ski_tracks );
		$manual_total_length_of_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_manual_total_length_of_ski_slopes', true );
		$total_length_with_routes_nordic 	= $manual_total_length_of_ski_slopes + $length_of_ski_tracks;
		$length_slopes_unity	            = get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_slopes_unity', true );

	}

	echo '<ul class="archive-slopes-colors">';

	if ( $green_slopes ) {

		echo '<li class="archive-green"><strong>' . $green_slopes . ' GREEN SLOPE';

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

		echo '<li class="archive-blue"><strong>' . $blue_slopes . ' BLUE SLOPE';

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

		echo '<li class="archive-red"><strong>' . $red_slopes . ' RED SLOPE';

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

		echo '<li class="archive-black"><strong>' . $black_slopes . ' BLACK SLOPE';

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

		echo '<li class="archive-black"><strong>' . $double_black_slopes . ' <span class="double-diamond">&#9830;&#9830;</span> BLACK SLOPE';

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

		echo '<li class="archive-black"><strong>' . $extreme_black_slopes . ' <span class="double-diamond">&#9830;&#9830;</span> EXTREME SLOPE';

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

		echo '<li class="archive-total-slopes" style="margin-bottom: 5px;"><strong> Slopes length: ' . $manual_total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' || ';

		if ( $length_slopes_unity == 'km' ) {
			echo round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi</strong></li>';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km</strong></li>';
		}

	}

	if ( $ski_routes ) {

		echo '<li class="archive-ski-routes"><strong>' . $ski_routes . ' SKI ROUTE';

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

		echo '<li class="archive-nordic-tracks"><strong>' . $nordic_tracks . ' NORDIC TRACK';

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

		echo '<li class="archive-ski-routes"><strong>' . $off_piste_runs . ' OFF-PISTE RUN';

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

			echo '<li class="archive-total-slopes"><strong>Total: ' . $total_slopes . ' trail';

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

			echo '<li class="archive-total-slopes"><strong> Total: ' . $total_slopes . ' trail';

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

			echo '<li class="archive-total-slopes"><strong> Total: ' . $total_slopes . ' trail';

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

			echo '<li class="archive-total-slopes"><strong> Total: ' . $total_slopes . ' trail';

			if ( $total_slopes > '1' ) {
				echo 's';
			}

			echo '</strong></li>';

		}

	}

	echo '</ul>';

}

$count_number_of_additional_ski_slopes = get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes', true );
$count_length_of_additional_ski_slopes = get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes', true );

if ( $count_number_of_additional_ski_slopes || $count_length_of_additional_ski_slopes ) {

	for ( $i = 0; $i < $count_number_of_additional_ski_slopes; $i++ ) {

		$additional_ski_routes		= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_number_of_additional_ski_routes', true );
		$additional_nordic_tracks	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_number_of_additional_nordic_tracks', true );
		$additional_off_piste_runs	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_number_of_additional_off_piste_runs', true );

	}

	for ( $i = 0; $i < $count_length_of_additional_ski_slopes; $i++ ) {

		$length_of_additional_ski_routes			= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_ski_routes', true );
		$length_of_additional_nordic_tracks			= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_nordic_tracks', true );
		$length_of_additional_off_piste				= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_off_piste_runs', true );
		$manual_length_of_additional_ski_routes		= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_ski_routes', true );
		$manual_length_of_additional_nordic_tracks	= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_nordic_tracks', true );
		$manual_length_of_additional_off_piste_runs	= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_off_piste_runs', true );

	}

	echo '<ul class="ul-archive-other-slopes">';

	if ( $manual_length_of_additional_ski_routes ) {

		echo '<li class="archive-ski-routes"><strong>SKI ROUTES: ' . $manual_length_of_additional_ski_routes . ' ' . $length_slopes_unity;

		if ( $length_slopes_unity == 'km' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_ski_routes * 0.62137, 1 ) . ' mi';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_ski_routes / 0.62137, 1 ) . ' km';
		}

		echo ')</strong></li>';

	}

	if ( $additional_ski_routes ) {

		echo '<li class="archive-ski-routes"><strong>' . $additional_ski_routes . ' SKI ROUTE';

		if ( $additional_ski_routes > '1' ) {
			echo 'S';
		}

		if ( $length_of_additional_ski_routes ) {

			echo ' || ' . $length_of_additional_ski_routes . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_additional_ski_routes * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_additional_ski_routes / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	if ( $manual_length_of_additional_nordic_tracks ) {

		echo '<li class="archive-nordic-tracks"><strong>CROSS COUNTRY / NORDIC TRACKS: ' . $manual_length_of_additional_nordic_tracks . ' ' . $length_slopes_unity;

		if ( $length_slopes_unity == 'km' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_nordic_tracks * 0.62137, 1 ) . ' mi';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_nordic_tracks / 0.62137, 1 ) . ' km';
		}

		echo ')</strong></li>';

	}

	if ( $additional_nordic_tracks ) {

		echo '<li class="archive-nordic-tracks"><strong>' . $additional_nordic_tracks . ' CROSS COUNTRY / NORDIC TRACK';

		if ( $additional_nordic_tracks > '1' ) {
			echo 'S';
		}

		if ( $length_of_additional_nordic_tracks ) {

			echo ' || ' . $length_of_additional_nordic_tracks . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_additional_nordic_tracks * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_additional_nordic_tracks / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';
	}

	if ( $manual_length_of_additional_off_piste_runs ) {

		echo '<li class="archive-ski-routes"><strong>OFF-PISTE RUNS: ' . $manual_length_of_additional_off_piste_runs . ' ' . $length_slopes_unity;

		if ( $length_slopes_unity == 'km' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_off_piste_runs * 0.62137, 1 ) . ' mi';
		} elseif ( $length_slopes_unity == 'mi' ) {
			echo ' (' . round( ( float ) $manual_length_of_additional_off_piste_runs / 0.62137, 1 ) . ' km';
		}

		echo ')</strong></li>';

	}

	if ( $additional_off_piste_runs ) {

		echo '<li class="archive-ski-routes"><strong>' . $additional_off_piste_runs . ' OFF-PISTE RUN';

		if ( $additional_off_piste_runs > '1' ) {
			echo 'S';
		}

		if ( $length_of_additional_off_piste ) {

			echo ' || ' . $length_of_additional_off_piste . ' ' . $length_slopes_unity . ' || ';

			if ( $length_slopes_unity == 'km' ) {
				echo round( ( float ) $length_of_additional_off_piste * 0.62137, 1 ) . ' mi';
			} elseif ( $length_slopes_unity == 'mi' ) {
				echo round( ( float ) $length_of_additional_off_piste / 0.62137, 1 ) . ' km';
			}

		}

		echo '</strong></li>';

	}

	echo '</ul>';

}