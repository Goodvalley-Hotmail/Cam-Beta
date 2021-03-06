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

add_filter( 'body_class', 'archive_ski_resorts_body_class' );
/**
 * Adds a CSS class to the body element.
 *
 * @since   1.0.0
 *
 * @param $classes
 *
 * @return array
 */
function archive_ski_resorts_body_class( $classes ) {

	$classes[] = 'ski-resorts-archive';

	return $classes;

}

add_filter( 'genesis_attr_entry-content', 'archive_ski_resorts_class' );
/**
 * Adds a CSS class of ski-resort to every Ski Resort item in the archive Page.
 *
 * @since   1.0.0
 *
 * @param $classes
 *
 * @return mixed
 */
function archive_ski_resorts_class( $classes ) {

	$classes['class'] .= ' ski-resort';
	return $classes;

}

add_filter( 'genesis_attr_archive-pagination', 'add_archive_pagination_attribute' );
/**
 * Afegim una css id "ski-resorts-archive-pagination" a entry-content per al CPT ski-resort.
 *
 * @since   1.0.0
 *
 * @param $attributes
 *
 * @return mixed
 */
function add_archive_pagination_attribute( $attributes ) {

	if ( is_post_type_archive( 'ski-resort' ) ) {
		$attributes['id'] = 'ski-resorts-archive-pagination';
	}

	return $attributes;

}

// Force full width content
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove Breadcrumbs before Archive description.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
//add_action( 'genesis_entry_header', 'genesis_do_breadcrumbs' );

// Remove standard Genesis elements.
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
// Remove the Entry Meta (Post Info) in the Entry Header.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
//remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );

// Remove the Post Meta. To remove empty markup, '<p class="entry-meta"></p>' for Entries that have not been assigned to any Location.
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
//remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Reposition Archive pagination.
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
add_action( 'genesis_before_while', 'genesis_posts_nav' );


add_action( 'genesis_before_while', 'taxonomy_locations_wrap_start' );
function taxonomy_locations_wrap_start() {

	?>
	<div class="flexbox-archive-ski-resorts">

		<div class="archive-ski-resort-content-wrap">
		    <?php

}
add_action( 'genesis_after_loop', 'taxonomy_locations_wrap_end' );
function taxonomy_locations_wrap_end() {

	echo '</div></div>';

}

add_action( 'genesis_after_loop', 'genesis_posts_nav' );
add_action( 'genesis_after_loop', 'change_custom_query_to_wp_query' );
/**
 * We use a custom WP_Query (taxonomy_locations_query()) to query Posts, but then in Pagination we're using the
 * global $wp_query variable, which contents a different query.
 * Then our Pagination acts weirdly.
 * We must use our custom query variable $taxonomy_locations_query in our Pagination, or change the global
 * $wp_query variable before our Pagination function call.
 * In our case, we use Pagination before and after our custom Loop, so we switch queries after the Loop, in the
 * genesis_after_loop Hook.
 *
 * @since   1.0.0
 *
 * @return void
 */
function change_custom_query_to_wp_query() {
	$wp_query = $original_query;
	wp_reset_query();
}

