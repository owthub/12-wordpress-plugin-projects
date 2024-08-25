<?php 

/**
 * Plugin Name: WP Employees CRUD
 * Description: This plugin performs CRUD Operations with Employees Table. Also on Activation it will create a dynamic wordpress page and it will have a shortcode.
 * Version: 1.0
 * Author: Sanjay Kumar
 */

 if(!defined("ABSPATH")){
    exit;
 }

 define("WCE_DIR_PATH", plugin_dir_path(__FILE__)); 
 define("WCE_DIR_URL", plugin_dir_url(__FILE__));

 include_once WCE_DIR_PATH . "MyEmployees.php";

 // Create Class Object
 $employeeObject = new MyEmployees;

 // Create DB Table
 register_activation_hook(__FILE__, [$employeeObject, "callPluginActivationFunctions"]);

 // Drop DB Table
 register_deactivation_hook(__FILE__, [$employeeObject, "dropEmployeesTable"]);

 // Register Shortcode
 add_shortcode("wp-employee-form", [$employeeObject, "createEmployeesForm"]);
 
 add_action("wp_enqueue_scripts", [$employeeObject, "addAssetsToPlugin"]);

 // Process Ajax Request (User is logged in)
 add_action("wp_ajax_wce_add_employee", [$employeeObject, "handleAddEmployeeFormData"]);
 add_action("wp_ajax_wce_load_employees_data", [$employeeObject, "handleLoadEmployeesData"]);
 add_action("wp_ajax_wce_delete_employee", [$employeeObject, "handleDeleteEmployeeData"]);
 add_action("wp_ajax_wce_get_employee_data", [$employeeObject, "handleToGetSingleEmployeeData"]);
 add_action("wp_ajax_wce_edit_employee", [$employeeObject, "handleUpdateEmployeeData"]);

 // User is logged out  (No login of WordPress)
//  add_action("wp_ajax_nopriv_wce_add_employee", [$employeeObject, "handleAddEmployeeFormData"]);
//  add_action("wp_ajax_nopriv_wce_load_employees_data", [$employeeObject, "handleLoadEmployeesData"]);
//  add_action("wp_ajax_nopriv_wce_delete_employee", [$employeeObject, "handleDeleteEmployeeData"]);
//  add_action("wp_ajax_nopriv_wce_et_employee_data", [$employeeObject, "handleToGetSingleEmployeeData"]);