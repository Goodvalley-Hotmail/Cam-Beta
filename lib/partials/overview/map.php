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

$mapsmarker_shortcode	= get_post_meta( get_the_ID(), 'mapsmarker_shortcode', true );
?>

<!--MAP-->
<div id="overview-map">

	<?php echo do_shortcode( $mapsmarker_shortcode ); ?>

</div>