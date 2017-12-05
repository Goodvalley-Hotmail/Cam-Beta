<?php

// 25/04/2016 - Add the attributes from 'entry', since this replaces the main entry
function camski_attributes_site_inner( $attributes ) {
	$attributes[ 'role' ]		= 'main';
	$attributes[ 'itemprop' ]	= 'mainContentOfPage';
	
	return $attributes;
}

add_filter( 'genesis_attr_site-inner', 'camski_attributes_site_inner' ); // Aix� ho hav�em comentat el 25/04/2016, no ho tinc clar per� en principi �s correcte tal com est�.

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
add_action( 'genesis_entry_footer', 'skirev_custom_post_meta' );

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
			
			// FLEXBOX-BOTTOM
			echo '<div class="flexbox-bottom">';
				
				// METEO
				echo '<div id="meteo-detail" class="one">';
							
				$resort_name	= get_post_meta( get_the_ID(), 'resort_name', true );
				$location_meteo	= get_post_meta( get_the_ID(), 'location_meteo', true );
							
				if ( $resort_name || $location_meteo ) {
								
					/* METEO COMPLET */
					ob_start();

					/* CARLES PROVES METEO DETAIL */

						//
					
					/* / CARLES PROVES METEO DETAIL */
					
					/* CARLES PROVES METEO OVERVIEW */

					$defaultWidth           = '50%';        // set do desired width 999px  or 100%
					# what parts should be printed
					$times                  = true;         // 
					# icons for top of page or startpage
					$topCount               = 10;           // max nr of day-part forecasts in icons or graph
					# two kinds of meteograms
					$yrnoMeteogram          = true;         // standard yrno meteogram two days - one column per hour
					$MeteogramInTabs        = true;         // high charts graph separate (false) or in a tab (true)
					$yrnoTable              = true;	        // table with one line for every 6 hours
					$yrnoDetailTable        = true;         // table with one line for every 3 or 1 hours
					//$tableHeight            = '500px';    // no restricted height use ''  - restrict use number of pixels: '500px' 
					$tableInTabs            = true;         // put tables in tabs
					$includeHTML            = true;         // head body css scripts  are loaded
					$colorClass             = 'blue';       // pastel green blue beige orange 
					$pageWidth              = '100%';       // set do disired width 999px  or 100%
					$scriptDir              = './';
					$pageName               = 'single-meteo-weather.php';
					$pageVersion            = '3.00 2014-07-11';
					$string                 = $pageName . '- version: ' . $pageVersion;
					$pageFile               = basename( __FILE__ ); // check to see this is the real script
					$title                  = '<title>YR.NO Forecast. Script ' . $pageName . '</title>';
					$myPage	                = $pageName;
					$script 				= $scriptDir . '/wp-content/themes/genesis-sample/meteo-yrno-page/yrnoGenerateHtml.php';

					//include $script;
					include_once ( $_SERVER['DOCUMENT_ROOT'] . "/wp-content/themes/genesis-sample/meteo-yrno-page/yrnoGenerateHtml.php" );
						
					$string = ob_get_contents ();

					ob_end_clean();

					/* CARLES PROVES METEO OVERVIEW */
					/*if ( $includeHTML ) {
						echo '<div class="' . $colorClass . '" style="text-align: center;">' . PHP_EOL;
							echo '<div id="pagina" style="width: ' . $pageWidth . '; ">' . PHP_EOL;
					}
						
					//echo $string;

					$styleborder    = '';
					$margin         = ' margin: 5px auto;'; 
					$topWidth       = ' width: ' . $defaultWidth . ';';

					if ( $times ) {
						$style  = 'style="" ';
						echo '<div id="times" style="' . $topWidth . $margin . '" >' . PHP_EOL;
							echo $wsUpdateTimes . PHP_EOL;
						echo '</div>' . PHP_EOL;
					}
						
					if ( $iconGraph ) {
						$style  = 'style="' . $topWidth . $styleborder . $margin . '"';
						echo '<div id="iconGraph" ' . $style . '>';
						echo $tableIcons_1 . PHP_EOL;
						echo $tableIcons_2 . PHP_EOL;
						echo $tableIconsMobile_1 . PHP_EOL;
						echo $tableIconsMobile_2 . PHP_EOL;
						echo '</div>' . PHP_EOL;
						#	echo '<br />' . PHP_EOL;
					}
					/* / CARLES PROVES METEO OVERVIEW */

					if ( $includeHTML ) {
					    echo'<div id="pagina" style="width: ' . $pageWidth . '; "><br />' . PHP_EOL;
					}

					#-----------------------  I M P O R T A N T   -----------------------------
					#	if you use your own page setup you should ADD a line with
					#	<link rel="stylesheet" type="text/css" href="yrno.css" media="screen" title="screen" />
					#	make sure you have the correct path set in href
					#  	in your html so that the correct css is loaded
					#---------------------------------------------------------------------------
					# Now ready for printing to the screen. Use echo for that
					#	$wsUpdateTimes	: this forecast en next forecast times 
					#	$tableIcons	: icon 
					#	$graphPart1	: javascript / highcharts graph
					#	$yrnoListTable	: table with all forecast lines
					$styleborder    = ' border: 1px inset; border-radius: 5px;';
					$margin         = ' margin: 10px auto;'; 
					$topWidth       = ' width: ' . $defaultWidth . ';';

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
					#
					if ( $tableInTabs || $MeteogramInTabs ) { // generate html for tabs
					    echo '<div class="tabber" style="' . $topWidth . ' margin: auto;">' . PHP_EOL;
					}

					if ( $yrnoMeteogram && $MeteogramInTabs ) {
					    $style = 'style="width: 100%; overflow: hidden; "';
					    include $scriptDir . 'wp-content/themes/genesis-sample/meteo-yrno-page/yrnoavansert3.php';
					    echo '<div class="tabbertab" style="padding: 0px;"><h2>' . yrnotransstr( 'Meteogram' ) . '</h2>' . PHP_EOL;
					    echo '<div ' . $style . '>';
					    echo '<a href="http://www.yr.no/place/' . $yrnoID . '" target="_blank" title="Vooruitzichten scandinavische leveranciers yr.no">' . PHP_EOL;
					    echo '<img src="' . $im . '" alt="  " style="vertical-align: top; width: 100%; height: 302px;"/>' . PHP_EOL;
					    echo '</a>' . PHP_EOL;
					    echo '</div>' . PHP_EOL;
					    echo '</div>' . PHP_EOL;
					}

					if ( $tableInTabs ) {

					    /* CARLES - Hem modificat: a dalt hem comentat l'alçada, i aquí hem tret $tableHeight per evitar l'avís */
					    /* CARLES - ORIGINAL: $style  = 'style="padding: 0px; '.$tableHeight.'"';*/
					    $style = 'style="padding: 3px;"';

					    if ( $yrnoTable ) {
					        echo '<div class="tabbertab" ' . $style . '>' . PHP_EOL;
					        echo '<h2>' . yrnotransstr( 'Forecast by 6 hour intervals' ) . '</h2>' . PHP_EOL;
					        echo $yrnoListTable . PHP_EOL;
					        echo '</div>' . PHP_EOL;
					    }

					    if ( $yrnoDetailTable ) {
					        echo '<div class="tabbertab" ' . $style . '>' . PHP_EOL;
					        echo '<h2>' . yrnotransstr( 'Forecast details' ) . '</h2>' . PHP_EOL;
					        echo $yrnoDetailTable . PHP_EOL;
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
					echo $creditString . PHP_EOL;
					echo '</div>' . PHP_EOL;
					echo '<br />' . PHP_EOL;

					#---------------------------------------------------------------------------
					#  end of enclosing div
					if ( $includeHTML ) {
					    echo '
					    </div>' . PHP_EOL; // end pagina div
					}

					#---------------------------------------------------------------------------
					#  the following lines output the needed scripts / html for a stand alone page
					#-------------------I M P O R T A N T  -------------------------------------
					# now we add the needed javascripts
					# if you use this script inside another script make sure you add the javascripts yourself
					#---------------------------------------------------------------------------
					$javaOutput = $includeHTML;	// we print javascript based on setting of enclosing html
					#$javaOutput = true;		// javascripts are ALWAYS printed by removing the #
					#
					if ( $javaOutput ) {

						if ( $tableInTabs || $MeteogramInTabs ) {
						   echo '<script type="text/javascript" src="' . $javascriptsDir . 'tabber-minimized.js"></script>' . PHP_EOL;
						}
						
					}

				}	
					
				echo '</div>';
		
			echo '</div>';
				
			do_action( 'genesis_after_entry_content' );

			do_action( 'genesis_entry_footer' );
		
		// 25/04/2016 - Aix� tanca l'etiqueta HTML <article>
		echo '</article>';

		do_action( 'genesis_after_entry' );

	endwhile; //* end of one post
	do_action( 'genesis_after_endwhile' );

else : //* if no posts exist
		do_action( 'genesis_loop_else' );
endif; //* end loop
		
do_action( 'genesis_after_loop' );

// 25/04/2016 - Aquest �s el /div que tanca <main class="content"> - NO-> Ho hem descomentat
genesis_markup( array(
	'html5' => '</main>', //* end .content
	'xhtml' => '</div>', //* end #content
) );
	
do_action( 'genesis_after_content' );

// 25/04/2016 - Aquest �s el /div que tanca content-sidebar-wrap - NO-> Ho hem descomentat - DONCS S�, HO HEM TORNAT A COMENTAR (21/07/2016)
//echo '</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
//do_action( 'genesis_after_content_sidebar_wrap' ); // Comentada perqu� est� Deprecated

get_footer();