<?php

/**
 * Plugin Name: CSV Data Backup
 * Description: It will export Table Data into .csv file
 * Version: 1.0
 * Author: Sanjay Kumar
 * Plugin URI: https://example.com
 * Author URI: https://onlinewebtutorblog.com
 */

add_action("admin_menu", "tdcb_create_admin_menu");

// Admin Menu
function tdcb_create_admin_menu(){
    
    add_menu_page("CSV Data Backup Plugin", "CSV Data Backup", "manage_options", "csv-data-backup", "tdcb_export_form", "dashicons-database-export", 8);
}

// Form Layout
function tdcb_export_form(){

    ob_start();

    include_once plugin_dir_path(__FILE__) . "/template/table_data_backup.php";

    $layout = ob_get_contents();

    ob_end_clean();

    echo $layout;
}

add_action("admin_init", "tdcb_handle_form_export");

function tdcb_handle_form_export(){

    if(isset($_POST['tdcb_export_button'])){

        global $wpdb;

        $table_name = $wpdb->prefix . "students_data";

        $students = $wpdb->get_results(
            "SELECT * FROM {$table_name}", ARRAY_A
        );

        if(empty($students)){

            // Error message
        }

        $filename = "students_data_".time().".csv";

        header("Content-Type: text/csv; charset=utf-8;");
        header("Content-Disposition: attachment; filename=".$filename);

        $output = fopen("php://output", "w");

        fputcsv($output, array_keys($students[0]));

        foreach($students as $student){

            fputcsv($output, $student);
        }

        fclose($output);

        exit;
    }
}