<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://onlinewebtutorblog.com
 * @since      1.0.0
 *
 * @package    Custom_Wordpress_Shortcode
 * @subpackage Custom_Wordpress_Shortcode/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Wordpress_Shortcode
 * @subpackage Custom_Wordpress_Shortcode/includes
 * @author     Sanjay Kumar <sanjay.example@gmail.com>
 */
class Custom_Wordpress_Shortcode_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-wordpress-shortcode',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
