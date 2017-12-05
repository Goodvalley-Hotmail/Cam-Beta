<?php

//$script	= $scriptDir . 'yrnosettings.php'; // we need hard coded directory path here because settings are not loaded yet.
$script		= site_url( '/wp-content/themes/genesis-sample/meteo-yrno/yrnosettings.php' );

//include $script;
include ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/genesis-sample/meteo-yrno/yrnosettings.php" );

$script		= $scriptDir . 'yrnoCreateArr.php';

//include $script;
include ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/genesis-sample/meteo-yrno/yrnoCreateArr.php" );

$weather		= new yrnoWeather();
$returnArray	= $weather->getWeatherData( $yrnoID );
unset( $weather );

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

$dateTimeFormat	= $timeFormat;
$timeFormat		= $timeOnlyFormat;
$dateFormat		= $dateOnlyFormat;
$utcDiff		= date( 'Z' );// used for graphs timestamps
$forecasts		= 0;
$dayParts		= array ( yrnotransstr( 'Night' ), yrnotransstr( 'Morning' ), yrnotransstr( 'Afternoon' ), yrnotransstr( 'Evening' ) );

#echo '<pre>'; print_r( $returnArray['forecast'] );
# informative text with update times and name of forecast area

# text for top of page time/date of updates
$fileTime		= strtotime( $returnArray['request_info']['lastupdate'] );
$string			= date( ' d M Y H', $fileTime );
$nextUpdate		= strtotime( $returnArray['request_info']['nextupdate'] );

#echo '<pre>'; print_r ( $returnArray ); exit;
$wsUpdateTimes	= '
<div style="text-align: left;">
	<span class="meteo-update">';
$wsUpdateTimes	.= 	yrnotransstr( 'Updated' ) . ': ' . myLongDate ( $fileTime ) . ' - ' . date ( $timeFormat, $fileTime ) . '<br />';
$wsUpdateTimes	.= 	yrnotransstr( 'Next update' ) . ': ' . myLongDate ( $nextUpdate ) . ' - ' . date( $timeFormat, $nextUpdate ) . '
	</span>
	' . /*'<h4 style="line-height: 1.225; margin: 0px;">' . yrnotransstr( 'MetNoForecast.' ) . ' ' . yrnotransstr( $yourArea ) . '
	<br />' . yrnotransstr( 'by' ) . ' ' . $organ . '</h4>';
$wsUpdateTimes .= */'</div>';

#echo $wsUpdateTimes . '<pre>'; print_r ( $returnArray ); exit;
# we loop through all data and build arrays for the coloms of the output.
$foundFirst		= '';
$arrTime		= array ();
$arrDay			= array ();
$arrIcon		= array ();
$arrDesc		= array ();
$arrTemp		= array ();
$arrRain		= array ();
$arrCoR			= array ();
$arrCoT			= array ();
$arrCoS			= array ();
$arrWind		= array ();
$arrWdir		= array ();
$arrWindIcon	= array ();
$arrBaro		= array ();
$oldDay			= ''; // to detect day changes in input

$now	= time();
$oldDay	= '';

