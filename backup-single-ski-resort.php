<?php

// 25/04/2016 - Add the attributes from 'entry', since this replaces the main entry
function camski_attributes_site_inner( $attributes ) {
	$attributes[ 'role' ]		= 'main';
	$attributes[ 'itemprop' ]	= 'mainContentOfPage';
	
	return $attributes;
}

add_filter( 'genesis_attr_site-inner', 'camski_attributes_site_inner' ); // Aix� ho hav�em comentat el 25/04/2016, no ho tinc clar per� en principi �s correcte tal com est�.

// 25/04/2016 - Remove div.site-inner's div.wrap - NO-> Ho hem comentat. No caldria perqu� el Sample Theme no inclou el site-inner's wrap.
//add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Reposition Breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove the Entry meta (Post Info) in the Entry Header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove Post Meta - To remove empty markup, '<p class="entry-meta"></p>' for Entries that have not been assigned to any Location
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_footer', 'skirev_custom_post_meta' );

get_header();

// 25/04/2016 - Treiem el div content-sidebar-wrap - NO-> Ho hem descomentat - DONCS S�, HO HEM TORNAT A COMENTAR (21/07/2016)
/*do_action( 'genesis_before_content_sidebar_wrap' );
genesis_markup( array(
	'html5'   => '<div %s>',
	'xhtml'   => '<div id="content-sidebar-wrap">',
	'context' => 'content-sidebar-wrap',
) );*/

// 25/04/2016 - Treiem el <main class="content"> - NO-> Ho hem descomentat
do_action( 'genesis_before_content' );
genesis_markup( array(
	'html5'   => '<main %s>',
	'xhtml'   => '<div id="content" class="hfeed">',
	'context' => 'content',
) );

do_action( 'genesis_before_loop' );
//do_action( 'genesis_loop' );

