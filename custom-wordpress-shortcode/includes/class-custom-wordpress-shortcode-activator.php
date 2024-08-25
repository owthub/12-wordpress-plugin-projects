<?php

/**
 * Fired during plugin activation
 *
 * @link       https://onlinewebtutorblog.com
 * @since      1.0.0
 *
 * @package    Custom_Wordpress_Shortcode
 * @subpackage Custom_Wordpress_Shortcode/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Custom_Wordpress_Shortcode
 * @subpackage Custom_Wordpress_Shortcode/includes
 * @author     Sanjay Kumar <sanjay.example@gmail.com>
 */
class Custom_Wordpress_Shortcode_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

		global $wpdb;

		$table_name = $wpdb->prefix . "books";
		$collate = $wpdb->get_charset_collate();

		$createTableCode = '
			CREATE TABLE `'.$table_name.'` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`book_name` varchar(50) DEFAULT NULL,
			`book_author` varchar(50) DEFAULT NULL,
			`book_price` varchar(10) DEFAULT NULL,
			PRIMARY KEY (`id`)
			) '.$collate.'
		';

		include_once ABSPATH . "wp-admin/includes/upgrade.php";

		dbDelta($createTableCode);
	}

}
