<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.instant-programming.com
 * @since             1.0.0
 * @package           Ip_Poi_map_list
 *
 * @wordpress-plugin
 * Plugin Name:       IP-POI Map List
 * Plugin URI:        www.instant-programming.com/poi-map-list
 * Description:       Create and customize your own Point of interest list item with a google map support
 * Version:           1.1.4
 * Author:            Instant - Programming
 * Author URI:        www.instant-programming.com
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


register_activation_hook(__FILE__, array( 'IP_poi_map_loader', 'start_activation' ));


class IP_poi_map_loader {
    function start_activation() {
        self::ip_poi_map_list_table(); // or self::func1();
        self::ip_poi_map_list_settings_table(); //    self::func2(); for static methods
    }
    function ip_poi_map_list_table(){
        global $wpdb;
        $db_table_name = $wpdb->prefix . 'ip_poi_map_list';  // table name
        $charset_collate = $wpdb->get_charset_collate();
        if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) {
            $sql = "CREATE TABLE `wp_ip_poi_map_list` (
					 `id` int(10) NOT NULL AUTO_INCREMENT,
					 `title` varchar(150) DEFAULT NULL,
					 `description` varchar(250) DEFAULT NULL,
					 `itemPicture` varchar(250) DEFAULT NULL,
					 `phone` varchar(255) DEFAULT NULL,
					 `email` varchar(255) DEFAULT NULL,
					 `url` varchar(255) DEFAULT NULL,
					 `streetNumber` varchar(255) DEFAULT NULL,
					 `address` varchar(255) DEFAULT NULL,
					 `city` varchar(255) DEFAULT NULL,
					 `zipCode` varchar(250) DEFAULT NULL,
					 `country` varchar(255) DEFAULT NULL,
					 `latitude` varchar(255) DEFAULT NULL,
					 `longitude` varchar(255) DEFAULT NULL,
					 `created` timestamp NOT NULL DEFAULT current_timestamp(),
					 PRIMARY KEY (`id`)
					) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            add_option('test_db_version', $test_db_version);
        }
    }
    function ip_poi_map_list_settings_table(){
        global $wpdb;
        $db_table_name = $wpdb->prefix . 'wp_ip_poi_map_settings';  // table name
        $charset_collate = $wpdb->get_charset_collate();
        if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) {
            $sql = "CREATE TABLE `wp_ip_poi_map_settings` (
                             `id` bigint(20) unsigned NOT NULL DEFAULT 1,
                             `api_key` varchar(255) DEFAULT NULL,
                             `map_height` varchar(255) DEFAULT NULL,
                             `theme_color` varchar(255) DEFAULT NULL,
                             `default_picture` varchar(255) DEFAULT NULL,
                             `map_type` varchar(255) DEFAULT 'map',
                             PRIMARY KEY (`id`)
                            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            add_option('test_db_version', $test_db_version);
        }
        $wpdb->insert('wp_ip_poi_map_settings',
            array(
                "api_key" =>'',
                "map_height"=>'',
                "theme_color" =>'',
                "default_picture" =>'',
                "map_type" =>'map',
            )
        );
    }
}




/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IP_POI_MAP_LIST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ip-poi_map_list-activator.php
 */
function activate_ip_poi_map_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ip-poi_map_list-activator.php';
	Ip_Poi_map_list_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ip-poi_map_list-deactivator.php
 */
function deactivate_ip_poi_map_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ip-poi_map_list-deactivator.php';
	Ip_Poi_map_list_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ip_poi_map_list' );
register_deactivation_hook( __FILE__, 'deactivate_ip_poi_map_list' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ip-poi_map_list.php';

require plugin_dir_path( __FILE__ ) . 'views/displayComponent.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ip_poi_map_list() {

	$plugin = new Ip_Poi_map_list();
	$plugin->run();

}
run_ip_poi_map_list();
