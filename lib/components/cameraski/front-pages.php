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
 * https://sridharkatakam.com/full-width-widgetized-front-page-genesis/
 */
// Register Front-Page Widget areas.
//for ( $i = 1; $i <= 5; $i++ ) {
//
//	genesis_register_widget_area(
//		array(
//			'id'            => "front-page-{$i}",
//			'name'          => __( "Front Page {$i}", CHILD_TEXT_DOMAIN ),
//			'description'   => __( "This is the Front Page {$i} Section.", CHILD_TEXT_DOMAIN ),
//		)
//	);
//
//}

/*********************************************************************************************************************/

/**
 * How to dynamically generate Front page widget areas via Customizer in Genesis
 */

//// Variable for storing the number of Front Page sections set by the User in the Customizer.
//global $num_sections;
//
//global $default_num_fp_sections;
//$default_num_fp_sections = 5; // Set your desired number of default Front Page sections.
//
//add_action( 'customize_register', __NAMESPACE__ . '\custom_customize_register' );
///**
// * Adds a control to change the number of Front Page sections in the Theme Customizer.
// *
// * @since   1.0.0
// *
// * @param WP_Customize_Manager $wp_customize Theme Customizer Object.
// *
// * @return void
// */
//function custom_customize_register( $wp_customize ) {
//
//	global $default_num_fp_sections;
//
//	$wp_customize->add_setting( 'fp_sections_count', array(
//		'default'           => $default_num_fp_sections,
//		'sanitize_callback' => 'absint',
//	) );
//
//	$wp_customize->add_control( 'fp_sections_count', array(
//		'label'             => esc_html__( 'Front Page Sections', CHILD_TEXT_DOMAIN ),
//		'description'       => __( 'Set the number of Sections on the HomePage', CHILD_TEXT_DOMAIN ),
//		'settings'          => 'fp_sections_count',
//		'section'           => 'static_front_page',
//		'type'              => 'number',
//		'active_callback'   => 'is_front_page',
//	) );
//
//}
//
//// Get the number of Front Page sections set via the Customizer.
//$fp_sections_count = get_theme_mod( 'fp_sections_count' );
//
//// If the number of Front Page sections has been changed (from the default) in the Customizer,
//// store it in the $num_sections variable, else set $num_sections to the default nunmber of Front Page sections.
//if ( $fp_sections_count ) {
//	$num_sections = $fp_sections_count;
//} else {
//	$num_sections = $default_num_fp_sections;
//}
//// Variable for storing the number of Front Page sections set by the User in the Customizer.
//global $num_sections;
//
//global $default_num_fp_sections;
//$default_num_fp_sections = 5; // Set your desired number of default Front Page sections.
//
//add_action( 'customize_register', __NAMESPACE__ . '\custom_customize_register' );
///**
// * Adds a control to change the number of Front Page sections in the Theme Customizer.
// *
// * @since   1.0.0
// *
// * @param WP_Customize_Manager $wp_customize Theme Customizer Object.
// *
// * @return void
// */
//function custom_customize_register( $wp_customize ) {
//
//	global $default_num_fp_sections;
//
//	$wp_customize->add_setting( 'fp_sections_count', array(
//		'default'           => $default_num_fp_sections,
//		'sanitize_callback' => 'absint',
//	) );
//
//	$wp_customize->add_control( 'fp_sections_count', array(
//		'label'             => esc_html__( 'Front Page Sections', CHILD_TEXT_DOMAIN ),
//		'description'       => __( 'Set the number of Sections on the HomePage', CHILD_TEXT_DOMAIN ),
//		'settings'          => 'fp_sections_count',
//		'section'           => 'static_front_page',
//		'type'              => 'number',
//		'active_callback'   => 'is_front_page',
//	) );
//
//}
//
//// Get the number of Front Page sections set via the Customizer.
//$fp_sections_count = get_theme_mod( 'fp_sections_count' );
//
//// If the number of Front Page sections has been changed (from the default) in the Customizer,
//// store it in the $num_sections variable, else set $num_sections to the default nunmber of Front Page sections.
//if ( $fp_sections_count ) {
//	$num_sections = $fp_sections_count;
//} else {
//	$num_sections = $default_num_fp_sections;
//}
//
//// Register Front Page Widget areas.
//for ( $i = 1; $i <= $num_sections; $i++ ) {
//
//	genesis_register_widget_area(
//		array(
//			'id'            => "front-page-{$i}",
//			'name'          => __( "Front Page {$i}", CHILD_TEXT_DOMAIN ),
//			'description'   => __( "This is the Front Page {$i} Section.", CHILD_TEXT_DOMAIN ),
//		)
//	);
//
//}
//
///**
// * Function to output Front Page Sections.
// */
//function fp_sections_display() {
//
//	global $num_sections;
//
//	for ( $i = 1; $i <= $num_sections; $i++ ) {
//
//
//		genesis_widget_area( "front-page-{$i}", array(
//			'before'    => '<div class="front-page-' . $i . ' front-page-section widget-area"><div class="wrap">',
//			'after'     => '</div></div>',
//		) );
//
//	}
//
//}
//// Register Front Page Widget areas.
//for ( $i = 1; $i <= $num_sections; $i++ ) {
//
//	genesis_register_widget_area(
//		array(
//			'id'            => "front-page-{$i}",
//			'name'          => __( "Front Page {$i}", CHILD_TEXT_DOMAIN ),
//			'description'   => __( "This is the Front Page {$i} Section.", CHILD_TEXT_DOMAIN ),
//		)
//	);
//
//}
//
///**
// * Function to output Front Page Sections.
// */
//function fp_sections_display() {
//
//	global $num_sections;
//
//	for ( $i = 1; $i <= $num_sections; $i++ ) {
//
//
//		genesis_widget_area( "front-page-{$i}", array(
//			'before'    => '<div class="front-page-' . $i . ' front-page-section widget-area"><div class="wrap">',
//			'after'     => '</div></div>',
//		) );
//
//	}
//
//}