for ( $i = 0; $i < count( $returnArray['forecast'] ); $i++ ) {
	$arr = $returnArray['forecast'][$i];
	
	if ( $now > $arr['timeTo'] ) {
		continue;
	}
	
	if ( $oldDay <> $arr['date'] ) { // do we have a new day
		$oldDay  		= $arr['date'];
		$rowColor		= 'row-dark';
		$cols           = '7';
		$yrnoListTable .= myDateLinePrint( $arr['timeTo'] );
		$yrnoListTable .= $yrnoListHead;
		$rowColor		= 'row-dark';
	}

	# first some housekeeping
	
	# translate icon
		if ( ( 1.0 * $arr['hour'] == 0 ) || ( 1.0 * $arr['hour'] == 3 ) ) {
			$imgstr = 'n';
		} else {
			$imgstr = 'd';
		}
		
		if ( strlen( $arr['icon'] ) == 1 ) {
			$arr['icon'] = '0' . $arr['icon'] . $imgstr;
		} else {
			$arr['icon'] = $arr['icon'] . $imgstr;
		}
	
	# Now the javascript graph
	/************************/
	
	# now the yrno list table
	/***********************/
	
	$to 	= ( string ) date( $hourOnlyFormat, $arr['timeTo'] );
	$start  = ( string ) date( $hourOnlyFormat, $arr['timeFrom'] );
	$period = $start . ' - ' . $to;
	$rain	= '';
	
	if ( isset ( $arr['rain'] ) && $arr['rainNU'] <> 0 ) {
		$rain = $arr['rain'];
	}
	
	$temp 			= $arr['tempNU'];
	$tempString		= myCommonTemperature( $temp );
	#	$tempString	= '<span class="myTemp" style="text-shadow:1px 1px black; font-weight:bolder; font-size:200%; color:' . $color . ';" >' . $temp . '&deg;</span>';	
	$windSpeed		= $arr['windSpeedNU'];
	list ( $value, $color, $tekst ) = yrnobeaufort( $windSpeed, $toWind );
	# $value		= wsBeaufortNumber( $windSpeed, $uomWind );
	# $color		= wsBeaufortColor( $value );
	$tekst			= yrnotransstr( $arr['windTxt'] );
	$windText		= '<span style="background-color: ' . $color . ';">' . $arr['windSpeed'] . ' - ' . $tekst . '</span>';
	$wind			= $windText . '<br />' . yrnotransstr( 'from the' ) . ' ' . yrnotransstr( $arr['windDir'] );
	$notUsed		= $iconUrl = $iconOut = $iconUrlOut = '';
	$iconIn			= $arr['icon'];
	list ( $url, $urlsmall ) = yrnoIcon( $iconIn );
	$description	= yrnotransstr( $arr['weatherDesc'] );
	$icon			= '<img src="' . $url . '" alt =" " width ="40" title="' . $description . '"/>';
	
	$forecasts++;
	$arrTime[]			= $arr['timeTo'];
	$timecheck			= $arr['timeFrom'];
	$nightDayBefore		= true; // if night not listed for previous day
	
	if ( !isset( $nightDayBefore ) || $nightDayBefore == true ) {
		$timecheck	= $timecheck - ( 6 - $offset ) * 60 * 60;
		$dayText	= yrnotransstr( date('l', $timecheck ) );
		# echo 'halt'; exit;
	} else {
		$timecheck	= $timecheck + $offset * 60 * 60;
		$dayText	= yrnotransstr( date( 'l', $timecheck ) );
	}
	
	$dayText2	= $dayParts[$arr['hour']];
	
	/**************************************/
	// CARLES - AQUEST ÉS EL CODI ORIGINAL
	if ( $foundFirst	=== '' ) { // do first time things
		$foundFirst	= 'xx';
		$dayString	= yrnotransstr( 'This' ) . '<br />' . $dayText2;
		$arrDay[]	= $dayString;	
	} else {
		$arrDay[] = $dayText . '<br />' . $dayText2;
	}
	/**************************************/
	
	/* CARLES - AQUEST ÉS EL MEU CODI */
	/*$arrDay[] = $dayText2;
	$arrDay_1 = 'Today\'s<br />';
	$arrDay_2 = 'Tomorrow\'s<br />';
	/**********************************/
	
	$notUsed				= $iconUrl = $iconOut = $iconUrlOut = '';
	$iconIn					= $arr['icon'];
	list ($url, $urlsmall)  = yrnoIcon( $iconIn );
	$arrIcon[]				= $url;
	$arrDesc[]				= yrnotransstr( $arr['weatherDesc'] );
	$arrTemp[]				= $arr['tempNU'];
	$arrRain[]				= $arr['rainNU'];
	$arrWind[]				= $arr['windSpeed'];
	# $arrWdir[]			= $arr['windDir'];	
	$arrWindIcon[]			= $arr['windDir'];
	$arrBaro[]				= $arr['baroNU'];
}

/**************************/
/* CARLES - PRIMERA TAULA */
/**************************/
if ( count( $arrTime ) < $topCount_1 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_1;
}

