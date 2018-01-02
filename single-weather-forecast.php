<?php
/**
 * Description
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://cameraski.com
 * @license     GNU General Public License 2.0+
 */

//namespace CameraSki;

add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\attributes_site_inner' ); // Aix� ho hav�em comentat el 25/04/2016, no ho tinc clar per� en principi �s correcte tal com est�.
/**
 * 25/04/2016 - Adds the attributes from 'entry', since this replaces the main entry.
 *
 * @since   1.0.0
 *
 * @param $attributes
 *
 * @return mixed
 */
function attributes_site_inner( $attributes ) {
	$attributes[ 'role' ]		= 'main';
	$attributes[ 'itemprop' ]	= 'mainContentOfPage';
	
	return $attributes;
}

// 25/04/2016 - Remove div.site-inner's div.wrap - NO-> Ho hem comentat. No caldria perqu� el Sample Theme no inclou el site-inner's wrap.
//add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Reposition Breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove the Entry meta (Post Info) in the Entry Header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove Post Meta - To remove empty markup, '<p class="entry-meta"></p>' for Entries that have not been assigned to any Location
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_footer', __NAMESPACE__ . '\custom_post_meta' );

get_header();

// 25/04/2016 - Treiem el div content-sidebar-wrap - NO-> Ho hem descomentat - DONCS S�, HO HEM TORNAT A COMENTAR (21/07/2016)
/*do_action( 'genesis_before_content_sidebar_wrap' );
genesis_markup( array(
	'html5'   => '<div %s>',
	'xhtml'   => '<div id="content-sidebar-wrap">',
	'context' => 'content-sidebar-wrap',
) );*/

// 25/04/2016 - Treiem el <main class="content"> - NO-> Ho hem descomentat
do_action( 'genesis_before_content' );
genesis_markup( array(
	'html5'   => '<main %s>',
	'xhtml'   => '<div id="content" class="hfeed">',
	'context' => 'content',
) );

do_action( 'genesis_before_loop' );
//do_action( 'genesis_loop' );

