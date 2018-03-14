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
//remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

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
			?>
			
			<div class="flexbox-top">

				<div id="overview-top-left" class="column-top-left first background-boxes">

					<?php include ( locate_template( 'lib/partials/overview/main-webcam.php' ) ); ?>

				</div>

				<div id="overview-top-center" class="column-top-center background-boxes">

					<?php include ( locate_template( 'lib/partials/overview/post-meta.php' ) ); ?>

					<div id="overview-central-tabs">

						<?php include ( locate_template( 'lib/partials/overview/current-date-open-close.php' ) ); ?>

						<?php include ( locate_template( 'lib/partials/overview/season.php' ) ); ?>

						<ul id="ul-today">

							<p class="today"><strong>TODAY</strong></p>

							<?php

                            include ( locate_template( 'lib/partials/overview/open-lifts.php' ) );

							include ( locate_template( 'lib/partials/overview/open-slopes.php' ) );

							include ( locate_template( 'lib/partials/overview/open-slopes-length.php' ) );

							include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth-elevation-meta.php' ) );

                            if ( isset( $snow_depth_max ) && $snow_depth_max >= 0 ) {
	                            include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth-max.php' ) );
                            }

		                    if ( isset( $snow_depth_min ) && $snow_depth_min >= 0 ) {
			                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth-min.php' ) );
		                    }

		                    if ( isset( $snow_depth_1 ) && $snow_depth_1 >= 0 ) {
			                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth1.php' ) );
			                    if ( isset( $snow_depth_2 ) && $snow_depth_2 >= 0 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth2.php' ) );
				                    if ( isset( $snow_depth_3 ) && $snow_depth_3 >= 0 ) {
					                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth3.php' ) );
					                    if ( isset( $snow_depth_4 ) && $snow_depth_4 >= 0 ) {
						                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth4.php' ) );
						                    if ( isset( $snow_depth_5 ) && $snow_depth_5 >= 0 ) {
							                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth5.php' ) );
							                    if ( isset( $snow_depth_6 ) && $snow_depth_6 >= 0 ) {
								                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth6.php' ) );
								                    if ( isset( $snow_depth_7 ) && $snow_depth_7 >= 0 ) {
									                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth7.php' ) );
								                    }
							                    }
						                    }
					                    }
				                    }
			                    }
		                    }

		                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-depth-unique.php' ) );

		                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/snow-type-unique.php' ) );

		                    if ( $location_depth_1 || $location_depth_2 || $location_depth_3 || $location_depth_4 || $location_depth_5 ) {

			                    if ( $location_1_name_1 && $location_1_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location1-name-elevation.php' ) );
			                    }

			                    if ( $location_1_name_1 && !$location_1_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location1-name-not-elevation.php' ) );
			                    }

			                    if ( $location_1_elevation_1 && !$location_1_name_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location1-elevation-not-name.php' ) );
			                    }

			                    if ( $location_2_name_1 && $location_2_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location2-name-elevation.php' ) );
			                    }

			                    if ( $location_2_name_1 && !$location_2_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location2-name-not-elevation.php' ) );
			                    }

			                    if ( $location_2_elevation_1 && !$location_2_name_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location2-elevation-not-name.php' ) );
			                    }

			                    if ( $location_3_name_1 && $location_3_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location3-name-elevation.php' ) );
			                    }

			                    if ( $location_3_name_1 && !$location_3_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location3-name-not-elevation.php' ) );
			                    }

			                    if ( $location_3_elevation_1 && !$location_3_name_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location3-elevation-not-name.php' ) );
			                    }

			                    if ( $location_4_name_1 && $location_4_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location4-name-elevation.php' ) );
			                    }

			                    if ( $location_4_name_1 && !$location_4_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location4-name-not-elevation.php' ) );
			                    }

			                    if ( $location_4_elevation_1 && !$location_4_name_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location4-elevation-not-name.php' ) );
			                    }

			                    if ( $location_5_name_1 && $location_5_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location5-name-elevation.php' ) );
			                    }

			                    if ( $location_5_name_1 && !$location_5_elevation_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location5-name-not-elevation.php' ) );
			                    }

			                    if ( $location_5_elevation_1 && !$location_5_name_1 ) {
				                    include ( locate_template( 'lib/partials/overview/snow-depth-elevation/location5-elevation-not-name.php' ) );
			                    }

		                    }
                            ?>

                            <?php include ( locate_template( 'lib/partials/overview/snow-report.php' ) ); ?>

						</ul>

					</div>

				</div>

				<div id="overview-top-right" class="column-top-right">

					<div class="column-top-right--top first">

					<div id="overview-right-tabs-1">

						<div class="overview-slopes-map">

							<?php include ( locate_template( 'lib/partials/overview/slopes-map.php' ) ); ?>

						</div>

						<?php include ( locate_template( 'lib/partials/overview/slopes-colors.php' ) ); ?>

						<div class="overview-clear"></div>

							<?php include ( locate_template( 'lib/partials/overview/additional-slopes-colors.php' ) ); ?>

							<?php include ( locate_template( 'lib/partials/overview/elevation.php' ) ); ?>

							<div class="overview-clear"></div>

						</div>

					</div>

					<div class="column-top-right--bottom">

						<div id="overview-right-tabs-2" class="background-boxes">

							<?php include ( locate_template( 'lib/partials/overview/lifts.php' ) ); ?>

							<?php include ( locate_template( 'lib/partials/overview/pricing.php' ) ); ?>

						</div>

					</div>

				</div>

			</div>

			<div class="flexbox-bottom">

				<div id="overview-bottom-left" class="column-bottom first">

					<?php include ( locate_template( 'lib/partials/overview/map.php' ) ); ?>

				</div>

				<div id="overview-bottom-right" class="column-bottom">

						<?php include ( locate_template( 'lib/partials/overview/meteo.php' ) ); ?>

						<?php include ( locate_template( 'lib/partials/overview/yrno-logo.php' ) ); ?>

				</div>

			</div>
				
			<?php do_action( 'genesis_after_entry_content' ); ?>

			<?php do_action( 'genesis_entry_footer' ); ?>
		
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
//</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
//do_action( 'genesis_after_content_sidebar_wrap' ); // Comentada perqu� est� Deprecated

get_footer();