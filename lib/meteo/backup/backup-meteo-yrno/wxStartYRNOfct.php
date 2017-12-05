<?php
# ---------------HERE YOU NEED TO MAKE SOME CHANGES -------------------
# what parts should be printed
#
$times                  = true;        // 
#       icons for top of page or startpage
$iconGraph		= true; 	// icon type header  with 2 icons for each day (12 hours data)
$topCount		= 8;		// max nr of day-part forecasts in icons or graph
#       two kinds of meteograms
$yrnoMeteogram          = true;         // standard yrno meteogram two days - one column per hour
$chartsMeteogram	= true;	        // high charts meteogram -  6 days - one colom for every 6 hours - 
$chartsMeteogramHeight  = '340px';
$MeteogramInTabs	= false; 	// high charts graph separate (false) or in a tab (true)
#
$yrnoTable		= true;		// table with one line for every 6 hours
$yrnoDetailTable	= true;		// table with one line for every 3 or 1 hours
$tableHeight            = '500px';      // no restricted height use ''  - restrict use number of pixels: '500px' 
$tableInTabs            = true;         // put tables in tabs
#
# -------most of the other settings are copied Settings.php
# -------these you have to specify yourself 
#
$yrnoID		= 'Belgium/Flanders/Leuven';	// #####        generic adres
$iconsOwn	= true; 		        // #####        use original yrno icons or our general icons (false)
#
$lower          = false;                        // #####	convert all texts to lowercase
#
$tempSimple	= false;		        // #####        false = we want colorfull temps;  true = red blue temps
#
$hourOnlyFormat	 = 'H';		        // 14  
#$hourOnlyFormat = 'ga';                // 2pm
$dateLongFormat	 = 'l d F Y';	        // Thursday 3 january 2013
#$dateLongFormat = 'l M j Y';           // Thursday January 3 2013
#
$defaultWidth	= '98%';
# ---------------END OF USER CHANGES - LEAVE REST OF SCRIPT AS IS ------
$mypage		= 'wxStartYRNIOfct.php';        // only change this if you renamed this script
$insideTemplate = true;
$scriptDir      = './wsyrnofct/';
# ----------------display source of script if requested so -------------
#
if (isset($_REQUEST['sce']) && strtolower($_REQUEST['sce']) == 'view' ) { //--self downloader --
   $filenameReal = __FILE__;
   $download_size = filesize($filenameReal);
   header('Pragma: public');
   header('Cache-Control: private');
   header('Cache-Control: no-cache, must-revalidate');
   header("Content-type: text/plain");
   header("Accept-Ranges: bytes");
   header("Content-Length: $download_size");
   header('Connection: close');
   readfile($filenameReal);
   exit;
}
# --------------------load first part of standard scripts---------------
require_once("Settings.php");
require_once("common.php");
# ----------------------------------------------------------------------
$TITLE = langtransstr($SITE['organ']) . " - " .$mypage;
$showGizmo = false;  			// set to true to include the gizmo
#
# ----------------load second part of standard scripts------------------
include("top.php");
# ----------------    we include our own css ---------------------------
?>
<link rel="stylesheet" type="text/css" href="wsyrnofct/yrno.css" media="screen" title="screen" />
<script type="text/javascript">
        var docready=[],$=function(){return{ready:function(fn){docready.push(fn)}}};
</script>
<style type = "text/css">
</style>
</head>
<body>
<?php
# ----------------  load third part of standard scripts-----------------
include("header.php");
include("menubar.php");
# ----------------------------------------------------------------------
?>
<div id="main-copy">
<?php
# ----------------------error reporting --------------------------------
$versiontext	        = $mypage.'  version  3.00  2014-07-15';
echo '<!-- module '.$versiontext.'loaded -->'.PHP_EOL;
$wsDebug		= false;
if (isset($_REQUEST['wsdebug']) ) {
	$wsDebug	= true;
	ini_set('display_errors', 'On'); 
	error_reporting(E_ALL);	
	echo '<!-- debug is switched on by user request - error reporting ALL -->'.PHP_EOL;
}
# ----THE FOLLOWING SETTINGS ARE MOSTLY COPIED FROM SETTINGS.PHP -------
#
$organ		= $SITE['organ'];
$yourArea	= $SITE['cityname'];
$latitude	= $SITE['latitude'];
$longitude	= $SITE['longitude'];
$charset        = $SITE['charset'];
#
$uomTemp	= $SITE['uomTemp'];
$uomRain	= $SITE['uomRain'];
$uomWind 	= $SITE['uomWind'];
$uomBaro	= $SITE['uomBaro'];
$uomSnow        = $SITE['uomSnow'];
$uomDistance    = $SITE['uomDistance'];
#
$timeFormat	= $SITE['timeFormat'];
$timeOnlyFormat	= $SITE['timeOnlyFormat'];
$dateOnlyFormat	= $SITE['dateOnlyFormat'];
#
$timezone	= $SITE['tz'];

