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

namespace CameraSki;

//add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\attributes_site_inner' ); // Aix� ho hav�em comentat el 25/04/2016, no ho tinc clar per� en principi �s correcte tal com est�.
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
			
			//echo '<div class="flexbox-top">';
			
			// FOURTHS
			// REPEATER - WEBCAMS
			$webcam = get_post_meta( get_the_ID(), 'webcam', true );
			
			if ( $webcam ) {
				
				for( $i = 0; $i < $webcam; $i++ ) {
					
					$webcam_name			= get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_name', true );
					$webcam_text			= get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_text', true );
					$webcam_file_generic	= get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_generic', true );
					$webcam_file_16_9		= get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_16_9', true );
					$webcam_file_4_3		= get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_4_3', true );
					$webcam_file_1_1 		= get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_1_1', true );
					
                    $class = 0 == $i || 0 == $i % 4 ? 'webcams-one-fourth first' : 'webcams-one-fourth';
                    
                    if ( $i == 0 || $i == 4 || $i == 8 || $i == 12 || $i == 16 || $i == 20 || $i == 24 || $i == 28 || $i == 32  ) {
                       	echo '<div class="flexbox-webcam">';
					}
                    
                    if ( $i == 3 || $i == 7 || $i == 11 || $i == 15 || $i == 19 || $i == 23 || $i == 27 || $i == 31 ) {
						echo '<div class="' . $class . '"><p class="webcam-image"><img src="' . $DOCUMENT_ROOT . $webcam_file_generic . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p><div class="webcam-info-wrap"><p class="webcam-name"><strong>' . $webcam_name . '</strong></p><p class="webcam-description">' . $webcam_text . '</p></div></div></div>';
					} else {
						echo '<div class="' . $class . '"><p class="webcam-image"><img src="' . $DOCUMENT_ROOT . $webcam_file_generic . '" alt="Baqueira" width="100%"  align="middle" class="main-webcam" /></p><div class="webcam-info-wrap"><p class="webcam-name"><strong>' . $webcam_name . '</strong></p><p class="webcam-description">' . $webcam_text . '</p></div></div>';
					}
					
					if ( $i == $webcam - 1 ) {
						echo '</div>';
    				}
					
				}
				
			}

			do_action( 'genesis_after_entry_content' );

			do_action( 'genesis_entry_footer' );
			?>
		
		</article>
		<?php

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