<?php

$pageName		= 'yrnoCreateDetailArr.php';
$pageVersion	= '3.00 2014-07-11';
$string         = $pageName . '- version: ' . $pageVersion;
$pageFile 		= basename( __FILE__ ); // check to see this is the real script

if ( $pageFile <> $pageName ) {
	$string .= ' - ' . $pageFile . ' loaded instead.';
}
// AFEGIT
echo '<!-- module loaded: ' . $string . '. -->' . PHP_EOL;
#--------------------------------------------------------------------------------------------------
# retrieve weather infor from weathersource (YrNo weather) 
# and return array with retrieved data in the desired language and units C/F
#
#  http://www.yr.no/place/Canada/Other/Toronto/forecast_hour_by_hour.xml
#   location Canada/Other/Toronto
#--------------------------------------------------------------------------------------------------
class yrnoDetailWeather {
  	
	# public variables
	public $location	= 'Canada/Other/Toronto'; 
	public $lang		= 'en';	// supported languages english only
	public $uom			= 'metric'; // units always celsius / hPa / m/s / mm?
	# private variables
	private $uomTemp	= 'c';
	private $uomBaro	= 'hpa';
	private $uomWind	= 'ms';
	private $uomRain	= 'mm';
	private $enableCache= true;	// cache should be anabled when frequent request are made. Keep in mind that the data is only refreshed every hour by google 
	private $cachePath	= 'cache'; // cache dir is created when not available
	private $cacheTime 	= 7200; // Cache expiration time Default: 3600 seconds = 1 Hour
	private $cacheFile	= 'xxx';
	private $apiUrlpart = array( // http://www.yr.no/place/Canada/Other/Toronto/forecast_hour_by_hour.xml
		0 => 'http://www.yr.no/place/',
		1 => 'userinput',
		2 => '/forecast_hour_by_hour.xml'
	);
	private $weatherApiUrl = '';
	private $rawData;
	#--------------------------------------------------------------------------------------------------
	# public functions	
	#--------------------------------------------------------------------------------------------------
	public function getWeatherDetailData( $userLocation = '' ) {
		global  $toTemp,  $toWind,  $toRain, $toBaro, $pageName, $cacheDir,
		        $uomTemp, $uomWind, $uomRain, $uomBaro;
		#----------------------------------------------------------------------------------------------
		# clean user input
		#----------------------------------------------------------------------------------------------
		$userLocation 	        = trim( $userLocation );
		$this->location         = $userLocation;
		$filename               = str_replace( '/', '', $userLocation );
		$this->cachePath        = $cacheDir;
		$uoms                   = $toTemp . $toWind . $toRain . $toBaro;
		$this->cacheFile        = $this->cachePath . $pageName . '-' . $this->lang . '-' . $filename . '-' . $uoms;
		#----------------------------------------------------------------------------------------------
		# try loading data from cache
		#----------------------------------------------------------------------------------------------		
		if ( $this->enableCache ) {
          	
			$returnArray = $this->loadFromCache();	// load from cache returns data only when its data is valid
          	
			if ( !empty($returnArray ) ) {
				return $returnArray; // if data is in cache and valid return data to calling program
			} // eo valid data, return to calling program
          	
		}  // eo check cache
		#----------------------------------------------------------------------------------------------
		# combine everything into required url
		#----------------------------------------------------------------------------------------------
		#  http://www.yr.no/place/Canada/Other/Toronto/forecast_hour_by_hour.xml
		$this->apiUrlpart[1] = $this->location;
		$this->weatherApiUrl = '';
      	
		for ( $i = 0; $i < count( $this->apiUrlpart ); $i++ ) {
			$this->weatherApiUrl .= $this->apiUrlpart[$i];
		}
      	
		if ( !$this->makeRequest() ) { // load xml from url and process
			echo 'Unable to retrieve xml for ' . $this->weatherApiUrl .' - Program halted.';
		    exit;		
		}
      	
        $xml = new SimpleXMLElement( $this->rawData );
		// print_r ($xml);
		$returnDetails = array();
		#--------------------------------------------------------------------------------------------------
		# first, get and save request info / units etc
		#--------------------------------------------------------------------------------------------------
		$returnDetails['request_info']['type'] 	        = 'xml';
        $returnDetails['request_info']['city']	        = ( string ) $xml->location->name . '-' . $xml->location->country;
        $returnDetails['request_info']['logo'] 	        = ( string ) $xml->credit->link['text'];
        $returnDetails['request_info']['link'] 	        = ( string ) $xml->credit->link['url'];
        $returnDetails['request_info']['uomTemp'] 		= $this->uomTemp;
        $returnDetails['request_info']['uomWind'] 		= $this->uomWind;
        $returnDetails['request_info']['uomRain'] 		= $this->uomRain;
        $returnDetails['request_info']['uomBaro'] 		= $this->uomBaro;
        $returnDetails['request_info']['lastupdate']    = ( string ) $xml->meta->lastupdate;
        $string                                         = ( string ) $xml->meta->nextupdate;
        $returnDetails['request_info']['nextupdate']    = $string;
        $returnDetails['request_info']['nextupdateunix']= strtotime( $string );
		#--------------------------------------------------------------------------------------------------
		#  get forecast info
		#--------------------------------------------------------------------------------------------------
        $end = count( $xml->forecast->tabular->time ); // one forecast is one occurence of <time>...</time>
		
      	for ( $i = 0; $i < $end ; $i++ ) {
          	
			# <time from="2013-05-08T11:00:00" to="2013-05-08T14:00:00">
            $returnDetails['forecast'][$i]['date'] 	        = substr( ( string ) $xml->forecast->tabular->time[$i-1]['to'], 0, 10 );
            $returnDetails['forecast'][$i]['timeFrom']		= strtotime((string) $xml->forecast->tabular->time[$i-1]['from']);
            $returnDetails['forecast'][$i]['timeTo'] 		= 
            $returnDetails['forecast'][$i]['timestamp']     = strtotime( ( string ) $xml->forecast->tabular->time[$i-1]['to'] );
            $data 											= $xml->forecast->tabular->time[$i-1];
            # <symbol number="3" name						= "Partly cloudy" var="03d"/>
            $returnDetails['forecast'][$i]['icon']	        = ( string ) $data->symbol['number'];				
            $returnDetails['forecast'][$i]['weatherDesc']   = ( string ) $data->symbol['name'];
            # <temperature unit="celsius" value="18"/>
            $string 										= ( string ) $data->temperature['value'];	
            $amount											= yrnoConvertTemp( $string, $this->uomTemp );
            $returnDetails['forecast'][$i]['tempNU'] 		= ( string ) $amount;
            $returnDetails['forecast'][$i]['temp'] 	        = ( string ) $amount.$uomTemp;
            # <windSpeed mps="4.7" name="Gentle breeze"/>
            $string											= ( string ) $data->windSpeed['mps'];
            $amount 										= yrnoConvertWind( $string, $this->uomWind );
            $returnDetails['forecast'][$i]['windSpeedNU']   = ( string ) $amount;
            $returnDetails['forecast'][$i]['windSpeed']		= ( string ) $amount.$uomWind;
            $returnDetails['forecast'][$i]['windTxt'] 		= ( string ) $data->windSpeed['name'];
            # <windDirection deg="103.6" code="ESE" name	= "East-southeast"/>
            $returnDetails['forecast'][$i]['windDir'] 		= ( string ) $data->windDirection['code'];
            $returnDetails['forecast'][$i]['windDeg'] 		= ( string ) $data->windDirection['deg'];
            # <precipitation value="0"/>
          	
            if ( isset ( $data->precipitation['maxvalue'] ) ) {
              	
                $amount = $data->precipitation['minvalue'];
                $string = ( string ) yrnoConvertRain( $amount, $this->uomRain );
                $amount = $data->precipitation['maxvalue'];
                $string .='-'.( string ) yrnoConvertRain( $amount, $this->uomRain );
            
            } else {
            
            $amount = $data->precipitation['value'];
            $string =( string ) yrnoConvertRain( $amount, $this->uomRain );
            
            }
          	
            $returnDetails['forecast'][$i]['rainNU'] 	= $string;
            $returnDetails['forecast'][$i]['rain'] 		= $string . $uomRain;
            # <pressure unit="hPa" value="1014.8"/>
            $string 									= ( string ) $data->pressure['value'];
            $amount										= round( yrnoConvertBaro( $string, $this->uomBaro ) );
            $returnDetails['forecast'][$i]['baroNU'] 	= ( string ) $amount;				
            $returnDetails['forecast'][$i]['baro'] 		= ( string ) $amount . $uomBaro;
          	
		}	// eo for loop forecasts
		
		if ( $this->enableCache && !empty( $this->cachePath ) ) {
			$this->writeToCache( $returnDetails );
		}
      	
		return $returnDetails;

	} // eof getWeatherData
	
