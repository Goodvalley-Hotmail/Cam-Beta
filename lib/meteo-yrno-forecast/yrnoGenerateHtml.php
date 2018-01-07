<?php

$script		= site_url( '/wp-content/themes/cameraski/lib/meteo-yrno-forecast/yrnosettings.php' );

include ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/cameraski/lib/meteo-yrno-forecast/yrnosettings.php" );
// AFEGIT
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;

$script		= $scriptDir . 'yrnoCreateArr.php';

include ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/cameraski/lib/meteo-yrno-forecast/yrnoCreateArr.php" );
// AFEGIT
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;

$weather 		= new yrnoWeather ();
$returnArray 	= $weather->getWeatherData( $yrnoID );
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

$dateTimeFormat = $timeFormat;
$timeFormat 	= $timeOnlyFormat;
$dateFormat 	= $dateOnlyFormat;
$utcDiff 		= date( 'Z' ); // used for graphs timestamps
$forecasts		= 0;
$dayParts		= array ( yrnotransstr( 'Night' ), yrnotransstr( 'Morning') , yrnotransstr( 'Afternoon' ), yrnotransstr( 'Evening' ) );

#echo '<pre>'; print_r($returnArray['forecast']);
# informative text with update times and name of forecast area
# --------------
# text for top of page time/date of updates
$fileTime		= strtotime( $returnArray['request_info']['lastupdate'] );
$string 		= date( ' d M Y H', $fileTime );
$nextUpdate 	= strtotime( $returnArray['request_info']['nextupdate'] );

#echo '<pre>'; print_r ($returnArray); exit;
$wsUpdateTimes  = '
	<span class="meteo-update">';
		$wsUpdateTimes .= yrnotransstr( 'Updated' ) . ': ' . myLongDate ( $fileTime ) . ' - ' . date ( $timeFormat, $fileTime ) . '<br />';
		$wsUpdateTimes .= yrnotransstr( 'Next update' ) . ': ' . myLongDate ( $nextUpdate ) . ' - ' . date ( $timeFormat, $nextUpdate ) . '
	</span>
	<h4 style="margin: 0px;">' . yrnotransstr( 'MetNoForecast.' ) . ' ' . yrnotransstr( $yourArea ) . '
	<br />' . yrnotransstr( 'by:' ) . ' ' . $organ . '</h4>';

#echo $wsUpdateTimes . '<pre>'; print_r( $returnArray ); exit;
# we loop through all data and build arrays for the coloms of the output.
$foundFirst		= '';
$arrTime 		= array ();
//$arrTimeGraph 	= array ();
$arrDay 		= array ();
$arrIcon		= array ();
//$arrIconGraph	= array ();
$arrDesc		= array ();
$arrTemp		= array ();
//$arrTempGraph	= array ();
$arrRain		= array ();
//$arrRainGraph	= array ();
$arrCoR			= array ();
$arrCoT			= array ();
$arrCoS			= array ();
$arrWind		= array ();
//$arrWindGraph	= array ();
$arrWdir		= array ();
//$arrWdirGraph	= array ();
$arrWindIcon    = array ();
$arrBaro		= array ();
//$arrBaroGraph	= array ();
//$graphsDays     = array ();
$oldDay			= ''; // to detect day changes in input
//$graphsData		= ''; // we store all javascript data here
//$graphLines     = 0; // number of javascript data lines
//$graphsStop     = 0;
//$graphsStart    = 0;
//$graphTempMin   = 100;
//$graphTempMax   = -100;
//$graphBaroMin   = 2000;
//$graphBaroMax   = 0;
//$graphRainMax   = 0;
//$graphWindMax   = 0;
#

$rowColor		= 'row-dark';