if ( have_posts() ) :

	do_action( 'genesis_before_while' );
	while ( have_posts() ) : the_post();

		do_action( 'genesis_before_entry' );
		
		// 25/04/2016 - Etiqueta HTML <article>	
		printf( '<article %s>', genesis_attr( 'entry' ) );

			do_action( 'genesis_entry_header' );

			do_action( 'genesis_before_entry_content' );

			printf( '<div %s>', genesis_attr( 'entry-content' ) );
			
			do_action( 'genesis_entry_content' );
			
			echo '<div class="flexbox-meteo">';
			
				ob_start();
				
				# ---------------HERE YOU NEED TO MAKE SOME CHANGES --------------------
				$defaultWidth           = '60%';        // set do desired width 999px  or 100%
				# what parts should be printed
				$times                  = true;         // 
				# icons for top of page or startpage
				$iconGraph              = false;        // icon type header  with 2 icons for each day (12 hours data)
				//$topCount               = 4;           // max nr of day-part forecasts in icons or graph
				$topCount_1               = 4;           // max nr of day-part forecasts in icons or graph
				$topCount_2               = 8;           // max nr of day-part forecasts in icons or graph
				$topCount_3               = 12;           // max nr of day-part forecasts in icons or graph
				$topCount_4               = 16;           // max nr of day-part forecasts in icons or graph
				$topCount_5               = 20;           // max nr of day-part forecasts in icons or graph
				$topCount_6               = 24;           // max nr of day-part forecasts in icons or graph
				$topCount_7               = 28;           // max nr of day-part forecasts in icons or graph
				$topCount_8               = 32;           // max nr of day-part forecasts in icons or graph
				$topCount_9               = 36;           // max nr of day-part forecasts in icons or graph
				$topCount3h_1			  = 8;
				$topCount3h_2			  = 16;
				$topCount3h_3			  = 24;
				$topCount3h_4			  = 32;
				$topCount3h_5			  = 40;
				$topCount3h_6			  = 48;
				$topCount3h_7			  = 56;
				$topCount3h_8			  = 64;
				$topCount3h_9			  = 72;
				# two kinds of meteograms
				$yrnoMeteogram          = true;         // standard yrno meteogram two days - one column per hour
				$chartsMeteogram        = false;        // high charts meteogram -  6 days - one colom for every 6 hours - 
				$chartsMeteogramHeight  = '340px';
				$MeteogramInTabs        = true;         // high charts graph separate (false) or in a tab (true)
				$yrnoTable              = true;	        // table with one line for every 6 hours
				$yrnoDetailTable        = true;         // table with one line for every 3 or 1 hours
				//$tableHeight            = '500px';    // no restricted height use ''  - restrict use number of pixels: '500px' 
				$tableInTabs            = true;         // put tables in tabs
				$includeHTML            = true;         // head body css scripts  are loaded
				$colorClass             = 'blue';       // pastel green blue beige orange 
				$pageWidth              = '100%';       // set do desired width 999px  or 100%
				$scriptDir              = './';
				$pageName               = 'single-weather-forecast.php';
				$pageVersion            = '1.00';
				$string                 = $pageName . '- version: ' . $pageVersion;
				$pageFile               = basename( __FILE__ ); // check to see this is the real script
				$title                  = '<title>yrno  forecast. Script ' . $pageName . '</title>';
				$myPage	                = $pageName;
				
				#-----------------------------------------------------------------------
				# Now create all tables and graphs to be printed here
				#-----------------------------------------------------------------------
				//$script	= $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-forecast/yrnoGenerateHtml.php';
				$script	= $scriptDir . '/wp-content/themes/cameraski/lib/meteo/yrnoGenerateHtml.php';
				echo '<!-- trying to load ' . $script . '... -->' . PHP_EOL;
				include $script;
				
				#---------------------------------------------------------------------------
				#  the following lines output the needed html if you want a stand alone page
				#  this includes the CSS file used for formatting
				#---------------------------------------------------------------------------
				$string = ob_get_contents ();
				
				ob_end_clean();
				
				if ( $includeHTML ) {

				    echo'<script type="text/javascript">

						var docready = [], $ = function() {
						    return {
						        ready:function( fn ) {
						            docready . push( fn )
						        }
						    }
						};
						
			    	</script>
			    	
			    	<div id="' . $colorClass . '" style="text-align: center;">
						<div id="pagina" style="width: ' . $pageWidth . '; "><br />' . PHP_EOL;
				}
				
				// En producció, comentem la següent línia
				echo $string; // Display info about all loaded scripts and version numbers as html comment lines
				
				$styleborder    = ' border: 1px inset; border-radius: 5px;';
				$margin         = ' margin: 10px auto;'; 
				$topWidth       = ' width: ' . $defaultWidth . ';';
				
				if ( $chartsMeteogramHeight <> '' ) {
				    $chartsMeteogramHeight  = 'height: ' . $chartsMeteogramHeight . ';';
				}
				
				/* CARLES - Hem modificat: a dalt hem comentat l'alçada, i aquí hem comentat $tableHeight per evitar l'avís */
				/*if ( $tableHeight <> '' ) {
					$tableHeight = 'height: ' . $tableHeight . ';';
				}*/
				/* / CARLES */
				#
				if ( $times ) {
				    $style = 'style="" ';
				    echo '<div id="times" style="" >' . PHP_EOL;
				    	echo $wsUpdateTimes . PHP_EOL;
				    echo '</div>' . PHP_EOL;
				}
				
				if ( $tableInTabs || $MeteogramInTabs ) { // generate html for tabs
				    // ORIGINAL -> echo '<div class="tabber" style="' . $topWidth . ' margin: auto;">' . PHP_EOL;
					//echo '<div class="tabber" style="margin: auto;">' . PHP_EOL;
					echo '<div class="tabber" style="margin: 30px auto;">' . PHP_EOL;
				}
				
				if ( $tableInTabs ) {
					
			    	// CARLES - Hem modificat: a dalt hem comentat l'alçada, i aquí hem tret $tableHeight per evitar l'avís
			    	// CARLES - ORIGINAL: $style  = 'style="padding: 0px; '.$tableHeight.'"';
			    	$style = 'style="padding: 3px;"';
              		
              		if ( $yrnoTable ) {
			    	    echo '<div class="tabbertab" ' . $style . '>' . PHP_EOL;
			    	    	echo '<h2>' . yrnotransstr( 'Every 6 hour' ) . '</h2>' . PHP_EOL;
                	        //echo $yrnoListTable . PHP_EOL;
                	  		echo $yrno6hTable_1 . PHP_EOL;
			    	    	echo $yrno6hTable_2 . PHP_EOL;
                	  		echo $yrno6hTable_3 . PHP_EOL;
                	  		echo $yrno6hTable_4 . PHP_EOL;
                	  		echo $yrno6hTable_5 . PHP_EOL;
                	  		echo $yrno6hTable_6 . PHP_EOL;
                	  		echo $yrno6hTable_7 . PHP_EOL;
                	  		echo $yrno6hTable_8 . PHP_EOL;
                	  		echo $yrno6hTable_9 . PHP_EOL;
                	  		echo $yrno6hTable_10 . PHP_EOL;
							echo $mobileYrno6hTable_1 . PHP_EOL;
							echo $mobileYrno6hTable_2 . PHP_EOL;
							echo $mobileYrno6hTable_3 . PHP_EOL;
							echo $mobileYrno6hTable_4 . PHP_EOL;
							echo $mobileYrno6hTable_5 . PHP_EOL;
							echo $mobileYrno6hTable_6 . PHP_EOL;
							echo $mobileYrno6hTable_7 . PHP_EOL;
							echo $mobileYrno6hTable_8 . PHP_EOL;
							echo $mobileYrno6hTable_9 . PHP_EOL;
			    	    echo '</div>' . PHP_EOL;
			    	}
              		
              		if ( $yrnoDetailTable ) {
			    	    echo '<div class="tabbertab" ' . $style . '>' . PHP_EOL;
			    	    	echo '<h2>' . yrnotransstr( '3 hour' ) . '</h2>' . PHP_EOL;
							echo $yrno3hTable_1 . PHP_EOL;
							//echo $yrnoDetailTable . PHP_EOL;
							echo $yrno3hTable_2 . PHP_EOL;
							echo $yrno3hTable_3 . PHP_EOL;
							echo $yrno3hTable_4 . PHP_EOL;
							echo $yrno3hTable_5 . PHP_EOL;
							echo $yrno3hTable_6 . PHP_EOL;
							echo $yrno3hTable_7 . PHP_EOL;
							echo $yrno3hTable_8 . PHP_EOL;
							echo $yrno3hTable_9 . PHP_EOL;
							echo $mobileYrno3hTable_1 . PHP_EOL;
							echo $mobileYrno3hTable_2 . PHP_EOL;
							echo $mobileYrno3hTable_3 . PHP_EOL;
							echo $mobileYrno3hTable_4 . PHP_EOL;
							echo $mobileYrno3hTable_5 . PHP_EOL;
							echo $mobileYrno3hTable_6 . PHP_EOL;
							echo $mobileYrno3hTable_7 . PHP_EOL;
							echo $mobileYrno3hTable_8 . PHP_EOL;
							echo $mobileYrno3hTable_9 . PHP_EOL;
			    	    echo '</div>' . PHP_EOL;
			    	}
              		
					if ( $yrnoMeteogram && $MeteogramInTabs ) {
					  	$style  = 'style="width: 100%; overflow: hidden; "';
						//include_once ( $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/genesis-sample/meteo-yrno-forecast/yrnoavansert3.php' );
                	  	include_once ( $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/cameraski/lib/meteo/yrnoavansert3.php' );
					   	echo '<div class="tabbertab" style="padding: 3px;"><h2>' . yrnotransstr( 'Meteogram' ) . '</h2>' . PHP_EOL;
					   		echo '<div ' . $style . '>';
					   			//echo '<a href="http://www.yr.no/place/' . $yrnoID . '" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">' . PHP_EOL;
					   			echo '<img src="' . $im . '" alt="  " style="vertical-align: top; width: 100%; height: 302px;"/>' . PHP_EOL;
					   			echo '</a>' . PHP_EOL;
					   		echo '</div>' . PHP_EOL;
					   	echo '</div>' . PHP_EOL;
					}
					
				}
				
				if ( $tableInTabs || $MeteogramInTabs ) {
				    echo '</div>' . PHP_EOL;
				}
				
				#	    
				# IMPORTANT do not delete as legally you are bind to display 
				# credit to Metno/Yrno in original readable text, same size as average text in window
				$style = 'style="' . $topWidth . $margin . '"';
				echo '<div id="credit" ' . $style . '>' . PHP_EOL;
				//echo '<div id="credit">' . PHP_EOL;
					echo $creditString . PHP_EOL;
				echo '</div>' . PHP_EOL;
				
				#  end of enclosing div
				if ( $includeHTML ) {
				    echo '</div>' . PHP_EOL; // end pagina div
				}
				
				$javaOutput = $includeHTML;	// we print javascript based on setting of enclosing html
				
				if ( $javaOutput ) {
				
				    if ( $tableInTabs || $MeteogramInTabs ) {
					   echo '<script type="text/javascript" src="' . $javascriptsDir . 'tabber.js"></script>' . PHP_EOL;
					}
				
				}
				
				#---------------------------------------------------------------------------
				# Leave this code here .. it will help you see what language translations are missing 
				# if you dont want them set next line to comment by adding a # as first cahracter on the line
				$noMissingLang = true;
				#
				if ( !isset ( $noMissingLang ) || $noMissingLang  == true ) {
					
					$string = '';
					
					foreach ( $missingTrans as $key => $val ) {
					
						$string .= "langlookup|$key|$key|" . PHP_EOL;
					}
					
					if ( strlen( $string ) > 0 ) {
						
						echo PHP_EOL . '<!-- missing langlookup entries for lang=' . $lang . PHP_EOL;
						echo $string;
						echo count( $missingTrans ) . ' entries found.' . PHP_EOL . 'End of missing langlookup entries. -->' . PHP_EOL;
						
					}
					
				}
				
			echo '</div>';
				
			do_action( 'genesis_after_entry_content' );

			do_action( 'genesis_entry_footer' );
			
		echo '</article>';

		do_action( 'genesis_after_entry' );

	endwhile; //* end of one post
	do_action( 'genesis_after_endwhile' );

else : //* if no posts exist
		do_action( 'genesis_loop_else' );
endif; //* end loop
		
do_action( 'genesis_after_loop' );

genesis_markup( array(
	'html5' => '</main>', //* end .content
	'xhtml' => '</div>', //* end #content
) );
	
do_action( 'genesis_after_content' );

// 25/04/2016 - Aquest �s el /div que tanca content-sidebar-wrap - NO-> Ho hem descomentat - DONCS S�, HO HEM TORNAT A COMENTAR (21/07/2016)
//echo '</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
//do_action( 'genesis_after_content_sidebar_wrap' ); // Comentada perqu� est� Deprecated

get_footer();