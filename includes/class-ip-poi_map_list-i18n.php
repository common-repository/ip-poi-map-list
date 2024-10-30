<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.instant-programming.com
 * @since      1.0.0
 *
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/includes
 * @author     Instant - Programming <alban@instant-programming.com>
 */
class Ip_Poi_map_list_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ip-poi_map_list',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
