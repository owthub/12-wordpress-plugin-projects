<?php

/**
 * Plugin Name: Hello World
 * Description: This is our first plugin which creates some information widget to admin dashboard as well as at admin notice
 * Author: Sanjay Kumar
 * Version: 1.0
 * Author URI: https://onlinewebtutorblog.com
 * Plugin URI: https://example.com/hello-world
 */

// Admin Notices

add_action("admin_notices", "hw_show_warning_message");

function hw_show_success_message(){

    echo '<div class="notice notice-success is-dismissible"><p>Hello, I am a success message</p></div>';
}

function hw_show_error_message(){

    echo '<div class="notice notice-error is-dismissible"><p>Hello, I am an error message</p></div>';
}

function hw_show_information_message(){

    echo '<div class="notice notice-info is-dismissible"><p>Hello, I am an informational message</p></div>';
}

function hw_show_warning_message(){

    echo '<div class="notice notice-warning is-dismissible"><p>Hello, I am warning message</p></div>';
}

// Admin Dashboard Widget

add_action("wp_dashboard_setup", "hw_hellow_world_dashboard_widget");

function hw_hellow_world_dashboard_widget(){

    wp_add_dashboard_widget("hw_hellow_world", "HW - Hello World Widget", "hw_custom_admin_widget");
}

function hw_custom_admin_widget(){
    echo "This is Hello World Custom Admin Widget";
}