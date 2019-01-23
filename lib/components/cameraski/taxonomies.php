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

add_action( 'init', __NAMESPACE__ . '\register_taxonomies' );
/**
 * Registers Taxonomies 'locations' and 'tabbed-groups' in a single function.
 * https://www.billerickson.net/code/register-multiple-taxonomies/
 *
 * @since   1.0.0
 *
 * @return void
 */
function register_taxonomies() {

	$taxonomies = array(
		array(
			'slug'              => 'locations',
			'single_name'       => 'Location',
			'plural_name'       => 'Locations',
			'post_type'         => array(
				'ski_domain'        => 'ski-domain',
				'ski_resort'        => 'ski-resort',
				'webcams'           => 'ski-resort-webcams',
				'weather_forecast'  => 'weather-forecast',
			),
			'hierarchical'      => false,
			'rewrite'           => array(
				'slug'              => 'ski-resorts',
			),
		),
		array(
			'slug'              => 'tabbed-groups',
			'single_name'       => 'Tabbed Group',
			'plural_name'       => 'Tabbed Groups',
			'post_type'         => array(
				'ski_resort'        => 'ski-resort',
				'webcams'           => 'ski-resort-webcams',
				'weather_forecast'  => 'weather-forecast',
			),
			'hierarchical'      => false,
			'rewrite'           => array(
				'slug'              => 'tabbed-groups',
			),
			'show_in_nav_menus' => false,
		),
		array(
			'slug'              => 'domain-groups',
			'single_name'       => 'Domain Group',
			'plural_name'       => 'Domain Groups',
			'post_type'         => array(
				'ski_resort'        => 'ski-resort',
				'webcams'           => 'ski-resort-webcams',
				'weather_forecast'  => 'weather-forecast',
			),
			'hierarchical'      => false,
			'rewrite'           => array(
				'slug'              => 'ski-domains',
			),
			'show_in_nav_menus' => false,
		),
	);

	foreach ( $taxonomies as $taxonomy ) {

		$labels = array(
			'name'                       => _x( $taxonomy['plural_name'], 'Taxonomy General Name', CHILD_TEXT_DOMAIN ),
			'singular_name'              => _x( $taxonomy['single_name'], 'Taxonomy Singular Name', CHILD_TEXT_DOMAIN ),
			'menu_name'                  => __( $taxonomy['plural_name'], CHILD_TEXT_DOMAIN ),
			'all_items'                  => __( 'All ' . $taxonomy['plural_name'], CHILD_TEXT_DOMAIN ),
			'parent_item'                => __( 'Parent ' . $taxonomy['single_name'], CHILD_TEXT_DOMAIN ),
			'parent_item_colon'          => __( 'Parent ' . $taxonomy['single_name'] . ':', CHILD_TEXT_DOMAIN ),
			'new_item_name'              => __( 'New ' . $taxonomy['single_name'] . ' Name', CHILD_TEXT_DOMAIN ),
			'add_new_item'               => __( 'Add new ' . $taxonomy['single_name'], CHILD_TEXT_DOMAIN ),
			'edit_item'                  => __( 'Edit ' . $taxonomy['single_name'], CHILD_TEXT_DOMAIN ),
			'update_item'                => __( 'Update ' . $taxonomy['single_name'], CHILD_TEXT_DOMAIN ),
			'view_item'                  => __( 'View ' . $taxonomy['single_name'], CHILD_TEXT_DOMAIN ),
			'separate_items_with_commas' => __( 'Separate ' . $taxonomy['plural_name'] . ' with commas', CHILD_TEXT_DOMAIN ),
			'add_or_remove_items'        => __( 'Add or remove ' . $taxonomy['plural_name'], CHILD_TEXT_DOMAIN ),
			'choose_from_most_used'      => __( 'Choose from the most used', CHILD_TEXT_DOMAIN ),
			'popular_items'              => __( 'Popular ' . $taxonomy['plural_name'], CHILD_TEXT_DOMAIN ),
			'search_items'               => __( 'Search ' . $taxonomy['plural_name'], CHILD_TEXT_DOMAIN ),
			'not_found'                  => __( 'Not Found', CHILD_TEXT_DOMAIN ),
			'no_terms'                   => __( 'No ' . $taxonomy['plural_name'], CHILD_TEXT_DOMAIN ),
			'items_list'                 => __( $taxonomy['plural_name'] . ' list', CHILD_TEXT_DOMAIN ),
			'items_list_navigation'      => __( $taxonomy['plural_name'] . ' list navigation', CHILD_TEXT_DOMAIN ),
		);

		$rewrite            = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
		$hierarchical       = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
		$show_in_nav_menus  = isset( $taxonomy['show_in_nav_menus'] ) ? $taxonomy['show_in_nav_menus'] : true;

		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
			'hierarchical'      => $hierarchical,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => $show_in_nav_menus,
			'rewrite'           => $rewrite,
		) );

	}

}