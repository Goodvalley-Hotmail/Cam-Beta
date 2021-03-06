<?php
/**
 * Description
 *
 * @package     CameraSki
 * @since       1.0.0
 * @author      Carles Goodvalley
 * @link        https://www.cameraski.com
 * @license     GNU General Public License 2.0+
 */

namespace CameraSki;

//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', __NAMESPACE__ . '\add_body_class' );
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

add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\add_attributes_to_site_inner' );
/**
 * Adds attributes for site-inner element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function add_attributes_to_site_inner( $attributes ) {

	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';

	return $attributes;

}

add_action( 'content_area', __NAMESPACE__ . '\display_frontpage_flexible_content' );
/**
 * Displays FrontPage Flexible Content ACF Fields Group.
 *
 * @since   1.0.0
 *
 * @return void
 */
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

get_header();
do_action( 'content_area' );
get_footer();