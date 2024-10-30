<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.instant-programming.com
 * @since      1.0.0
 *
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/admin
 * @author     Instant - Programming <alban@instant-programming.com>
 */
class Ip_Poi_map_list_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ip-poi_map_list-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'new_editStyle', plugin_dir_url( __FILE__ ) . 'css/new_editStyle.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'settings_style', plugin_dir_url( __FILE__ ) . 'css/settings_style.css', array(), $this->version, 'all' );
    }

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ip-poi_map_list-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     *
     * admin/class-wp-cbf-admin.php - Don't add this
     *
     **/

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_menu_page( 'POI map list', 'POI map list', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), 'dashicons-location');

    }

    public function add_plugin_admin_submenu(){
        add_submenu_page( $this->plugin_name, 'Add Item', 'Add Item', 'manage_options', 'new_poi_item', array($this, 'display_createItem'));
        add_submenu_page( $this->plugin_name, 'Settings POI map list', 'Settings', 'manage_options', 'Settings_poi_map_list', array($this, 'display_settings'));
        add_submenu_page( $this->plugin_name, 'Support', 'Support', 'manage_options', 'display_about_us', array($this, 'display_about_us'));

    }
        /**
     * @return string
     */
    function display_createItem()
    {
        require_once plugin_dir_path(__FILE__) . '../views/new_POI_item.php';

    }


    function display_settings()
    {
        require_once plugin_dir_path(__FILE__) . '../views/plugin_settings.php';

    }

    function display_about_us()
    {
        require_once plugin_dir_path(__FILE__) . '../views/about_us.php';

    }
    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */


    public function add_action_links( $links ) {
        /*
   *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
   */
        $settings_link = array(
            '<a href="' . admin_url( 'admin.php?page=Settings_poi_map_list') . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {

        ob_start();
        $action = sanitize_text_field(isset($_GET['action'])? trim($_GET['action']) : "");
        if ($action=="poi-edit"){
            include_once  plugin_dir_path(__FILE__) . '../views/edit_POI_item.php';
        }
        else{
            if ($action=="poi-delete"){
                $id = esc_attr( apply_filters( 'get_search_query', isset($_GET['id']) ? intval($_GET['id']) : "") );

                global $wpdb;

                $wpdb->get_results(
                    "DELETE FROM wp_ip_poi_map_list WHERE id like '%$id%'"
                );
                include_once( 'partials/ip-poi_map_list-admin-display.php' );

            }
            else{
                include_once( 'partials/ip-poi_map_list-admin-display.php' );
            }
        }

    }


    /**
     *
     * admin/class-wp-cbf-admin.php
     *
     **/
    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    /**
     *
     * admin/class-wp-cbf-admin.php
     *
     **/
    public function validate($input) {
        // All checkboxes inputs
        $valid = array();

        //Cleanup
        $valid['cleanup'] = (isset($input['cleanup']) && !empty($input['cleanup'])) ? 1 : 0;
        $valid['comments_css_cleanup'] = (isset($input['comments_css_cleanup']) && !empty($input['comments_css_cleanup'])) ? 1: 0;
        $valid['gallery_css_cleanup'] = (isset($input['gallery_css_cleanup']) && !empty($input['gallery_css_cleanup'])) ? 1 : 0;
        $valid['body_class_slug'] = (isset($input['body_class_slug']) && !empty($input['body_class_slug'])) ? 1 : 0;
        $valid['jquery_cdn'] = (isset($input['jquery_cdn']) && !empty($input['jquery_cdn'])) ? 1 : 0;
        $valid['cdn_provider'] = ($input['cdn_provider']);

        return $valid;
    }

}
