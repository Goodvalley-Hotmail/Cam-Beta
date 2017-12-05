<?php

#-----------------------------------------------------------------------
# display source of script if requested so
#-----------------------------------------------------------------------
if ( isset( $_REQUEST['sce'] ) && strtolower( $_REQUEST['sce'] ) == 'view' ) {
   //--self downloader --
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

$pageName		='yrnoGenerateHtml.php';
$pageVersion	= '3.01 2015-10-08';
$string         = $pageName.'- version: ' . $pageVersion;
$pageFile 		= basename( __FILE__ ); // check to see this is the real script

if ( $pageFile <> $pageName ) {
	$string .= ' - ' . $pageFile . ' loaded instead';
}

echo '<!-- module loaded:' . $string . ' -->' . PHP_EOL;
#-----------------------------------------------------------------------
#
$script	= $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-page/yrnosettings.php'; // we need hard coded directory path here because settings are not loaded yet.
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
include $script;
#
$script	= $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-page/yrnoCreateArr.php';
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
include $script;
$weather 		= new yrnoWeather ();
$returnArray 	= $weather->getWeatherData( $yrnoID );
unset( $weather );
#
# Time to generate the html
// temparray 2 starts at -30C, so add 30 to C temp
// for F subtract 2 to arrive at 0C = 32F
$tempArray2 = array(
	'#F6AAB1', '#F6A7B6', '#F6A5BB', '#F6A2C1', '#F6A0C7', '#F79ECD', '#F79BD4', '#F799DB', '#F796E2', '#F794EA', 
	'#F792F3', '#F38FF7', '#EA8DF7', '#E08AF8', '#D688F8', '#CC86F8', '#C183F8', '#B681F8', '#AA7EF8', '#9E7CF8', 
	'#9179F8', '#8477F9', '#7775F9', '#727BF9', '#7085F9', '#6D8FF9', '#6B99F9', '#68A4F9', '#66AFF9', '#64BBFA', 
	'#61C7FA', '#5FD3FA', '#5CE0FA', '#5AEEFA', '#57FAF9', '#55FAEB', '#52FADC', '#50FBCD', '#4DFBBE', '#4BFBAE', 
	'#48FB9E', '#46FB8D', '#43FB7C', '#41FB6A', '#3EFB58', '#3CFC46', '#40FC39', '#4FFC37', '#5DFC35', '#6DFC32', 
	'#7DFC30', '#8DFC2D', '#9DFC2A', '#AEFD28', '#C0FD25', '#D2FD23', '#E4FD20', '#F7FD1E', '#FDF01B', '#FDDC19', 
	'#FDC816', '#FDC816', '#FEB414', '#FEB414', '#FE9F11', '#FE9F11', '#FE890F', '#FE890F', '#FE730C', '#FE730C', 
	'#FE5D0A', '#FE5D0A', '#FE4607', '#FE4607', '#FE2F05', '#FE2F05', '#FE1802', '#FE1802', '#FF0000', '#FF0000',
);

$dateTimeFormat = $timeFormat;
$timeFormat 	= $timeOnlyFormat;
$dateFormat 	= $dateOnlyFormat;
$utcDiff 		= date( 'Z' ); // used for graphs timestamps
$forecasts		= 0;
$dayParts		= array ( yrnotransstr( 'night' ), yrnotransstr( 'morning') , yrnotransstr( 'afternoon' ), yrnotransstr( 'evening' ) );
#echo '<pre>'; print_r($returnArray['forecast']);
# informative text with update times and name of forecast area
# --------------
# text for top of page time/date of updates
$fileTime		= strtotime( $returnArray['request_info']['lastupdate'] );
$string 		= date( ' d M Y H', $fileTime );
$nextUpdate 	= strtotime( $returnArray['request_info']['nextupdate'] );
#echo '<pre>'; print_r ($returnArray); exit;
$wsUpdateTimes  = '
<div style="text-align: left; margin:  0px 10px 10px 10px;">
<span style="float:right;text-align:right;">';
$wsUpdateTimes .= 	yrnotransstr( 'Updated' ) . ': ' . myLongDate ( $fileTime ) . ' - ' . date ( $timeFormat, $fileTime ) . '<br />';
$wsUpdateTimes .= 	yrnotransstr( 'Next update' ) . ': ' . myLongDate ( $nextUpdate ) . ' - ' . date ( $timeFormat, $nextUpdate ) . '
</span>
<h4 style="margin: 0px;">' . yrnotransstr( 'MetNoForecast.' ) . ' ' . yrnotransstr( $yourArea ) . '
<br />' . yrnotransstr( 'by:' ) . ' ' . $organ . '</h4>';
$wsUpdateTimes .= '</div>';
#echo $wsUpdateTimes . '<pre>'; print_r( $returnArray ); exit;
# we loop through all data and build arrays for the coloms of the output.
$foundFirst		= '';
$arrTime 		= array ();
$arrTimeGraph 	= array ();
$arrDay 		= array ();
$arrIcon		= array ();
$arrIconGraph	= array ();
$arrDesc		= array ();
$arrTemp		= array ();
$arrTempGraph	= array ();
$arrRain		= array ();
$arrRainGraph	= array ();
$arrCoR			= array ();
$arrCoT			= array ();
$arrCoS			= array ();
$arrWind		= array ();
$arrWindGraph	= array ();
$arrWdir		= array ();
$arrWdirGraph	= array ();
$arrWindIcon    = array ();
$arrBaro		= array ();
$arrBaroGraph	= array ();
$graphsDays     = array ();
$oldDay			= ''; // to detect day changes in input
$graphsData		= ''; // we store all javascript data here
$graphLines     = 0; // number of javascript data lines
$graphsStop     = 0;
$graphsStart    = 0;
$graphTempMin   = 100;
$graphTempMax   = -100;
$graphBaroMin   = 2000;
$graphBaroMax   = 0;
$graphRainMax   = 0;
$graphWindMax   = 0;
#
$rowColor		= 'row-dark';
$yrnoListTable 	= '<table class="genericTable" style="width: 100%;"><tbody>' . PHP_EOL;
$yrnoListHead   = '<tr class="table-top">
<td>' . yrnotransstr( 'Period' ) . '</td><td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
<td>' . yrnotransstr( 'Temperature' ) . '</td><td>' . yrnotransstr( 'Precipitation' ) . '</td>
<td>' . yrnotransstr( 'Wind' ) . '</td><td>' . yrnotransstr( 'Pressure' ) . '</td>
</tr>' . PHP_EOL;
#
$now 	= time();
$oldDay = '';

for ( $i = 0; $i < count( $returnArray['forecast'] ); $i++ ) {

	$arr 	= $returnArray['forecast'][$i];

	if ( $now > $arr['timeTo'] ) {
		continue;
	}

	if ( $oldDay <> $arr['date'] ) { // do we have a new day
		$oldDay 		= $arr['date'];
		$rowColor 		= 'row-dark';
		$graphsDays[] 	= 1000 * ( strtotime( $arr['date'] . 'T00:00:00Z' ) );
		$cols           = '7';
		$yrnoListTable .= myDateLinePrint( $arr['timeTo'] );
		$yrnoListTable .= $yrnoListHead;
		$rowColor 		= 'row-dark';
	} //

	# first some housekeeping
	#	translate icon
	if ( ( 1.0 * $arr['hour'] == 0 ) || ( 1.0 * $arr['hour'] == 3 ) ) {
		$imgstr = 'n';
	}  else {
		$imgstr = 'd';
	}

	if ( strlen( $arr['icon'] ) == 1 ) {
		$arr['icon'] = '0' . $arr['icon'] . $imgstr;
	} else {
		$arr['icon'] = $arr['icon'] . $imgstr;
	}

	# Now the javascript graph
	# time
	$arrTimeGraph[$graphLines]	= $arr['timestamp'] + $utcDiff;

	# icon
    $iconIn                     = $arr['icon'];
    list ( $url, $urlsmall ) 	= yrnoIcon ( $iconIn );
	$arrIconGraph[$graphLines]	= $urlsmall;
	
	# rain	
	if ( !isset ( $arr['rainNU'] ) ) {

		$value = '-';

	} else {

		$value = $arr['rainNU'];

		if ( $value > $graphRainMax ) {
			$graphRainMax = $value;
		}

	}

	$arrRainGraph[$graphLines] = $value;

	# baro	
	$value = $arr['baroNU'];
	
	if ( $value > $graphBaroMax ) {
		$graphBaroMax = $value;
	}

	if ( $value < $graphBaroMin ) {
		$graphBaroMin = $value;
	}

	$arrBaroGraph[$graphLines] = $value;

	# temp
	$value = $arr['tempNU'];

	if ( $value > $graphTempMax ) {
		$graphTempMax = $value;
	}

	if ( $value < $graphTempMin ) {
		$graphTempMin = $value;
	}

	$arrTempGraph[$graphLines]	= $value;

	# wind
	$value = $arr['windSpeedNU'];

	if ( $value > $graphWindMax ) {
		$graphWindMax = $value;
	}

	$arrWindGraph[$graphLines]	= $value;
	$arrWdirGraph[$graphLines]	= $arr['windDir'];
	
	# store all javascript data	
	$readTime	= date( $timeFormat, $arrTimeGraph[$graphLines] );
	$graphsData	.= 	'tsv[' . $graphLines . '] ="' . 
					$arrTimeGraph[$graphLines] . '|' . 
					$arrTempGraph[$graphLines] . '|' . 
					$arrBaroGraph[$graphLines] . '|' . 
					$arrWindGraph[$graphLines] . '|' . 
					$arrWdirGraph[$graphLines] . '|' . 
					( $arrTimeGraph[$graphLines] - 2 * 3600 ) . '|' . $arrRainGraph[$graphLines] . '|' . 		
					( $arrTimeGraph[$graphLines] - 2 * 3600 ) . '|' . $arrIconGraph[$graphLines] . '|' . $readTime . '";' . PHP_EOL;
				
	$graphLines++;
#
# now the yrno list table
	$yrnoListTable .='<tr class="' . $rowColor . '">' . PHP_EOL;

	if ( $rowColor == 'row-dark' ) {
		$rowColor = 'row-light';
	} else {
		$rowColor =  'row-dark';
	}

	$to 	= ( string ) date( $hourOnlyFormat, $arr['timeTo'] );
	$start  = ( string ) date( $hourOnlyFormat, $arr['timeFrom'] );
	$period = $start . ' - ' . $to;
	$rain = '';

	if ( isset ( $arr['rain'] ) && $arr['rainNU'] <> 0 ) {
		$rain = $arr['rain'];
	}

	$temp 		= $arr['tempNU'];
	$tempString	= myCommonTemperature( $temp );
	# $tempString = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';	
	$windSpeed	= $arr['windSpeedNU'];
	list ($value, $color, $tekst) = yrnobeaufort( $windSpeed, $toWind );
	# $value 	= wsBeaufortNumber( $windSpeed, $uomWind );
	# $color 	= wsBeaufortColor( $value );
	$tekst		= yrnotransstr( $arr['windTxt'] );
	$windText	='<span style="background-color: ' . $color . ';">' . $arr['windSpeed'] . ' - ' . $tekst . '</span>';
	$wind		= $windText . '<br />' . yrnotransstr( 'from the' ) . ' ' . yrnotransstr( $arr['windDir'] );
	$notUsed 	= $iconUrl = $iconOut = $iconUrlOut = '';
    $iconIn 	= $arr['icon'];
    list ( $url, $urlsmall ) = yrnoIcon ( $iconIn );
	$description = yrnotransstr( $arr['weatherDesc'] );
	$icon = '<img src="' . $url . '" alt =" " width ="40" title="' . $description . '"/>';
	$yrnoListTable .='<td>' . $period . '</td><td>' . $description . '</td>
	<td>' . $icon . '</td><td>' . $tempString . '</td>
	<td>' . $rain . '</td><td>' . $wind . '</td><td>' . $arr['baro'] . '</td></tr>' . PHP_EOL;
	#
	$forecasts++;
	$arrTime[] = $arr['timeTo'];
	$timecheck = $arr['timeFrom'];
	# $nightDayBefore = false;	// if night not listed for previous day
	
	if ( !isset( $nightDayBefore ) || $nightDayBefore == true ) {
	    $timecheck 	= $timecheck - ( 6 - $offset ) * 60 * 60;
	    $dayText 	= yrnotransstr( date( 'l', $timecheck ) );
		# echo 'halt'; exit;

	} else {
		$timecheck 	= $timecheck + $offset * 60 * 60;
	    $dayText 	= yrnotransstr( date( 'l', $timecheck ) );
	}

	$dayText2 = $dayParts[$arr['hour']];

	if ( $foundFirst === '' ) { // do first time things

		$foundFirst = 'xx';
		$dayString 	= yrnotransstr( 'this' ) . '<br />' . $dayText2;
		$arrDay[]	= $dayString;

	} else {

		$arrDay[]	= $dayText . '<br />' . $dayText2;

	}

	$notUsed 		= $iconUrl = $iconOut = $iconUrlOut = '';
    $iconIn     	= $arr['icon'];
    list ( $url, $urlsmall )  = yrnoIcon( $iconIn );
	$arrIcon[]		= $url;
	$arrDesc[]		= yrnotransstr( $arr['weatherDesc'] );
	$arrTemp[]		= $arr['tempNU'];
	$arrRain[]		= $arr['rainNU'];
	$arrWind[]		= $arr['windSpeed'];
	# $arrWdir[]	= $arr['windDir'];	
	$arrWindIcon[]	= $arr['windDir'];
	$arrBaro[]		= $arr['baroNU'];

}

#print_r( $arrDay );
$yrnoListTable .= '</tbody></table>' . PHP_EOL;

if ( count( $arrTime ) < $topCount ) {
	$end = count( $arrTime );
} else {
	$end = $topCount;
}

$topCount 	= $end;
$iconWidth	= 100 / $topCount;
$tableIcons = '
	<!-- start icon output -->
	<table class=" genericTable" style=" background-color: transparent;">
		<tbody>
 			<tr>' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$tableIcons .= '<td style="width: ' . $iconWidth . '%;" >' . $arrDay[$i] . '</td>' . PHP_EOL;
}

