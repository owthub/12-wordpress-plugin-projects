<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://onlinewebtutorblog.com
 * @since      1.0.0
 *
 * @package    Custom_Wordpress_Shortcode
 * @subpackage Custom_Wordpress_Shortcode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Wordpress_Shortcode
 * @subpackage Custom_Wordpress_Shortcode/admin
 * @author     Sanjay Kumar <sanjay.example@gmail.com>
 */
class Custom_Wordpress_Shortcode_Admin {

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
		 * defined in Custom_Wordpress_Shortcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Wordpress_Shortcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-wordpress-shortcode-admin.css', array(), $this->version, 'all' );

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
		 * defined in Custom_Wordpress_Shortcode_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Wordpress_Shortcode_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-wordpress-shortcode-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Display Admin Notices
	public function cws_display_admin_notices(){

		echo '<div class="notice notice-success"> <p> This is our first message </p> </div>';
	}

	// Register Menu
	public function cws_add_admin_menu_page(){

		add_menu_page("CWS Custom Menu", "CWS Custom Menu", "manage_options", "cws-custom-menu",[ $this, "cws_handle_menu_event" ], "", 8);
	}

	public function cws_handle_menu_event(){

		echo "<h3>This is plugin menu static message.</h3>";
	}
}
