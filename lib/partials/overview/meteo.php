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
	//$scriptDir	    = site_url( '/wp-content/themes/cameraski/lib/meteo/' ); // CARLES LOCAL
	$scriptDir	    = './'; // CARLES SERVER
	$pageName		= 'single-ski-resort.php';
	$pageVersion	= '3.00 2014-07-11';
	$string         = $pageName . '- version: ' . $pageVersion;
	$pageFile 		= basename( __FILE__ );
	$title          = '<title>YR.NO Forecast. Script ' . $pageName . '</title>';
	$myPage			= $pageName;
	//$script			= $scriptDir . 'yrnoGenerateHtml.php'; // CARLES LOCAL

	#-----------------------------------------------------------------------
	# Now create all tables and graphs to be printed here
	#-----------------------------------------------------------------------
	$script	= $scriptDir . '/wp-content/themes/cameraski/lib/meteo/yrnoGenerateHtml.php'; // CARLES SERVER
	echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
	include $script;

	//include $script;
	//include_once ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/cameraski/lib/meteo/yrnoGenerateHtml.php" ); // CARLES LOCAL

	$string = ob_get_contents ();
	ob_end_clean();

	if ( $includeHTML ) {
		echo '<div class="' . $colorClass . '" style="text-align: center;">' . PHP_EOL;
		echo '<div id="pagina" style="width: ' . $pageWidth . '; ">' . PHP_EOL;
	}

	echo $string;

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
		echo '</div>';
	}

}