$tableIcons .= '</tr>
<tr>' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt ="" width ="40" title="' . $arrDesc[$i] . '"/>';
	$tableIcons .= '<td style="width:' . $iconWidth . '%;">' . $icon . '<br />' . $arrDesc[$i] . '</td>' . PHP_EOL;
}

$tableIcons .= '</tr>
<tr>' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$temp 	= round( $arrTemp[$i] );
	$string = myCommonTemperature( $temp );
	#$string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';	
	$tableIcons .= '<td>' . $string . '</td>' . PHP_EOL;
}

$tableIcons .= '</tr>
<tr>' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$tableIcons .= '<td>' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
}

$tableIcons .= '</tr>
<tr>' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$stringWind = '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" /><br />' . $arrWind[$i];
	$tableIcons .=  '<td>' . $stringWind . '</td>' . PHP_EOL;	
}

$tableIcons .= '</tr>
</tbody></table>
<!-- end icon ouptput -->
' . PHP_EOL;

# now we are going to generate the javascript graphs
# calculate Y axis steps for graphs
$graphNrLines	= 6;
$graphTempMin	= $tempMin = floor ( $graphTempMin ); // round down
$graphTempMax	= ceil( $graphTempMax ); // round up
$stringY 		= '<!-- temp max: ' . $graphTempMax . ' temp min: ' . $graphTempMin;
$graphTempStep	= 2 * ceil( ( $graphTempMax - $graphTempMin ) / $graphNrLines );
$stringY 		.= ' temp step: ' . $graphTempStep;

