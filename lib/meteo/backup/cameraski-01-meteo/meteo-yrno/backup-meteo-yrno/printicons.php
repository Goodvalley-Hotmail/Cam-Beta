<?php

$errorMessages  = true; // for testing and debugging only - Set to false for production versions

#-----------------------------------------------------------------------
# set error reporting, you can witch it on by adding ?debug to the url 
#-----------------------------------------------------------------------
if ( isset( $_REQUEST['debug'] ) ) {		// display error messages 
	$errorMessages = true;
}

if ( $errorMessages ) {
	ini_set( 'display_errors', 'On' ); 
	error_reporting( E_ALL );
}

ob_start();

# ---------------HERE YOU NEED TO MAKE SOME CHANGES --------------------
#
$defaultWidth			= '96%';	// set do desired width 999px  or 100%
#
# what parts should be printed
#
$times                  = false;        // 
# icons for top of page or startpage
$iconGraph				= true;	// icon type header  with 2 icons for each day (12 hours data)
$topCount				= 8; // max nr of day-part forecasts in icons or graph
#       two kinds of meteograms
$yrnoMeteogram          = false; // standard yrno meteogram two days - one column per hour
$chartsMeteogram		= false; // high charts meteogram -  6 days - one colom for every 6 hours - 
$chartsMeteogramHeight  = '340px';
$MeteogramInTabs		= false; // high charts graph separate (false) or in a tab (true)
#
$yrnoTable				= false; // table with one line for every 6 hours
$yrnoDetailTable		= false; // table with one line for every 3 or 1 hours
$tableHeight            = '500px'; // no restricted height use ''  - restrict use number of pixels: '500px' 
$tableInTabs            = false; // put tables in tabs
#
# Customize the printed page settings here:
#
$includeHTML			= true; // head body css scripts  are loaded
$colorClass				= 'beige'; // pastel green blue beige orange 
$pageWidth				= '98%'; // set do disired width 999px  or 100%
#
# where are we? Specify the folder the scripts are executing from
#                       './'; => same folder as this script
#                       './wsyrnofct'; => other folder
$scriptDir	        	= './'; 
#-----------------------------------------------------------------------
# just to know which script version is executing
#-----------------------------------------------------------------------
#
$pageName				= 'printfull.php';
$pageVersion			= '3.00 2014-07-11';
$string         		= $pageName.'- version: ' . $pageVersion;
$pageFile 				= basename( __FILE__ ); // check to see this is the real script
if ( $pageFile <> $pageName ) {
	$string .= ' - ' . $pageFile . ' loaded instead';
}

echo '<!-- module loaded:' .$string . ' -->' . PHP_EOL;
$title          		= '<title>yrno  forecast. Script ' . $pageName . '</title>';
$myPage					= $pageName;
#-----------------------------------------------------------------------
# Now create all tables and graphs to be printed here
#-----------------------------------------------------------------------
$script	= $scriptDir.'yrnoGenerateHtml.php';
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
include $script;
#---------------------------------------------------------------------------
#  the following lines output the needed html if you want a stand alone page
#  this includes the CSS file used for formatting
#---------------------------------------------------------------------------
$string = ob_get_contents();
ob_end_clean();

if ( $includeHTML ) {
echo'<!DOCTYPE html>
<html lang="' . $lang . '">
<head>
	<meta name="description" content="' . $organ . ' - ' . $myPage . '>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="' . $scriptDir . 'yrno.css" media="screen" title="screen" />
	<link rel="shortcut icon" href="' . $scriptDir . 'img/icon.png" type="image/x-icon" />
	<meta name="Keywords" content="weather, Weather, temperature, dew point, humidity, forecast, Davis Vantage Pro,  Weather, Your City, weather conditions, live weather, live weather conditions, weather data, weather history, Meteohub " />
	<meta name="Description" content="Weather conditions ' . $organ . '" />
	'.$title.'
	<script type="text/javascript">
		var docready=[],$=function(){return{ready:function(fn){docready.push(fn)}}};
	</script>
</head>
<body class="' . $colorClass . '" style="text-align: center;">
<div id="pagina" style="width: ' . $pageWidth . '; "><br />' . PHP_EOL;
}
echo $string; // Display info about all loaded scripts and version numbers as html comment lines
# //  display info about all loaded scripts and version numbers as html comment lines
#
#-----------------------  I M P O R T A N T   -----------------------------
#
#	if you use your own page setup you should ADD a line with
#
#	<link rel="stylesheet" type="text/css" href="yrno.css" media="screen" title="screen" />
#
#	make sure you have the correct path set in href
#
#  	in your html so that the correct css is loaded
#---------------------------------------------------------------------------
# Now ready for printing to the screen. Use echo for that
#	$wsUpdateTimes	: this forecast en next forecast times 
#	$tableIcons	: icon 
#	$graphPart1	: javascript / highcharts graph
#	$yrnoListTable	: table with all forecast lines
#
$styleborder    = 'border: 1px inset; border-radius: 5px;';
$margin         = 'margin: 10px auto;'; 
$topWidth       = 'width: '.$defaultWidth.';';

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
	$style = 'style="' . $topWidth . $styleborder . $margin . '"';
	echo '<div id="iconGraph" ' . $style . '>';
	echo $tableIcons . PHP_EOL;
    echo '</div>' . PHP_EOL;
