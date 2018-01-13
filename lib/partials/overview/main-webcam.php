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

//WEBCAM
$main_webcam_name		= get_post_meta( get_the_ID(), 'main_webcam_name', true );
$main_webcam_url_generic= get_post_meta( get_the_ID(), 'main_webcam_url_generic', true );
$main_webcam_url_16_9	= get_post_meta( get_the_ID(), 'main_webcam_url_16_9', true );
$main_webcam_url_4_3	= get_post_meta( get_the_ID(), 'main_webcam_url_4_3', true );
$main_webcam_url_1_1	= get_post_meta( get_the_ID(), 'main_webcam_url_1_1', true );
$main_webcam_file		= get_post_meta( get_the_ID(), 'main_webcam_file', true );
$webcam					= get_post_meta( get_the_ID(), 'webcam', true );

$cameraski_ski_resort_webcams   = 'http://beta-01.com/ski-resort-webcams/';
$tab                            = get_post_meta( get_the_ID(), 'tab', true );

?>
<p class="main-webcam-title"><a href="<?php echo $cameraski_ski_resort_webcams . $tab; ?>"><strong>ALL WEBCAMS</strong></a></p>

<?php
// Field
if ( $main_webcam_url_generic ) {

	echo '<p class="main-webcam-image"><img src="' . $DOCUMENT_ROOT . $main_webcam_url_generic . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p>';

} /*elseif ( $main_webcam_url_4_3 ) {

	echo '<p class="main-webcam-image"><img src="' $main_webcam_url_4_3 . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p>';

} elseif ( $main_webcam_url_1_1 ) {

	echo '<p class="main-webcam-image"><img src="' $main_webcam_url_1_1 . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p>';

}*/