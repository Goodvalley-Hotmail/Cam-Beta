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

<ul id="ul-status" class="background-boxes">

<?php

echo '<li class="datetime"><strong><time datetime="'.date( 'c' ).'">'.date( 'F j, Y ' ).'</time></strong> ';

if ( $operating_status == 'OPEN' ) {

	echo '<span class="operating-status-open"><strong> ' . $operating_status_english . '</strong></span></li>';

} elseif ( $operating_status == 'CLOSED' ) {

	echo '<span class="operating-status-closed"><strong> ' . $operating_status_english . '</strong></span></li>';

}
?>

</ul>