if ( have_posts() ) :

	do_action( 'genesis_before_while' );
	while ( have_posts() ) : the_post();

		do_action( 'genesis_before_entry' );
		
		// 25/04/2016 - Etiqueta HTML <article>	
		printf( '<article %s>', genesis_attr( 'entry' ) );

			do_action( 'genesis_entry_header' );

			do_action( 'genesis_before_entry_content' );

			printf( '<div %s>', genesis_attr( 'entry-content' ) );
			do_action( 'genesis_entry_content' );
			
			echo '<div class="flexbox-top">';
			
				// TWO-FIFTHS FIRST
				echo '<div id="overview-top-left" class="two-fifths first">';
				
					//WEBCAM		
					$main_webcam_name		= get_post_meta( get_the_ID(), 'main_webcam_name', true );
					$main_webcam_url_16_9	= get_post_meta( get_the_ID(), 'main_webcam_url_16_9', true );
					$main_webcam_url_4_3	= get_post_meta( get_the_ID(), 'main_webcam_url_4_3', true );
					$main_webcam_url_1_1	= get_post_meta( get_the_ID(), 'main_webcam_url_1_1', true );
					$main_webcam_file		= get_post_meta( get_the_ID(), 'main_webcam_file', true );
					$webcam					= get_post_meta( get_the_ID(), 'webcam', true );
					
					// Field
					echo '<p class="main-webcam-title"><strong>ALL  WEBCAMS</strong></p>';
					
					// Field
					if ( $main_webcam_url_16_9 ) {
						
                        echo '<p class="main-webcam-image"><img src="' . $DOCUMENT_ROOT . $main_webcam_url_16_9 . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p>';
					
                    }/* elseif ( $main_webcam_url_4_3 ) {
                        
                        echo '<p class="main-webcam-image"><img src="' $main_webcam_url_4_3 . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p>';
                        
                    } elseif ( $main_webcam_url_1_1 ) {
                        
                        echo '<p class="main-webcam-image"><img src="' $main_webcam_url_1_1 . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p>';
                        
                    }*/
					
				echo '</div>';
				
				// ONE-FIFTH
				
				echo '<div id="overview-top-center" class="one-fifth">';
				
					$included_options = get_post_meta( get_the_ID(), 'included_options', true );
					
					include_once ( $_SERVER['DOCUMENT_ROOT'] . $included_options );
					
					// TODAY
					$skiresort_data			= get_post_meta( get_the_ID(), 'skiresort_data', true );
					$ski_slopes				= get_post_meta( get_the_ID(), 'ski_slopes', true );
					$timezone				= get_post_meta( get_the_ID(), 'timezone', true );
					$operating_schedule 	= get_post_meta( get_the_ID(), 'operating_schedule', true );
					$season					= get_post_meta( get_the_ID(), 'season', true );
					$snow					= get_post_meta( get_the_ID(), 'snow', true );
					$snow_depth				= get_post_meta( get_the_ID(), 'snow_depth', true );
					$name_depth				= get_post_meta( get_the_ID(), 'name_depth', true );
					$location_depth_1		= get_post_meta( get_the_ID(), 'location_depth_1', true );
					$location_depth_2		= get_post_meta( get_the_ID(), 'location_depth_2', true );
					$location_depth_3		= get_post_meta( get_the_ID(), 'location_depth_3', true );
					$location_depth_4		= get_post_meta( get_the_ID(), 'location_depth_4', true );
					$location_depth_5		= get_post_meta( get_the_ID(), 'location_depth_5', true );
					$official_snow_report	= get_post_meta( get_the_ID(), 'official_snow_report', true );
					$elevation_info			= get_post_meta( get_the_ID(), 'elevation_info', true );
					$number_of_ski_slopes	= get_post_meta( get_the_ID(), 'number_of_ski_slopes', true );
					$length_of_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes', true );
					$remuntadors			= get_post_meta( get_the_ID(), 'remuntadors', true );
					$lifts					= get_post_meta( get_the_ID(), 'lifts', true );
					$pricing				= get_post_meta( get_the_ID(), 'pricing', true );
					$mapsmarker_shortcode	= get_post_meta( get_the_ID(), 'mapsmarker_shortcode', true );
					
					echo '<div id="overview-central-tabs">';
					
						echo '<ul id="ul-status" class="background-boxes">';
							
							// Field
							$defaultTimeZone = $timezone;
							
							echo '<li class="datetime"><strong><time datetime="'.date( 'c' ).'">'.date( 'F j, Y ' ).'</time></strong> ';
							
							if ( $operating_status == 'OPEN' ) {
								echo '<span class="operating-status-open"><strong> ' . $operating_status_english . '</strong></span></li>';
							} elseif ( $operating_status == 'CLOSED' ) {
								echo '<span class="operating-status-closed"><strong> ' . $operating_status_english . '</strong></span></li>';
							}
							
						echo '</ul>';
						
						echo '<ul id="ul-season" class="background-boxes">';
							
							// REPEATER - SEASON
							$count_season = get_post_meta( get_the_ID(), 'season', true );
							
							if ( $count_season ) {
								
								for ( $i= 0; $i < $count_season; $i++ ) {
									
									$opening_date		= get_post_meta( get_the_ID(), 'season_' . $i . '_opening_date', true );
									if ( $opening_date ) {
										$opening_date		= date( 'F d', strtotime( $opening_date ) );
									}
									
									$closing_date		= get_post_meta( get_the_ID(), 'season_' . $i . '_closing_date', true );
									if ( $closing_date ) {
										$closing_date		= date( 'F d', strtotime( $closing_date ) );
									}
									
									$full_year_round	= get_post_meta( get_the_ID(), 'season_' . $i . '_full_year_round', true );
									
									// Sub-Field
									if ( $opening_date || $closing_date ) {
										echo '<li class="season"><strong>SEASON: </strong><br /> ' .  $opening_date . ' - ' . $closing_date . '<strong> | </strong>' . $operating_schedule . '</li>';
									}
									elseif ( $full_year_round ) {
										echo '<li class="season"><strong>SEASON: </strong><br /> ' .  $full_year_round . '<strong> | </strong>' . $operating_schedule . '</li>';
									}
									
								}
								
							}
							
						echo '</ul>';
						
						echo '<ul id="ul-today" class="background-boxes">';
							
							echo '<p class="today"><strong>TODAY</strong></p>';
							
							// REPEATER - LIFTS
							$count_lifts = get_post_meta( get_the_ID(), 'lifts', true );
							
							if ( $count_lifts ) {
								
								for ( $i = 0; $i < $count_lifts; $i++ ) {
									
									$cog_railways							= get_post_meta( get_the_ID(), 'lifts_' . $i . '_cog_railways', true );
									$funiculars								= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_funiculars', true );
									$aerial_tramways_reversible_ropeways	= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_aerial_tramways_reversible_ropeways', true );
									$cage_lifts								= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_cage_lifts', true );
									$circulating_ropeway_gondola_lift		= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_circulating_ropeway_gondola_lift', true );
									$combined_installations_gondola_and_chair	= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_combined_installations_gondola_and_chair', true );
									$detachable_chairlifts					= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_detachable_chairlifts', true );
									$fixed_grip_chairlifts					= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_fixed_grip_chairlifts', true );
									$chairlifts								= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_chairlifts', true );
									$t_bar_lifts_platters_button_lifts		= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_t_bar_lifts_platters_button_lifts', true );
									$rope_tow_beginner_lift					= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_rope_tow_beginner_lift', true );
									$magic_carpet_people_mover				= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_magic_carpet_people_mover', true );
									$surface_lifts							= get_post_meta ( get_the_ID(), 'lifts_' . $i . '_surface_lifts', true );
									$total_lifts = ( $cog_railways + $funiculars + $aerial_tramways_reversible_ropeways + $cage_lifts + $circulating_ropeway_gondola_lift + $combined_installations_gondola_and_chair + $detachable_chairlifts + $fixed_grip_chairlifts + $chairlifts + $t_bar_lifts_platters_button_lifts + $rope_tow_beginner_lift + $magic_carpet_people_mover + $surface_lifts );
									
								}
								
							}
							if ( isset( $working_lifts ) && $working_lifts >= 0 ) {
								
								echo '<li class="open-lifts"><strong>Open Lifts: </strong>' . $working_lifts . ' / ' . $total_lifts . '</li>';
								
							} elseif ( isset( $working_lifts ) && $working_lifts == 'Not available' ) {
								
								echo '<li class="open-lifts"><strong>Open Lifts: </strong>' . 'Not available' . ' / ' . $total_lifts . '</li>';
								
							}
							
							// REPEATER - NUMBER OF SKI SLOPES
							$count_number_of_ski_slopes = get_post_meta( get_the_ID(), 'number_of_ski_slopes', true );
							
							if ( $count_number_of_ski_slopes ) {
								
								for ( $i = 0; $i < $count_number_of_ski_slopes; $i++ ) {
									
									$green_slopes			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_green_slopes', true );
									$blue_slopes			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_blue_slopes', true );
									$red_slopes				= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_red_slopes', true );
									$black_slopes			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_black_slopes', true );
									$double_black_slopes	= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_double_black_slopes', true );
									$extreme_black_slopes	= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_extreme_black_slopes', true );
									$ski_routes				= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_ski_routes', true );
									$nordic_tracks			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_nordic_tracks', true );
									$off_piste_runs			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_off-piste_runs', true );
									$manual_runs			= get_post_meta( get_the_ID(), 'number_of_ski_slopes_' . $i . '_manual_runs', true );
									$total_slopes			= ( $green_slopes + $blue_slopes + $red_slopes + $black_slopes + $ski_routes + $nordic_tracks + $off_piste_runs );
									
								}
								
							}
							if ( $manual_runs ) {
								
								echo '<li class="open-slopes"><strong>Open Runs: </strong>' . $working_slopes . ' /  ' . $manual_runs . '</li>';
								
							} elseif ( isset ( $working_slopes ) && $working_slopes >= 0 ) {
								
								echo '<li class="open-slopes"><strong>Open Slopes: </strong>' . $working_slopes . ' /  ' . $total_slopes;
								
								if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 || isset( $working_ski_routes ) && $working_ski_routes >= 0 || isset( $working_nordic_tracks ) && $working_nordic_tracks >= 0 || isset( $working_off_piste_runs ) && $working_off_piste_runs >= 0 ) {
									echo ' <strong>&#10142; </strong>';
									
									if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 ) {
										echo ' <strong><span class="working-green">' . $working_slopes_green . '</span></strong>';
									}
									if ( isset( $working_slopes_blue ) && $working_slopes_blue >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 ) {
											
											echo ' + ';
										}
										
										echo ' <strong><span class="working-blue">' . $working_slopes_blue . '</span></strong>';
									}
									if ( isset( $working_slopes_red ) && $working_slopes_red >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-red">' . $working_slopes_red . '</span></strong>';
									}
									if ( isset( $working_slopes_black ) && $working_slopes_black >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-black">' . $working_slopes_black . '</span></strong>';
									}
									if ( isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-black">' . $working_slopes_double_black . '</span></strong>&#9830;&#9830;';
									}
									if ( isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-black">' . $working_slopes_extreme_black . '&#9830;&#9830;</span></strong>';
									}
									if ( isset( $working_ski_routes ) && $working_ski_routes >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-ski-routes">' . $working_ski_routes . '</span></strong>';
									}
									
									if ( isset( $working_nordic_tracks ) && $working_nordic_tracks >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 || isset( $working_ski_routes ) && $working_ski_routes >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-nordic-tracks">' . $working_nordic_tracks . '</span></strong>';
										
									}
									if ( isset( $working_off_piste_runs ) && $working_off_piste_runs >= 0 ) {
										
										if ( isset( $working_slopes_green ) && $working_slopes_green >= 0 || isset( $working_slopes_blue ) && $working_slopes_blue >= 0 || isset( $working_slopes_red ) && $working_slopes_red >= 0 || isset( $working_slopes_black ) && $working_slopes_black >= 0 || isset( $working_slopes_double_black ) && $working_slopes_double_black >= 0 || isset( $working_slopes_extreme_black ) && $working_slopes_extreme_black >= 0 || isset( $working_ski_routes ) && $working_ski_routes >= 0 || isset( $working_nordic_tracks ) && $working_nordic_tracks >= 0 ) {
											echo ' + ';
										}
										
										echo ' <strong><span class="working-ski-routes">' . $working_off_piste_runs . '</span></strong>';
										
									}
									
								}
								
								echo '</li>';
								
							// Si no hi ha distribuci� de pistes per colors
							} elseif ( isset( $working_slopes ) && $working_slopes = 'Not available' ) {
								
								echo '<li class="open-slopes"><strong>Open Slopes: </strong>' . 'Not available' . ' / ' . $total_slopes . '</li>';
								
							} else {
								
								echo '<li class="open-slopes"><strong>Open Slopes: </strong>' . $working_slopes . ' /  ' . $total_slopes . '</li>';
									
							}
							
							// REPEATER - LENGTH OF SKI SLOPES
							$count_length_slopes = get_post_meta( get_the_ID(), 'length_of_ski_slopes', true );
							
							if ( $count_length_slopes ) {
								
								for ( $i = 0; $i < $count_length_slopes; $i++ ) {
									
									$length_of_green_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_green_ski_slopes', true );
									$length_of_blue_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_blue_ski_slopes', true );
									$length_of_red_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_red_ski_slopes', true );
									$length_of_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_black_ski_slopes', true );
									$length_of_double_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_double_black_ski_slopes', true );
									$length_of_extreme_black_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_extreme_black_ski_slopes', true );
									$length_of_ski_routes		= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_ski_routes', true );
									$length_of_nordic_tracks	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_nordic_tracks', true );
									$length_of_off_piste	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_of_off_piste', true );
									$length_only_ski_slopes	= ( $length_of_green_ski_slopes + $length_of_blue_ski_slopes + $length_of_red_ski_slopes + $length_of_black_ski_slopes + $length_of_double_black_ski_slopes + $length_of_extreme_black_ski_slopes );
									$length_of_ski_tracks 	= ( $length_of_ski_routes + $length_of_nordic_tracks + $length_of_off_piste );
									$total_length_of_ski_slopes			= ( $length_only_ski_slopes + $length_of_ski_tracks );
									$manual_total_length_of_ski_slopes	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_manual_total_length_of_ski_slopes', true );
									$total_length_with_routes_nordic 	= $manual_total_length_of_ski_slopes + $length_of_ski_tracks;
									$length_slopes_unity	= get_post_meta( get_the_ID(), 'length_of_ski_slopes_' . $i . '_length_slopes_unity', true );
									
								}
								
							}
							
							if ( $manual_total_length_of_ski_slopes && $total_length_of_ski_slopes ) {
								
								if ( $working_slopes_length ) {
								
									echo '<li class="open-length"><strong>Open Length: </strong>' . $working_slopes_length . ' /  ' . $total_length_with_routes_nordic . ' ' . $length_slopes_unity . ' (';
									if ( $length_slopes_unity == 'km' ) {
										echo round( ( float ) $working_slopes_length * 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi)';
									} elseif ( $length_slopes_unity == 'mi' ) {
										echo round( ( float ) $working_slopes_length / 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km)';
									}
									echo '</li>';
									
								}
								
							} elseif ( $manual_total_length_of_ski_slopes && !$total_length_of_ski_slopes ) {
								
								if ( $working_slopes_length ) {
									
									if ( $working_slopes_length == 'Not available' ) {
										
										echo '<li class="open-length"><strong>Open Length: </strong>Not available</li>';
										
									} elseif ( $working_slopes_length == 'Undisclosed data' ) {
										
										echo '<li class="open-length"><strong>Open Length: </strong>Undisclosed data</li>';
										
									} elseif ( $working_slopes_length == 'Not provided' ) {
										
										echo '<li class="open-length"><strong>Open Length: </strong>Not provided</li>';
										
									} else {
										
										echo '<li class="open-length"><strong>Open Length: </strong>' . $working_slopes_length . ' /  ' . $manual_total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' (';
										if ( $length_slopes_unity == 'km' ) {
											echo round( ( float ) $working_slopes_length * 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes * 0.62137, 1 ) . ' mi)';
										} elseif ( $length_slopes_unity == 'mi' ) {
											echo round( ( float ) $working_slopes_length / 0.62137, 1 ) . ' / ' . round( ( float ) $manual_total_length_of_ski_slopes / 0.62137, 1 ) . ' km)';
										}
										echo '</li>';
										
									}
									
								}
								
							} elseif ( $total_length_of_ski_slopes && !$manual_total_length_of_ski_slopes ) {
								
								if ( $working_slopes_length ) {
									
									echo '<li class="open-length"><strong>Open Length: </strong>' . $working_slopes_length . ' /  ' . $total_length_of_ski_slopes . ' ' . $length_slopes_unity . ' (';
									if ( $length_slopes_unity == 'km' ) {
										echo round( ( float ) $working_slopes_length * 0.62137, 1 ) . ' / ' . round( ( float ) $total_length_of_ski_slopes * 0.62137, 1 ) . ' mi)';
									} elseif ( $length_slopes_unity == 'mi' ) {
										echo round( ( float ) $working_slopes_length / 0.62137, 1 ) . ' / ' . number_format( ( float ) $total_length_of_ski_slopes / 0.62137, 1 ) . ' km)';
									}
									echo '</li>';
									
								}
								
							}
							
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
									
									$elevation_snow_unique		= get_post_meta( get_the_ID(), 'snow_depth_' . $i . '_elevation_snow_unique', true );
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
							if ( isset( $snow_depth_max ) && $snow_depth_max >= 0 ) {
								echo '<li class="snow-depth"><strong>';
								if ( $name_depth_max ) {
									if ( $elevation_snow_depth_max ) {
										echo $name_depth_max . ' (' . number_format( $elevation_snow_depth_max ) . ' ' . $elevation_depth_measure . '): ';
									} else {
										echo $name_depth_max . ': ';
									}
								} elseif ( $elevation_snow_depth_max ) {
									echo 'Snow Depth (' . number_format( $elevation_snow_depth_max ) . ' ' . $elevation_depth_measure . '): ';
								} elseif ( !$name_depth_max && !$elevation_snow_depth_max ) {
									echo 'Max Snow Depth: ';
								}
								echo '</strong>' . $snow_depth_max . ' ' . $snow_depth_measure;
								if ( $snow_depth_measure == 'cm' ) {
									echo ' (' . round( $snow_depth_max * 0.3937 ) . '")';
								} elseif ( $snow_depth_measure == '"' ) {
									echo ' (' . round( $snow_depth_max / 0.39370 ) . 'cm)';
								}
								if ( $snow_type_max_english ) {
									echo ' ' . $snow_type_max_english . '</li>';
								} else {
									echo '</li>';
								}
							}
							if ( isset( $snow_depth_min ) && $snow_depth_min >= 0 ) {
								echo '<li class="snow-depth"><strong>';
								if ( $name_depth_min ) {
									if ( $elevation_snow_depth_min ) {
										echo $name_depth_min . ' (' . number_format( $elevation_snow_depth_min ) . ' ' . $elevation_depth_measure . '): ';
									} else {
										echo $name_depth_min . ': ';
									}
								} elseif ( $elevation_snow_depth_min ) {
									echo 'Snow Depth (' . number_format( $elevation_snow_depth_min ) . ' ' . $elevation_depth_measure . '): ';
								} elseif ( !$name_depth_1 && !$elevation_snow_depth_min ) {
									echo 'Min Snow Depth: ';
								}
								echo '</strong>' . $snow_depth_min . ' ' . $snow_depth_measure;
								if ( $snow_depth_measure == 'cm' ) {
									echo ' (' . round( $snow_depth_min * 0.3937 ) . '")';
								} elseif ( $snow_depth_measure == '"' ) {
									echo ' (' . round( $snow_depth_min / 0.39370 ) . 'cm)';
								}
								if ( $snow_type_min_english ) {
									echo ' ' . $snow_type_min_english . '</li>';
								} else {
									echo '</li>';
								}
							}
							if ( isset( $snow_depth_1 ) && $snow_depth_1 >= 0 ) {
								echo '<li class="snow-depth"><strong>';
								if ( $name_depth_1 ) {
									if ( $elevation_snow_depth_1 ) {
										echo $name_depth_1 . ' (' . number_format( $elevation_snow_depth_1 ) . ' ' . $elevation_depth_measure . '): ';
									} else {
										echo $name_depth_1 . ': ';
									}
								} elseif ( $elevation_snow_depth_1 ) {
									echo 'Snow Depth (' . number_format( $elevation_snow_depth_1 ) . ' ' . $elevation_depth_measure . '): ';
								} elseif ( !$name_depth_1 && !$elevation_snow_depth_1 ) {
									echo 'Snow Depth: ';
								}
								echo '</strong>' . $snow_depth_1 . ' ' . $snow_depth_measure;
								if ( $snow_depth_measure == 'cm' ) {
									echo ' (' . round( $snow_depth_1 * 0.3937 ) . '")';
								} elseif ( $snow_depth_measure == '"' ) {
									echo ' (' . round( $snow_depth_1 / 0.39370 ) . 'cm)';
								}
								if ( $snow_type_1 ) {
									echo ' ' . $snow_type_1_english . '</li>';
								} else {
									echo '</li>';
								}
								if ( isset( $snow_depth_2 ) && $snow_depth_2 >= 0 ) {
									echo '<li class="snow-depth"><strong>';
									if ( $name_depth_2 ) {
										if ( $elevation_snow_depth_2 ) {
											echo $name_depth_2 . ' (' . number_format( $elevation_snow_depth_2 ) . ' ' . $elevation_depth_measure . '): ';
										} else {
											echo $name_depth_2 . ': ';
										}
									} elseif ( $elevation_snow_depth_2 ) {
										echo 'Snow Depth (' . number_format( $elevation_snow_depth_2 ) . ' ' . $elevation_depth_measure . '): ';
									} elseif ( !$name_depth_2 && !$elevation_snow_depth_2 ) {
										echo 'Snow Depth: ';
									}
									echo '</strong>' . $snow_depth_2 . ' ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_2 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_2 / 0.39370 ) . 'cm)';
									}
									if ( $snow_type_2 ) {
										echo ' ' . $snow_type_2_english . '</li>';
									} else {
										echo '</li>';
									}
									if ( isset( $snow_depth_3 ) && $snow_depth_3 >= 0 ) {
										echo '<li class="snow-depth"><strong>';
										if ( $name_depth_3 ) {
											if ( $elevation_snow_depth_3 ) {
												echo $name_depth_3 . ' (' . number_format( $elevation_snow_depth_3 ) . ' ' . $elevation_depth_measure . '): ';
											} else {
												echo $name_depth_3 . ': ';
											}
										} elseif ( $elevation_snow_depth_3 ) {
											echo 'Snow Depth (' . number_format( $elevation_snow_depth_3 ) . ' ' . $elevation_depth_measure . '): ';
										} elseif ( !$name_depth_3 && !$elevation_snow_depth_3 ) {
											echo 'Snow Depth: ';
										}
										echo '</strong>' . $snow_depth_3 . ' ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_3 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_3 / 0.39370 ) . 'cm)';
										}
										if ( $snow_type_3 ) {
											echo ' ' . $snow_type_3_english . '</li>';
										} else {
											echo '</li>';
										}
										if ( isset( $snow_depth_4 ) && $snow_depth_4 >= 0 ) {
											echo '<li class="snow-depth"><strong>';
											if ( $name_depth_4 ) {
												if ( $elevation_snow_depth_4 ) {
													echo $name_depth_4 . ' (' . number_format( $elevation_snow_depth_4 ) . ' ' . $elevation_depth_measure . '): ';
												} else {
													echo $name_depth_4 . ': ';
												}
											} elseif ( $elevation_snow_depth_4 ) {
												echo 'Snow Depth (' . number_format( $elevation_snow_depth_4 ) . ' ' . $elevation_depth_measure . '): ';
											} elseif ( !$name_depth_4 && !$elevation_snow_depth_4 ) {
												echo 'Snow Depth: ';
											}
											echo '</strong>' . $snow_depth_4 . ' ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_4 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_4 / 0.39370 ) . 'cm)';
											}
											if ( $snow_type_4 ) {
												echo ' ' . $snow_type_4_english . '</li>';
											} else {
												echo '</li>';
											}
											if ( isset( $snow_depth_5 ) && $snow_depth_5 >= 0 ) {
												echo '<li class="snow-depth"><strong>';
												if ( $name_depth_5 ) {
													if ( $elevation_snow_depth_5 ) {
														echo $name_depth_5 . ' (' . number_format( $elevation_snow_depth_5 ) . ' ' . $elevation_depth_measure . '): ';
													} else {
														echo $name_depth_5 . ': ';
													}
												} elseif ( $elevation_snow_depth_5 ) {
													echo 'Snow Depth (' . number_format( $elevation_snow_depth_5 ) . ' ' . $elevation_depth_measure . '): ';
												} elseif ( !$name_depth_5 && !$elevation_snow_depth_5 ) {
													echo 'Snow Depth: ';
												}
												echo '</strong>' . $snow_depth_5 . ' ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_5 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_5 / 0.39370 ) . 'cm)';
												}
												if ( $snow_type_5 ) {
													echo ' ' . $snow_type_5_english . '</li>';
												} else {
													echo '</li>';
												}
												if ( isset( $snow_depth_6 ) && $snow_depth_6 >= 0 ) {
													echo '<li class="snow-depth"><strong>';
													if ( $name_depth_1 ) {
														if ( $elevation_snow_depth_6 ) {
															echo $name_depth_6 . ' (' . number_format( $elevation_snow_depth_6 ) . ' ' . $elevation_depth_measure . '): ';
														} else {
															echo $name_depth_6 . ': ';
														}
													} elseif ( $elevation_snow_depth_6 ) {
														echo 'Snow Depth (' . number_format( $elevation_snow_depth_6 ) . ' ' . $elevation_depth_measure . '): ';
													} elseif ( !$name_depth_6 && !$elevation_snow_depth_6 ) {
														echo 'Snow Depth: ';
													}
													echo '</strong>' . $snow_depth_6 . ' ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_6 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_6 / 0.39370 ) . 'cm)';
													}
													if ( $snow_type_6 ) {
														echo ' ' . $snow_type_6_english . '</li>';
													} else {
														echo '</li>';
													}
													if ( isset( $snow_depth_7 ) && $snow_depth_7 >= 0 ) {
														echo '<li class="snow-depth"><strong>';
														if ( $name_depth_7 ) {
															if ( $elevation_snow_depth_7 ) {
																echo $name_depth_7 . ' (' . number_format( $elevation_snow_depth_7 ) . ' ' . $elevation_depth_measure . '): ';
															} else {
																echo $name_depth_7 . ': ';
															}
														} elseif ( $elevation_snow_depth_7 ) {
															echo 'Snow Depth (' . number_format( $elevation_snow_depth_7 ) . ' ' . $elevation_depth_measure . '): ';
														} elseif ( !$name_depth_7 && !$elevation_snow_depth_7 ) {
															echo 'Snow Depth: ';
														}
														echo '</strong>' . $snow_depth_7 . ' ' . $snow_depth_measure;
														if ( $snow_depth_measure == 'cm' ) {
															echo ' (' . round( $snow_depth_7 * 0.3937 ) . '")';
														} elseif ( $snow_depth_measure == '"' ) {
															echo ' (' . round( $snow_depth_7 / 0.39370 ) . 'cm)';
														}
														if ( $snow_type_7 ) {
															echo ' ' . $snow_type_7_english . '</li>';
														} else {
															echo '</li>';
														}
													}
												}
											}
										}
									}
								}
							}
							if ( isset( $snow_depth_unique ) && $snow_depth_unique >= 0 ) {
								echo '<li class="snow-depth"><strong>';
								if ( $name_depth_unique ) {
									if ( $elevation_snow_unique ) {
										echo $name_depth_unique . ' (' . number_format( $elevation_snow_unique ) . ' ' . $elevation_depth_measure . '): ';
									} else {
										echo $name_depth_unique . ': ';
									}
								} elseif ( $elevation_snow_unique ) {
									echo 'Snow Depth (' . number_format( $elevation_snow_unique ) . ' ' . $elevation_depth_measure . '): ';
								} elseif ( !$name_depth_unique && !$elevation_snow_unique ) {
									echo 'Snow Depth: ';
								}
								echo '</strong>' . $snow_depth_unique . ' ' . $snow_depth_measure;
								if ( $snow_depth_measure == 'cm' ) {
									echo ' (' . round( $snow_depth_unique * 0.3937 ) . '")';
								} elseif ( $snow_depth_measure == '"' ) {
									echo ' (' . round( $snow_depth_unique / 0.39370 ) . 'cm)';
								}
							} elseif ( $snow_depth_unique == 'Not available' ) {
								echo '<li class="snow-depth"><strong>Snow Depth: </strong>Not available</li>';
							}
							if ( $snow_type_unique == 'Not available' ) {
								echo '<li class="snow-type"><strong>Snow type: </strong>Not available' . '</li>';
							} elseif ( isset( $snow_type_unique ) ) {
								echo '<li class="snow-type"><strong>Snow type: </strong>' . $snow_type_unique_english . '</li>';
							}
							
							// REPEATERS LOCATION DEPTH
							if ( $location_depth_1 || $location_depth_2 || $location_depth_3 || $location_depth_4 || $location_depth_5 ) {
								
								if ( $location_1_name_1 && $location_1_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_1 . '( ' . number_format( $location_1_elevation_1 ) . ' ): </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_1_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_1_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_1_1_english;
									if ( $location_1_name_2 && $location_1_elevation_2 ) {
										echo ' | ' . $snow_depth_1_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_1_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_1_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_1_2_english;
										if ( $location_1_name_3 && $location_1_elevation_3 ) {
											echo ' | ' . $snow_depth_1_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_1_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_1_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_1_3_english;
											if ( $location_1_name_4 && $location_1_elevation_4 ) {
												echo ' | ' . $snow_depth_1_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_1_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_1_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_1_4_english;
												if ( $location_1_name_5 && $location_1_elevation_5 ) {
													echo ' | ' . $snow_depth_1_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_1_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_1_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_1_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_1 . '</li>';
								}
								if ( $location_1_name_1 && !$location_1_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_1 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_1_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_1_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_1_1_english;
									if ( $location_1_name_2 && !$location_1_elevation_2 ) {
										echo '<strong> || </strong>' . $snow_depth_1_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_1_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_1_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_1_2_english;
										if ( $location_1_name_3 && !$location_1_elevation_3 ) {
											echo '<strong> || </strong>' . $snow_depth_1_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_1_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_1_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_1_3_english;
											if ( $location_1_name_4 && !$location_1_elevation_4 ) {
												echo '<strong> || </strong>' . $snow_depth_1_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_1_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_1_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_1_4_english;
												if ( $location_1_name_5 && !$location_1_elevation_5 ) {
													echo '<strong> || </strong>' . $snow_depth_1_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_1_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_1_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_1_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_1 . '</li>';
								}
								if ( $location_1_elevation_1 && !$location_1_name_1 ) {
									echo '<li class="snow-depth"><strong>' . number_format( $location_1_elevation_1 ) . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_1_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_1_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_1_1_english;
									if ( $location_1_elevation_2 && !$location_1_name_2 ) {
										echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_2 ) . ': </strong>' . $snow_depth_1_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_1_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_1_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_1_2_english;
										if ( $location_1_elevation_3 && !$location_1_name_3 ) {
											echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_3 ) . ': </strong>' . $snow_depth_1_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_1_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_1_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_1_3_english;
											if ( $location_1_elevation_4 && !$location_1_name_4 ) {
												echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_4 ) . ': </strong>' . $snow_depth_1_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_1_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_1_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_1_4_english;
												if ( $location_1_elevation_5 && !$location_1_name_5 ) {
													echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_5 ) . ': </strong>' . $snow_depth_1_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_1_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_1_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_1_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_1 . '</li>';
								}
								if ( $location_2_name_1 && $location_2_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_2 . '( ' . number_format( $location_2_elevation_1 ) . ' ): </strong>' . $snow_depth_2_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_2_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_2_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_2_1_english;
									if ( $location_2_name_2 && $location_2_elevation_2 ) {
										echo ' | ' . $snow_depth_2_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_2_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_2_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_2_2_english;
										if ( $location_2_name_3 && $location_2_elevation_3 ) {
											echo ' | ' . $snow_depth_2_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_2_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_2_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_2_3_english;
											if ( $location_2_name_4 && $location_2_elevation_4 ) {
												echo ' | ' . $snow_depth_2_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_2_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_2_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_2_4_english;
												if ( $location_2_name_5 && $location_2_elevation_5 ) {
													echo ' | ' . $snow_depth_2_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_2_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_2_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_2_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_2 . '</li>';
								}
								if ( $location_2_name_1 && !$location_2_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_2 . ': </strong>' . $snow_depth_2_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_2_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_2_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_2_1_english;
									if ( $location_2_name_2 && !$location_2_elevation_2 ) {
										echo '<strong> || </strong>' . $snow_depth_2_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_2_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_2_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_2_2_english;
										if ( $location_2_name_3 && !$location_2_elevation_3 ) {
											echo '<strong> || </strong>' . $snow_depth_2_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_2_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_2_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_2_3_english;
											if ( $location_2_name_4 && !$location_2_elevation_4 ) {
												echo '<strong> || </strong>' . $snow_depth_2_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_2_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_2_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_2_4_english;
												if ( $location_2_name_5 && !$location_2_elevation_5 ) {
													echo '<strong> || </strong>' . $snow_depth_2_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_2_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_2_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_2_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_2 . '</li>';
								}
								if ( $location_2_elevation_1 && !$location_2_name_1 ) {
									echo '<li class="snow-depth"><strong>' . number_format( $location_2_elevation_1 ) . ': </strong>' . $snow_depth_2_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_2_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_2_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_2_1_english;
									if ( $location_2_elevation_2 && !$location_2_name_2 ) {
										echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_2 ) . ': </strong>' . $snow_depth_2_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_2_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_2_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_2_2_english;
										if ( $location_2_elevation_3 && !$location_2_name_3 ) {
											echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_3 ) . ': </strong>' . $snow_depth_2_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_2_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_2_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_2_3_english;
											if ( $location_2_elevation_4 && !$location_2_name_4 ) {
												echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_4 ) . ': </strong>' . $snow_depth_2_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_2_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_2_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_2_4_english;
												if ( $location_2_elevation_5 && !$location_2_name_5 ) {
													echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_5 ) . ': </strong>' . $snow_depth_2_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_2_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_2_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_2_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_2 . '</li>';
								}
								if ( $location_3_name_1 && $location_3_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_3 . '( ' . number_format( $location_3_elevation_1 ) . ' ): </strong>' . $snow_depth_3_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_3_1_english;
									if ( $location_3_name_2 && $location_3_elevation_2 ) {
										echo ' | ' . $snow_depth_3_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_3_2_english;
										if ( $location_3_name_3 && $location_3_elevation_3 ) {
											echo ' | ' . $snow_depth_3_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_3_3_english;
											if ( $location_3_name_4 && $location_3_elevation_4 ) {
												echo ' | ' . $snow_depth_3_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_3_4_english;
												if ( $location_3_name_5 && $location_3_elevation_5 ) {
													echo ' | ' . $snow_depth_3_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_3_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_3 . '</li>';
								}
								if ( $location_3_name_1 && !$location_3_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_3 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_3_1_english;
									if ( $location_3_name_2 && !$location_3_elevation_2 ) {
										echo '<strong> || </strong>' . $snow_depth_3_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_3_2_english;
										if ( $location_3_name_3 && !$location_3_elevation_3 ) {
											echo '<strong> || </strong>' . $snow_depth_3_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_3_3_english;
											if ( $location_3_name_4 && !$location_3_elevation_4 ) {
												echo '<strong> || </strong>' . $snow_depth_3_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_3_4_english;
												if ( $location_3_name_5 && !$location_3_elevation_5 ) {
													echo '<strong> || </strong>' . $snow_depth_3_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_3_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_3 . '</li>';
								}
								if ( $location_3_elevation_1 && !$location_3_name_1 ) {
									echo '<li class="snow-depth"><strong>' . number_format( $location_3_elevation_1 ) . ': </strong>' . $snow_depth_3_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_3_1_english;
									if ( $location_3_elevation_2 && !$location_3_name_2 ) {
										echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_2 ) . ': </strong>' . $snow_depth_3_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_3_2_english;
										if ( $location_3_elevation_3 && !$location_3_name_3 ) {
											echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_3 ) . ': </strong>' . $snow_depth_3_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_3_3_english;
											if ( $location_3_elevation_4 && !$location_3_name_4 ) {
												echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_4 ) . ': </strong>' . $snow_depth_3_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_3_4_english;
												if ( $location_3_elevation_5 && !$location_3_name_5 ) {
													echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_5 ) . ': </strong>' . $snow_depth_3_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_3_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_3 . '</li>';
								}
								if ( $location_4_name_1 && $location_4_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_4 . '( ' . number_format( $location_4_elevation_1 ) . ' ): </strong>' . $snow_depth_4_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_4_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_4_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_4_1_english;
									if ( $location_4_name_2 && $location_4_elevation_2 ) {
										echo ' | ' . $snow_depth_4_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_4_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_4_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_4_2_english;
										if ( $location_4_name_3 && $location_4_elevation_3 ) {
											echo ' | ' . $snow_depth_4_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_4_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_4_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_4_3_english;
											if ( $location_4_name_4 && $location_4_elevation_4 ) {
												echo ' | ' . $snow_depth_4_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_4_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_4_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_4_4_english;
												if ( $location_4_name_5 && $location_4_elevation_5 ) {
													echo ' | ' . $snow_depth_4_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_4_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_4_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_4_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_4 . '</li>';
								}
								if ( $location_4_name_1 && !$location_4_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_4 . ': </strong>' . $snow_depth_4_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_4_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_4_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_4_1_english;
									if ( $location_4_name_2 && !$location_4_elevation_2 ) {
										echo '<strong> || </strong>' . $snow_depth_4_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_4_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_4_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_4_2_english;
										if ( $location_4_name_3 && !$location_4_elevation_3 ) {
											echo '<strong> || </strong>' . $snow_depth_4_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_4_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_4_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_4_3_english;
											if ( $location_4_name_4 && !$location_4_elevation_4 ) {
												echo '<strong> || </strong>' . $snow_depth_4_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_4_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_4_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_4_4_english;
												if ( $location_4_name_5 && !$location_4_elevation_5 ) {
													echo '<strong> || </strong>' . $snow_depth_4_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_4_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_4_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_4_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_4 . '</li>';
								}
								if ( $location_4_elevation_1 && !$location_4_name_1 ) {
									echo '<li class="snow-depth"><strong>' . number_format( $location_4_elevation_1 ) . ': </strong>' . $snow_depth_4_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_4_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_4_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_4_1_english;
									if ( $location_4_elevation_2 && !$location_4_name_2 ) {
										echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_2 ) . ': </strong>' . $snow_depth_4_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_4_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_4_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_4_2_english;
										if ( $location_4_elevation_3 && !$location_4_name_3 ) {
											echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_3 ) . ': </strong>' . $snow_depth_4_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_4_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_4_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_4_3_english;
											if ( $location_4_elevation_4 && !$location_4_name_4 ) {
												echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_4 ) . ': </strong>' . $snow_depth_4_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_4_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_4_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_4_4_english;
												if ( $location_4_elevation_5 && !$location_4_name_5 ) {
													echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_5 ) . ': </strong>' . $snow_depth_4_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_4_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_4_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_4_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_4 . '</li>';
								}
								if ( $location_5_name_1 && $location_5_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_5 . '( ' . number_format( $location_5_elevation_1 ) . ' ): </strong>' . $snow_depth_5_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_5_1_english;
									if ( $location_5_name_2 && $location_5_elevation_2 ) {
										echo ' | ' . $snow_depth_5_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_5_2_english;
										if ( $location_5_name_3 && $location_5_elevation_3 ) {
											echo ' | ' . $snow_depth_5_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_5_3_english;
											if ( $location_5_name_4 && $location_5_elevation_4 ) {
												echo ' | ' . $snow_depth_5_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_5_4_english;
												if ( $location_5_name_5 && $location_5_elevation_5 ) {
													echo ' | ' . $snow_depth_5_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_5_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_5 . '</li>';
								}
								if ( $location_5_name_1 && !$location_5_elevation_1 ) {
									echo '<li class="snow-depth"><strong>' . $location_5 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_5_1_english;
									if ( $location_5_name_2 && !$location_5_elevation_2 ) {
										echo '<strong> || </strong>' . $snow_depth_5_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_5_2_english;
										if ( $location_5_name_3 && !$location_5_elevation_3 ) {
											echo '<strong> || </strong>' . $snow_depth_5_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_5_3_english;
											if ( $location_5_name_4 && !$location_5_elevation_4 ) {
												echo '<strong> || </strong>' . $snow_depth_5_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_5_4_english;
												if ( $location_5_name_5 && !$location_5_elevation_5 ) {
													echo '<strong> || </strong>' . $snow_depth_5_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_5_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_5 . '</li>';
								}
								if ( $location_5_elevation_1 && !$location_5_name_1 ) {
									echo '<li class="snow-depth"><strong>' . number_format( $location_5_elevation_1 ) . ': </strong>' . $snow_depth_5_1 . '  ' . $snow_depth_measure;
									if ( $snow_depth_measure == 'cm' ) {
										echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
									} elseif ( $snow_depth_measure == '"' ) {
										echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
									}
									echo ' ' . $snow_type_5_1_english;
									if ( $location_5_elevation_2 && !$location_5_name_2 ) {
										echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_2 ) . ': </strong>' . $snow_depth_5_2 . '  ' . $snow_depth_measure;
										if ( $snow_depth_measure == 'cm' ) {
											echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
										} elseif ( $snow_depth_measure == '"' ) {
											echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
										}
										echo ' ' . $snow_type_5_2_english;
										if ( $location_5_elevation_3 && !$location_5_name_3 ) {
											echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_3 ) . ': </strong>' . $snow_depth_5_3 . '  ' . $snow_depth_measure;
											if ( $snow_depth_measure == 'cm' ) {
												echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
											} elseif ( $snow_depth_measure == '"' ) {
												echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
											}
											echo ' ' . $snow_type_5_3_english;
											if ( $location_5_elevation_4 && !$location_5_name_4 ) {
												echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_4 ) . ': </strong>' . $snow_depth_5_4 . '  ' . $snow_depth_measure;
												if ( $snow_depth_measure == 'cm' ) {
													echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
												} elseif ( $snow_depth_measure == '"' ) {
													echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
												}
												echo ' ' . $snow_type_5_4_english;
												if ( $location_5_elevation_5 && !$location_5_name_5 ) {
													echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_5 ) . ': </strong>' . $snow_depth_5_5 . '  ' . $snow_depth_measure;
													if ( $snow_depth_measure == 'cm' ) {
														echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
													} elseif ( $snow_depth_measure == '"' ) {
														echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
													}
													echo ' ' . $snow_type_5_5_english;
												}
											}
										}
									}
									echo ' ' . $snow_type_5 . '</li>';
								}
							}
							
							// Field
							if ( $official_snow_report ) {
								echo '<li class="snow-report-link"><strong><a href="' . $official_snow_report . '" target="_blank">Official Snow Report</a></strong></li>';
							}
							
						echo '</ul>';
						
					echo '</div>';
					
				echo '</div>';
				
				// TWO-FIFTHS
				echo '<div id="overview-top-right" class="three-fifths">';
					
					echo '<div class="four-fifths first-2">';
					
					// SLOPES - ELEVATION - PRICING - LIFTS
					$number_of_additional_ski_slopes	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes', true );
					$slopes_maps						= get_post_meta( get_the_ID(), 'slopes_maps', true );
				
					echo '<div id="overview-right-tabs-1" class="background-boxes">';
						
						echo '<div class="overview-slopes-map">';
							
							// REPEATER - SLOPES MAPS
							$count_slopes_maps = get_post_meta( get_the_ID(), 'slopes_maps', true );
							
							if ( $count_slopes_maps ) {
								
								for ( $i = 0; $i < $count_slopes_maps; $i++ ) {
									
									$slopes_map_full		= (int) get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slopes_map_full', true );
									$slopes_map_thumbnail	= (int) get_post_meta( get_the_ID(), 'slopes_maps_' . $i . '_slopes_map_thumbnail', true );
									
									if ( $slopes_map_thumbnail ) {
										echo '<p class="overview-slopes-map-mini"><a href="' . wp_get_attachment_url( $slopes_map_full, 'slopes_maps' ) . '">' . wp_get_attachment_image( $slopes_map_thumbnail, 'slopes_maps' ) . '</a></p>';
									}
									
								}
								
							}
							
						echo '</div>';
						
						echo '<ul class="overview-slopes-colors">';
							
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
										echo '<li class="overview-total-slopes"><strong>Total: ' . $total_slopes . ' trail';
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
										echo '<li class="overview-total-slopes"><strong> Total: ' . $total_slopes . ' trail';
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
										echo '<li class="overview-total-slopes"><strong> Total: ' . $total_slopes . ' trail';
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
										echo '<li class="overview-total-slopes"><strong> Total: ' . $total_slopes . ' trail';
										if ( $total_slopes > '1' ) {
											echo 's';
										}
										echo '</strong></li>';
									}
									
								}
							
						echo '</ul>';
						
						//echo '<div class="overview-clear"></div>';	--> Hem canviat la posició d'aquest codi i l'hem posat a sota del proper ul.
							
							echo '<ul class="ul-overview-other-slopes">';
								
								// REPEATER - ADDITIONAL SKI SLOPES
								$count_number_of_additional_ski_slopes = get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes', true );
								
								if ( $count_number_of_additional_ski_slopes ) {
									
									for ( $i = 0; $i < $count_number_of_additional_ski_slopes; $i++ ) {
										
										$additional_ski_routes		= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_additional_ski_routes', true );
										$additional_nordic_tracks	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_additional_nordic_tracks', true );
										$additional_off_piste_runs	= get_post_meta( get_the_ID(), 'number_of_additional_ski_slopes_' . $i . '_additional_off_piste_runs', true );
										
									}
									
								}
										
								$count_length_of_additional_ski_slopes = get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes', true );
								
								if ( $count_length_of_additional_ski_slopes ) {
									
									for ( $i = 0; $i < $count_length_of_additional_ski_slopes; $i++ ) {
										
										$length_of_additional_ski_routes			= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_ski_routes', true );
										$length_of_additional_nordic_tracks			= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_nordic_tracks', true );
										$length_of_additional_off_piste				= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_length_of_additional_off_piste', true );
										$manual_length_of_additional_ski_routes		= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_ski_routes', true );
										$manual_length_of_additional_nordic_tracks	= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_nordic_tracks', true );
										$manual_length_of_additional_off_piste_runs	= get_post_meta( get_the_ID(), 'length_of_additional_ski_slopes_' . $i . '_manual_length_of_additional_off_piste_runs', true );
									}
									
								}
								
								// Additional Ski Routes / Nordic Tracks / Off-Piste
								if( $manual_length_of_additional_ski_routes ) {
									echo '<li class="overview-ski-routes"><strong>SKI ROUTES: ' . $manual_length_of_additional_ski_routes . ' ' . $length_slopes_unity;
									if ( $length_slopes_unity == 'km' ) {
										echo ' (' . round( ( float ) $manual_length_of_additional_ski_routes * 0.62137, 1 ) . ' mi';
									} elseif ( $length_slopes_unity == 'mi' ) {
										echo ' (' . round( ( float ) $manual_length_of_additional_ski_routes / 0.62137, 1 ) . ' km';
									}
									echo ')</strong></li>';
								}
								if ( $additional_ski_routes ) {
									echo '<li class="overview-ski-routes"><strong>' . $additional_ski_routes . ' SKI ROUTE';
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
								if( $manual_length_of_additional_nordic_tracks ) {
									echo '<li class="overview-nordic-tracks"><strong>CROSS COUNTRY / NORDIC TRACKS: ' . $manual_length_of_additional_nordic_tracks . ' ' . $length_slopes_unity;
									if ( $length_slopes_unity == 'km' ) {
										echo ' (' . round( ( float ) $manual_length_of_additional_nordic_tracks * 0.62137, 1 ) . ' mi';
									} elseif ( $length_slopes_unity == 'mi' ) {
										echo ' (' . round( ( float ) $manual_length_of_additional_nordic_tracks / 0.62137, 1 ) . ' km';
									}
									echo ')</strong></li>';
								}
								if ( $additional_nordic_tracks ) {
									echo '<li class="overview-nordic-tracks"><strong>' . $additional_nordic_tracks . ' CROSS COUNTRY / NORDIC TRACK';
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
								if( $manual_length_of_additional_off_piste_runs ) {
									echo '<li class="overview-ski-routes"><strong>OFF-PISTE RUNS: ' . $manual_length_of_additional_off_piste_runs . ' ' . $length_slopes_unity;
									if ( $length_slopes_unity == 'km' ) {
										echo ' (' . round( ( float ) $manual_length_of_additional_off_piste_runs * 0.62137, 1 ) . ' mi';
									} elseif ( $length_slopes_unity == 'mi' ) {
										echo ' (' . round( ( float ) $manual_length_of_additional_off_piste_runs / 0.62137, 1 ) . ' km';
									}
									echo ')</strong></li>';
								}
								if ( $additional_off_piste_runs ) {
									echo '<li class="overview-ski-routes"><strong>' . $additional_off_piste_runs . ' OFF-PISTE RUN';
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
							
							echo '<div class="overview-clear"></div>';
							
							echo '<ul class="ul-overview-elevation">';
								//echo '<ul class="ul-overview-elevation-narrow">';
								
								// REPEATER - ELEVATION INFO
								if ( $count_elevation_info ) {
									
									for ( $i = 0; $i < $count_elevation_info; $i++ ) {
										
										$min_elevation			= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_min_elevation', true );
										$max_elevation			= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_max_elevation', true );
										$elevation_difference	= ( $max_elevation - $min_elevation );
										$elevation_unity		= get_post_meta( get_the_ID(), 'elevation_info_' . $i . '_elevation_unity', true );
										
										// Sub-Field
											if ( $max_elevation ) {
												echo '<li class="overview-elevation"><strong>Max Elevation: </strong> ' . number_format( $max_elevation, 0 ) . ' ' . $elevation_unity . ' (';
												if ( $elevation_unity == 'm' ) {
													echo number_format( $max_elevation * 3.2808, 0 ) . ' ft)';
												} elseif ( $elevation_unity == 'ft' ) {
													echo number_format( $max_elevation / 3.2808, 0 ) . ' m)';
												}
												echo '</li>';
											}
											if ( $min_elevation ) {
												echo '<li class="overview-elevation"><strong>Min Elevation: </strong> ' . number_format( $min_elevation, 0 ) . ' ' . $elevation_unity . ' (';
												if ( $elevation_unity == 'm' ) {
													echo number_format( $min_elevation * 3.2808, 0 ) . ' ft)';
												} elseif ( $elevation_unity == 'ft' ) {
													echo number_format( $min_elevation / 3.2808, 0 ) . ' m) )';
												}
												echo '</li>';
											}
											if ( $elevation_difference ) {
												echo '<li class="overview-elevation"><strong>Elev. Difference: </strong> ' . number_format( $elevation_difference, 0 ) . ' ' . $elevation_unity . ' (';
												if ( $elevation_unity == 'm' ) {
													echo number_format( $elevation_difference * 3.2808, 0 ) . ' ft)';
												} elseif ( $elevation_unity == 'ft' ) {
													echo number_format( $elevation_difference / 3.2808, 0 ) . ' m)';
												}
												echo '</li>';
											}
										
									}
									
								}
								
								//echo '</ul>';
								
							echo '</ul>';
							
							echo '<div class="overview-clear"></div>';
							
						echo '</div>';
						
					echo '</div>';
					
					echo '<div class="five-fifths">';
					
						echo '<div id="overview-right-tabs-2" class="background-boxes">';
						
							$count_lifts = get_post_meta( get_the_ID(), 'lifts', true );
							
							if ( $count_lifts ) {
								
								for ( $i = 0; $i < $count_lifts; $i++ ) {
									
									$total_chairlifts			= ( $detachable_chairlifts + $fixed_grip_chairlifts + $chairlifts );
									$total_lift_capacity		= get_post_meta( get_the_ID(), 'lifts_' . $i . '_total_lift_capacity', true );
									$total_lift_capacity_format	= number_format( $total_lift_capacity, 0 );
									$total_lift_length			= get_post_meta( get_the_ID(), 'lifts_' . $i . '_total_lift_length', true );
									$lift_length_unity			= get_post_meta( get_the_ID(), 'lifts_' . $i . '_lift_length_unity', true );
									
									echo '<ul class="overview-lifts">';
										
										if ( $cog_railways ) {
											echo '<li class="cog-railways"><strong>' . $cog_railways . '</strong></li>';
										}
										if ( $funiculars ) {
											echo '<li class="funicular"><strong>' . $funiculars . '</strong></li>';
										}
										if ( $aerial_tramways_reversible_ropeways ) {
											echo '<li class="aerial-cable-tramway-reversible-ropeway"><strong>' . $aerial_tramways_reversible_ropeways . '</strong></li>';
										}
										if ( $circulating_ropeway_gondola_lift ) {
											echo ' <li class="circulating_ropeway-gondola-lift"><strong>' . $circulating_ropeway_gondola_lift . '</strong></li>';
										}
										if ( $combined_installations_gondola_and_chair ) {
											echo '<li class="combined-installation"><strong>' . $combined_installations_gondola_and_chair . '</strong></li>';
										}
										if ( $total_chairlifts ) {
											echo ' <li class="chairlift"><strong>' . $total_chairlifts . '</strong></li>';
										}
										if ( $t_bar_lifts_platters_button_lifts ) {
											echo '<li class="t-bar-lift-platter-button-lift"><strong>' . $t_bar_lifts_platters_button_lifts . '</strong></li>';
										}
										if ( $rope_tow_beginner_lift ) {
											echo ' <li class="rope-tow-beginner-lift"><strong>' . $rope_tow_beginner_lift . '</strong></li>';
										}
										if ( $magic_carpet_people_mover ) {
											echo ' <li class="magic-carpet-people-mover"><strong>' . $magic_carpet_people_mover . '</strong></li>';
										}
										if ( $surface_lifts ) {
											echo '<li class="t-bar-lift-platter-button-lift"><strong>' . $surface_lifts . '</strong></li>';
										}
										
									echo '</ul>';
									
									echo '<ul class="overview-lift-totals">';
									
										if ( $total_lift_capacity ) {
											echo '<li><strong>Total lift capacity: </strong> ' . $total_lift_capacity_format . ' passengers / hour' . '</li>';
										}
										if ( $total_lift_length ) {
											echo '<li><strong>Total lift length: </strong> ' . $total_lift_length . ' ' . $lift_length_unity . ' (';
											if ( $lift_length_unity == 'km' ) {
												echo number_format( $total_lift_length * 0.62137, 1 ) . ' mi)';
											} elseif ( $lift_length_unity == 'mi' ) {
												echo number_format( $total_lift_length / 0.62137, 1 ) . ' km)';
											}
											echo '</li><p class="divi-horizontal-half"></p>';
										}
									
									echo '</ul>';
										
								}
								
							}
							
									echo '<ul class="overview-pricing">';
										
										echo '<li class="overview-pricing-title"><strong>PRICES </strong><span class="see-all-prices"><strong> SEE ALL PRICES</strong></span></li>';
										
										// FLEXIBLE CONTENT - PRICING
										$rows_pricing = get_post_meta( get_the_ID(), 'pricing', true );
										foreach ( ( array ) $rows_pricing as $count_pricing => $row_pricing ) {
											
											switch ( $row_pricing ) {
												
												//case 'currency':
												//$local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
												//break;
												
												case 'overview_prices':
                                                $local_currency = get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_local_currency', true );
												$adult			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
												$junior			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );
												
												if ( $adult || $junior ) {
													echo '<li><strong>1-Day Pass Adult/Junior: </strong> ' . $local_currency, $adult . ' / ' . $local_currency, $junior . '</li>';
												}
												break;
												case 'season_pass':
												$adult			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_adult', true );
												$junior			= get_post_meta( get_the_ID(), 'pricing_' . $count_pricing . '_junior', true );
												
												if ( $adult || $junior ) {
													echo '<li class="end-of-prices-tab"><strong>Season Pass Adult/Junior: </strong> ' . $local_currency, $adult . ' / ' . $local_currency, $junior . '</li>';
												}
												break;
												
											}
											
										}
										
									echo '</ul>';
							
						echo '</div>';
						
					echo '</div>';
					
				echo '</div>';
				
			echo '</div>';
			
			// FLEXBOX-BOTTOM
			echo '<div class="flexbox-bottom">';
				
				// ONE-HALF FIRST
				echo '<div id="overview-bottom-left" class="one-half first">';
					
					// MAP
					echo '<div id="overview-map">';
						echo do_shortcode( $mapsmarker_shortcode );
					echo '</div>';
					
					
				echo '</div>';
				
				// ONE-HALF
				echo '<div id="overview-bottom-right" class="one-half">';
						
					// METEO
					echo '<div id="overview-meteo">';
							
					$resort_name	= get_post_meta( get_the_ID(), 'resort_name', true );
					$location_meteo	= get_post_meta( get_the_ID(), 'location_meteo', true );
							
					if ( $resort_name || $location_meteo ) {
								
						/* METEO COMPLET */
							
						ob_start();
							
						$defaultWidth	= '98%';
						$times          = true;
						$iconGraph		= true;
						$topCount		= 4;
						$topCount_1		= 4;
						$topCount_2		= 8;
						$includeHTML	= true;
						$colorClass		= 'blue';
						$pageWidth		= '100%';
						//$scriptDir	    = site_url( '/wp-content/themes/cameraski/lib/meteo/' );
                      	$scriptDir	    = './';
                      	$pageName		= 'single-ski-resort.php';
						$pageVersion	= '3.00 2014-07-11';
						$string         = $pageName . '- version: ' . pageVersion;
						$pageFile 		= basename( __FILE__ );
						$title          = '<title>YR.NO Forecast. Script ' . $pageName . '</title>';
						$myPage			= $pageName;
						//$script			= $scriptDir . 'yrnoGenerateHtml.php';
                      	
                      	#-----------------------------------------------------------------------
						# Now create all tables and graphs to be printed here
						#-----------------------------------------------------------------------
						$script	= $scriptDir . '/wp-content/themes/cameraski/lib/meteo/yrnoGenerateHtml.php';
						echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
						include $script;
						
						//include $script;
						//include_once ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/cameraski/lib/meteo/yrnoGenerateHtml.php" );
						
						$string = ob_get_contents ();
						ob_end_clean();

						if ( $includeHTML ) {
							echo '<div class="' . $colorClass . '" style="text-align: center;">' . PHP_EOL;
								echo '<div id="pagina" style="width: ' . $pageWidth . '; ">' . PHP_EOL;
						}
						
						echo $string; // Display info about all loaded scripts and version numbers as html comment lines

						$styleborder    = '';
						$margin         = ' margin: 5px auto;'; 
						$topWidth       = ' width: ' . $defaultWidth . ';';

						if ( $times ) {
							$style  = 'style="" ';
							echo '<div id="times" style="' . $topWidth . $margin . '" >' . PHP_EOL;
								echo $wsUpdateTimes . PHP_EOL;
							echo '</div>' . PHP_EOL;
						}
						
						if ( $iconGraph ) {
							$style  = 'style="' . $topWidth . $styleborder . $margin . '"';
							echo '<div id="iconGraph" ' . $style . '>';
								echo $tableIcons_1 . PHP_EOL;
								echo $tableIcons_2 . PHP_EOL;
								echo $tableIconsMobile_1 . PHP_EOL;
								echo $tableIconsMobile_2 . PHP_EOL;
							echo '</div>' . PHP_EOL;
							#	echo '<br />' . PHP_EOL;
						}
						
						#  end of enclosing div
						if ( $includeHTML ) {
							echo '</div>' . PHP_EOL; // end pagina div
						}
						
						if ( $includeHTML ) {
							echo '
							</div>';
						}
					}
					/* -------------------------------------------------- */
					
					echo '</div>';
		
				echo '</div>';
				
			echo '</div>';
				
			do_action( 'genesis_after_entry_content' );

			do_action( 'genesis_entry_footer' );
		
		// 25/04/2016 - Aix� tanca l'etiqueta HTML <article>
		echo '</article>';

		do_action( 'genesis_after_entry' );

	endwhile; //* end of one post
	do_action( 'genesis_after_endwhile' );

else : //* if no posts exist
		do_action( 'genesis_loop_else' );
endif; //* end loop
		
do_action( 'genesis_after_loop' );

// 25/04/2016 - Aquest �s el /div que tanca <main class="content"> - NO-> Ho hem descomentat
genesis_markup( array(
	'html5' => '</main>', //* end .content
	'xhtml' => '</div>', //* end #content
) );
	
do_action( 'genesis_after_content' );

// 25/04/2016 - Aquest �s el /div que tanca content-sidebar-wrap - NO-> Ho hem descomentat - DONCS S�, HO HEM TORNAT A COMENTAR (21/07/2016)
//echo '</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
//do_action( 'genesis_after_content_sidebar_wrap' ); // Comentada perqu� est� Deprecated

get_footer();