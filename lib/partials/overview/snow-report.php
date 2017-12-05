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

// Field
$official_snow_report	= get_post_meta( get_the_ID(), 'official_snow_report', true );
if ( $official_snow_report ) {

	echo '<li class="snow-report-link"><strong><a href="' . $official_snow_report . '" target="_blank">Official Snow Report</a></strong></li>';

}