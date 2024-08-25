<?php 
/**
 * Plugin Name: My Custom Widget
 * Description: This widget will provide options to display a static message as well as recent posts over website
 * Version: 1.0
 * Author: Sanjay Kumar
 * Author URI: https://onlinewebtutorblog.com
 * Plugin URI: https://example.com/my-custom-widget
 */

 if(!defined("ABSPATH")){
    exit;
 }

 add_action("widgets_init", "mcw_register_widget");

 include_once plugin_dir_path(__FILE__) . "/My_Custom_Widget.php";

 function mcw_register_widget(){

    register_widget("My_Custom_Widget");
 }

 // Add admin panel script

 add_action("admin_enqueue_scripts", "mcw_add_admin_script");

 function mcw_add_admin_script(){

    // CSS
    wp_enqueue_style("mcw_style", plugin_dir_url(__FILE__) . "style.css");
    // JS
    wp_enqueue_script("admin-script", plugin_dir_url(__FILE__)."/script.js", array("jquery"));
 }