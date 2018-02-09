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

add_action( 'get_header', __NAMESPACE__ . '\cpt_ski_resort_microdata' );
function cpt_ski_resort_microdata() {

	if ( 'ski-resort' == get_post_type() ) {

		add_filter( 'genesis_attr_entry', __NAMESPACE__ .  '\microdata_entry' );
		/**
		 * Changes MicroData in <article></article>.
		 *
		 * @since   1.0.0
		 *
		 * @param $attributes
		 *
		 * @return mixed
		 */
		function microdata_entry( $attributes ) {

			$attributes['itemtype'] = 'http://schema.org/SkiResort';

			return $attributes;

		}

		//add_filter( 'genesis_entry_header', __NAMESPACE__ . '\microdata_entry_header' );
		function microdata_entry_header( $attributes ) {

			$attributes['itemprop'] = 'headline';

			return $attributes;

		}

		add_filter( 'genesis_attr_entry-title', __NAMESPACE__ . '\microdata_entry_title' );
		function microdata_entry_title( $attributes ) {

			$attributes['itemprop'] = 'name';

			return $attributes;

		}

	}

}