/*********************************************************************************************************************/

///**
// * TechCrunch-like Featured Content Blocks in Genesis
// */
//
//// Add 2 new image sizes.
//add_image_size( 'home-featured-left', 555, 350, true );
//add_image_size( 'home-featured-right', 150, 90, true );
//
//// Register Left and Right Home Featured widget areas.
//genesis_register_sidebar( array(
//	'id'            => 'home-featured-left',
//	'name'          => 'Home Featured Left',
//	'description'   => 'This is the Home Featured left section.'
//) );
//
//genesis_register_sidebar( array(
//	'id'            => 'home-featured-right',
//	'name'          => 'Home Featured Right',
//	'description'   => 'This is the Home Featured right section.'
//) );
//
//// Display Left and Right Home Featured widget areas below Header+Nav only on HomePage.
//add_action( 'genesis_after_header', __NAMESPACE__ . '\home_featured' );
//function home_featured() {
//
//	if ( ! ( is_home() || is_front_page() ) )
//		return;
//
//	genesis_widget_area( 'home-featured-left', array(
//		'before'    => '<div class="home-featured"><div class="wrap"><div class="home-featured-left widget-area one-half first">',
//		'after'     => '</div>'
//	) );
//
//	genesis_widget_area( 'home-featured-right', array(
//		'before'    => '<div class="home-featured-right widget-area one-half">',
//		'after'     => '</div></div></div>'
//	) );
//
//}

/*********************************************************************************************************************/

/**
 * file:///media/karls/Linux-Dades/tutorials/000-sridhar-katakam/front-page/Sample%20Widgetized%20Front%20Page%20with%20Full%20Width%20Sections%20in%20Genesis%20-%20Sridhar%20Katakam.html
 * Sample Widgetized Front Page with Full Width Sections in Genesis
 */

