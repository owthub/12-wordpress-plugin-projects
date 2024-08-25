<?php

/**
 * Plugin Name: WP Login Page Customizer
 * Description: This Plugin will customizer Logo, Text Color, and Background Color
 * Author: Sanjay Kumar
 * Plugin URI: https://example.com/wp-login-page-customizer
 * Author URI: https://onlinewebtutorblog.com
 * Version: 1.0
 */

 if(!defined("ABSPATH")){
    exit;
 }

 add_action("admin_menu", "wlc_add_submenu");

 function wlc_add_submenu(){

    add_submenu_page("options-general.php", "WP Login Page Customizer", "WP Login Page Customizer", "manage_options", "wp-login-page-customizer", "wlc_handle_login_settings_layout");
 }

 // Create Login Page Customizer Layout
 function wlc_handle_login_settings_layout(){
    ob_start();
    include_once plugin_dir_path(__FILE__) . "template/login_settings_layout.php";
    $content = ob_get_contents();
    ob_end_clean();
    echo $content;
 }

 // Register Settings for Login Page
 add_action("admin_init", "wlc_login_page_settings_field_registration");

 function wlc_login_page_settings_field_registration(){

    register_setting("wlc_login_page_settings_field_group", "wlc_login_page_text_color");

    register_setting("wlc_login_page_settings_field_group", "wlc_login_page_background_color");

    register_setting("wlc_login_page_settings_field_group", "wlc_login_page_logo");

    // Create a Section here and Add Settings Fields
    add_settings_section("wlc_login_page_section_id", "Login Page Customizer Settings", null, "wp-login-page-customizer");

    // Text Color
    add_settings_field("wlc_login_page_text_color", "Page Text Color", "wlc_login_page_text_color_input", "wp-login-page-customizer", "wlc_login_page_section_id");

    // Background Color
    add_settings_field("wlc_login_page_background_color", "Page Background Color", "wlc_login_page_background_color_input", "wp-login-page-customizer", "wlc_login_page_section_id");

    // Logo
    add_settings_field("wlc_login_page_logo", "Login Page Logo", "wlc_login_page_logo_input", "wp-login-page-customizer", "wlc_login_page_section_id");
 }

 // Text Color Settings
 function wlc_login_page_text_color_input(){
    $text_color = get_option("wlc_login_page_text_color", "");
    ?>
    <input type="text" value="<?php echo $text_color; ?>" name="wlc_login_page_text_color" placeholder="Text Color">
    <?php
 }

 // Background Color Settings
 function wlc_login_page_background_color_input(){
    $bg_color = get_option("wlc_login_page_background_color", "");
    ?>
    <input type="text" value="<?php echo $bg_color; ?>" name="wlc_login_page_background_color" placeholder="Background Color">
    <?php
 }

 // Page Logo
 function wlc_login_page_logo_input(){
    $page_logo = get_option("wlc_login_page_logo", "");
    ?>
    <input type="text" value="<?php echo $page_logo; ?>" name="wlc_login_page_logo" placeholder="Enter Logo URL">
    <?php
 }

 // Render Custom Login Page Settings to Login Screen
 add_action("login_enqueue_scripts", "wlc_login_page_customizer_settings");

 function wlc_login_page_customizer_settings(){

    $text_color = get_option("wlc_login_page_text_color", "");
    $bg_color = get_option("wlc_login_page_background_color", "");
    $page_logo = get_option("wlc_login_page_logo", "");

    ?>
    <style>
        <?php 
        if(!empty($text_color)){
            ?>
            div#login,
            a.wp-login-lost-password,
            p#backtoblog a{
                color: <?php echo $text_color; ?> !important;
            }
            <?php
        }
        ?>
        <?php
        if(!empty($bg_color)){
            ?>
            body.login{
                 background: <?php echo $bg_color; ?> !important;
            }
            <?php
        }
        ?>

        <?php 
        if(!empty($page_logo)){
            ?>
            #login a{
                background-image: url(<?php echo $page_logo; ?>) !important;
            }
            <?php
        }
        ?>
    </style>
    <?php
 }