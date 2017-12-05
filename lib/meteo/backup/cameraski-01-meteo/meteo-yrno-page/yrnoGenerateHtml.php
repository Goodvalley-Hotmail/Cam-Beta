<?php

$script	= $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-page/yrnosettings.php'; // we need hard coded directory path here because settings are not loaded yet.
include $script;
#
$script	= $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-page/yrnoCreateArr.php';
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
<td>' . yrnotransstr( 'Time' ) . '</td><td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
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
</tbody></table>' . PHP_EOL;

# now we are going to generate the javascript graphs

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