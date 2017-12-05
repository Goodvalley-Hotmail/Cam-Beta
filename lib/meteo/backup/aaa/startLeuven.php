<?php
# display source of script if requested so
if ( isset( $_REQUEST['sce'] ) && strtolower( $_REQUEST['sce'] ) == 'view' ) { //--self downloader --
   $filenameReal = __FILE__;
   $download_size = filesize( $filenameReal );
   header( 'Pragma: public' );
   header( 'Cache-Control: private' );
   header( 'Cache-Control: no-cache, must-revalidate' );
   header( "Content-type: text/plain" );
   header( "Accept-Ranges: bytes" );
   header( "Content-Length: $download_size" );
   header( 'Connection: close' );
   readfile( $filenameReal );
   exit;
}

# the leuven scripts can not be used / started  without index.php
if ( !isset( $SITE ) ){
	header( "Location: ../index.php" );
	exit;
}

# ----------------------------------------------------------------------
#                HERE YOU NEED TO MAKE SOME CHANGES
# ----------------------------------------------------------------------
#
# what parts should be printed
$times					= true; // 
# Icons for top of page or startpage
$iconGraph				= true; // icon type header  with 2 icons for each day (12 hours data)
$topCount				= 10; // max nr of day-part forecasts in icons or graph
# Two kinds of meteograms
$yrnoMeteogram			= true; // standard yrno meteogram two days - one column per hour
$chartsMeteogram		= true;	// high charts meteogram -  6 days - one colom for every 6 hours - 
$chartsMeteogramHeight  = '340px';
$MeteogramInTabs		= false; // high charts graph separate (false) or in a tab (true)

$yrnoTable				= true; // table with one line for every 6 hours
$yrnoDetailTable		= true;	// table with one line for every 3 or 1 hours
$tableHeight			= '500px'; // no restricted height use ''  - restrict use number of pixels: '500px' 
$tableInTabs			= true; // put tables in tabs

# ---------THE FOLLOWING SETTINGS ARE COPIED FROM WSSETTINGS.PHP -------
$yrnoID			= $SITE['yrnoID'];
$iconsOwn		= $SITE['yrnoIconsOwn'];
$yourArea		= $SITE['yourArea'];
$organ			= $SITE['organ'];
$latitude		= $SITE['latitude'];
$longitude		= $SITE['longitude'];
$charset		= $SITE['charset'];
$lower			= $SITE['textLowerCase'];
$tempSimple		= $SITE['tempSimple'];  

$uomTemp		= $SITE['uomTemp'];
$uomRain		= $SITE['uomRain'];
$uomWind 		= $SITE['uomWind'];
$uomBaro		= $SITE['uomBaro'];
$uomSnow		= $SITE['uomSnow'];
$uomDistance	= $SITE['uomDistance'];

$timeFormat		= $SITE['timeFormat'];
$timeOnlyFormat	= $SITE['timeOnlyFormat'];
$hourOnlyFormat	= $SITE['hourOnlyFormat'];
$dateOnlyFormat	= $SITE['dateOnlyFormat'];
$dateLongFormat	= $SITE['dateLongFormat'];
$timezone		= $SITE['tz'];

$defaultWidth	= '98%';
$insideTemplate = true;
$scriptDir      = './wsyrnofct/';

# --------------- END OF SETTINGS ----------------------------------------
#
# print version of script in the html of the generated page
#
$pageName						= 'startLeuven.php';
$pageVersion					= '3.00 2014-07-14';
$SITE['wsModules'][$pageName]	= 'version: ' . $pageVersion;
$pageFile						= basename( __FILE__ ); // check to see this is the real script

if ( $pageFile <> $pageName ) {
	$SITE['wsModules'][$pageFile] = 'this file loaded instead of ' . $pageName;
}

echo '<!-- module ' . $pageFile . ' ==== ' . $SITE['wsModules'][$pageFile] . " -->" . PHP_EOL;

if ( $SITE['uomTemp'] == '&deg;C' ) {
	$metric = true;
} else {
	$metric = false;
}

$script	= $scriptDir . 'yrnoGenerateHtml.php';
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
include $script;

$styleborder    = ' border: 1px inset; border-radius: 5px;';
$margin         = ' margin: 10px auto;'; 
$topWidth       = ' width: ' . $defaultWidth . ';';

if ( $chartsMeteogramHeight <> '' ) {
	$chartsMeteogramHeight  = 'height: ' . $chartsMeteogramHeight . ';';
}

if ( $tableHeight <> '' ) {
	$tableHeight = 'height: ' . $tableHeight . ';';
}

if ( $times ) {
	
	$style  = 'style="" ';
	
	echo '<div id="times" style="" >' . PHP_EOL;
		echo $wsUpdateTimes . PHP_EOL;
	echo '</div>' . PHP_EOL;
	
}

if ( $iconGraph ) {
	
	$style  = 'style="' . $topWidth . $styleborder . $margin . '"';
	
	echo '<div id="iconGraph" ' . $style . '>';
		echo $tableIcons . PHP_EOL;
	echo '</div>' . PHP_EOL;
#	echo '<br />' . PHP_EOL;

}

