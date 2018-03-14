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

	$logo_overview                  = (int) get_post_meta( get_the_ID(), 'logo_overview', true );
	$title_domain                   = get_post_meta( get_the_ID(), 'title_domain', true );
	$cameraski_ski_resort           = 'http://beta-01.com/ski-resort/';
	$cameraski_ski_resort_webcams   = 'http://beta-01.com/ski-resort-webcams/';
	$cameraski_weather_forecast     = 'http://beta-01.com/weather-forecast/';
	$tab                            = get_post_meta( get_the_ID(), 'tab', true );

	if ( is_singular( 'ski-resort' ) ) {

		if ( $logo_overview ) {

			if ( $title_domain ) {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . ' - <span itemprop="memberOf">' . $title_domain . '</span><span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		} else {

			if ( $title_domain ) {

				$title = $title . ' - <span><span itemprop="memberOf">' . $title_domain . '</span><span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-active"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		}

	} elseif ( is_singular( 'ski-resort-webcams' ) ) {

		if ( $logo_overview ) {

			if ( $title_domain ) {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . ' - <span><span itemprop="memberOf">' . $title_domain . '</span><span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		} else {

			if ( $title_domain ) {

				$title = $title . ' - <span><span itemprop="memberOf">' . $title_domain . '</span><span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-active"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-weather-forecast"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		}

	} elseif ( is_singular( 'weather-forecast' ) ) {

		if ( $logo_overview ) {

			if ( $title_domain ) {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . ' - <span><span itemprop="memberOf">' . $title_domain . '</span><span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = '<span class="logo-overview">' . wp_get_attachment_image( $logo_overview, 'full', false, array( 'itemprop' => 'logo' ) ) . '</span>' . $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}

		} else {

			if ( $title_domain ) {

				$title = $title . ' - <span><span itemprop="memberOf">' . $title_domain . '</span><span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			} else {

				$title = $title . '<span id="tabbed"><nav id="tabbed"><span id="tab-first" class="tab-ski-resort"><a href="' . $cameraski_ski_resort . $tab . '">Ski Resort Overview</a></span><span class="tab-ski-resort-webcams"><a href="' . $cameraski_ski_resort_webcams . $tab . '">WebCams</a></span><span class="tab-active"><a href="' . $cameraski_weather_forecast . $tab . '">Weather Forecast</a></span></nav></span>';

			}
		}

	}

	return $title;

}