/*
if ( $graphTempMin < 0 ) {
	$result = abs( $graphTempMin ) / $graphTempStep;
	$result = ceil ( $result );
	$graphTempMin = -1 * $result * $graphTempStep;
} else {
	$result = floor ( $graphTempMin / $graphTempStep );
	$graphTempMin = $result * $graphTempStep;
}
*/

$graphTempMax 		= $graphTempStep * ceil( $graphTempMax / $graphTempStep );
$tempMax			= $graphTempMax;
$tempMin			= $tempMin - $graphTempStep;
$graphTempMax		= $graphTempMax	+  $graphTempStep;
$graphTempMin   	= $graphTempMax - ( 1 + $graphNrLines ) * $graphTempStep;
$stringY 			.= '  temp max: ' . $graphTempMax . ' temp min: ' . $graphTempMin;
$graphIconYvalue 	= $graphTempMax - ( $graphTempStep / 2 );
#$graphIconYvalue 	= $graphTempMax;
$stringY 			.= ' icon: ' . $graphIconYvalue . ' -->' . PHP_EOL;
#
$rainMax 			= $graphRainMax;

if ( preg_match( "|mm|", $uomRain ) ) {

	if ( $graphRainMax < 3.5 ) {
		$graphRainMax = 3.5;
	}

	$graphRainStep	= round ( ( $graphRainMax / $graphNrLines ),0 );
	$graphRainMax	=  $graphRainStep * $graphNrLines;

} else {

	if ( $graphRainMax < 1.3 ) {

		$graphRainMax = 14;

	} else {

		$graphRainMax = 10 * $graphRainMax;

	}

	$graphRainStep	= ( ceil( $graphRainMax / $graphNrLines ) ) / 10;
	$graphRainMax	= $graphRainStep * $graphNrLines;

}