// Remove the Genesis Loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add our custom Loop.
add_action( 'genesis_loop', 'archive_ski_resorts_loop' );
function archive_ski_resorts_loop() {

	$args = array(
		'posts_per_page'    => 10,
		'post_type'         => 'ski-resort',
		'paged'             => get_query_var( 'paged' ),
		'order'             => 'ASC',
		'orderby'           => 'title',
	);

	global $wp_query;

	$wp_query = new WP_Query( $args );

	if ( $wp_query->have_posts() ) :

		do_action( 'genesis_before_while' );

		// BreadCrumbs in every Post found -> PART 1/3 START
		$old_singular_value = $wp_query->is_singular;
		// BreadCrumbs in every Post found -> PART 1/3 END

		while ( $wp_query->have_posts() ) : $wp_query->the_post();

			//global $post;

			do_action( 'genesis_before_entry' );

			printf( '<article %s>', genesis_attr( 'entry' ) );

				do_action( 'genesis_entry_header' );
				do_action( 'genesis_before_entry_content' );

				printf( '<div %s>', genesis_attr( 'entry-content' ) );

					do_action( 'genesis_entry_content' );

					echo '<div class="flexbox-archive-ski-resorts-content">';

						$included_options = get_post_meta( get_the_ID(), 'included_options', true );
						include_once ( $_SERVER['DOCUMENT_ROOT'] . $included_options );

						echo '<div class="two-fourths-first">';

							$title_domain = get_post_meta( get_the_ID(), 'title_domain', true );

							if ( $title_domain ) {

								echo '<h2 class="entry-title" id="ski-resort-entry-title" itemprop="headline"><a href="' . get_permalink() . '">' . get_the_title() . ' - ' .  $title_domain . '</a>';

							} else {

								echo '<h2 class="entry-title" id="ski-resort-entry-title" itemprop="headline"><a href="' . get_permalink() . '">' . get_the_title() . '</a>';

							}

							if ( $operating_status == 'OPEN' ) {

								echo '<span class="operating-status-open"><strong> ' . $operating_status_english . '</strong></span></h2>';

							} elseif ( $operating_status == 'CLOSED' ) {

								echo '<span class="operating-status-closed"><strong> ' . $operating_status_english . '</strong></span></h2>';

							}

							// BreadCrumbs in every Post found -> PART 2/3 START
							$wp_query->is_singular          = true;
							// BreadCrumbs in every Post found -> PART 2/3 END

							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-01-breadcrumbs.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-02-season-schedule.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-03-elevation-info.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-04-lifts.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-05-pricing.php' ) );

						echo '</div>';

						echo '<div class="overview-clear"></div>';

						echo '<div class="one-fourth first">';

							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-left.php' ) );

						echo '</div>';

						echo '<div class="two-fourths">';

							if ( $title_domain ) {

								echo '<h2 class="entry-title" id="ski-resort-entry-title" itemprop="headline"><a href="' . get_permalink() . '">' . get_the_title() . ' - ' .  $title_domain . '</a>';

							} else {

								echo '<h2 class="entry-title" id="ski-resort-entry-title" itemprop="headline"><a href="' . get_permalink() . '">' . get_the_title() . '</a>';

							}

							if ( $operating_status == 'OPEN' ) {

								echo '<span class="operating-status-open"><strong> ' . $operating_status_english . '</strong></span></h2>';

							} elseif ( $operating_status == 'CLOSED' ) {

								echo '<span class="operating-status-closed"><strong> ' . $operating_status_english . '</strong></span></h2>';

							}

							unset( $operating_status );

							// BreadCrumbs in every Post found -> PART 2/3 START
							$wp_query->is_singular          = true;
							// BreadCrumbs in every Post found -> PART 2/3 END

							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-01-breadcrumbs.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-02-season-schedule.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-03-elevation-info.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-04-lifts.php' ) );
							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-center-05-pricing.php' ) );

						echo '</div>';

						echo '<div class="one-fourth">';

							include ( locate_template( 'lib/partials/archive-ski-resort/ski-resort-entry-section-right.php' ) );

						echo '</div>';

					echo '</div>';

				echo '</div>';

				do_action( 'genesis_after_entry_content' );
				do_action( 'genesis_entry_footer' );

			echo '</article>';

			do_action( 'genesis_after_entry' );

		endwhile; // End of one Post.

		do_action( 'genesis_after_endwhile' );

	else :

		do_action( 'genesis_loop_else' );

	endif;

	// BreadCrumbs in every Post found -> PART 3/3 START
	$wp_query->is_singular = $old_singular_value;
	// BreadCrumbs in every Post found -> PART 3/3 END

	//wp_reset_query();

}

genesis();