	private function loadFromCache() {
      	
		if ( !file_exists( $this->cacheFile ) ) {
          	return;
        } // no cached file found => goback
      	
        $returnArray    = unserialize( file_get_contents( $this->cacheFile ) );
        $updatetime     = $returnArray['request_info']['nextupdateunix'];
        $updatestring   = date ( 'c', $updatetime );
        $now            = time();
        $nowtimestring  = date ( 'c', $now );
        
      	if ( $now > $updatetime ) {
          	return;
        } // new update should be available => goback
      	
        echo "<!-- weatherdata ( $this->cacheFile ) loaded from cache.
			Next-update at $updatestring ( $updatetime )
			It is now      $nowtimestring ( $now )  -->" . PHP_EOL;
		return $returnArray;
      	
	} // eof loadFromCache
	
	private function writeToCache( $data ) {
      	
		if ( !file_put_contents( $this->cacheFile, serialize( $data ) ) ) {
			echo PHP_EOL . "<!-- Could not save data ( $this->cacheFile ) to cache ( $this->cacheFile ). Please make sure your cache directory exists and is writable. -->" . PHP_EOL;
		} else {
          	echo "<!-- Weatherdata ( $this->cacheFile ) saved to cache. -->" . PHP_EOL;
        }
      	
	} // eof writeToCache
	
	private function makeRequest() {
      	
	    global $scriptDir;
		$test = false;
      	
		if ( $test ) {
			$this->rawData  = file_get_contents( $scriptDir . 'testDetail.xml' );
			echo '<!-- test file testDetail.xml loaded. -->' . PHP_EOL;
		} else {
			$this->rawData = yrnoCurl ( $this->weatherApiUrl );
		}
      	
      	// AFEGIT
		echo '<!-- curl for: ' . $this->weatherApiUrl . ' -->' . PHP_EOL;

		if ( empty( $this->rawData ) ) {
			return false;
		}
      	
		$search = array ( 'Service Unavailable', 'Error 504', 'Error 503' );
		$error 	= false;
      	
		for ( $i = 0; $i < count( $search ); $i++ ) {
          	
			$int = strpos( $this->rawData , $search[$i] );
          	
			if ( $int > 0 ) {
              	$error = true; break;
            }
          	
		}
      	
		if ( $error == false ) {
          	return true;
        } else {
          	return false;
        }
      	
	} // eof makeRequest
	
}