$graphRainMax	= $graphRainMax	* 2;
$graphRainStep	= $graphRainStep * 2;
$rainMax		= $rainMax + $graphRainStep;
$stringY 		.= '<!-- rain max: ' . $graphRainMax . '   rain step: ' . $graphRainStep . ' -->' . PHP_EOL;
$baroMax		= $graphBaroMax;
$baroMin		= $graphBaroMin;

if ( preg_match( "|hPa|", $uomBaro ) || preg_match( "|mb|", $uomBaro ) ) {

	$graphBaroDiff = $graphBaroMax - $graphBaroMin;

	if ( ceil( $graphBaroDiff / 15 ) <= $graphNrLines ) {

		$graphBaroStep = 15;

	} else {

		$graphBaroStep = 20;
	}

	$graphBaroMax  = $graphBaroStep * ( ceil( $graphBaroMax / $graphBaroStep ) );

	if ( $graphBaroMax < 1035 ) {

		$graphBaroMax = 1035;

	}

	$graphBaroMin = $graphBaroMax - $graphNrLines * $graphBaroStep;

} else { // inHg

	$graphBaroMax = 32; $graphBaroMin = 28.5; $graphBaroStep = .5;

}

$baroMax = $baroMax + $graphBaroStep;
$baroMin = $baroMin - $graphBaroStep;
$stringY .='<!-- baro max: ' . $graphBaroMax . ' baro min: ' . $graphBaroMin . '-->' . PHP_EOL;

if ( $graphWindMax < $graphNrLines ) {
	$graphWindMax = $graphNrLines;
}

