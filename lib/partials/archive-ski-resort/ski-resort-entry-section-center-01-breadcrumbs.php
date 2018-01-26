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

$count_breadcrumbs_1 = get_post_meta( get_the_ID(), 'breadcrumbs', true );

if ( $count_breadcrumbs_1 ) {

	for ( $i = 0; $i < $count_breadcrumbs_1; $i++ ) {

		$breadcrumb_1   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_1', true );
		$breadcrumb_2   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_2', true );
		$breadcrumb_3   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_3', true );
		$breadcrumb_4   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_4', true );
		$breadcrumb_5   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_5', true );
		$breadcrumb_6   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_6', true );
		$breadcrumb_7   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_7', true );
		$breadcrumb_8   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_8', true );
		$breadcrumb_9   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_9', true );
		$breadcrumb_10  = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_10', true );
		$url_1          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_1', true );
		$url_2          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_2', true );
		$url_3          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_3', true );
		$url_4          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_4', true );
		$url_5          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_5', true );
		$url_6          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_6', true );
		$url_7          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_7', true );
		$url_8          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_8', true );
		$url_9          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_9', true );
		$url_10         = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_10', true );

		if ( ! empty( $count_breadcrumbs_1 ) ) {

			echo '<p id="breadcrumbs"><a href="' . $url_1 . '" rel="bookmark">' . $breadcrumb_1 . '</a>';

			if ( ! empty( $breadcrumb_2 ) ) {

				echo ' &raquo; <a href="' . $url_2 . '" rel="bookmark">' . $breadcrumb_2 . '</a>';

				if ( ! empty( $breadcrumb_3 ) ) {

					echo ' &raquo; <a href="' . $url_3 . '" rel="bookmark">' . $breadcrumb_3 . '</a>';

					if ( ! empty( $breadcrumb_4 ) ) {

						echo ' &raquo; <a href="' . $url_4 . '" rel="bookmark">' . $breadcrumb_4 . '</a>';

						if ( ! empty( $breadcrumb_5 ) ) {

							echo ' &raquo; <a href="' . $url_5 . '" rel="bookmark">' . $breadcrumb_5 . '</a>';

							if ( ! empty( $breadcrumb_6 ) ) {

								echo ' &raquo; <a href="' . $url_6 . '" rel="bookmark">' . $breadcrumb_6 . '</a>';

								if ( ! empty( $breadcrumb_7 ) ) {

									echo ' &raquo; <a href="' . $url_7 . '" rel="bookmark">' . $breadcrumb_7 . '</a>';

									if ( ! empty( $breadcrumb_8 ) ) {

										echo ' &raquo; <a href="' . $url_8 . '" rel="bookmark">' . $breadcrumb_8 . '</a>';

										if ( ! empty( $breadcrumb_9 ) ) {

											echo ' &raquo; <a href="' . $url_9 . '" rel="bookmark">' . $breadcrumb_9 . '</a>';

											if ( ! empty( $breadcrumb_10 ) ) {

												echo ' &raquo; <a href="' . $url_10 . '" rel="bookmark">' . $breadcrumb_10 . '</a>';

											}

										}

									}

								}

							}

						}

					}

				}

			}

			echo '</p>';

		}

	}

}

$count_breadcrumbs_2 = get_post_meta( get_the_ID(), 'breadcrumbs', true );

if ( $count_breadcrumbs_2 ) {

	for ( $i = 0; $i < $count_breadcrumbs_2; $i++ ) {

		$breadcrumb_1   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_1', true );
		$breadcrumb_2   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_2', true );
		$breadcrumb_3   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_3', true );
		$breadcrumb_4   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_4', true );
		$breadcrumb_5   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_5', true );
		$breadcrumb_6   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_6', true );
		$breadcrumb_7   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_7', true );
		$breadcrumb_8   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_8', true );
		$breadcrumb_9   = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_9', true );
		$breadcrumb_10  = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_breadcrumb_10', true );
		$url_1          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_1', true );
		$url_2          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_2', true );
		$url_3          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_3', true );
		$url_4          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_4', true );
		$url_5          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_5', true );
		$url_6          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_6', true );
		$url_7          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_7', true );
		$url_8          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_8', true );
		$url_9          = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_9', true );
		$url_10         = get_post_meta( get_the_ID(), 'breadcrumbs_' . $i . '_url_10', true );

		if ( ! empty( $count_breadcrumbs_2 ) ) {

			echo '<p id="breadcrumbs"><a href="' . $url_1 . '" rel="bookmark">' . $breadcrumb_1 . '</a>';

			if ( ! empty( $breadcrumb_2 ) ) {

				echo ' &raquo; <a href="' . $url_2 . '" rel="bookmark">' . $breadcrumb_2 . '</a>';

				if ( ! empty( $breadcrumb_3 ) ) {

					echo ' &raquo; <a href="' . $url_3 . '" rel="bookmark">' . $breadcrumb_3 . '</a>';

					if ( ! empty( $breadcrumb_4 ) ) {

						echo ' &raquo; <a href="' . $url_4 . '" rel="bookmark">' . $breadcrumb_4 . '</a>';

						if ( ! empty( $breadcrumb_5 ) ) {

							echo ' &raquo; <a href="' . $url_5 . '" rel="bookmark">' . $breadcrumb_5 . '</a>';

							if ( ! empty( $breadcrumb_6 ) ) {

								echo ' &raquo; <a href="' . $url_6 . '" rel="bookmark">' . $breadcrumb_6 . '</a>';

								if ( ! empty( $breadcrumb_7 ) ) {

									echo ' &raquo; <a href="' . $url_7 . '" rel="bookmark">' . $breadcrumb_7 . '</a>';

									if ( ! empty( $breadcrumb_8 ) ) {

										echo ' &raquo; <a href="' . $url_8 . '" rel="bookmark">' . $breadcrumb_8 . '</a>';

										if ( ! empty( $breadcrumb_9 ) ) {

											echo ' &raquo; <a href="' . $url_9 . '" rel="bookmark">' . $breadcrumb_9 . '</a>';

											if ( ! empty( $breadcrumb_10 ) ) {

												echo ' &raquo; <a href="' . $url_10 . '" rel="bookmark">' . $breadcrumb_10 . '</a>';

											}

										}

									}

								}

							}

						}

					}

				}

			}

			echo '</p>';

		}

	}

}