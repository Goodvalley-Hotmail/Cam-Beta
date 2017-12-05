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

add_action( 'init', __NAMESPACE__ . '\register_cpts' );
/**
 * Registers CPT 'ski-resort'.
 *
 * @since   1.0.0
 *
 * @return void
 */
function register_cpts() {

	$cpts = array(
		array(
			'slug'          => 'ski-domain',
			'single_name'   => 'Ski Domain',
			'plural_name'   => 'Ski Domains',
			'label'         => __( 'Ski Domain', CHILD_TEXT_DOMAIN ),
			'description'   => __( 'CPT Ski Domain', CHILD_TEXT_DOMAIN ),
			'menu_icon'     => 'dashicons-networking',
			'has_archive'   => 'ski-domains',
		),
		array(
			'slug'          => 'ski-resort',
			'single_name'   => 'Ski Resort',
			'plural_name'   => 'Ski Resorts',
			'label'         => __( 'Ski Resort', CHILD_TEXT_DOMAIN ),
			'description'   => __( 'CPT Ski Resort', CHILD_TEXT_DOMAIN ),
			'menu_icon'     => 'dashicons-chart-area',
			'has_archive'   => 'ski-resorts',
		),
		array(
			'slug'          => 'ski-resort-webcams',
			'single_name'   => 'WebCam',
			'plural_name'   => 'WebCams',
			'label'         => __( 'WebCams', CHILD_TEXT_DOMAIN ),
			'description'   => __( 'CPT WebCams', CHILD_TEXT_DOMAIN ),
			'menu_icon'     => 'dashicons-camera',
			'has_archive'   => 'ski-resort-webcams',
		),
		array(
			'slug'          => 'weather-forecast',
			'single_name'   => 'Weather Forecast',
			'plural_name'   => 'Weather Forecasts',
			'label'         => __( 'Weather Forecast', CHILD_TEXT_DOMAIN ),
			'description'   => __( 'CPT Weather Forecast', CHILD_TEXT_DOMAIN ),
			'menu_icon'     => 'dashicons-cloud',
			'has_archive'   => 'weather-forecasts',
		),
	);

	foreach ( $cpts as $cpt ) {

		$labels = array(
			'name'                  => _x( $cpt['plural_name'], 'Post Type General Name', CHILD_TEXT_DOMAIN ),
			'singular_name'         => _x( $cpt['single_name'], 'Post Type Singular Name', CHILD_TEXT_DOMAIN ),
			'menu_name'             => __( $cpt['plural_name'], CHILD_TEXT_DOMAIN ),
			'name_admin_bar'        => __( $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'archives'              => __( $cpt['single_name'] . ' Archives', CHILD_TEXT_DOMAIN ),
			'attributes'            => __( $cpt['single_name'] . ' Attributes', CHILD_TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent ' . $cpt['single_name'] . ':', CHILD_TEXT_DOMAIN ),
			'all_items'             => __( 'All ' . $cpt['plural_name'], CHILD_TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'add_new'               => __( 'Add New', CHILD_TEXT_DOMAIN ),
			'new_item'              => __( 'New ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'update_item'           => __( 'Update ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'view_item'             => __( 'View ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'view_items'            => __( 'View ' . $cpt['plural_name'], CHILD_TEXT_DOMAIN ),
			'search_items'          => __( 'Search ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'not_found'             => __( 'Not found', CHILD_TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', CHILD_TEXT_DOMAIN ),
			'featured_image'        => __( 'Featured Image', CHILD_TEXT_DOMAIN ),
			'set_featured_image'    => __( 'Set featured image', CHILD_TEXT_DOMAIN ),
			'remove_featured_image' => __( 'Remove featured image', CHILD_TEXT_DOMAIN ),
			'use_featured_image'    => __( 'Use as featured image', CHILD_TEXT_DOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this ' . $cpt['single_name'], CHILD_TEXT_DOMAIN ),
			'items_list'            => __( $cpt['plural_name'] . ' list', CHILD_TEXT_DOMAIN ),
			'items_list_navigation' => __( $cpt['plural_name'] . ' list navigation', CHILD_TEXT_DOMAIN ),
			'filter_items_list'     => __( 'Filter ' . $cpt['plural_name'] . ' list', CHILD_TEXT_DOMAIN ),
		);

		$label          = isset( $cpt['label'] ) ? $cpt['label'] : null;
		$description    = isset( $cpt['description'] ) ? $cpt['description'] : null;
		$hierarchical   = isset( $cpt['hierarchical'] ) ? $cpt['hierarchical'] : false;
		$menu_icon      = isset( $cpt['menu_icon'] ) ? $cpt['menu_icon'] : null;
		$has_archive    = isset( $cpt['has_archive'] ) ? $cpt['has_archive'] : false;

		register_post_type( $cpt['slug'], array(
			'label'                 => $label,
			'description'           => $description,
			'hierarchical'          => $hierarchical,
			'labels'                => $labels,
			'supports'              => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'genesis-cpt-archives-settings',
				'genesis-seo',
				'genesis-layouts',
			),
			'public'                => true,
			'menu_position'         => 5,
			'menu_icon'             => $menu_icon,
			'has_archive'           => $has_archive,
		) );

	}

}