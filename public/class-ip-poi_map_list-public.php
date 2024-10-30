<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.instant-programming.com
 * @since      1.0.0
 *
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/public
 * @author     Instant - Programming <alban@instant-programming.com>
 */
class Ip_Poi_map_list_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ip_Poi_map_list_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ip_Poi_map_list_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ip-poi_map_list-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'display_component_style', plugin_dir_url( __FILE__ ) . 'css/display_component_style.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ip_Poi_map_list_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ip_Poi_map_list_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ip-poi_map_list-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_style( 'display_component_style', plugin_dir_url( __FILE__ ) . 'css/display_component_style.css', array(), $this->version, 'all' );
    }

}