$topCount_1	= $end;
$iconWidth	= 100 / $topCount;
$tableIcons_1	= '
<table class="genericTable centerTable" style="background-color: transparent;">
<thead class="thead-icons">
<tr class="tr-top">' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$tableIcons_1 .=  '<th class="th-period" style="width:25%;" colspan="3">' . $arrDay_1 . $arrDay[$i] . '</th>' . PHP_EOL;
}

$tableIcons_1 .= '</tr></thead><tbody class="tbody-icons"><tr class="tr-top">' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIcons_1 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIcons_1  .= '<td class="td-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
}

$tableIcons_1 .= '</tr>
<tr class="tr-wind">' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIcons_1 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '</td>' . PHP_EOL;
}

$tableIcons_1 .= '</tr>
<tr>' . PHP_EOL;

$tableIcons_1 .= '</tr>
<tr class="tr-weather">' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {
	$tableIcons_1 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
}

/* CARLES */
$tableIcons_1 .= '</tr>
<tr class="tr-bottom">' . PHP_EOL;

for ( $i = 0; $i < $end; $i++ ) {

	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	/* L'ALTRE CODI AMB Today / Tomorrow
	for ( $i = 0; $i < $end; $i++ ) {
	if ( $arrDay[$i] == 'Night' ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( $arrDay[$i] == 'Morning' ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( $arrDay[$i] == 'Afternoon' ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( $arrDay[$i] == 'Evening' ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	*/
	
	$tableIcons_1 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
	
}
/* /CARLES */

$tableIcons_1 .= '
</tr>
</tbody>
</table>
' . PHP_EOL;
/*************************/
/* CARLES - SEGONA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_2 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_2;
}

$topCount_2	= $end;
$iconWidth	= 100 / $topCount;
$tableIcons_2	= '
<table class="genericTable centerTable" style="background-color: transparent;">
<thead class="thead-icons">
<tr class="tr-top">' . PHP_EOL;

for ( $i = 4; $i < $end; $i++ ) {
	$tableIcons_2 .=  '<th class="th-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</th>' . PHP_EOL;
}

$tableIcons_2 .= '</tr></thead><tbody class="tbody-icons"><tr class="tr-top">' . PHP_EOL;

for ( $i = 4; $i < $end; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIcons_2 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIcons_2  .= '<td class="td-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
}

$tableIcons_2 .= '</tr>
<tr class="tr-wind">' . PHP_EOL;

for ( $i = 4; $i < $end; $i++ ) {
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIcons_2 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '</td>' . PHP_EOL;
}

$tableIcons_2 .= '</tr>
<tr>' . PHP_EOL;

$tableIcons_2 .= '</tr>
<tr class="tr-weather">' . PHP_EOL;

for ( $i = 4; $i < $end; $i++ ) {
	$tableIcons_2 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
}

/* CARLES */
$tableIcons_2 .= '</tr>
<tr class="tr-bottom">' . PHP_EOL;

for ( $i = 4; $i < $end; $i++ ) {
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIcons_2 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
	
}

$tableIcons_2 .= '
</tr>
</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 1 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_1 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_1;
}

$topCount_1	= $end;
$iconWidth	= 100 / $topCount;
$tableIconsMobile_1	= '
<table class="mobileGenericTable mobileCenterTable" style="background-color: transparent;">
<tbody>
<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 0; $i < 1; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_1  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_1  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_1 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_1 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_1 .= '
</tr>

<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 1; $i < 2; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_1  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_1  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_1 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_1 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_1 .= '
</tr>

<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 2; $i < 3; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_1  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_1  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_1 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_1 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_1 .= '
</tr>

<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 3; $i < 4; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_1  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_1  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_1 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_1 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_1 .= '
</tr>