if ( $yrnoMeteogram && !$MeteogramInTabs ) {
	
	$style = 'style="' . $topWidth . $styleborder . $margin . 'overflow: hidden;"';
	include $scriptDir . 'yrnoavansert3.php';
	
	echo '<div ' . $style . '>';
		echo '<a href="http://www.yr.no/place/' . $yrnoID . '" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">' . PHP_EOL;
			echo '<img src="' . $im . '" alt="  " style="vertical-align: top; width: 100%; height:302px;"/>' . PHP_EOL;
		echo '</a>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}

if ( $chartsMeteogram && !$MeteogramInTabs ) { // are the graphs separate (=false) on the page or are they in a tab

	$style  = 'style="' . $topWidth . $styleborder . $margin . $chartsMeteogramHeight . '"';
	
	echo '<div id="containerTemp" '.$style.'>here the graph will be drawn</div><br />' . PHP_EOL;
	echo $graphPart1 . PHP_EOL;
	
}

if ( $tableInTabs || $MeteogramInTabs ) { // generate html for tabs
	echo '<div class="tabber" style="' . $topWidth . ' margin: auto;">' . PHP_EOL;
}

if ( $yrnoMeteogram && $MeteogramInTabs ) {
	
	$style  = 'style="width: 100%; overflow: hidden; "';
	include $scriptDir . 'yrnoavansert3.php';
	
	echo '<div class="tabbertab" style="padding: 0px;"><h2>' . yrnotransstr('Meteogram') . '</h2>' . PHP_EOL;
		echo '<div ' . $style . '>';
			echo '<a href="http://www.yr.no/place/' . $yrnoID . '" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">' . PHP_EOL;
				echo '<img src="' . $im . '" alt="  " style="vertical-align: top; width: 100%; height:302px;"/>' . PHP_EOL;
			echo '</a>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}

if ( $chartsMeteogram && $MeteogramInTabs ) {
	
	$style = 'style="width: 100%; overflow: hidden; ' . $chartsMeteogramHeight . '"';
	
	echo '<div class="tabbertab" style="padding: 0px;"><h2>' . yrnotransstr('Graph') . '</h2>' . PHP_EOL;
		echo '<div id="containerTemp" ' . $style . '>';
			echo 'here the graph will be drawn</div>' . PHP_EOL;
			echo $graphPart1 . PHP_EOL;
		echo '</div>' . PHP_EOL;	 
}

if ( $tableInTabs ) {
	
	$style  = 'style="padding: 0px;' . $tableHeight . '"';
	
	if ( $yrnoTable ) {
		echo '<div class="tabbertab" ' . $style . '>' . PHP_EOL;
			echo '<h2>' . yrnotransstr( 'Forecast by 6 hour intervals' ) . '</h2>' . PHP_EOL;
			echo $yrnoListTable . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	
	if ( $yrnoDetailTable ) {
		echo '<div class="tabbertab" ' . $style . '>' . PHP_EOL;
			echo '<h2>' . yrnotransstr( 'Forecast details' ) . '</h2>' . PHP_EOL;
			echo $yrnoDetailTable . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	
 }
 
if ( $tableInTabs || $MeteogramInTabs ) {
	echo '</div>' . PHP_EOL;
}

if ( !$tableInTabs ) {
	
	$style  = 'style="' . $topWidth . $margin . $tableHeight . ' overflow: auto;"';

	if ( $yrnoTable ) {
		echo '<div ' . $style . '>' . PHP_EOL;
			echo $yrnoListTable . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	
	if ( $yrnoDetailTable ) {
		echo '<div ' . $style . '>' . PHP_EOL;
			echo $yrnoDetailTable . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	
}
	    
# IMPORTANT do not delete as legally you are bind to display credit to Metno/Yrno in original readable text, same size as average text in window
$style  = 'style="' . $topWidth.$margin . '"';

echo '<div id="credit" ' . $style . '>' . PHP_EOL;
	echo $creditString . PHP_EOL;
echo '</div>' . PHP_EOL;
echo '<br />' . PHP_EOL;

#---------------------------------------------------------------------------
#  the following lines output the needed scripts / html for a stand alone page
#
#-------------------I M P O R T A N T  -------------------------------------
# now we add the needed javascripts if we display the graphs
# if you use this script inside another script make sure you add the javascripts yourself
#---------------------------------------------------------------------------
#
if ( $chartsMeteogram ) {
	
	echo '<script type="text/javascript" src="' . $javascriptsDir . 'jquery.js"></script>' . PHP_EOL;
	
	if ( $tableInTabs || $MeteogramInTabs ) {
		echo '<script type="text/javascript" src="' . $javascriptsDir . 'tabber.js"></script>' . PHP_EOL;
	}
	
	echo '<script type="text/javascript" src="' . $javascriptsDir . 'highcharts.js"></script>' . PHP_EOL;
	echo '<script type="text/javascript">$=jQuery;jQuery(document).ready(function(){for(n in docready){docready[n]()}});</script>' . PHP_EOL;
}

?>