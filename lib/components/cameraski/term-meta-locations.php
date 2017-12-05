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
 * Array for Location Types.
 *
 * @since   1.0.0
 *
 * @return array
 */
function get_location_type() {

	return array(
		'continent'                     =>  __( 'Continents', CHILD_TEXT_DOMAIN ),
		'sub_continent'                 =>  __( 'Sub-Continents', CHILD_TEXT_DOMAIN ),
		'central_asia'                  =>  __( 'Central Asia', CHILD_TEXT_DOMAIN ),
		'east_asia'                     =>  __( 'East Asia', CHILD_TEXT_DOMAIN ),
		'south_asia'                    =>  __( 'South Asia', CHILD_TEXT_DOMAIN ),
		'southeast_asia'                =>  __( 'SouthEast Asia', CHILD_TEXT_DOMAIN ),
		'west_asia'                     =>  __( 'West Asia', CHILD_TEXT_DOMAIN ),
		'central_europe'                =>  __( 'Central Europe', CHILD_TEXT_DOMAIN ),
		'eastern_europe'                =>  __( 'Eastern Europe', CHILD_TEXT_DOMAIN ),
		'northern_europe'               =>  __( 'Northern Europe', CHILD_TEXT_DOMAIN ),
		'southern_europe'               =>  __( 'Southern Europe', CHILD_TEXT_DOMAIN ),
		'western_europe'                =>  __( 'Western Europe', CHILD_TEXT_DOMAIN ),
		'balkans'                       =>  __( 'Balkans - SouthEastern Europe', CHILD_TEXT_DOMAIN ),
		'baltic_states'                 =>  __( 'Baltic States', CHILD_TEXT_DOMAIN ),
		'benelux_union'                 =>  __( 'Benelux Union', CHILD_TEXT_DOMAIN ),
		'eu'                            =>  __( 'European Union', CHILD_TEXT_DOMAIN ),
		'scandinavia'                   =>  __( 'Scandinavia', CHILD_TEXT_DOMAIN ),
		'country_group'                 =>  __( 'Country Groups', CHILD_TEXT_DOMAIN ),
		'country'                       =>  __( 'Countries', CHILD_TEXT_DOMAIN ),
		'country_area'                  =>  __( 'Country Areas', CHILD_TEXT_DOMAIN ),
		'country_sub_area'              =>  __( 'Country Sub-Areas', CHILD_TEXT_DOMAIN ),
		'country_district'              =>  __( 'Country Districts / Free City', CHILD_TEXT_DOMAIN ),
		'administrative_region'         =>  __( 'Administrative Regions', CHILD_TEXT_DOMAIN ),
		'autonomous_community'          =>  __( 'Autonomous Communities', CHILD_TEXT_DOMAIN ),
		'canton'                        =>  __( 'Cantons', CHILD_TEXT_DOMAIN ),
		'county'                        =>  __( 'Counties', CHILD_TEXT_DOMAIN ),
		'department'                    =>  __( 'Departments', CHILD_TEXT_DOMAIN ),
		'district'                      =>  __( 'Districts', CHILD_TEXT_DOMAIN ),
		'district_city'                 =>  __( 'Districts / Cities', CHILD_TEXT_DOMAIN ),
		'greater_area'                  =>  __( 'Greater Areas', CHILD_TEXT_DOMAIN ),
		'greater_regions'               =>  __( 'Greater Regions', CHILD_TEXT_DOMAIN ),
		'language_area'                 =>  __( 'Language Areas', CHILD_TEXT_DOMAIN ),
		'municipality'                  =>  __( 'Municipalities', CHILD_TEXT_DOMAIN ),
		'new_regions'                   =>  __( 'New Regions', CHILD_TEXT_DOMAIN ),
		'old_regions'                   =>  __( 'Old Regions', CHILD_TEXT_DOMAIN ),
		'prefecture'                    =>  __( 'Prefectures', CHILD_TEXT_DOMAIN ),
		'province'                      =>  __( 'Provinces', CHILD_TEXT_DOMAIN ),
		'province_can'                  =>  __( 'Canada Provinces', CHILD_TEXT_DOMAIN ),
		'region'                        =>  __( 'Regions', CHILD_TEXT_DOMAIN ),
		'regional_district'             =>  __( 'Regional Districts', CHILD_TEXT_DOMAIN ),
		'state'                         =>  __( 'States', CHILD_TEXT_DOMAIN ),
		'state_us'                      =>  __( 'US States', CHILD_TEXT_DOMAIN ),
		'subprefecture'                 =>  __( 'Subprefectures', CHILD_TEXT_DOMAIN ),
		'territory'                     =>  __( 'Territories', CHILD_TEXT_DOMAIN ),
		'urban_area'                    =>  __( 'Urban Area', CHILD_TEXT_DOMAIN ),
		'continental_mountain_range'    =>  __( 'Continental Mountain Ranges', CHILD_TEXT_DOMAIN ),
		'cross_border_mountain_range'   =>  __( 'Cross-border Mountain Ranges', CHILD_TEXT_DOMAIN ),
		'country_mountain_range'        =>  __( 'Country Mountain Ranges', CHILD_TEXT_DOMAIN ),
		'country_sub_mountain_range'    =>  __( 'Country Sub-Mountain Ranges', CHILD_TEXT_DOMAIN ),
		'mountain_system'               =>  __( 'Mountain Range Systems', CHILD_TEXT_DOMAIN ),
		'mountain_range'                =>  __( 'Mountain Ranges', CHILD_TEXT_DOMAIN ),
		'mountain_range_area'           =>  __( 'Mountain Range Areas', CHILD_TEXT_DOMAIN ),
		'mountain_range_sub_area'       =>  __( 'Mountain Range Sub Areas', CHILD_TEXT_DOMAIN ),
		'sub_mountain_range'            =>  __( 'Sub-Mountain Ranges', CHILD_TEXT_DOMAIN ),
		'greater_tourism_area'          =>  __( 'Greater Tourism Areas', CHILD_TEXT_DOMAIN ),
		'tourism_area'                  =>  __( 'Tourism Areas', CHILD_TEXT_DOMAIN ),
		'national_park'                 =>  __( 'National Parks', CHILD_TEXT_DOMAIN ),
		'natural_park'                  =>  __( 'Natural Parks', CHILD_TEXT_DOMAIN ),
		'park_system'                   =>  __( 'Park Systems', CHILD_TEXT_DOMAIN ),
		'provincial_park'               =>  __( 'Provincial Parks', CHILD_TEXT_DOMAIN ),
		'regional_park'                 =>  __( 'Regional Parks', CHILD_TEXT_DOMAIN ),
		'island'                        =>  __( 'Islands', CHILD_TEXT_DOMAIN ),
		'valley'                        =>  __( 'Valleys', CHILD_TEXT_DOMAIN ),
		'special_area'                  =>  __( 'Special Areas', CHILD_TEXT_DOMAIN ),
		'other'                         =>  __( 'Others', CHILD_TEXT_DOMAIN ),
	);

}