</tbody>
</table>
' . PHP_EOL;
/****************************************/
/* CARLES - CODI TAULA 2 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_2 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_2;
}

$topCount_2	= $end;
$iconWidth	= 100 / $topCount;
$tableIconsMobile_2	= '
<table class="mobileGenericTable mobileCenterTable" style="background-color: transparent;">
<tbody>
<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 4; $i < 5; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_2  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_2  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_2 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_2 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_2 .= '
</tr>

<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 5; $i < 6; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_2  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_2  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_2 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_2 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_2 .= '
</tr>

<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 6; $i < 7; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_2  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_2  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_2 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_2 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_2 .= '
</tr>

<tr class="mobile-tr-top">' . PHP_EOL;

for ( $i = 7; $i < 8; $i++ ) {
	$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
	$temp	  = round( $arrTemp[$i] );
	$string   = myCommonTemperature( $temp );
	# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
	$tableIconsMobile_2  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
	$tableIconsMobile_2  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
	
	$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
	$tableIconsMobile_2 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
	
	$tableIconsMobile_2 .= '
	</tr><tr class="mobile-tr-bottom">';
	
	if ( fnmatch( "*Night", $arrDay[$i] ) ) {
		$dayParts3 = '23:00 - 05:00h';
	} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
		$dayParts3 = '05:00 - 11:00h';
	} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
		$dayParts3 = '11:00 - 17:00h';
	} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
		$dayParts3 = '17:00 - 23:00h';
	}
	
	$tableIconsMobile_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-rain">' . $arrRain[$i] . $uomRain . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
	$tableIconsMobile_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
	
}

$tableIconsMobile_2 .= '
</tr>

</tbody>
</table>
' . PHP_EOL;
/****************************************/
/* CARLES - FINAL CODI TAULA 2 MÒBIL	*/
/****************************************/

# now we generate the detail table if needed
# ------------------------------------------------------------------

function myCommonTemperature( $value ) {
	global $toTemp, $tempArray2, $tempSimple;
	$color	= 'red';
	$temp	= round( $value );
	
	if ( $toTemp == 'c' ) { // for the color lookup we need C as unit
		$colorTemp	= $temp + 32; // first color entry => -32 C
	} else {
		$colorTemp	= round( 5 * ( $value - 32 ) / 9 ) + 32;
	}
	
	if ( !$tempSimple ) {
		
		if ( $colorTemp < 0 ) {
			$colorTemp = 0;
		} elseif ( $colorTemp >= count ( $tempArray2 ) ) {
			$colorTemp = count ( $tempArray2 ) - 1;
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
function myLongDate( $time ) {
	
	global $dateLongFormat;
	$longDays	= array ( "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" );
	$longMonths	= array ( "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" );
	#
	$longDate	= date ( $dateLongFormat, $time );
	$from		= array();
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
	
	$longDate = str_replace ( $from, $to, $longDate );
	return $longDate;
	
}

#-----------------------------------------------------------------------
#
#-----------------------------------------------------------------------
function myDateLinePrint($time) {
	global  $latitude, $longitude, $rowColor, $timeFormat, $imgDir, $srise, $sset, $cols; 
	$srise		= date_sunrise($time, SUNFUNCS_RET_TIMESTAMP, $latitude, $longitude); // standard time integer
	$sset		= date_sunset ($time, SUNFUNCS_RET_TIMESTAMP, $latitude, $longitude);
	$dlength	= $sset - $srise;
	$dlengthHr	= floor ($dlength /3600);
	$dlengthMin	= round (($dlength - (3600 * $dlengthHr) ) / 60);
	$strDayLength= $dlengthHr.':'. substr('00'.$dlengthMin,-2);
	$longDate	= myLongDate ($time);
	$string		='<tr class="dateline '.$rowColor.'"><td colspan="'.$cols.'">
<span style="float:left; position:relative;">&nbsp;<b>'.$longDate.'</b></span>
<span style="float:right;position:relative;">
	<span class="rTxt">
		<img src="'.$imgDir.'/sunrise.png" width="24" height="12" alt="sunrise" />&nbsp;&nbsp;'.date($timeFormat,$srise).'&nbsp;&nbsp;
		<img src="'.$imgDir.'/sunset.png"  width="24" height="12" alt="sunset" />&nbsp;&nbsp;'.date($timeFormat,$sset).'&nbsp;&nbsp;&nbsp;'.
		yrnotransstr('Daylength').': '.$strDayLength.'&nbsp;
	</span>
</span>
</td></tr>'.PHP_EOL;
	
	if ($rowColor == 'row-dark') {
		$rowColor = 'row-light';
	}
	else {
		$rowColor =  'row-dark';
	}
	
	return $string;
}

?>