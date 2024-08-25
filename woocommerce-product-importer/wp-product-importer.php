<?php 

/**
 * Plugin Name: WooCommerce Product Importer
 * Description: This plugin will help to import products from CSV File
 * Version: 1.0
 * Author: Sanjay Kumar
 */

if(!defined("WPINC")){
    exit;
}

if(!in_array("woocommerce/woocommerce.php", apply_filters("active_plugins", get_option("active_plugins")))){
    add_action("admin_notices", function(){
        echo '<div class="notice notice-error"> <p>Please Install and Active WooCommerce Plugin.</p> </div>';
    }); 
}

// Add Plugin Menu
add_action("admin_menu", "wpi_add_menu");

function wpi_add_menu(){

    add_menu_page("WooCommerce Product Importer", "WooCommerce Product Importer", "manage_options", "wpi-woocommerce-product-importer", "wpi_product_importer_page", "dashicons-database-export", 8);
}

function wpi_product_importer_page(){

    ob_start();

    include_once plugin_dir_path(__FILE__) . "template/import_layout.php";

    $template = ob_get_contents();

    ob_end_clean();

    echo $template;
}

add_action("admin_init", "wpi_handle_form_upload");

function wpi_handle_form_upload(){

    if(isset($_POST['btn_import_csv_products'])){

        // Nonce value
        if(!wp_verify_nonce($_POST['wpi_nonce_value'], "wpi_handle_form_upload")){
            return;
        }

        if(isset($_FILES['product_csv']['name']) && !empty($_FILES['product_csv']['name'])){

            $csvFile = $_FILES['product_csv']['tmp_name'];
            $handle = fopen($csvFile, "r");

            $row = 0; // Headers

            while( ($data = fgetcsv($handle, 1000, ",")) !== FALSE ){

                if($row == 0){

                    $row++;
                    continue;
                }

                $productObject = new WC_Product_Simple();

                // Set Product Attributes
                $productObject->set_name($data[0]);
                $productObject->set_regular_price($data[1]);
                $productObject->set_sale_price($data[2]);
                $productObject->set_description($data[3]);
                $productObject->set_short_description($data[4]);
                $productObject->set_sku($data[5]);
                $productObject->set_status("publish");
                $productObject->save();
            }

            add_action("admin_notices", function(){
                echo '<div class="notice notice-success"> <p> Successfully, Products from CSV uploaded. </p> </div>'; 
            });
        }else{

            add_action("admin_notices", function(){
                echo '<div class="notice notice-error"> <p> Please upload a Product CSV File </p> </div>';
            });
        }
    }
}