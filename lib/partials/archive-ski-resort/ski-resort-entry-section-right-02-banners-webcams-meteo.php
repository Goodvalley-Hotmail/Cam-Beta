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

$cameraski_ski_resort_webcams   = 'http://beta-01.com/ski-resort-webcams/';
$cameraski_weather_forecast     = 'http://beta-01.com/weather-forecast/';
$tab                            = get_post_meta( get_the_ID(), 'tab', true );

if ( $tab ) {

	echo '<div class="archive-webcams-meteo-links">';
		echo '<span class="archive-blue-link"><span class="archive-webcams-link"><a href="' . $cameraski_ski_resort_webcams . $tab . '"><strong>WebCams</strong></a></span><span class="archive-meteo-link"><a href="' . $cameraski_weather_forecast . $tab . '"><strong>Weather Forecast</strong></a></span></span>';
	echo '</div>';

}