/*$yrnoListTable 	= '<table class="meteoYrnoTable" style="width: 100%;"><tbody>' . PHP_EOL;
$yrnoListHead   = '<tr class="table-top">
						<td>' . yrnotransstr( 'Time' ) . '</td>
                        <td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
						<td>' . yrnotransstr( 'Temperature' ) . '</td>
                        <td>' . yrnotransstr( 'Precipitation' ) . '</td>
						<td colspan="2">' . yrnotransstr( 'Wind' ) . '</td>
                        <td>' . yrnotransstr( 'Pressure' ) . '</td>
				   </tr>' . PHP_EOL;*/
				   
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
		//$graphsDays[] 	= 1000 * ( strtotime( $arr['date'] . 'T00:00:00Z' ) );
		$cols           = '12';
		//$yrnoListTable .= myDateLinePrint( $arr['timeTo'] );
		//$yrnoListTable .= $yrnoListHead;
		$rowColor 		= 'row-dark';
	} //

	# first some housekeeping
	# translate icon
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
	//$yrnoListTable .= '<tr class="' . $rowColor . '">' . PHP_EOL;

	if ( $rowColor == 'row-dark' ) {
		$rowColor = 'row-light';
	} else {
		$rowColor =  'row-dark';
	}

	$to 	= ( string ) date( $hourOnlyFormat, $arr['timeTo'] );
	$start  = ( string ) date( $hourOnlyFormat, $arr['timeFrom'] );
	$period = $start . ':00 - ' . $to . ':00 h';
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
	$windText	='<span style="background-color: ' . $color . ';">' . $arr['windSpeed'] . '<br />' . $tekst . '</span>';
	//$windText	='<span style="background-color: ' . $color . ';">' . $arr['windSpeed'] . '</span>';
	$stringWind	= '<img src="' . $iconsWind . yrnotransstr( $arr['windDir'] ) . '.png" width="32" alt="" />';
	//$wind		= $windText . '<br />' . yrnotransstr( 'from the' ) . ' ' . yrnotransstr( $arr['windDir'] );
	//$wind		= $windText . '<br />' . $stringWind;
	//$wind		= $stringWind . ' ' . $windText;
	$notUsed 	= $iconUrl = $iconOut = $iconUrlOut = '';
    $iconIn 	= $arr['icon'];
    list ( $url, $urlsmall ) = yrnoIcon ( $iconIn );
	$description = yrnotransstr( $arr['weatherDesc'] );
	$icon = '<img src="' . $url . '" alt =" " width ="40" title="' . $description . '"/>';
	/*$yrnoListTable .=	'<td>' . $period . '</td>
    					<td>' . $description . '</td>
						<td>' . $icon . '</td>
                        <td>' . $tempString . '</td>
						<td>' . $rain . '</td>
                        <td>' . $stringWind . '</td>
                        <td>' . $windText . '</td>
                        <td>' . $arr['baro'] . '</td>
					</tr>' . PHP_EOL;*/
	
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

	//if ( $foundFirst === '' ) { // do first time things
	if ( $i < 4 ) { // do first time things

		$foundFirst = 'xx';
		$dayString 	= yrnotransstr( 'This' ) . '<br />' . $dayText2;
		$arrDay[]	= $dayString;

	} else {

		$arrDay[]	= $dayText . '<br />' . $dayText2;

	}

	$notUsed 					= $iconUrl = $iconOut = $iconUrlOut = '';
    $iconIn     				= $arr['icon'];
    list ( $url, $urlsmall )  	= yrnoIcon( $iconIn );
	$arrIcon[]					= $url;
	$arrDesc[]					= yrnotransstr( $arr['weatherDesc'] );
	$arrTemp[]					= $arr['tempNU'];
	$arrRain[]					= $arr['rainNU'];
	$arrWind[]					= $arr['windSpeed'];
	# $arrWdir[]				= $arr['windDir'];	
	$arrWindIcon[]				= $arr['windDir'];
	$arrBaro[]					= $arr['baroNU'];

}

#print_r( $arrDay );
//$yrnoListTable .= '</tbody></table>' . PHP_EOL;

/* FINAL ---------------------------------------------------------------------------- */

/*if ( 1.0 * $arr['hour'] == 0 ) {
	$topCount = 2;
  	$dayStart = 2;
}  elseif ( 1.0 * $arr['hour'] == 1 ) {
	$topCount = 4;
  	$dayStart = 2;
}  elseif ( 1.0 * $arr['hour'] == 2 ) {
	$topCount = 3;
  	$dayStart = 3;
}  elseif ( 1.0 * $arr['hour'] == 3 ) {
	$topCount = 2;
  	$dayStart = 2;
}

//$yrno6hTable_1 .= '<tr class="' . $rowColor . '"><td>' . $topCount . '</td></tr>' . PHP_EOL;

/* FINAL ---------------------------------------------------------------------------- */

/**************************/
/* CARLES - PRIMERA TAULA */
/**************************/
if ( count( $arrTime ) < $topCount_1 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_1;
}

$topCount_1	= $end;
$iconWidth	= 100 / $topCount_1;
$yrno6hTable_1	= '
<table class="yrno6hTable_1 centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;

		for ( $i = 0; $i < 1; $i++ ) {
			
			$arr = $returnArray['forecast'][$i];
			
			if ( $now > $arr['timeTo'] ) {
				continue;
			}
		
			if ( $oldDay <> $arr['date'] ) { // do we have a new day
				$oldDay 		= $arr['date'];
				$cols           = '12';
				$yrno6hTable_1 .= myDateLinePrint( $arr['timeTo'] );
			}
			
		}

		$yrno6hTable_1 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;

		for ( $i = 0; $i < $end; $i++ ) {
			$yrno6hTable_1 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay[$i] . '</td>' . PHP_EOL;
		}
			
		$yrno6hTable_1 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_1 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_1  .= '<td class="td-6h-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_1 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_1 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_1 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_1 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$yrno6hTable_1 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_1 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		//for ( $i = $topCount_1; $i < $end; $i++ ) {
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
            
			//for ( $i = 0; $i < $end; $i++ ) {
				$yrno6hTable_1 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
            //}
			
		}
		
		$yrno6hTable_1 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/* FINAL ---------------------------------------------------------------------------- */

