<?php

$pageName		= 'yrnoavansert3.php'; // the name of this module 
$pageVersion	= '3.01 2015-10-08'; // the version = last version

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

if ( !function_exists ( 'LoadPNG' ) ) {

	function LoadPNG ( &$retCode, $imgname ) {
    
		$im = @imagecreatefrompng ( $imgname ); // Attempt to open 
    	
		if ( !$im ) { // See if it failed
			$retCode = false;
		} // eo test failed
    	
		return $im;
	
	} // eof  loadPNG
}

$name 		= str_replace ( '/', '_', $yrnoID );
$cacheFile	= $cacheDir . $name . 'yrnoavansert3.png';
$yrTotalPng = 'http://www.yr.no/place/' . $yrnoID . '/avansert_meteogram.png';

$cacheTime	= 7200;
$retCodeOK	= true;

if ( file_exists( $cacheFile ) ) { // check if a cached version exist
  	
	$fileTime = filectime( $cacheFile ); // check age of cached file
	$now = time();
	$diff = ( $now - $fileTime );
  	
	if ( $diff <= $cacheTime ) { // is it still usable
		$im = 	$cacheFile;
		return;
	}

}

$im = LoadPNG ( $retCodeOK, $yrTotalPng ); // load picture

if ( !$retCodeOK ) { // something went wrong, probably loading url
  	
	if ( ( file_exists( $cacheFile ) ) && ( $diff < 5 * $cacheTime ) ) { // if it is not tooooooo old, try cache 
		$im = 	$cacheFile;
		return;
	}

}

if ( $retCodeOK ) { // did we correctly load a new picture
	imagepng( $im, $cacheFile ); // than save it in the cache
	$im = $cacheFile;
} else {
	$im = $yrTotalPng;
}