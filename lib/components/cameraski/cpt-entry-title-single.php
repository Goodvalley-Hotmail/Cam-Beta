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

add_filter( 'genesis_post_title_text', __NAMESPACE__ . '\add_logo_title_domain_tabs_to_cpt_title' );
function add_logo_title_domain_tabs_to_cpt_title( $title ) {

	//$logo_overview                  = (int) get_post_meta( get_the_ID(), 'logo_overview', true );
	//$current_website                = get_post_meta( get_the_ID(), 'current_website', true );
	//$cameraski_ski_domain           = $current_website . 'ski-domain/';
	//$title_domain_1                 = get_post_meta( get_the_ID(), 'title_domain_1', true );
	//$title_domain_2                 = get_post_meta( get_the_ID(), 'title_domain_2', true );
	//$title_domain_3                 = get_post_meta( get_the_ID(), 'title_domain_3', true );
	//$title_domain_url_1             = get_post_meta( get_the_ID(), 'title_domain_url_1', true );
	//$title_domain_url_2             = get_post_meta( get_the_ID(), 'title_domain_url_2', true );
	//$title_domain_url_3             = get_post_meta( get_the_ID(), 'title_domain_url_3', true );
	//$cameraski_ski_resort           = $current_website . 'ski-resort/';
	//$cameraski_ski_resort_webcams   = $current_website . 'ski-resort-webcams/';
	//$cameraski_weather_forecast     = $current_website . 'weather-forecast/';
	//$tab                            = get_post_meta( get_the_ID(), 'tab', true );

	$logo_overview                  = (int) get_post_meta( get_the_ID(), 'logo_overview', true );
	$cameraski_ski_domain           = 'https://www.beta-01.com/ski-domain/';
	$title_domain_1                 = get_post_meta( get_the_ID(), 'title_domain_1', true );
	$title_domain_2                 = get_post_meta( get_the_ID(), 'title_domain_2', true );
	$title_domain_3                 = get_post_meta( get_the_ID(), 'title_domain_3', true );
	$title_domain_url_1             = get_post_meta( get_the_ID(), 'title_domain_url_1', true );
	$title_domain_url_2             = get_post_meta( get_the_ID(), 'title_domain_url_2', true );
	$title_domain_url_3             = get_post_meta( get_the_ID(), 'title_domain_url_3', true );
	$cameraski_ski_resort           = 'https://www.beta-01.com/ski-resort/';
	$cameraski_ski_resort_webcams   = 'https://www.beta-01.com/ski-resort-webcams/';
	$cameraski_weather_forecast     = 'https://www.beta-01.com/weather-forecast/';
	$tab                            = get_post_meta( get_the_ID(), 'tab', true );

	if ( is_singular( 'ski-resort' ) ) {

		if ( $logo_overview ) {

			if ( $title_domain_1 ) {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_1 . '">' . $title_domain_1 . '</a></span>';

				if ( $title_domain_2 ) {

					$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_2 . '">' . $title_domain_2 . '</a></span>';

					if ( $title_domain_3 ) {

						$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_3 . '">' . $title_domain_3 . '</a></span>';

					}

				}

				$title .= '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		} else {

			if ( $title_domain_1 ) {

				$title = $title . ' - <span><span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_1 . '">' . $title_domain_1 . '</a></span>';

				if ( $title_domain_2 ) {

					$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_2 . '">' . $title_domain_2 . '</a></span>';

					if ( $title_domain_3 ) {

						$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_3 . '">' . $title_domain_3 . '</a></span>';

					}

				}

				$title .= '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		}

	} elseif ( is_singular( 'ski-resort-webcams' ) ) {

		if ( $logo_overview ) {

			if ( $title_domain_1 ) {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_1 . '">' . $title_domain_1 . '</a></span>';

				if ( $title_domain_2 ) {

					$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_2 . '">' . $title_domain_2 . '</a></span>';

					if ( $title_domain_3 ) {

						$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_3 . '">' . $title_domain_3 . '</a></span>';

					}

				}

				$title .= '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		} else {

			if ( $title_domain_1 ) {

				$title = $title . ' - <span><span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_1 . '">' . $title_domain_1 . '</a></span>';

				if ( $title_domain_2 ) {

					$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_2 . '">' . $title_domain_2 . '</a></span>';

					if ( $title_domain_3 ) {

						$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_3 . '">' . $title_domain_3 . '</a></span>';

					}

				}

				$title .= '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		}

	} elseif ( is_singular( 'weather-forecast' ) ) {

		if ( $logo_overview ) {

			if ( $title_domain_1 ) {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_1 . '">' . $title_domain_1 . '</a></span>';

				if ( $title_domain_2 ) {

					$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_2 . '">' . $title_domain_2 . '</a></span>';

					if ( $title_domain_3 ) {

						$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_3 . '">' . $title_domain_3 . '</a></span>';

					}

				}

				$title .= '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		} else {

			if ( $title_domain_1 ) {

				$title = $title . ' - <span><span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_1 . '">' . $title_domain_1 . '</a></span>';

				if ( $title_domain_2 ) {

					$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_2 . '">' . $title_domain_2 . '</a></span>';

					if ( $title_domain_3 ) {

						$title .= ' - <span itemprop="memberOf"><a href="' .  $cameraski_ski_domain . $title_domain_url_3 . '">' . $title_domain_3 . '</a></span>';

					}

				}

				$title .= '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a class="tab-after-entry-title" href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a class="tab-after-entry-title" href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		}

	}

	return $title;

}