add_action( 'locations_add_form_fields', __NAMESPACE__ . '\add_location_type_term_meta' );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @return void
 */
function add_location_type_term_meta() {

	?>
	<div class="form-field term-group">
		<label for="location-type"><?php _e( 'Location Type', CHILD_TEXT_DOMAIN ); ?></label>
		<select class="postform[]" id="location-type[]" name="location-type[]" size="70" multiple="multiple">
			<option value="" selected><?php _e( 'None', CHILD_TEXT_DOMAIN ) ?></option>
			<?php foreach ( get_location_type() as $value => $option_name ) : ?>

				<option value="<?php echo $value; ?>" class=""><?php echo $option_name; ?></option>

			<?php endforeach; ?>
		</select>
	</div>
	<?php

}

add_action( 'created_locations', __NAMESPACE__ . '\save_location_type_term_meta' );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @param $term_id
 *
 * @return void
 */
function save_location_type_term_meta( $term_id ) {
	$old_values = get_term_meta( $term_id, 'location-type' );
	$new_values = isset( $_POST['location-type'] ) ? $_POST['location-type'] : array();
	if ( empty( $new_values ) ) {
		delete_term_meta( $term_id, 'location-type' );
	} else {
		$already_values = array();
		if ( ! empty( $old_values ) ) {
			foreach ( $old_values as $old_value ) {
				if ( ! in_array( $old_value, $new_values ) ) {
					delete_term_meta( $term_id, 'location-type', $old_value );
				} else {
					$already_values[] = $old_value;
				}
			}
		}
		$to_save_values = array_diff( $new_values, $already_values );
		if ( ! empty( $to_save_values ) ) {
			foreach ( $to_save_values as $to_save_value ) {
				add_term_meta( $term_id, 'location-type', $to_save_value, false );
			}
		}
	}
}

