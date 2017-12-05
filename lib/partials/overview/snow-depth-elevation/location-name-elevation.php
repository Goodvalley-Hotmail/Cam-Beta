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

if ( $location_depth_1 || $location_depth_2 || $location_depth_3 || $location_depth_4 || $location_depth_5 ) {

	if ( $location_1_name_1 && $location_1_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_1 . '( ' . number_format( $location_1_elevation_1 ) . ' ): </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_1_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_1_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_1_1_english;

		if ( $location_1_name_2 && $location_1_elevation_2 ) {

			echo ' | ' . $snow_depth_1_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_1_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_1_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_1_2_english;

			if ( $location_1_name_3 && $location_1_elevation_3 ) {

				echo ' | ' . $snow_depth_1_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_1_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_1_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_1_3_english;

				if ( $location_1_name_4 && $location_1_elevation_4 ) {

					echo ' | ' . $snow_depth_1_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_1_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_1_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_1_4_english;

					if ( $location_1_name_5 && $location_1_elevation_5 ) {

						echo ' | ' . $snow_depth_1_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_1_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_1_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_1_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_1 . '</li>';

	}

	if ( $location_1_name_1 && !$location_1_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_1 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_1_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_1_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_1_1_english;

		if ( $location_1_name_2 && !$location_1_elevation_2 ) {

			echo '<strong> || </strong>' . $snow_depth_1_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_1_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_1_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_1_2_english;

			if ( $location_1_name_3 && !$location_1_elevation_3 ) {

				echo '<strong> || </strong>' . $snow_depth_1_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_1_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_1_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_1_3_english;

				if ( $location_1_name_4 && !$location_1_elevation_4 ) {

					echo '<strong> || </strong>' . $snow_depth_1_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_1_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_1_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_1_4_english;

					if ( $location_1_name_5 && !$location_1_elevation_5 ) {

						echo '<strong> || </strong>' . $snow_depth_1_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_1_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_1_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_1_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_1 . '</li>';

	}

	if ( $location_1_elevation_1 && !$location_1_name_1 ) {

		echo '<li class="snow-depth"><strong>' . number_format( $location_1_elevation_1 ) . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_1_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_1_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_1_1_english;

		if ( $location_1_elevation_2 && !$location_1_name_2 ) {

			echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_2 ) . ': </strong>' . $snow_depth_1_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_1_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_1_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_1_2_english;

			if ( $location_1_elevation_3 && !$location_1_name_3 ) {

				echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_3 ) . ': </strong>' . $snow_depth_1_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_1_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_1_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_1_3_english;

				if ( $location_1_elevation_4 && !$location_1_name_4 ) {

					echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_4 ) . ': </strong>' . $snow_depth_1_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_1_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_1_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_1_4_english;

					if ( $location_1_elevation_5 && !$location_1_name_5 ) {

						echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_1_elevation_5 ) . ': </strong>' . $snow_depth_1_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_1_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_1_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_1_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_1 . '</li>';

	}

	if ( $location_2_name_1 && $location_2_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_2 . '( ' . number_format( $location_2_elevation_1 ) . ' ): </strong>' . $snow_depth_2_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_2_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_2_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_2_1_english;

		if ( $location_2_name_2 && $location_2_elevation_2 ) {

			echo ' | ' . $snow_depth_2_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_2_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_2_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_2_2_english;

			if ( $location_2_name_3 && $location_2_elevation_3 ) {

				echo ' | ' . $snow_depth_2_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_2_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_2_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_2_3_english;

				if ( $location_2_name_4 && $location_2_elevation_4 ) {

					echo ' | ' . $snow_depth_2_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_2_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_2_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_2_4_english;

					if ( $location_2_name_5 && $location_2_elevation_5 ) {

						echo ' | ' . $snow_depth_2_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_2_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_2_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_2_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_2 . '</li>';

	}

	if ( $location_2_name_1 && !$location_2_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_2 . ': </strong>' . $snow_depth_2_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_2_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_2_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_2_1_english;

		if ( $location_2_name_2 && !$location_2_elevation_2 ) {

			echo '<strong> || </strong>' . $snow_depth_2_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_2_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_2_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_2_2_english;

			if ( $location_2_name_3 && !$location_2_elevation_3 ) {

				echo '<strong> || </strong>' . $snow_depth_2_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_2_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_2_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_2_3_english;

				if ( $location_2_name_4 && !$location_2_elevation_4 ) {

					echo '<strong> || </strong>' . $snow_depth_2_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_2_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_2_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_2_4_english;

					if ( $location_2_name_5 && !$location_2_elevation_5 ) {

						echo '<strong> || </strong>' . $snow_depth_2_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_2_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_2_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_2_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_2 . '</li>';

	}

	if ( $location_2_elevation_1 && !$location_2_name_1 ) {

		echo '<li class="snow-depth"><strong>' . number_format( $location_2_elevation_1 ) . ': </strong>' . $snow_depth_2_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_2_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_2_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_2_1_english;

		if ( $location_2_elevation_2 && !$location_2_name_2 ) {

			echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_2 ) . ': </strong>' . $snow_depth_2_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_2_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_2_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_2_2_english;

			if ( $location_2_elevation_3 && !$location_2_name_3 ) {

				echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_3 ) . ': </strong>' . $snow_depth_2_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_2_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_2_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_2_3_english;

				if ( $location_2_elevation_4 && !$location_2_name_4 ) {

					echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_4 ) . ': </strong>' . $snow_depth_2_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_2_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_2_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_2_4_english;

					if ( $location_2_elevation_5 && !$location_2_name_5 ) {

						echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_2_elevation_5 ) . ': </strong>' . $snow_depth_2_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_2_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_2_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_2_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_2 . '</li>';

	}

	if ( $location_3_name_1 && $location_3_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_3 . '( ' . number_format( $location_3_elevation_1 ) . ' ): </strong>' . $snow_depth_3_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_3_1_english;

		if ( $location_3_name_2 && $location_3_elevation_2 ) {

			echo ' | ' . $snow_depth_3_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_3_2_english;

			if ( $location_3_name_3 && $location_3_elevation_3 ) {

				echo ' | ' . $snow_depth_3_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_3_3_english;

				if ( $location_3_name_4 && $location_3_elevation_4 ) {

					echo ' | ' . $snow_depth_3_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_3_4_english;

					if ( $location_3_name_5 && $location_3_elevation_5 ) {

						echo ' | ' . $snow_depth_3_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_3_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_3 . '</li>';

	}

	if ( $location_3_name_1 && !$location_3_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_3 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_3_1_english;

		if ( $location_3_name_2 && !$location_3_elevation_2 ) {

			echo '<strong> || </strong>' . $snow_depth_3_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_3_2_english;

			if ( $location_3_name_3 && !$location_3_elevation_3 ) {

				echo '<strong> || </strong>' . $snow_depth_3_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_3_3_english;

				if ( $location_3_name_4 && !$location_3_elevation_4 ) {

					echo '<strong> || </strong>' . $snow_depth_3_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_3_4_english;

					if ( $location_3_name_5 && !$location_3_elevation_5 ) {

						echo '<strong> || </strong>' . $snow_depth_3_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_3_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_3 . '</li>';

	}

	if ( $location_3_elevation_1 && !$location_3_name_1 ) {

		echo '<li class="snow-depth"><strong>' . number_format( $location_3_elevation_1 ) . ': </strong>' . $snow_depth_3_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_3_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_3_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_3_1_english;

		if ( $location_3_elevation_2 && !$location_3_name_2 ) {

			echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_2 ) . ': </strong>' . $snow_depth_3_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_3_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_3_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_3_2_english;

			if ( $location_3_elevation_3 && !$location_3_name_3 ) {

				echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_3 ) . ': </strong>' . $snow_depth_3_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_3_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_3_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_3_3_english;

				if ( $location_3_elevation_4 && !$location_3_name_4 ) {

					echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_4 ) . ': </strong>' . $snow_depth_3_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_3_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_3_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_3_4_english;

					if ( $location_3_elevation_5 && !$location_3_name_5 ) {

						echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_3_elevation_5 ) . ': </strong>' . $snow_depth_3_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_3_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_3_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_3_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_3 . '</li>';

	}

	if ( $location_4_name_1 && $location_4_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_4 . '( ' . number_format( $location_4_elevation_1 ) . ' ): </strong>' . $snow_depth_4_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_4_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_4_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_4_1_english;

		if ( $location_4_name_2 && $location_4_elevation_2 ) {

			echo ' | ' . $snow_depth_4_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_4_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_4_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_4_2_english;

			if ( $location_4_name_3 && $location_4_elevation_3 ) {

				echo ' | ' . $snow_depth_4_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_4_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_4_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_4_3_english;

				if ( $location_4_name_4 && $location_4_elevation_4 ) {

					echo ' | ' . $snow_depth_4_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_4_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_4_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_4_4_english;

					if ( $location_4_name_5 && $location_4_elevation_5 ) {

						echo ' | ' . $snow_depth_4_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_4_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_4_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_4_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_4 . '</li>';

	}

	if ( $location_4_name_1 && !$location_4_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_4 . ': </strong>' . $snow_depth_4_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_4_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_4_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_4_1_english;

		if ( $location_4_name_2 && !$location_4_elevation_2 ) {

			echo '<strong> || </strong>' . $snow_depth_4_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_4_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_4_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_4_2_english;

			if ( $location_4_name_3 && !$location_4_elevation_3 ) {

				echo '<strong> || </strong>' . $snow_depth_4_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_4_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_4_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_4_3_english;

				if ( $location_4_name_4 && !$location_4_elevation_4 ) {

					echo '<strong> || </strong>' . $snow_depth_4_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_4_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_4_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_4_4_english;

					if ( $location_4_name_5 && !$location_4_elevation_5 ) {

						echo '<strong> || </strong>' . $snow_depth_4_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_4_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_4_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_4_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_4 . '</li>';

	}

	if ( $location_4_elevation_1 && !$location_4_name_1 ) {

		echo '<li class="snow-depth"><strong>' . number_format( $location_4_elevation_1 ) . ': </strong>' . $snow_depth_4_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_4_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_4_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_4_1_english;

		if ( $location_4_elevation_2 && !$location_4_name_2 ) {

			echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_2 ) . ': </strong>' . $snow_depth_4_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_4_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_4_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_4_2_english;

			if ( $location_4_elevation_3 && !$location_4_name_3 ) {

				echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_3 ) . ': </strong>' . $snow_depth_4_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_4_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_4_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_4_3_english;

				if ( $location_4_elevation_4 && !$location_4_name_4 ) {

					echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_4 ) . ': </strong>' . $snow_depth_4_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_4_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_4_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_4_4_english;

					if ( $location_4_elevation_5 && !$location_4_name_5 ) {

						echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_4_elevation_5 ) . ': </strong>' . $snow_depth_4_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_4_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_4_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_4_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_4 . '</li>';

	}

	if ( $location_5_name_1 && $location_5_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_5 . '( ' . number_format( $location_5_elevation_1 ) . ' ): </strong>' . $snow_depth_5_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_5_1_english;

		if ( $location_5_name_2 && $location_5_elevation_2 ) {

			echo ' | ' . $snow_depth_5_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_5_2_english;

			if ( $location_5_name_3 && $location_5_elevation_3 ) {

				echo ' | ' . $snow_depth_5_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_5_3_english;

				if ( $location_5_name_4 && $location_5_elevation_4 ) {

					echo ' | ' . $snow_depth_5_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_5_4_english;

					if ( $location_5_name_5 && $location_5_elevation_5 ) {

						echo ' | ' . $snow_depth_5_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_5_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_5 . '</li>';

	}

	if ( $location_5_name_1 && !$location_5_elevation_1 ) {

		echo '<li class="snow-depth"><strong>' . $location_5 . ': </strong>' . $snow_depth_1_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_5_1_english;

		if ( $location_5_name_2 && !$location_5_elevation_2 ) {

			echo '<strong> || </strong>' . $snow_depth_5_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_5_2_english;

			if ( $location_5_name_3 && !$location_5_elevation_3 ) {

				echo '<strong> || </strong>' . $snow_depth_5_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_5_3_english;

				if ( $location_5_name_4 && !$location_5_elevation_4 ) {

					echo '<strong> || </strong>' . $snow_depth_5_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_5_4_english;

					if ( $location_5_name_5 && !$location_5_elevation_5 ) {

						echo '<strong> || </strong>' . $snow_depth_5_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_5_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_5 . '</li>';

	}

	if ( $location_5_elevation_1 && !$location_5_name_1 ) {

		echo '<li class="snow-depth"><strong>' . number_format( $location_5_elevation_1 ) . ': </strong>' . $snow_depth_5_1 . '  ' . $snow_depth_measure;

		if ( $snow_depth_measure == 'cm' ) {
			echo ' (' . round( $snow_depth_5_1 * 0.3937 ) . '")';
		} elseif ( $snow_depth_measure == '"' ) {
			echo ' (' . round( $snow_depth_5_1 / 0.39370 ) . 'cm)';
		}

		echo ' ' . $snow_type_5_1_english;

		if ( $location_5_elevation_2 && !$location_5_name_2 ) {

			echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_2 ) . ': </strong>' . $snow_depth_5_2 . '  ' . $snow_depth_measure;

			if ( $snow_depth_measure == 'cm' ) {
				echo ' (' . round( $snow_depth_5_2 * 0.3937 ) . '")';
			} elseif ( $snow_depth_measure == '"' ) {
				echo ' (' . round( $snow_depth_5_2 / 0.39370 ) . 'cm)';
			}

			echo ' ' . $snow_type_5_2_english;

			if ( $location_5_elevation_3 && !$location_5_name_3 ) {

				echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_3 ) . ': </strong>' . $snow_depth_5_3 . '  ' . $snow_depth_measure;

				if ( $snow_depth_measure == 'cm' ) {
					echo ' (' . round( $snow_depth_5_3 * 0.3937 ) . '")';
				} elseif ( $snow_depth_measure == '"' ) {
					echo ' (' . round( $snow_depth_5_3 / 0.39370 ) . 'cm)';
				}

				echo ' ' . $snow_type_5_3_english;

				if ( $location_5_elevation_4 && !$location_5_name_4 ) {

					echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_4 ) . ': </strong>' . $snow_depth_5_4 . '  ' . $snow_depth_measure;

					if ( $snow_depth_measure == 'cm' ) {
						echo ' (' . round( $snow_depth_5_4 * 0.3937 ) . '")';
					} elseif ( $snow_depth_measure == '"' ) {
						echo ' (' . round( $snow_depth_5_4 / 0.39370 ) . 'cm)';
					}

					echo ' ' . $snow_type_5_4_english;

					if ( $location_5_elevation_5 && !$location_5_name_5 ) {

						echo '<li class="snow-depth"><strong>Snow Depth ' . number_format( $location_5_elevation_5 ) . ': </strong>' . $snow_depth_5_5 . '  ' . $snow_depth_measure;

						if ( $snow_depth_measure == 'cm' ) {
							echo ' (' . round( $snow_depth_5_5 * 0.3937 ) . '")';
						} elseif ( $snow_depth_measure == '"' ) {
							echo ' (' . round( $snow_depth_5_5 / 0.39370 ) . 'cm)';
						}

						echo ' ' . $snow_type_5_5_english;

					}

				}

			}

		}

		echo ' ' . $snow_type_5 . '</li>';

	}

}