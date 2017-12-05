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

if ( isset( $snow_depth_1 ) && $snow_depth_1 >= 0 ) {

	echo '<li class="snow-depth"><strong>';

	if ( $name_depth_1 ) {

		if ( $elevation_snow_depth_1 ) {
			echo $name_depth_1 . ' (' . number_format( $elevation_snow_depth_1 ) . ' ' . $elevation_depth_measure . '): ';
		} else {
			echo $name_depth_1 . ': ';
		}

	} elseif ( $elevation_snow_depth_1 ) {

		echo 'Snow Depth (' . number_format( $elevation_snow_depth_1 ) . ' ' . $elevation_depth_measure . '): ';

	} elseif ( !$name_depth_1 && !$elevation_snow_depth_1 ) {

		echo 'Snow Depth: ';

	}

	echo '</strong>' . $snow_depth_1 . ' ' . $snow_depth_measure;

	if ( $snow_depth_measure == 'cm' ) {
		echo ' (' . round( $snow_depth_1 * 0.3937 ) . '")';
	} elseif ( $snow_depth_measure == '"' ) {
		echo ' (' . round( $snow_depth_1 / 0.39370 ) . 'cm)';
	}

	if ( $snow_type_1 ) {
		echo ' ' . $snow_type_1_english . '</li>';
	} else {
		echo '</li>';
	}

	if ( isset( $snow_depth_2 ) && $snow_depth_2 >= 0 ) {

		echo '<li class="snow-depth"><strong>';

		if ( $name_depth_2 ) {

			if ( $elevation_snow_depth_2 ) {
				echo $name_depth_2 . ' (' . number_format( $elevation_snow_depth_2 ) . ' ' . $elevation_depth_measure . '): ';
			} else {
				echo $name_depth_2 . ': ';
			}

		} elseif ( $elevation_snow_depth_2 ) {

			echo 'Snow Depth (' . number_format( $elevation_snow_depth_2 ) . ' ' . $elevation_depth_measure . '): ';

		} elseif ( !$name_depth_2 && !$elevation_snow_depth_2 ) {

			echo 'Snow Depth: ';

		}

		echo '</strong>' . $snow_depth_2 . ' ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_2 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_2 / 0.39370 ) . 'cm)';
		}

		if ( $snow_type_2 ) {
			echo ' ' . $snow_type_2_english . '</li>';
		} else {
			echo '</li>';
		}

		if ( isset( $snow_depth_3 ) && $snow_depth_3 >= 0 ) {

			echo '<li class="snow-depth"><strong>';

			if ( $name_depth_3 ) {

				if ( $elevation_snow_depth_3 ) {
					echo $name_depth_3 . ' (' . number_format( $elevation_snow_depth_3 ) . ' ' . $elevation_depth_measure . '): ';
				} else {
					echo $name_depth_3 . ': ';
				}

			} elseif ( $elevation_snow_depth_3 ) {

				echo 'Snow Depth (' . number_format( $elevation_snow_depth_3 ) . ' ' . $elevation_depth_measure . '): ';

			} elseif ( !$name_depth_3 && !$elevation_snow_depth_3 ) {

				echo 'Snow Depth: ';

			}

			echo '</strong>' . $snow_depth_3 . ' ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_3 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_3 / 0.39370 ) . 'cm)';
			}

			if ( $snow_type_3 ) {
				echo ' ' . $snow_type_3_english . '</li>';
			} else {
				echo '</li>';
			}

			if ( isset( $snow_depth_4 ) && $snow_depth_4 >= 0 ) {

				echo '<li class="snow-depth"><strong>';

				if ( $name_depth_4 ) {

					if ( $elevation_snow_depth_4 ) {
						echo $name_depth_4 . ' (' . number_format( $elevation_snow_depth_4 ) . ' ' . $elevation_depth_measure . '): ';
					} else {
						echo $name_depth_4 . ': ';
					}

				} elseif ( $elevation_snow_depth_4 ) {

					echo 'Snow Depth (' . number_format( $elevation_snow_depth_4 ) . ' ' . $elevation_depth_measure . '): ';

				} elseif ( !$name_depth_4 && !$elevation_snow_depth_4 ) {

					echo 'Snow Depth: ';

				}

				echo '</strong>' . $snow_depth_4 . ' ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_4 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_4 / 0.39370 ) . 'cm)';
				}

				if ( $snow_type_4 ) {
					echo ' ' . $snow_type_4_english . '</li>';
				} else {
					echo '</li>';
				}

				if ( isset( $snow_depth_5 ) && $snow_depth_5 >= 0 ) {

					echo '<li class="snow-depth"><strong>';

					if ( $name_depth_5 ) {

						if ( $elevation_snow_depth_5 ) {
							echo $name_depth_5 . ' (' . number_format( $elevation_snow_depth_5 ) . ' ' . $elevation_depth_measure . '): ';
						} else {
							echo $name_depth_5 . ': ';
						}

					} elseif ( $elevation_snow_depth_5 ) {

						echo 'Snow Depth (' . number_format( $elevation_snow_depth_5 ) . ' ' . $elevation_depth_measure . '): ';

					} elseif ( !$name_depth_5 && !$elevation_snow_depth_5 ) {

						echo 'Snow Depth: ';

					}

					echo '</strong>' . $snow_depth_5 . ' ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_5 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_5 / 0.39370 ) . 'cm)';
					}

					if ( $snow_type_5 ) {
						echo ' ' . $snow_type_5_english . '</li>';
					} else {
						echo '</li>';
					}

					if ( isset( $snow_depth_6 ) && $snow_depth_6 >= 0 ) {

						echo '<li class="snow-depth"><strong>';

						if ( $name_depth_1 ) {

							if ( $elevation_snow_depth_6 ) {
								echo $name_depth_6 . ' (' . number_format( $elevation_snow_depth_6 ) . ' ' . $elevation_depth_measure . '): ';
							} else {
								echo $name_depth_6 . ': ';
							}

						} elseif ( $elevation_snow_depth_6 ) {

							echo 'Snow Depth (' . number_format( $elevation_snow_depth_6 ) . ' ' . $elevation_depth_measure . '): ';

						} elseif ( !$name_depth_6 && !$elevation_snow_depth_6 ) {

							echo 'Snow Depth: ';

						}

						echo '</strong>' . $snow_depth_6 . ' ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_6 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_6 / 0.39370 ) . 'cm)';
						}

						if ( $snow_type_6 ) {
							echo ' ' . $snow_type_6_english . '</li>';
						} else {
							echo '</li>';
						}

						if ( isset( $snow_depth_7 ) && $snow_depth_7 >= 0 ) {

							echo '<li class="snow-depth"><strong>';

							if ( $name_depth_7 ) {

								if ( $elevation_snow_depth_7 ) {
									echo $name_depth_7 . ' (' . number_format( $elevation_snow_depth_7 ) . ' ' . $elevation_depth_measure . '): ';
								} else {
									echo $name_depth_7 . ': ';
								}

							} elseif ( $elevation_snow_depth_7 ) {

								echo 'Snow Depth (' . number_format( $elevation_snow_depth_7 ) . ' ' . $elevation_depth_measure . '): ';

							} elseif ( !$name_depth_7 && !$elevation_snow_depth_7 ) {

								echo 'Snow Depth: ';

							}

							echo '</strong>' . $snow_depth_7 . ' ' . $snow_depth_measure;

							if ( $snow_depth_measure == 'cm' ) {
								echo ' (' . round( $snow_depth_7 * 0.3937 ) . '")';
							} elseif ( $snow_depth_measure == '"' ) {
								echo ' (' . round( $snow_depth_7 / 0.39370 ) . 'cm)';
							}

							if ( $snow_type_7 ) {
								echo ' ' . $snow_type_7_english . '</li>';
							} else {
								echo '</li>';
							}

						}

					}

				}

			}

		}

	}

}