/*************************/
/* CARLES - SEGONA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_2 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_2;
}

$topCount_2	= $end;
$iconWidth	= 100 / $topCount_2;
$yrno6hTable_2	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 4; $i < count( $returnArray['forecast'] ); $i++ ) {
		
			$arr 	= $returnArray['forecast'][$dayStart + 4];
			
			if ( $now > $arr['timeTo'] ) {
				continue;
			}

			if ( $oldDay <> $arr['date'] ) { // do we have a new day
				$oldDay 		= $arr['date'];
				$cols           = '12';
				$yrno6hTable_2 .= myDateLinePrint( $arr['timeTo'] );
			}
			
		}

		$yrno6hTable_2 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 4; $i < $end; $i++ ) {
			$yrno6hTable_2 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_2 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 4; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_2 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_2  .= '<td class="td-6h-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_2 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 4; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_2 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_2 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_2 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 4; $i < $end; $i++ ) {
			$yrno6hTable_2 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_2 .= '</tr>
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
			
			$yrno6hTable_2 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_2 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - TERCERA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_3 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_3;
}

$topCount_3	= $end;
$iconWidth	= 100 / $topCount_3;
$yrno6hTable_3	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 8; $i < count( $returnArray['forecast'] ); $i++ ) {
		
				$arr 	= $returnArray['forecast'][$dayStart + 8];
			
				if ( $now > $arr['timeTo'] ) {
					continue;
				}

				if ( $oldDay <> $arr['date'] ) { // do we have a new day
					$oldDay 		= $arr['date'];
					$cols           = '12';
					$yrno6hTable_3 .= myDateLinePrint( $arr['timeTo'] );
					$rowColor 		= 'row-dark';
				}
            }

		$yrno6hTable_3 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 8; $i < $end; $i++ ) {
			$yrno6hTable_3 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}

		$yrno6hTable_3 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 8; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_3 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_3  .= '<td class="td-6h-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_3 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 8; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_3 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_3 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_3 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 8; $i < $end; $i++ ) {
			$yrno6hTable_3 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_3 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 8; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_3 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_3 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - QUARTA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_4 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_4;
}

$topCount_4	= $end;
$iconWidth	= 100 / $topCount_4;
$yrno6hTable_4	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 12; $i < count( $returnArray['forecast'] ); $i++ ) {
		
				$arr 	= $returnArray['forecast'][$dayStart + 12];
			
				if ( $now > $arr['timeTo'] ) {
					continue;
				}

				if ( $oldDay <> $arr['date'] ) { // do we have a new day
					$oldDay 		= $arr['date'];
					$cols           = '12';
					$yrno6hTable_4 .= myDateLinePrint( $arr['timeTo'] );
				}
			
            }

		$yrno6hTable_4 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 12; $i < $end; $i++ ) {
			$yrno6hTable_4 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_4 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 12; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_4 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_4  .= '<td class="td-6h-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_4 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 12; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_4 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_4 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_4 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 12; $i < $end; $i++ ) {
			$yrno6hTable_4 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_4 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 12; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_4 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_4 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - CINQUENA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_5 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_5;
}

$topCount_5	= $end;
$iconWidth	= 100 / $topCount_5;
$yrno6hTable_5	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 16; $i < count( $returnArray['forecast'] ); $i++ ) {
		
				$arr 	= $returnArray['forecast'][$dayStart + 16];
			
				if ( $now > $arr['timeTo'] ) {
					continue;
				}

				if ( $oldDay <> $arr['date'] ) { // do we have a new day
					$oldDay 		= $arr['date'];
					$cols           = '12';
					$yrno6hTable_5 .= myDateLinePrint( $arr['timeTo'] );
				}
			
            }
			
		$yrno6hTable_5 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 16; $i < $end; $i++ ) {
			$yrno6hTable_5 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_5 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 16; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_5 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_5  .= '<td class="td-6h-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_5 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 16; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_5 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_5 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_5 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 16; $i < $end; $i++ ) {
			$yrno6hTable_5 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_5 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 16; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_5 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_5 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - SISENA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_6 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_6;
}

$topCount_6	= $end;
$iconWidth	= 100 / $topCount_6;
$yrno6hTable_6	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 20; $i < count( $returnArray['forecast'] ); $i++ ) {
		
				$arr 	= $returnArray['forecast'][$dayStart + 20];
			
				if ( $now > $arr['timeTo'] ) {
					continue;
				}

				if ( $oldDay <> $arr['date'] ) { // do we have a new day
					$oldDay 		= $arr['date'];
					$cols           = '12';
					$yrno6hTable_6 .= myDateLinePrint( $arr['timeTo'] );
				}
			
            }
		
		$yrno6hTable_6 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 20; $i < $end; $i++ ) {
			$yrno6hTable_6 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_6 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 20; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_6 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_6  .= '<td class="td-6h-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_6 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 20; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_6 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_6 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_6 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 20; $i < $end; $i++ ) {
			$yrno6hTable_6 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_6 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 20; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_6 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_6 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - SETENA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_7 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_7;
}

$topCount_7	= $end;
$iconWidth	= 100 / $topCount_7;
$yrno6hTable_7	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 24; $i < count( $returnArray['forecast'] ); $i++ ) {
		
				$arr 	= $returnArray['forecast'][$dayStart + 24];
			
				if ( $now > $arr['timeTo'] ) {
					continue;
				}

				if ( $oldDay <> $arr['date'] ) { // do we have a new day
					$oldDay 		= $arr['date'];
					$cols           = '12';
					$yrno6hTable_7 .= myDateLinePrint( $arr['timeTo'] );
				}
			
            }
		
		$yrno6hTable_7 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 24; $i < $end; $i++ ) {
			$yrno6hTable_7 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_7 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 24; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_7 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_7  .= '<td class="td-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_7 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 24; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_7 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_7 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_7 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 24; $i < $end; $i++ ) {
			$yrno6hTable_7 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_7 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 24; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_7 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_7 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - VUITENA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_8 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_8;
}

$topCount_8	= $end;
$iconWidth	= 100 / $topCount_8;
$yrno6hTable_8	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 28; $i < count( $returnArray['forecast'] ); $i++ ) {
		
			$arr 	= $returnArray['forecast'][$dayStart + 28];
			
			if ( $now > $arr['timeTo'] ) {
				continue;
			}

			if ( $oldDay <> $arr['date'] ) { // do we have a new day
				$oldDay 		= $arr['date'];
				$cols           = '12';
				$yrno6hTable_8 .= myDateLinePrint( $arr['timeTo'] );
			}
		
		}
		
		$yrno6hTable_8 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 28; $i < $end; $i++ ) {
			$yrno6hTable_8 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_8 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 28; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_8 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_8  .= '<td class="td-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_8 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 28; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_8 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_8 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_8 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 28; $i < $end; $i++ ) {
			$yrno6hTable_8 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_8 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 28; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_8 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_8 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/*************************/