add_action( 'locations_edit_form_fields', __NAMESPACE__ . '\edit_location_type_term_meta' );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @param $term
 *
 * @return void
 */
function edit_location_type_term_meta( $term ) {

	// Get current group.
	$current_values = get_term_meta( $term->term_id, 'location-type' );

	?>
	<tr class="form-field term-group-wrap">
		<th scope="row"><label for="location-type"><?php _e( 'Location Type', CHILD_TEXT_DOMAIN ); ?></label></th>
		<td>
			<select multiple class="postform[]" id="location-type[]" name="location-type[]" size="70" multiple="multiple">
				<option value="" selected><?php _e( 'None', CHILD_TEXT_DOMAIN ); ?></option>
				<?php foreach ( get_location_type() as $value => $option_name ) : ?>

					<option value="<?php echo $value; ?>" <?php selected( $current_values, $value ); ?>><?php echo $option_name; ?></option>

				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<?php

}

add_action( 'edited_locations', __NAMESPACE__ . '\update_location_type_term_meta' );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @param $term_id
 *
 * @return void
 */
function update_location_type_term_meta( $term_id ) {

	$old_values = get_term_meta( $term_id, 'location-type' );
	$new_values = isset( $_POST['location-type'] ) ? $_POST['location-type'] : array();

	if ( empty( $new_values ) ) {

		// No Groups Europe selected. Then, completely delete all Meta values for the Term.
		delete_term_meta( $term_id, 'location-type' );

	} else {

		$already_values = array();

		if ( ! empty( $old_values ) ) {

			foreach ( $old_values as $old_value ) {

				if ( ! in_array( $old_value, $new_values ) ) {

					// This value was selected, but now it isn't, so delete it.
					delete_term_meta( $term_id, 'location-type', $old_value );

				} else {

					// This value is already saved, we can skip it from saving.
					$already_values[] = $old_value;

				}

			}

		}

		// We don't save what is already saved.
		$to_save_values = array_diff( $new_values, $already_values );

		if ( ! empty( $to_save_values ) ) {

			foreach ( $to_save_values as $to_save_value ) {

				//$group_europe = sanitize_title( $_POST['location-type'] );
				add_term_meta( $term_id, 'location-type', $to_save_value, false );

			}

		}

	}

}

add_filter( 'manage_edit-locations_columns', __NAMESPACE__ . '\add_location_type_column' );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @param $columns
 *
 * @return mixed
 */
function add_location_type_column( $columns ) {

	$columns['location_type'] = __( 'Location Type', CHILD_TEXT_DOMAIN );

	return $columns;

}

add_filter( 'manage_locations_custom_column', __NAMESPACE__ . '\add_location_type_column_content', 10, 3 );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @param $content
 * @param $column_name
 * @param $term_id
 *
 * @return string
 */
function add_location_type_column_content( $content, $column_name, $term_id ) {

	if ( $column_name !== 'location_type' ) {
		return $content;
	}

	$term_id                = absint( $term_id );
	$current_column_values  = get_term_meta( $term_id, 'location-type', true );

	if ( ! empty( $current_column_values ) ) {
		$content .= esc_attr( get_location_type()[ $current_column_values ] );
	}

	return $content;

}

add_filter( 'manage_edit-locations_sortable_columns', __NAMESPACE__ . '\add_location_type_column_sortable' );
/**
 * Description
 *
 * @since   1.0.0
 *
 * @param $sortable
 *
 * @return mixed
 */
function add_location_type_column_sortable( $sortable ) {

	$sortable['location_type'] = 'location_type';

	return $sortable;

}