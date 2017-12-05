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
			
			echo '<div class="flexbox-top">';
			
				// FOURTHS - REPEATER - WEBCAMS
				$webcam = get_post_meta( get_the_ID(), 'webcam', true );

				if ( $webcam ) {

					for ( $i = 0; $i < $webcam; $i++ ) {

						$webcam_name			= esc_html( get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_name', true ) );
						$webcam_text			= esc_html( get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_text', true ) );
						$webcam_file_16_9		= esc_html( get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_16_9', true ) );
						$webcam_file_4_3		= esc_html( get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_4_3', true ) );
						$webcam_file_1_1		= esc_html( get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_1_1', true ) );
						$webcam_file_panoramic	= esc_html( get_post_meta( get_the_ID(), 'webcam_' . $i . '_webcam_file_panoramic', true ) );

						$class = 0 == $i || 0 == $i % 4 ? 'one-fourth first' : 'one-fourth';
						
						if ( $webcam_file_16_9 ) {

							echo  '<div class="' . $class . '"><p class="main-webcam-image"><img src="' . esc_url( $DOCUMENT_ROOT . $webcam_file_16_9 ) . '" alt="' . $webcam_name . '" width="100%" align="middle" class="main-webcam" /></p>' . esc_html( $webcam_name ) . '</div>';

						} elseif ( $webcam_file_4_3 ) {

							echo '<div class="' . $class . '"><p class="main-webcam-image"><img src="' . esc_url( $DOCUMENT_ROOT . $webcam_file_4_3 ) . '" alt="' . $webcam_name . '" width="100%" align="middle" class="main-webcam" /></p>' . esc_html( $webcam_name ) . '</div>';

						} elseif ( $webcam_file_1_1 ) {

							echo '<div class="' . $class . '"><p class="main-webcam-image"><img src="' . esc_url( $DOCUMENT_ROOT . $webcam_file_1_1 ) . '" alt="' . $webcam_name . '" width="100%" align="middle" class="main-webcam" /></p>' . esc_html( $webcam_name ) . '</div>';

						} elseif ( $webcam_file_panoramic ) {

							echo '<div class="' . $class . '"><p class="main-webcam-image"><img src="' . esc_url( $DOCUMENT_ROOT . $webcam_file_panoramic ) . '" alt="' . $webcam_name . '" width="100%" align="middle" class="main-webcam" /></p>' . esc_html( $webcam_name ) . '</div>';

						}
						
					}

				}
				
			echo '</div>';

			// FLEXBOX-BOTTOM
			echo '<div class="flexbox-bottom">';
				
				// ONE-HALF FIRST
				echo '<div id="overview-bottom-left" class="one-half first">';
					
					
					
				echo '</div>';
				
				// ONE-HALF
				echo '<div id="overview-bottom-right" class="one-half">';
						
					
		
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