# --------------END OF SETTINGS COPIED FROM SETTINGS.PHP ---------------
$script	= $scriptDir.'yrnoGenerateHtml.php';
echo '<!-- trying to load '.$script.' -->'.PHP_EOL;
include $script;
#
$styleborder    = ' border: 1px inset; border-radius: 5px;';
$margin         = ' margin: 10px auto;'; 
$topWidth       = ' width: '.$defaultWidth.';';
if ($chartsMeteogramHeight <> '' ) {
        $chartsMeteogramHeight  = 'height: '.$chartsMeteogramHeight.';';
}
if ($tableHeight <> '') {
	$tableHeight            = 'height: '.$tableHeight.';';
}
#
if ($times) {
        $style  = 'style="" ';
        echo '<div id="times" style="" >'.PHP_EOL;
        echo $wsUpdateTimes.PHP_EOL;
        echo '</div>'.PHP_EOL;
}
#
if ($iconGraph) {
        $style  = 'style="'.$topWidth.$styleborder.$margin.'"';
	echo '<div id="iconGraph" '.$style.'>';
	echo $tableIcons.PHP_EOL;
        echo '</div>'.PHP_EOL;
#	echo '<br />'.PHP_EOL;
}
if ($yrnoMeteogram && !$MeteogramInTabs) {
        $style  = 'style="'.$topWidth.$styleborder.$margin.'overflow: hidden; "';
        include $scriptDir.'yrnoavansert3.php';
        echo '<div '.$style.'>';
        echo '  <a href="http://www.yr.no/place/'.$yrnoID.'" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">'.PHP_EOL;
        echo '     <img src="'.$im.'" alt="  " style="vertical-align: top; width: 100%; height:302px;"/>'.PHP_EOL;  
        echo '  </a>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
}
if ($chartsMeteogram && !$MeteogramInTabs) {		// are the graphs separate (=false) on the page or are they in a tab
        $style  = 'style="'.$topWidth.$styleborder.$margin.$chartsMeteogramHeight.'"';
        echo '<div id="containerTemp" '.$style.'>
        here the graph will be drawn
        </div>
        <br />'.PHP_EOL;
        echo $graphPart1.PHP_EOL;
}
if ($tableInTabs || $MeteogramInTabs) { // generate html for tabs
        echo '<div class="tabber"  style="'.$topWidth.' margin: auto;">'.PHP_EOL;
}
if ($yrnoMeteogram && $MeteogramInTabs) {
        $style  = 'style="width: 100%; overflow: hidden; "';
        include $scriptDir.'yrnoavansert3.php';
        echo '<div class="tabbertab" style="padding: 0px;"><h2>'.yrnotransstr('Meteogram').'</h2>'.PHP_EOL;
                echo '<div '.$style.'>';
                echo '  <a href="http://www.yr.no/place/'.$yrnoID.'" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">'.PHP_EOL;
                echo '          <img src="'.$im.'" alt="  " style="vertical-align: top;  width: 100%; height:302px;"/>'.PHP_EOL;  
                echo '  </a>'.PHP_EOL;
                echo '</div>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
}
if ($chartsMeteogram && $MeteogramInTabs) {
        $style  = 'style="width: 100%; overflow: hidden; '.$chartsMeteogramHeight.'"';
        echo '<div class="tabbertab" style="padding: 0px;"><h2>'.yrnotransstr('Graph').'</h2>'.PHP_EOL;
                echo '<div id="containerTemp" '.$style.'>';
                echo 'here the graph will be drawn</div>'.PHP_EOL;
                echo $graphPart1.PHP_EOL;
        echo '</div>'.PHP_EOL;	 
}
if ($tableInTabs) {
        $style  = 'style="padding: 0px;'.$tableHeight.'"';
        if ($yrnoTable) {
                echo '<div class="tabbertab" '.$style.'>'.PHP_EOL;
                        echo '<h2>'.yrnotransstr('Forecast by 6 hour intervals').'</h2>'.PHP_EOL;
                        echo $yrnoListTable.PHP_EOL;
                echo '</div>'.PHP_EOL;
        }
        if ($yrnoDetailTable) {
                echo '<div class="tabbertab" '.$style.'">'.PHP_EOL;
                        echo '<h2>'.yrnotransstr('Forecast details').'</h2>'.PHP_EOL;
                        echo $yrnoDetailTable.PHP_EOL;
                echo '</div>'.PHP_EOL;
        }
 }       
if ($tableInTabs || $MeteogramInTabs) {
        echo '</div>'.PHP_EOL;
}
if (!$tableInTabs) {
        $style  = 'style="'.$topWidth.$margin.$tableHeight.' overflow: auto;"';
        if ($yrnoTable) {       
                echo '<div '.$style.'>'.PHP_EOL;
                        echo $yrnoListTable.PHP_EOL;
                echo '</div>'.PHP_EOL;
        }
        if ($yrnoDetailTable) {
                echo '<div '.$style.'>'.PHP_EOL;
                        echo $yrnoDetailTable.PHP_EOL;
                echo '</div>'.PHP_EOL;
        }
}
#	    
#       IMPORTANT do not delete as legally you are bind to display 
#       credit to Metno/Yrno in original readable text, same size as average text in window
#
$style  = 'style="'.$topWidth.$margin.'"';
echo '<div id="credit" '.$style.'>'.PHP_EOL;
        echo $creditString.PHP_EOL;
echo '</div>'.PHP_EOL;
echo '<br />'.PHP_EOL;
#-------------------I M P O R T A N T  -------------------------------------
# now we add the needed javascripts if we display the graphs
#---------------------------------------------------------------------------
#
if ($chartsMeteogram) {
	echo '<script type="text/javascript" src="'.$javascriptsDir.'jquery.js"></script>'.PHP_EOL;
        if ($tableInTabs || $MeteogramInTabs) {
	        echo '<script type="text/javascript" src="'.$javascriptsDir.'tabber.js"></script>'.PHP_EOL;
	}
	echo '<script type="text/javascript" src="'.$javascriptsDir.'highcharts.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">$=jQuery;jQuery(document).ready(function(){for(n in docready){docready[n]()}});</script>'.PHP_EOL;
}?>
</div><!-- end main-copy -->
<?php
# ----------------  load LAST part of standard scripts-------------------
include("footer.php");
?>