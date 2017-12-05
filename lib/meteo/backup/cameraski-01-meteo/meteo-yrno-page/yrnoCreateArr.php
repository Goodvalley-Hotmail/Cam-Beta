<?php
if (isset($_REQUEST['sce']) && strtolower($_REQUEST['sce']) == 'view' ) {
   //--self downloader --
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
$pageName		= 'yrnoCreateArr.php';
$pageVersion	= '3.00 2014-07-11';
$string         = $pageName.'- version: ' . $pageVersion;
$pageFile 		= basename(__FILE__); // check to see this is the real script
if ($pageFile <> $pageName) {$string .= ' - '.$pageFile .' loaded instead';}
echo '<!-- module loaded:'.$string.' -->'.PHP_EOL;
#--------------------------------------------------------------------------------------------------
# retrieve weather infor from weathersource (YrNo weather) 
# and return array with retrieved data in the desired language and units C/F
#
#  http://www.yr.no/place/Belgium/Flanders/Wilsele/varsel.xml
#   location Belgium/Flanders/Wilsele
#--------------------------------------------------------------------------------------------------
class yrnoWeather{
	# public variables
	public $location	= 'Belgium/Flanders/wilsele';  
	public $lang		= 'en'; // supported languages english only
	public $uom			= 'metric'; // units always celsius / hPa / m/s / mm?
	# private variables
	private $uomTemp	= 'c';
	private $uomBaro	= 'hpa';
	private $uomWind	= 'ms';
	private $uomRain	= 'mm';
	private $enableCache= true;	// cache should be anabled when frequent request are made. Keep in mind that the data is only refreshed every hour by google 
	private $cachePath	= 'cache'; // cache dir is created when not available
	private $cacheTime 	= 7200; // Cache expiration time Default: 7200 seconds = 2 Hour
	private $cacheFile	= 'xxx';
	private $apiUrlpart = array(		// http://www.yr.no/place/Belgium/Flanders/Wilsele/varsel.xml
	 0 => 'http://www.yr.no/place/',
	 1 => 'userinput',
	 2 => '/varsel.xml'
	);
	private $weatherApiUrl = '';
	private $rawData;
#--------------------------------------------------------------------------------------------------
# public functions	
#--------------------------------------------------------------------------------------------------
	public function getWeatherData($userLocation = '') {
		global  $toTemp,  $toWind,  $toRain, $toBaro, $pageName, $cacheDir,
		        $uomTemp, $uomWind, $uomRain,$uomBaro;		
#----------------------------------------------------------------------------------------------
# clean user input
#----------------------------------------------------------------------------------------------
		$userLocation 	        = trim($userLocation);
		$this->location         = $userLocation;
		$filename               = str_replace( '/', '', $userLocation);
		$this->cachePath        = $cacheDir;
		$uoms                   = $toTemp.$toWind.$toRain.$toBaro;
		$this->cacheFile        = $this->cachePath.$pageName.'-'.$this->lang.'-'.$filename.'-' .$uoms;
#----------------------------------------------------------------------------------------------
# try loading data from cache
#----------------------------------------------------------------------------------------------		
		if ( $this->enableCache) {
			$returnArray    = $this->loadFromCache();	// load from cache returns data only when its data is valid
			if (!empty($returnArray)) {
				return $returnArray;			// if data is in cache and valid return data to calling program
			}  // eo valid data, return to calling program
		}  // eo check cache
#----------------------------------------------------------------------------------------------
# combine everything into required url
#----------------------------------------------------------------------------------------------
		#  http://www.yr.no/place/Belgium/Flanders/Wilsele/varsel.xml
		$this->apiUrlpart[1]    = $this->location;
		$this->weatherApiUrl    = '';
		for ($i = 0; $i < count($this->apiUrlpart); $i++){
			$this->weatherApiUrl .= $this->apiUrlpart[$i];
		}
		if (!$this->makeRequest()) {    // load xml from url, if fails stop
		        echo 'Unable to retrieve xml for '.$this->weatherApiUrl .' - ptogram halted';
		        exit;
		}
                $xml = new SimpleXMLElement($this->rawData);
                $returnArray = array();
#--------------------------------------------------------------------------------------------------
# first, get and save request info / units etc
#--------------------------------------------------------------------------------------------------	
                $returnArray['request_info']['type'] 	        = 'xml';
                $returnArray['request_info']['city']	        = (string) $xml->location->name.'-'.$xml->location->country;
                $returnArray['request_info']['logo'] 	        = (string) $xml->credit->link['text'];
                $returnArray['request_info']['link'] 	        = (string) $xml->credit->link['url'];
                $returnArray['request_info']['uomTemp'] 	= $this->uomTemp;
                $returnArray['request_info']['uomWind'] 	= $this->uomWind;
                $returnArray['request_info']['uomRain'] 	= $this->uomRain;
                $returnArray['request_info']['uomBaro'] 	= $this->uomBaro;
                $returnArray['request_info']['uomDistance']     = 'n/a';
                $returnArray['request_info']['lastupdate'] 	= (string) $xml->meta->lastupdate;
                $returnArray['request_info']['nextupdate'] 	= (string) $xml->meta->nextupdate;
                $returnArray['request_info']['nextupdate'] 	= (string) $xml->meta->nextupdate;
                $returnArray['request_info']['nextupdateunix']	= strtotime($returnArray['request_info']['nextupdate']);
#--------------------------------------------------------------------------------------------------
# YR.NO only supplies forecast, no current condition descriptions
#--------------------------------------------------------------------------------------------------
#--------------------------------------------------------------------------------------------------
#  get forecast info
#--------------------------------------------------------------------------------------------------
                $end = count($xml->forecast->tabular->time);  // one forecast is one occurence of <time>...</time>
                for ($i = 0; $i < $end; $i++){
                        # <time from="2013-05-08T05:00:00" to="2013-05-08T11:00:00" period="1">
                        $returnArray['forecast'][$i]['date'] 		= substr((string) $xml->forecast->tabular->time[$i]['from'],0,10);
                        $returnArray['forecast'][$i]['timeFrom']	= strtotime((string) $xml->forecast->tabular->time[$i]['from']);
                        $returnArray['forecast'][$i]['timeTo'] 		= 
                        $returnArray['forecast'][$i]['timestamp'] 	= strtotime((string) $xml->forecast->tabular->time[$i]['to']);
                        $returnArray['forecast'][$i]['hour'] 		= (string) $xml->forecast->tabular->time[$i]['period'];
                        $data 						= $xml->forecast->tabular->time[$i];
                        # <symbol number="2" name="Fair" var="02d"/>
                        $returnArray['forecast'][$i]['icon']		= (string) $data->symbol['number'];		// = icon number
                         $returnArray['forecast'][$i]['weatherDesc']	= (string) $data->symbol['name'];
                        # <temperature unit="celsius" value="11"/>
                        $string 					= (string) $data->temperature['value'];
                        $amount						= yrnoConvertTemp($string, $this->uomTemp);
                        $returnArray['forecast'][$i]['tempNU'] 		= (string) $amount;
                        $returnArray['forecast'][$i]['temp'] 		= (string) $amount.$uomTemp;
                        # <windSpeed mps="3.4" name="Gentle breeze"/>
                        $string						= (string) $data->windSpeed['mps'];
                        $amount 					= yrnoConvertWind($string, $this->uomWind);
                        $returnArray['forecast'][$i]['windSpeedNU']	= (string) $amount;
                        $returnArray['forecast'][$i]['windSpeed']	= (string) $amount.$uomWind;
                        $returnArray['forecast'][$i]['windTxt'] 	= (string) $data->windSpeed['name'];
                        # <windDirection deg="105.3" code="ESE" name="East-southeast"/>
                        $returnArray['forecast'][$i]['windDir'] 	= (string) $data->windDirection['code'];
                        $returnArray['forecast'][$i]['windDeg'] 	= (string) $data->windDirection['deg'];
                        # <precipitation value="0.9"/>
                        if (isset ($data->precipitation['maxvalue'])) {
                                $amount                                 = $data->precipitation['minvalue'];
                                $string                                 = (string) yrnoConvertRain($amount, $this->uomRain);
                                $amount                                 = $data->precipitation['maxvalue'];
                                $string                                 .='-'.(string) yrnoConvertRain($amount, $this->uomRain);
                        } else {
                                $amount                                 = $data->precipitation['value'];
                                $string                                 =(string) yrnoConvertRain($amount, $this->uomRain);					
                        }				
                        $returnArray['forecast'][$i]['rainNU'] 		= $string;
                        $returnArray['forecast'][$i]['rain'] 		= $string.$uomRain;
                        # <pressure unit="hPa" value="1014.8"/>
                        $string 				        = (string) $data->pressure['value'];
                        $amount						= yrnoConvertBaro($string, $this->uomBaro);
                        $returnArray['forecast'][$i]['baroNU'] 		= (string) $amount;				
                        $returnArray['forecast'][$i]['baro'] 		= (string) $amount.$uomBaro;
                }	// eo for loop forecasts
                
        
                if ($this->enableCache){
                        $this->writeToCache($returnArray);
                }		
                return $returnArray;	
	} // eof getWeatherData
	
	private function loadFromCache(){
		if (!file_exists($this->cacheFile)){
          return;
        }  // no cached file found => goback
      
		$returnArray    = unserialize(file_get_contents($this->cacheFile));	
		$updatetime     = $returnArray['request_info']['nextupdateunix'];
		$updatestring   = date ('c',$updatetime);
		$now            = time();
		$nowtimestring  = date ('c',$now);
      
        if ($now > $updatetime){
        	return;
        } // new update should be available => goback
      
        echo "<!-- weatherdata ($this->cacheFile) loaded from cache
				next-update at $updatestring ($updatetime)
				it is now      $nowtimestring ($now)  -->".PHP_EOL; 
		        return $returnArray;
      
	} // eof loadFromCache
	
	private function writeToCache($data){
		if (!file_put_contents($this->cacheFile, serialize($data))){   
			echo PHP_EOL."<!-- Could not save data ($this->cacheFile) to cache ($this->cacheFile). Please make sure your cache directory exists and is writable. -->".PHP_EOL;
		} else {echo "<!-- Weatherdata ($this->cacheFile) saved to cache  -->".PHP_EOL;}
	} // eof writeToCache
	
	private function makeRequest(){
	        global $scriptDir;
		$test= false;
		if ($test) {
			$this->rawData  = file_get_contents($scriptDir.'test.xml');
			echo '<!-- test file test.xml loaded -->'.PHP_EOL;
		} else {
                        $this->rawData =yrnoCurl ($this->weatherApiUrl);
		}
		echo '<!-- curl for: '.$this->weatherApiUrl.' -->'.PHP_EOL;
		if (empty($this->rawData)){
			return false;
		}
		$search = array ('Service Unavailable','Error 504','Error 503');
		$error  = false;
		for ($i = 0; $i < count($search); $i++) {
			$int = strpos($this->rawData , $search[$i]);
			if ($int > 0) {
				$error = true; break;
			}
		}
		if ($error == false) {
			return true;
		} else {
			return false;
		}
	} // eof makeRequest
	
}