#	echo '<br />' . PHP_EOL;
}

if ( $yrnoMeteogram && !$MeteogramInTabs ) {
	$style  = 'style="' . $topWidth . $styleborder . $margin . 'overflow: hidden; "';
	include $scriptDir . 'yrnoavansert3.php';
	echo '<div ' . $style . '>';
	echo '<a href="http://www.yr.no/place/' . $yrnoID . '" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">' . PHP_EOL;
	echo '<img src="' . $im . '" alt="  " style=" width: 100%; height:302px;"/>' . PHP_EOL;  
	echo '</a>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}

if ( $chartsMeteogram && !$MeteogramInTabs ) { // are the graphs separate (=false) on the page or are they in a tab
	$style  = 'style="' . $topWidth . $styleborder . $margin . $chartsMeteogramHeight . '"';
	echo '<div id="containerTemp" ' . $style . '>
	here the graph will be drawn
	</div>
	<br />' . PHP_EOL;
	echo $graphPart1 . PHP_EOL;
}

if ( $tableInTabs || $MeteogramInTabs ) { // generate html for tabs
	echo '<div class="tabber"  style="' . $topWidth . ' margin: auto;">' . PHP_EOL;
}

if ( $yrnoMeteogram && $MeteogramInTabs ) {
	$style = 'style="width: 100%; overflow: hidden; "';
	include $scriptDir . 'yrnoavansert3.php';
	echo '<div class="tabbertab" style="padding: 0px;"><h2>' . yrnotransstr( 'Meteogram' ) . '</h2>' . PHP_EOL;
		echo '<div ' . $style . '>';
			echo '<a href="http://www.yr.no/place/' . $yrnoID . '" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">' . PHP_EOL;
				echo '<img src="' . $im . '" alt="  " style=" width: 100%; height:302px;"/>' . PHP_EOL;
			echo '</a>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
}

if ( $chartsMeteogram && $MeteogramInTabs ) {
	$style = 'style="width: 100%; overflow: hidden;' . $chartsMeteogramHeight . '"';
	echo '<div class="tabbertab" style="padding: 0px;"><h2>' . yrnotransstr( 'Graph' ) . '</h2>' . PHP_EOL;
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
		echo '<div class="tabbertab" ' . $style . '">' . PHP_EOL;
			echo '<h2>' . yrnotransstr( 'Forecast details' ) . '</h2>' . PHP_EOL;
			echo $yrnoDetailTable . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	
}

if ( $tableInTabs || $MeteogramInTabs ) {
	echo '</div>' . PHP_EOL;
}

if ( !$tableInTabs ) {
	
	$style = 'style="' . $topWidth . $margin . $tableHeight . ' overflow: auto;"';
	
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
  
#       IMPORTANT do not delete as legally you are bind to display 
#       credit to Metno/Yrno in original readable text, same size as average text in window

/*
$style  = 'style="'.$topWidth.$margin.'"';
echo '<div id="credit" '.$style.'>'.PHP_EOL;
        echo $creditString.PHP_EOL;
echo '</div>'.PHP_EOL;
echo '<br />'.PHP_EOL;
*/
#---------------------------------------------------------------------------
#  end of enclosing div
if ( $includeHTML ) {
	echo '</div><!-- end of pagina -->' . PHP_EOL; // end pagina div
}

#---------------------------------------------------------------------------
#  the following lines output the needed scripts / html for a stand alone page
#
#-------------------I M P O R T A N T  -------------------------------------
# now we add the needed javascripts
# if you use this script inside another script make sure you add the javascripts yourself
#---------------------------------------------------------------------------
$javaOutput = $includeHTML;		// we print javascript based on setting of enclosing html
#$javaOutput = true;			// javascripts are ALWAYS printed by removing the #

if ( $javaOutput ) {
	
	echo '<script type="text/javascript" src="' . $javascriptsDir . 'jquery.js"></script>' . PHP_EOL;
	
	if ( $tableInTabs || $MeteogramInTabs ) {
		echo '<script type="text/javascript" src="' . $javascriptsDir . 'tabber.js"></script>' . PHP_EOL;
	}
	
	echo '<script type="text/javascript" src="' . $javascriptsDir . 'highcharts.js"></script>' . PHP_EOL;
	echo '<script type="text/javascript">$=jQuery;jQuery(document).ready(function(){for(n in docready){docready[n]()}});</script>' . PHP_EOL;
	
}

if ( $includeHTML ) {
		echo '<br />
	</body>
	</html>';
}

#---------------------------------------------------------------------------
# Leave this code here .. it will help you see what language translations are missing 
# if you dont want them set next line to comment by adding a # as first cahracter on the line
$noMissingLang = true;

if ( !isset ( $noMissingLang ) || $noMissingLang  == true ) {
	
	$string='';
	
	foreach ( $missingTrans as $key => $val ) {
		$string.= "langlookup|$key|$key|" . PHP_EOL;
	}
	
	if ( strlen( $string ) > 0 ) {
		echo PHP_EOL . '<!-- missing langlookup entries for lang=' . $lang . PHP_EOL;
		echo $string;
		echo count( $missingTrans ) . ' entries found.' . PHP_EOL . 'End of missing langlookup entries -->' . PHP_EOL;
	}
	
}

?>