/* CARLES - NOVENA TAULA */
/*************************/
if ( count( $arrTime ) < $topCount_9 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_9;
}

$topCount_9	= $end;
$iconWidth	= 100 / $topCount_9;
$yrno6hTable_9	= '
<table class="yrno6hTable centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		for ( $i = 32; $i < count( $returnArray['forecast'] ); $i++ ) {
		
			$arr 	= $returnArray['forecast'][$dayStart + 32];
		
			if ( $now > $arr['timeTo'] ) {
				continue;
			}
			
			if ( $oldDay <> $arr['date'] ) { // do we have a new day
				$oldDay 		= $arr['date'];
				$cols           = '12';
				$yrno6hTable_9 .= myDateLinePrint( $arr['timeTo'] );
			}
			
		}
		
		$yrno6hTable_9 .= '</thead><tbody class="tbody-6h"><tr class="tr-dayParts">' . PHP_EOL;
		
		for ( $i = 32; $i < $end; $i++ ) {
			$yrno6hTable_9 .=  '<td class="td-period" style="width:25%;" colspan="3">' . $arrDay_2 . $arrDay[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_9 .= '</tr><tr class="tr-top">' . PHP_EOL;
		
		for ( $i = 32; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno6hTable_9 .= '<td class="td-data-icons" style="width:16.66666%;" colspan="2" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br /><br />' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			$yrno6hTable_9  .= '<td class="td-data-temperature" style="width:8.33333%">' . $string . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_9 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 32; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno6hTable_9 .= '<td class="td-arrow-wind" style="width:8.33333%" rowspan="2">' . $stringWind . '<br />' . $arrWind[$i] . '<br />' . $tekst . '</td>' . PHP_EOL;
		}
		
		$yrno6hTable_9 .= '</tr>
		<tr>' . PHP_EOL;
		
		$yrno6hTable_9 .= '</tr>
		<tr class="tr-weather">' . PHP_EOL;
		
		for ( $i = 32; $i < $end; $i++ ) {
			$yrno6hTable_9 .= '<td class="td-data-weather" style="width:25%" colspan="3">' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno6hTable_9 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		for ( $i = 32; $i < $end; $i++ ) {
			
			if ( fnmatch( "*Night", $arrDay[$i] ) ) {
				$dayParts3 = '23:00 - 05:00h';
			} elseif ( fnmatch( "*Morning", $arrDay[$i] ) ) {
				$dayParts3 = '05:00 - 11:00h';
			} elseif ( fnmatch( "*Afternoon", $arrDay[$i] ) ) {
				$dayParts3 = '11:00 - 17:00h';
			} elseif ( fnmatch( "*Evening", $arrDay[$i] ) ) {
				$dayParts3 = '17:00 - 23:00h';
			}
			
			$yrno6hTable_9 .= '<td class="td-foot" style="width:25%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
			
		}
		
		$yrno6hTable_9 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/* FINAL ---------------------------------------------------------------------------- */

/****************************************/
/* CARLES - CODI TAULA 1 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_1 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_1;
}

$topCount_1	= $end;
$iconWidth	= 100 / $topCount_1;
$mobileYrno6hTable_1	= '
<table class="mobileYrno6hTable_1 mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;

	for ( $i = 0; $i < 1; $i++ ) {
	//for ( $i = 0; $i < count( $returnArray['forecast'] ); $i++ ) {
			
		$arr = $returnArray['forecast'][$i];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_1 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_1 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_1 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 0; $i < 1; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_1  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_1 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_1 .= '
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
			
			$mobileYrno6hTable_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_1 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 1; $i < 2; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_1  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_1 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_1 .= '
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
			
			$mobileYrno6hTable_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_1 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 2; $i < 3; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_1  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_1 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_1 .= '
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
			
			$mobileYrno6hTable_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_1 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 3; $i < 4; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_1  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_1 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_1 .= '
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
			
			$mobileYrno6hTable_1 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_1 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_1 .= '
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
$iconWidth	= 100 / $topCount_2;
$mobileYrno6hTable_2	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 1; $i < 2; $i++ ) {
		
		$arr = $returnArray['forecast'][$dayStart + 4];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_2 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_2 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_2 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 4; $i < 5; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_2  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_2 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_2 .= '
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
			
			$mobileYrno6hTable_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_2 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 5; $i < 6; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_2  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_2 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_2 .= '
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
			
			$mobileYrno6hTable_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_2 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 6; $i < 7; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_2  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_2 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_2 .= '
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
			
			$mobileYrno6hTable_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_2 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 7; $i < 8; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_2  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_2 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_2 .= '
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
			
			$mobileYrno6hTable_2 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_2 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_2 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 3 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_3 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_3;
}

$topCount_3	= $end;
$iconWidth	= 100 / $topCount_3;
$mobileYrno6hTable_3	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 2; $i < 3; $i++ ) {
		
		$arr = $returnArray['forecast'][$dayStart + 8];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_3 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_3 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_3 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 8; $i < 9; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_3  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_3 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_3 .= '
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
			
			$mobileYrno6hTable_3 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_3 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 9; $i < 10; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_3  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_3 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_3 .= '
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
			
			$mobileYrno6hTable_3 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_3 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 10; $i < 11; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_3  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_3 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_3 .= '
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
			
			$mobileYrno6hTable_3 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_3 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 11; $i < 12; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_3  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_3 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_3 .= '
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
			
			$mobileYrno6hTable_3 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_3 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_3 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 4 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_4 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_4;
}

$topCount_4	= $end;
$iconWidth	= 100 / $topCount_4;
$mobileYrno6hTable_4	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 3; $i < 4; $i++ ) {
			
		$arr = $returnArray['forecast'][$dayStart + 12];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_4 .= myDateLinePrint( $arr['timeTo'] );
		}
			
	}

	$mobileYrno6hTable_4 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_4 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 12; $i < 13; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_4  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_4 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_4 .= '
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
			
			$mobileYrno6hTable_4 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_4 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 13; $i < 14; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_4  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_4 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_4 .= '
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
			
			$mobileYrno6hTable_4 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_4 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 14; $i < 15; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_4  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_4 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_4 .= '
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
			
			$mobileYrno6hTable_4 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_4 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 15; $i < 16; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_4  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_4 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_4 .= '
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
			
			$mobileYrno6hTable_4 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_4 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_4 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 5 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_5 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_5;
}

$topCount_5	= $end;
$iconWidth	= 100 / $topCount_5;
$mobileYrno6hTable_5	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 4; $i < 5; $i++ ) {
			
		$arr = $returnArray['forecast'][$dayStart + 16];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_5 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_5 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_5 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 16; $i < 17; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_5  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_5 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_5 .= '
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
			
			$mobileYrno6hTable_5 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_5 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 17; $i < 18; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_5  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_5 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_5 .= '
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
			
			$mobileYrno6hTable_5 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_5 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 18; $i < 19; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_5  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_5 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_5 .= '
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
			
			$mobileYrno6hTable_5 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_5 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 19; $i < 20; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_5  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_5 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_5 .= '
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
			
			$mobileYrno6hTable_5 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_5 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_5 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 6 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_6 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_6;
}

$topCount_6	= $end;
$iconWidth	= 100 / $topCount_6;
$mobileYrno6hTable_6	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 5; $i < 6; $i++ ) {
			
		$arr = $returnArray['forecast'][$dayStart + 20];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_6 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_6 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_6 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 20; $i < 21; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_6  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_6 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_6 .= '
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
			
			$mobileYrno6hTable_6 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_6 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 21; $i < 22; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_6  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_6 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_6 .= '
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
			
			$mobileYrno6hTable_6 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_6 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 22; $i < 23; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_6  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_6 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_6 .= '
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
			
			$mobileYrno6hTable_6 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_6 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 23; $i < 24; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_6  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_6 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_6 .= '
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
			
			$mobileYrno6hTable_6 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_6 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_6 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 7 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_7 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_7;
}

$topCount_7	= $end;
$iconWidth	= 100 / $topCount_7;
$mobileYrno6hTable_7	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 6; $i < 7; $i++ ) {
			
		$arr = $returnArray['forecast'][$dayStart + 24];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_7 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_7 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_7 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 24; $i < 25; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_7  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_7 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_7 .= '
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
			
			$mobileYrno6hTable_7 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_7 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 25; $i < 26; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_7  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_7 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_7 .= '
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
			
			$mobileYrno6hTable_7 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_7 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 26; $i < 27; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_7  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_7 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_7 .= '
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
			
			$mobileYrno6hTable_7 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_7 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 27; $i < 28; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_7  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_7 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_7 .= '
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
			
			$mobileYrno6hTable_7 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_7 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_7 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 8 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_8 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_8;
}

$topCount_8	= $end;
$iconWidth	= 100 / $topCount_8;
$mobileYrno6hTable_8	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 7; $i < 8; $i++ ) {
			
		$arr = $returnArray['forecast'][$dayStart + 28];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_8 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_8 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_8 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 28; $i < 29; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_8  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_8 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_8 .= '
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
			
			$mobileYrno6hTable_8 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_8 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 29; $i < 30; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_8  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_8 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_8 .= '
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
			
			$mobileYrno6hTable_8 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_8 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 30; $i < 31; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_8  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_8 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_8 .= '
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
			
			$mobileYrno6hTable_8 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_8 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 31; $i < 32; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_8  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_8 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_8 .= '
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
			
			$mobileYrno6hTable_8 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_8 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_8 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/****************************************/
/* CARLES - CODI TAULA 9 MÒBIL			*/
/****************************************/
if ( count( $arrTime ) < $topCount_9 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount_9;
}

$topCount_9	= $end;
$iconWidth	= 100 / $topCount_9;
$mobileYrno6hTable_9	= '
<table class="mobileYrno6hTable mobileCenterTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
	
	for ( $i = 8; $i < 9; $i++ ) {
			
		$arr = $returnArray['forecast'][$dayStart + 32];
		
		if ( $now > $arr['timeTo'] ) {
			continue;
		}
		
		if ( $oldDay <> $arr['date'] ) { // do we have a new day
			$oldDay 		= $arr['date'];
			$cols           = '12';
			$mobileYrno6hTable_9 .= myDateLinePrint( $arr['timeTo'] );
		}
		
	}

	$mobileYrno6hTable_9 .= '</thead>' . PHP_EOL;
	$mobileYrno6hTable_9 .= '<tbody>
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 32; $i < 33; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_9  .=  '<td class="mobile-td-period-1">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-icons-1">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9  .= '<td class="mobile-td-data-temperature-1">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_9 .= '<td class="mobile-td-arrow-wind-1">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind-text_1">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_9 .= '
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
			
			$mobileYrno6hTable_9 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_9 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 33; $i < 34; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_9  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_9 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_9 .= '
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
			
			$mobileYrno6hTable_9 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_9 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 34; $i < 35; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_9  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_9 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_9 .= '
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
			
			$mobileYrno6hTable_9 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_9 .= '
		</tr>
		
		<tr class="mobile-tr-top">' . PHP_EOL;
		
		for ( $i = 35; $i < 36; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="60" title="' . $arrDesc[$i] . '"/>';
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$mobileYrno6hTable_9  .=  '<td class="mobile-td-period-2">' . $arrDay_1 . $arrDay[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-icons-2">' . $icon . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9  .= '<td class="mobile-td-data-temperature-2">' . $string . '</td>' . PHP_EOL;
			
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$mobileYrno6hTable_9 .= '<td class="mobile-td-arrow-wind-2">' . $stringWind . '<br />' . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind-text_2">' . $tekst . '</td>' . PHP_EOL;
			
			$mobileYrno6hTable_9 .= '
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
			
			$mobileYrno6hTable_9 .= '<td class="mobile-td-day-hours">' . $dayParts3 . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-rain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-weather">' . $arrDesc[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-wind">' . $arrWind[$i] . '</td>' . PHP_EOL;
			$mobileYrno6hTable_9 .= '<td class="mobile-td-data-baro">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
			
		}
		
		$mobileYrno6hTable_9 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/* FINAL ---------------------------------------------------------------------------- */

$logoMetYr = '<img src="' . $imgDir . 'met.no_logo2_eng_250px.jpg" class="yrno-image" alt="Met.No - Yr.No logo"/>';
$creditString =
'<table class="table-yrno-credit">
   	<tr>
       	<td class="logo-yrno">' . $logoMetYr . '</td>
           <td><small>Weather <a target="new" href="http://www.yr.no/?lang=en">Forecast</a> from yr.no, 
            	delivered by the Norwegian Meteorological Institute and the NRK. </small></td>
		</tr>
</table>';

# now we generate the detail table if needed
if ( !$yrnoDetailTable ) {
	return;
}

$script = $scriptDir . '/wp-content/themes/cameraski/lib/meteo-yrno-forecast/yrnoCreateDetailArr.php';
// AFEGIT
echo '<!-- trying to load ' . $script . ' -->' . PHP_EOL;
include $script;
$weather 		= new yrnoDetailWeather();
$returnDetails 	= $weather->getWeatherDetailData( $yrnoID );
unset( $weather );
#echo '<pre>'; print_r ($returnDetails); exit;

$rowColor			= 'row-dark';
/*$yrnoDetailTable 	= '<table class="meteoYrnoTable" style="width: 100%;"><tbody>' . PHP_EOL;
$yrnoDetailHead     = '<tr class="table-top">
							<td>' . yrnotransstr( 'Period' ) . '</td>
                            <td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
							<td>' . yrnotransstr( 'Temperature' ) . '</td>
                            <td>' . yrnotransstr( 'Precipitation' ) . '</td>
							<td colspan="2">' . yrnotransstr( 'Wind' ) . '</td>
                            <td>' . yrnotransstr( 'Pressure' ) . '</td>
						</tr>' . PHP_EOL;*/

$yrno3hTable_1 	= '<table class="yrno3hTable_1" style="width: 100%;" style="background-color: white;"><tbody>' . PHP_EOL;
$yrno3hHead     = '<tr class="table-top3h">
							<td>' . yrnotransstr( 'Period' ) . '</td>
                            <td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
							<td>' . yrnotransstr( 'Temperature' ) . '</td>
                            <td>' . yrnotransstr( 'Precipitation' ) . '</td>
							<td colspan="2">' . yrnotransstr( 'Wind' ) . '</td>
                            <td>' . yrnotransstr( 'Pressure' ) . '</td>
						</tr>' . PHP_EOL;

$mobileYrno3hTable_1 	= '<table class="mobileYrno3hTable_1" style="width: 100%;" style="background-color: white;"><tbody>' . PHP_EOL;
$mobileYrno3hHead     = '<tr class="table-top3h">
							<td>' . yrnotransstr( 'Period' ) . '</td>
                            <td colspan="2">' . yrnotransstr( 'Forecast' ) . '</td>
							<td>' . yrnotransstr( 'Temperature' ) . '</td>
                            <td>' . yrnotransstr( 'Precipitation' ) . '</td>
							<td colspan="2">' . yrnotransstr( 'Wind' ) . '</td>
                            <td>' . yrnotransstr( 'Pressure' ) . '</td>
						</tr>' . PHP_EOL;

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
		$cols           	= '8';
		//$yrnoDetailTable 	.= myDateLinePrint( $arr['timeTo'] );$yrno3hTable_2
		//$yrnoDetailTable 	.= $yrnoDetailHead;
		$yrno3hTable_1 	.= myDateLinePrint( $arr['timeTo'] );
		$yrno3hTable_1 	.= $yrno3hHead;
		$mobileYrno3hTable_1 	.= myDateLinePrint( $arr['timeTo'] );
		//$mobileYrno3hTable_1 	.= $yrno3hHead;
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
	//$yrnoDetailTable .= '<tr class="' . $rowColor . '">' . PHP_EOL;
	$yrno3hTable_1 .= '<tr class="tr3hRow">' . PHP_EOL;
	$mobileYrno3hTable_1 .= '<tr class="mobile3htr-Top">' . PHP_EOL;
	
	if ( $rowColor == 'row-dark' ) {
		$rowColor = 'row-light';
	} else {
		$rowColor =  'row-dark';
	}

	$to 	= ( string ) date( $hourOnlyFormat, $arr['timeTo'] );
	$start  = ( string ) date( $hourOnlyFormat, $arr['timeFrom'] );
	$period = $start . ':00 - ' . $to . ':00 h';
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
	$windText	='<span style="background-color: ' . $color . ';">' . $arr['windSpeed'] . '<br />' . $tekst . '</span>';
  	$stringWind	= '<img src="' . $iconsWind . yrnotransstr( $arr['windDir'] ) . '.png" width="32" alt="" />';
  	//$wind		= $windText . '<br />' . yrnotransstr( 'from the' ) . ' ' . yrnotransstr( $arr['windDir'] );
	//$wind		= $windText . '<br />' . $stringWind;
	$wind		= $stringWind . ' ' . $windText;
	$notUsed 	= $iconUrl = $iconOut = $iconUrlOut = '';
    $iconIn  	= $arr['icon'];
    list ( $url, $urlsmall )  = yrnoIcon ( $iconIn );
	$description 		= yrnotransstr( $arr['weatherDesc'] );
	$icon 				= '<img src="' . $url . '" alt =" " width ="60" title="' . $description . '"/>';
	/*$yrnoDetailTable 	.= '<td>' . $period . '</td>
    						<td>' . $description . '</td>
							<td>' . $icon . '</td>
                            <td>' . $tempString . '</td>
							<td>' . $rain . '</td>
                            <td>' . $stringWind . '</td>
							<td>' . $windText . '</td>
                            <td>' . $arr['baro'] . '</td>
						</tr>' . PHP_EOL;*/
	$yrno3hTable_1 			.= '<td class="period3h"><strong>' . $period . '</strong></td>
								<td>' . $icon . '</td>
								<td>' . $description . '</td>
								<td>' . $tempString . '</td>
								<td><strong>' . $arrRain[$i] . $uomRain . '</strong></td>
								<td>' . $stringWind . '</td>
								<td>' . $windText . '</td>
								<td>' . $arr['baro'] . '</td>
						</tr>' . PHP_EOL;
	$mobileYrno3hTable_1 	.= '<td class="mobile3hPeriod"><strong>' . $period . '</strong></td>
								<td class="mobile3hIcon">' . $icon . '</td>
                            	<td class="mobile3hTemp">' . $tempString . '</td>
                                <td class="mobile3hArrow">' . $stringWind . '</td>
                                <td class="mobile3hWindDesc">' . $tekst . '</td></tr>
                                <tr class="mobile3htr-Bottom">
                                <td class="mobile3hVoid"></td>
                                <td class="mobile3hRain"><strong>' . $arrRain[$i] . $uomRain . '</strong></td>
                                <td class="mobile3hDescription">' . $description . '</td>
                                <td class="mobile3hWindSpeed">' . $windSpeed . $uomWind . '</td>
                                <td class="mobile3hBaro">' . $arr['baro'] . '</td>
								</tr>' . PHP_EOL;
}

#print_r($arrDay);
//$yrnoDetailTable .= '</tbody></table>' . PHP_EOL;
$yrno3hTable_1 .= '</tbody></table>' . PHP_EOL;
$mobileYrno3hTable_1 .= '</tbody></table>' . PHP_EOL;

# ------------------------------------------------------------------

/*****************************/
/* CARLES - 3H PRIMERA TAULA */
/*****************************/
/*if ( count( $arrTime ) < $topCount3h_1 ) {
	$end = count( $arrTime );
} else {
	$end = $topCount3h_1;
}

$topCount3h_1	= $end;
$iconWidth	= 100 / $topCount3h_1;
$yrno3hTable_1	= '
<table class="yrno3hTable_1 centerTable" style="background-color: white;">
	<thead class="thead-icons">' . PHP_EOL;
		
		//for ( $i = 0; $i < count( $returnDetails['forecast'] ); $i++ ) {
		for ( $i = 0; $i < 1; $i++ ) {
			
			$arr = $returnDetails['forecast'][$i];
			
			if ( $now > $arr['timeTo'] ) {
				continue;
			}
			
			if ( $oldDay <> $arr['date'] ) { // do we have a new day
				$oldDay  			= $arr['date'];
				$graphsDays[]   	= 1000 * ( $arr['timestamp'] + $utcDiff );
				$cols           	= '24';
				$yrnoDetailTable 	.= myDateLinePrint( $arr['timeTo'] );
			}
			
        }

		$yrno3hTable_1 .= '</thead><tbody class="tbody-3h"><tr class="tr-dayParts">' . PHP_EOL;

		for ( $i = 0; $i < $end; $i++ ) {
			$yrno3hTable_1 .=  '<td class="td-period" style="width:12.5%;" colspan="3">' . $arrDay[$i] . '</td>' . PHP_EOL;
		}
			
		$yrno3hTable_1 .= '</tr><tr class="tr-icons">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$icon = '<img src="' . $arrIcon[$i] . '" alt="" width="80" title="' . $arrDesc[$i] . '"/>';
			$yrno3hTable_1 .= '<td class="td-data-icons" style="width:12.5%;" colspan="3" rowspan="3">' . $icon . '<br />' . '<strong>' . $arrRain[$i] . $uomRain . '</strong><br />' . $arrDesc[$i] . '</td>' . PHP_EOL;
		}
		
		$yrno3hTable_1 .= '</tr><tr></tr><tr></tr><tr class"tr-baro">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$yrno3hTable_1 .= '<td class="td-3h-data-baro" style="width:12.5%;" colspan="3">' . $arrBaro[$i] . $uomBaro . '</td>' . PHP_EOL;
        }
		
		$yrno3hTable_1 .= '</tr><tr class="temp-windarrow">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$temp	  = round( $arrTemp[$i] );
			$string   = myCommonTemperature( $temp );
			# $string = '<span class="myTemp" style="text-shadow:1px 1px black; font-weight: bolder; font-size: 200%; color: ' . $color . ';" >' . $temp . '&deg;</span>';
			$yrno3hTable_1  .= '<td class="td-3h-data-temp" style="width:8.33333%" colspan="2">' . $string . '</td>' . PHP_EOL;
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno3hTable_1 .= '<td class="td-3h-arrow-wind" style="width:4.16666%" colspan="1">' . $stringWind . '</td>' . PHP_EOL;
		}
		
		$yrno3hTable_1 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$stringWind	= '<img src="' . $iconsWind . $arrWindIcon[$i] . '.png" width="32" alt="" />';
			$yrno3hTable_1 .= '<td class="td-3h-wind-speed" style="width:6.25%" colspan="3">' . $arrWind[$i] . '</td>' . PHP_EOL;
        }
		
		$yrno3hTable_1 .= '</tr>
		<tr class="tr-wind">' . PHP_EOL;
		
		for ( $i = 0; $i < $end; $i++ ) {
			$yrno3hTable_1 .= '<td class="td-3h-wind-desc" style="width:12.5%" colspan="3">' . $tekst . '</td>' . PHP_EOL;
		}
		
		// CARLES
		$yrno3hTable_1 .= '</tr>
		<tr class="tr-bottom">' . PHP_EOL;
		
		//for ( $i = $topCount_1; $i < $end; $i++ ) {
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
            
			//for ( $i = 0; $i < $end; $i++ ) {
				$yrno3hTable_1 .= '<td class="td-foot" style="width:12.5%" colspan="3">' . $dayParts3 . '</td>' . PHP_EOL;
            //}
			
		}
		
		$yrno3hTable_1 .= '
		</tr>
	</tbody>
</table>
' . PHP_EOL;

/* FINAL ---------------------------------------------------------------------------- */

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
	$string 		= '<tr class="yrnoDateHeader">
    						<th colspan="' . $cols . '">
								<span style="float:left; position:relative;"><b>' . $longDate . '</b></span>
								<span style="float:right;position:relative;">
									<span class="rTxt">
										<img src="' . $imgDir . '/sunrise.png" width="24" height="12" alt="sunrise" />&nbsp;' . date( $timeFormat, $srise ) . '&nbsp;&nbsp;
										<img src="' . $imgDir . '/sunset.png"  width="24" height="12" alt="sunset" />&nbsp;' . date( $timeFormat, $sset ) . '&nbsp;&nbsp;' . yrnotransstr( 'Day length' ) . ': ' . $strDayLength . '
									</span>
								</span>
							</th>
						</tr>' . PHP_EOL;

	if ( $rowColor == 'row-dark' ) {
		$rowColor = 'row-light';
	} else {
		$rowColor =  'row-dark';
	}	
	return $string;

}