$graphWindStep 	= ceil( $graphWindMax / $graphNrLines );
$graphWindMax  	= $graphNrLines * $graphWindStep;
$windMax		= $graphWindMax;
$graphWindMax  	= $graphWindMax	* 2;
$graphWindStep 	= $graphWindStep * 2;
$stringY 		.='<!-- wind max: ' . $graphWindMax . ' wind step: ' . $graphWindStep . '-->' . PHP_EOL;
echo $stringY;
#
$graphDaysString = '{';
$daysShort 		 = array ( 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' );
$daysLong 		 = array ( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' );

for ( $i = 0; $i < count ( $daysShort ); $i++ ) {
	$graphDaysString .= "'$daysShort[$i]':'" . yrnotransstr( $daysLong[$i] ) . "',";
}

$graphDaysString 	= substr( $graphDaysString, 0, strlen( $graphDaysString ) -1 );
$graphDaysString 	.= '}';
$graphsStart 		= 1000 * ( $arrTime[0] - 10800 + $utcDiff );
$n					= count( $arrDay ) - 1;
$graphsStop			= 1000 * ($arrTime[$n] + 3600 + $utcDiff );
$ddays				= '';
#
for( $i = 0 ; $i < count( $graphsDays ); $i++ ) { // shaded background every other day

	if ( $i ==  count( $graphsDays ) - 1 ) { // last incomplete day

		$ddays .= '{ from: ' . $graphsDays[$i] . ', to: ' . ( $graphsStop ) . ', color: "rgba(255, 255, 255, 0.6)" },';

	} else {

		$ddays .= '{ from: ' . $graphsDays[$i] . ', to: ' . $graphsDays[$i + 1] . ', color: "rgba(255, 255, 255, 0.9)" },';
	}

	$i++; // skip next day
}

$from 		= array ( '&deg;', ' ', '/' );
$graphRain 	= str_replace ( $from, '', $uomRain );
$graphTemp 	= str_replace ( $from, '', $uomTemp );
$graphBaro 	= str_replace ( $from, '', $uomBaro );
$graphWind 	= str_replace ( $from, '', $uomWind );
$negValue 	= "return '<span style=\"fill: blue;\">' + this.value + '</span>'";
$posValue 	= "return '<span style=\"fill: red;\">' + this.value + '</span>'";

$graphPart1 = '
	<script type="text/javascript">
	<!--
	var days        = ' . $graphDaysString . ';

	var globalX = [{
		type: "datetime",
		min: ' . $graphsStart . ',
		max: ' . $graphsStop . ',
		plotBands: [' . substr( $ddays, 0, -1 ) . '],
		title: {text: null},
		dateTimeLabelFormats: {day: "%H",hour: "%H"},	
		tickInterval: 6 * 3600 * 1000,	
		gridLineWidth: 0.4,      
		lineWidth: 0,
		labels: {y: 20,style:{fontWeight: \'normal\',fontSize:\'10px\'},
			formatter: function() { 
				var uh = Highcharts.dateFormat("%H", this.value);
				if(uh=="12"){return Highcharts.dateFormat("%H <br />", this.value) + days[Highcharts.dateFormat("%a", this.value)];}
				else{return Highcharts.dateFormat("%H", this.value);}
			}
		}
	}];
	-->
	</script>
	';

$graphPart1 .='
	<script type="text/javascript">
	<!--
	var tsv = [];
	' . $graphsData . '
	var temps = [],
	wsps = [],
	baros = [],
	precs = [],
	icos = [];
	for (j = 0; j < tsv.length; j++) {
		var line =[];
		line = tsv[j].split("|");
		if(line[0].length > 0 && parseInt(line[0]) != "undefined"){
	    	date = 1000 * parseInt(line[0]);
	    	d = new Date (date);
			temps.push([date, parseFloat(line[1])]);
			baros.push([date, parseFloat(line[2])]);
			mkr = "' . $iconsWindSmall . '" +line[4]+".png";
			str = {x:date,y:parseFloat(line[3]), marker:{symbol:\'url(\'+mkr+\')\'}};
			wsps.push(str);
			if (line[6] != \'-\') {
				date = 1000 * parseInt(line[5]);
				precs.push([date, parseFloat(line[6])]);
				date = 1000 * parseInt(line[7]);
				mkr = line[8];
				str = {x:date,y:' . $graphIconYvalue . ', marker:{symbol:\'url(\'+mkr+\')\'}};
				icos.push(str); 
			}
	    } // Line contains correct data           
	}; // eo for each tsv

	var yTitles 	= {color: "#000000", fontWeight: "bold", fontSize:"10px"};
	var yLabels 	= {color: "#4572A7", fontWeight: "bold", fontSize:"8px"};
	var yLabelsWind = {color: "#1485DC", fontWeight: "bold", fontSize:"8px"};
	var yLabelsBaro = {color: "#9ACD32", fontWeight: "bold", fontSize:"8px"};

	$(document).ready(function() {
		Highcharts.setOptions({
			chart: {
			    spacingTop:4,
				renderTo: "placeholder",
				defaultSeriesType: "spline",
				backgroundColor: "rgba(255, 255, 255, 0.4)",
				plotBackgroundColor: {linearGradient: [0, 0, 0, 150],stops: [[0, "#ddd"],[1, "rgba(255, 255, 255, 0.4)"]]},
				plotBorderColor: "#88BCCE",
				plotBorderWidth: 0.5,
				marginRight: 60,
				marginTop: 30,
				marginLeft: 60,
				style: {fontFamily: \'"UbuntuM","Lucida Grande",Verdana,Helvetica,sans-serif\',fontSize:\'11px\'}
			},
			title: {text: ""},
			xAxis: globalX,
			lang: {thousandsSep: ""},
			credits: {enabled: false},
			plotOptions: {
				series: {marker: { radius: 0,states: {hover: {enabled: true}}}},
				spline: {lineWidth: 1.5, shadow: false, cursor: "pointer",states:{hover:{enabled: false}}},
				column: {pointWidth:15},
				areaspline: {lineWidth: 1.5, shadow: false,states:{hover:{enabled: false}}}
			},
			legend: { borderWidth: 0, align: \'center\', verticalAlign: \'top\', rtl: true},
			exporting: {enabled:false},
			tooltip: {
	            positioner: function () {return { x: 0};},
				backgroundColor: "#A2D959",
	         	borderColor: "#fff",
	         	borderRadius: 3,
	         	borderWidth: 0,  
	         	shared: true,
	         	crosshairs: { width: 0.5,color: "#666"},
	         	style: {lineHeight: "1.3em",fontSize: "11px",color: "#000"},
	         	formatter: function() {
	              var s = "" + days[Highcharts.dateFormat(\'%a\', this.x)]+" "+ Highcharts.dateFormat(\'%H:%M\', this.x) +"";
	              $.each(this.points, function(i, point) {
					var unit = {
					   "' . yrnotransstr( 'Precipation' ) . '": " ' . $graphRain . '",
					   "' . yrnotransstr( 'Wind' ) . '": " ' . $graphWind . '",
					   "' . yrnotransstr( 'Temperature' ) . '": "°' . $graphTemp . '",
					   "' . yrnotransstr( 'Pressure' ) . '": " ' . $graphBaro . '"
					}[point.series.name];
					if(point.series.name != " ") {
						s += "<br/>"+point.series.name+": <b>"+point.y+unit+"</b>";
					}				     
	            });  // eo each
	            return s;
	         }
	      }
		});  // eo set general options
	   chartTempData  = new Highcharts.Chart({
	        chart: {events: {load: applyGraphGradient}, renderTo: "containerTemp" },		
	      	yAxis: [
	      	{ lineWidth: 2, 
	          gridLineWidth: 0.4, min: ' . $graphTempMin . ',max:' . $graphTempMax . ',tickInterval:' . $graphTempStep . ', offset: 25,
	          title: {text: "°' . $graphTemp . '", rotation: 0, align:"high", offset: 4, y: 0, style:yTitles},
	          labels: {x: -4, y: 1, formatter: function() {if (this.value < ' . $tempMin . ' || this.value > ' . $tempMax . ' ){ return ""; } 
	          else
	          {if (this.value < 0) {' . $negValue . ';} else {' . $posValue . ';}}
	          },style:yLabels}       
	      	},
	      	{ 
	          gridLineWidth: 0, min: 0,max:' . $graphRainMax . ',tickInterval:' . $graphRainStep . ', offset: 0,
	          title: {text: "' . $graphRain . '", rotation: 0, align:"low", offset: 0,x: -30, y: 15, style:yTitles},
	          labels: {align: "left", x: -20, y: 1,  formatter: function() {if (this.value < 0 || this.value > ' . $rainMax . ' ){ return ""; } else {return this.value;}},style:yLabels}
	      	},
	      	{ 
	          gridLineWidth: 0, min: 0, max: ' . $graphWindMax . ', tickInterval: ' . $graphWindStep . ', opposite: true,
	          title: {text: "' . $graphWind . '", rotation:0, align:"low", offset: 5,x: 0, y: 15, style:yTitles},      
	          labels: {align: "right",x: 25, y: 1, formatter: function() {if (this.value < 0 || this.value > ' . $windMax . ' ){ return ""; } else {return this.value;}},style:yLabelsWind}      
	      	},
	      	{ lineWidth: 2, 
	          gridLineWidth: 0, min: ' . $graphBaroMin . ',max: ' . $graphBaroMax . ',tickInterval: ' . $graphBaroStep . ',opposite: true, offset: 30,
	          title: {text:"' . $graphBaro . '", rotation: 0, align:"high", offset: 20, y: 0, style:yTitles},        
	          labels: {align: "left",x: 4, y: 1, formatter: function() {if (this.value < ' . $baroMin . ' || this.value > ' . $baroMax . ' ){ return ""; } else {return this.value;}},style:yLabelsBaro}
	        }
	       	],
	      	series: [
	      		{name: "' . yrnotransstr( 'Wind' ) . '", data: wsps,  color:"#1485DC",yAxis:2},
	      		{name: "' . yrnotransstr( 'Pressure' ) . '",data: baros,color: "#9ACD32",yAxis: 3},
	      		{name: "' . yrnotransstr( 'Precipation' ) . '",data: precs,color:"#4572A7",type:"column",yAxis:1},
	      		{name: "' . yrnotransstr( 'Temperature' ) . '",data: temps,color:"#EE7621"},
	      		{name: " ",data:icos ,color:"transparent",type:"",events:{legendItemClick:false}}
	      	]
	        });  // eo chart    
	/**
	 * Event handler for applying different colors above and below a threshold value. 
	 * Currently this only works in SVG capable browsers. A full solution is scheduled
	 * for Highcharts 3.0. In the current example the data is static, so we dont need to
	 * recompute after altering the data. In dynamic series, the same event handler 
	 * should be added to yAxis.events.setExtremes and possibly other events, like
	 * chart.events.resize.
	 */
	function applyGraphGradient() { 
	    // Options
	    var threshold = 0,
	        colorAbove = "#EE4643",
	        colorBelow = "#4572EE";   
	    // internal
	    var series = this.series[3],  i,point;      
	    if (this.renderer.box.tagName === "svg") {  
	        var translatedThreshold = series.yAxis.translate(threshold),
	            y1 = Math.round(series.yAxis.len - translatedThreshold),
	            y2 = y1 + 2; // 0.01 would be fine, but IE9 requires 2     
	        // Apply gradient to the path
	        series.graph.attr({
	            stroke: {
	                linearGradient: [0, y1, 0, y2],
	                stops: [
	                    [0, colorAbove],
	                    [1, colorBelow]
	                ]
	            }
	         });      
	    }
	    // prevent the old color from coming back after hover
	    delete series.pointAttr.hover.fill;
	    delete series.pointAttr[""].fill;  
	}
	}); // eo document ready
	-->
	</script>' . PHP_EOL;	

$logoMetYr = '<img src="' . $imgDir . 'met.no_logo2_eng_250px.jpg" style="height: 30px; margin: 4px 4px 4px 4px;" alt="Met.No - Yr.No logo"/>';
$creditString = '<div>
<table style="width: 100%;"><tr><td>' . $logoMetYr . '</td><td>
<small>Meteogram and script developed by <a target="_blank" href="http://www.weerstation-leuven.be"> WeerstationLeuven</a>.&nbsp;&nbsp;
Graphs are drawn using <a target="_blank"  href="http://www.highcharts.com">Highcharts</a><br />
Weather <a target="new" href="http://www.yr.no/?lang=en">forecast</a> from yr.no, 
delivered by the Norwegian Meteorological Institute and the NRK. 
</small></td></tr></table>
</div>';

# now we generate the detail table if needed
if ( !$yrnoDetailTable ) {
	return;
}

$script = $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-page/yrnoCreateDetailArr.php';
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
include $script;
$weather 		= new yrnoDetailWeather();
$returnDetails 	= $weather->getWeatherDetailData( $yrnoID );
unset( $weather );
#echo '<pre>'; print_r ($returnDetails); exit;
#
$rowColor			= 'row-dark';
$yrnoDetailTable 	= '<table class="genericTable" style="width: 100%;"><tbody>' . PHP_EOL;
$yrnoDetailHead     = '<tr class="table-top">
<td>' . yrnotransstr( 'Period' ) . '</td><td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
<td>' . yrnotransstr( 'Temperature' ) . '</td><td>' . yrnotransstr( 'Precipitation' ) . '</td>
<td>' . yrnotransstr( 'Wind' ) . '</td><td>' . yrnotransstr( 'Pressure' ) . '</td>
</tr>' . PHP_EOL;
#
$now 	= time();
$oldDay = '';
#echo '<pre>'; print_r( $returnDetails ); exit;

for ( $i = 0; $i < count( $returnDetails['forecast'] ); $i++ ) {

	$arr = $returnDetails['forecast'][$i];

	if ( $now > $arr['timeTo'] ) {
		continue;
	}

	if ( $oldDay <> $arr['date'] ) { // do we have a new day
		$oldDay  			= $arr['date'];
		$rowColor			= 'row-dark';
		$graphsDays[]   	= 1000 * ( $arr['timestamp'] + $utcDiff );
		$cols           	= '7';
		$yrnoDetailTable 	.= myDateLinePrint( $arr['timeTo'] );
		$yrnoDetailTable 	.= $yrnoDetailHead;
		$rowColor			= 'row-dark';
	} // 

	# first some housekeeping
	#	translate icon
        if ( $arr['timeTo'] > $srise && $arr['timeTo'] < $sset ) {
			$imgstr='d';
		}  else {
			$imgstr='n';
		}

	if ( strlen( $arr['icon'] ) == 1 ) {
		$arr['icon'] = '0' . $arr['icon'] . $imgstr;
	} else {
		$arr['icon'] = $arr['icon'] . $imgstr;
	}

	# now the yrno list table
	$yrnoDetailTable .= '<tr class="' . $rowColor . '">' . PHP_EOL;;
	
	if ( $rowColor == 'row-dark' ) {
		$rowColor = 'row-light';
	} else {
		$rowColor =  'row-dark';
	}

	$to 	= ( string ) date( $hourOnlyFormat, $arr['timeTo'] );
	$start  = ( string ) date( $hourOnlyFormat, $arr['timeFrom'] );
	$period = $start . ' - ' . $to;
	$rain 	= '';

	if ( isset( $arr['rain'] ) && $arr['rainNU'] <> 0 ) {
		$rain = $arr['rain'];
	}

	$temp 		= $arr['tempNU'];
	$tempString	= $color = myCommonTemperature( $temp );
	$windSpeed	= $arr['windSpeedNU'];
	list ( $value, $color, $tekst ) = yrnobeaufort( $windSpeed, $toWind );
#	$value		= wsBeaufortNumber ( $windSpeed, $uomWind );
#	$color		= wsBeaufortColor ( $value );
	$tekst		= yrnotransstr( $arr['windTxt'] );
	$windText	= '<span style="background-color: ' . $color . ';">' . $arr['windSpeed'] . ' - ' . $tekst . '</span>';
	$wind		= $windText . '<br />' . yrnotransstr( 'from the' ) . ' ' . yrnotransstr( $arr['windDir'] );
	$notUsed 	= $iconUrl = $iconOut = $iconUrlOut = '';
    $iconIn  	= $arr['icon'];
    list ( $url, $urlsmall )  = yrnoIcon ( $iconIn );
	$description 		= yrnotransstr( $arr['weatherDesc'] );
	$icon 				= '<img src="' . $url . '" alt =" " width ="40" title="' . $description . '"/>';
	$yrnoDetailTable 	.= '<td>' . $period . '</td><td>' . $description . '</td>
	<td>' . $icon . '</td><td>' . $tempString . '</td>
	<td>' . $rain . '</td><td>' . $wind . '</td><td>' . $arr['baro'] . '</td></tr>' . PHP_EOL;
}

#print_r($arrDay);
$yrnoDetailTable .= '</tbody></table>' . PHP_EOL;

# ------------------------------------------------------------------
function myCommonTemperature( $value ) {

	global $toTemp, $tempArray2, $tempSimple;
	$color 	= 'red';
	$temp   = round( $value );

	if ( $toTemp == 'c' ) {	// for the color lookup we need C as unit
		$colorTemp	= $temp + 32; // first color entry => -32 C
	} else {
		$colorTemp	= round( 5 * ( $value - 32 ) / 9 ) + 32;
	}

	if ( !$tempSimple ) {

		if ( $colorTemp < 0 ) {
			$colorTemp = 0;
		} elseif ( $colorTemp >= count( $tempArray2 ) ) {
			$colorTemp = count( $tempArray2 ) - 1;
		}

		$color		= $tempArray2[$colorTemp];
		$tempString	= '<span class="myTemp" style="color: ' . $color . ';" >' . $temp . '&deg;</span>';

	} else {

		if ( $colorTemp <  32 ) {
			$color = 'blue';
		} else {
			$color = 'red';
		}

		$tempString	= '<span class="myTemp" style="font-size: 150%; color: ' . $color . ';" >' . $temp . '&deg;</span>';

	}

	return $tempString;
}
#-----------------------------------------------------------------------
#
#-----------------------------------------------------------------------
function myLongDate ( $time ) {

	global $dateLongFormat;
	$longDays	= array( "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" );
	$longMonths	= array( "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" );
#
	$longDate 	= date ( $dateLongFormat, $time );
	$from 		= array();
	$to			= array();

	for ( $i = 0; $i < count( $longDays ); $i++ ) {

		if ( scriptfound( $longDate, $longDays[$i] ) ) {
			$from[] = $longDays[$i];
			$to[] 	= yrnotransstr( $longDays[$i] );
			break;
		}

	}

	for ( $i = 0; $i < count( $longMonths ); $i++ ) {

		if ( scriptfound( $longDate, $longMonths[$i] ) ) {
			$from[] = $longMonths[$i];
			$to[] 	= yrnotransstr( $longMonths[$i] );
			break;
		}

	}

	$longDate = str_replace( $from, $to, $longDate );
	return $longDate;
}
#-----------------------------------------------------------------------
#
#-----------------------------------------------------------------------
function myDateLinePrint( $time ) {

	global $latitude, $longitude, $rowColor, $timeFormat, $imgDir, $srise, $sset, $cols;
	$srise 	        = date_sunrise( $time, SUNFUNCS_RET_TIMESTAMP, $latitude, $longitude ); // standard time integer
	$sset 	        = date_sunset ( $time, SUNFUNCS_RET_TIMESTAMP, $latitude, $longitude );
	$dlength        = $sset - $srise;
	$dlengthHr      = floor ( $dlength / 3600 );
	$dlengthMin     = round ( ( $dlength - ( 3600 * $dlengthHr ) ) / 60 );
	$strDayLength   = $dlengthHr . ':' . substr( '00' . $dlengthMin, - 2 );
	$longDate       = myLongDate ( $time );
	$string 		= '<tr class="dateline ' . $rowColor . '"><td colspan="' . $cols . '">
							<span style="float:left; position:relative;">&nbsp;<b>' . $longDate . '</b></span>
							<span style="float:right;position:relative;">
							<span class="rTxt">
								<img src="' . $imgDir . '/sunrise.png" width="24" height="12" alt="sunrise" />&nbsp;&nbsp;' . date( $timeFormat, $srise ) . '&nbsp;&nbsp;
								<img src="' . $imgDir . '/sunset.png"  width="24" height="12" alt="sunset" />&nbsp;&nbsp;' . date( $timeFormat, $sset ) . '&nbsp;&nbsp;&nbsp;' . yrnotransstr( 'Daylength' ) . ': ' . $strDayLength . '&nbsp;
							</span>
							</span>
						</td></tr>' . PHP_EOL;
	if ( $rowColor == 'row-dark' ) {
		$rowColor = 'row-light';
	} else {
		$rowColor =  'row-dark';
	}	
	return $string;

}