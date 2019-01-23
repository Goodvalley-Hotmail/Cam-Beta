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

/**
 * Adds a 'flexible-content' class to the body section.
 *
 * @since   1.0.0
 *
 * @param $classes
 *
 * @return array
 */
function add_body_class( $classes ) {

	$classes[] = 'flexible-content';

	return $classes;

}

add_action( 'get_header', __NAMESPACE__ . '\frontpage_flexible_content_check' );
function frontpage_flexible_content_check() {

	$frontpage_flexible_content_sections = get_post_meta( get_the_ID(), 'frontpage_flexible_content', true );

	if ( $frontpage_flexible_content_sections ) {

		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//remove_action( 'genesis_loop', 'genesis_do_loop' );

		add_action( 'genesis_loop', __NAMESPACE__ . '\display_frontpage_flexible_content' );

		add_filter( 'body_class', __NAMESPACE__ . '\add_body_class' );

	}

}

add_action( 'genesis_before_entry', __NAMESPACE__ . '\remove_front_page_title' );
/**
 * Removes entry title.
 *
 * @since   1.0.0
 *
 * @return void
 */
function remove_front_page_title() {

	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

}

function display_frontpage_flexible_content() {

	$frontpage_flexible_content_sections = get_post_meta( get_the_ID(), 'frontpage_flexible_content', true );

	foreach ( ( array ) $frontpage_flexible_content_sections as $count_frontpage_flexible_content_sections => $frontpage_flexible_content_section ) {

		switch ( $frontpage_flexible_content_section ) {

			case 'text-map':

				$left_text  = get_post_meta( get_the_ID(), 'frontpage_flexible_content_' . $count_frontpage_flexible_content_sections . '_left_text', true );
				$right_map  = get_post_meta( get_the_ID(), 'frontpage_flexible_content_' . $count_frontpage_flexible_content_sections . '_right_map', true );
				$css_class  = get_post_meta( get_the_ID(), 'frontpage_flexible_content_' . $count_frontpage_flexible_content_sections . '_css_class', true );

				echo '<section class="row text-image' . $css_class . '">';
				echo '<div class="left-half left-text">' . $left_text . '</div>';
				echo '<div class="right-half" style="background-image";>' . do_shortcode( $right_map ) . '</div>';
				echo '</section>';
				echo '<div class="overview-clear"></div>';

				break;

			case 'map-text':

				$left_map   = get_post_meta( get_the_ID(), 'frontpage_flexible_content_' . $count_frontpage_flexible_content_sections . '_left_map', true );
				$right_text = get_post_meta( get_the_ID(), 'frontpage_flexible_content_' . $count_frontpage_flexible_content_sections . '_right_text', true );
				$css_class  = get_post_meta( get_the_ID(), 'frontpage_flexible_content_' . $count_frontpage_flexible_content_sections . '_css_class', true );

				echo '<section class="row image-text' . $css_class . '">';
				echo '<div class="left-half" style="background-image";>' . do_shortcode( $left_map ) . '</div>';
				echo '<div class="right-half right-text">' . $right_text . '</div>';
				echo '</section>';

				break;

		}

	}

}

genesis();