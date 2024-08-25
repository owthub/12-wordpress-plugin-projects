<?php 

/**
 * Plugin Name: My Custom Metabox
 * Description: This will be the metabox for WordPress Pages
 * Version: 1.0
 * Author: Sanjay Kumar
 */

if(!defined("ABSPATH")){
    exit;
}

// Register Pages Metabox
add_action("add_meta_boxes", "mmp_register_page_metabox");

function mmp_register_page_metabox(){

    add_meta_box("mmp_metabox_id", "My Custom Metabox - SEO", "mmp_create_page_metabox", "page");
}

// Create layout for Page metabox
function mmp_create_page_metabox($post){
    
    // Include Template File
    ob_start();

    include_once plugin_dir_path(__FILE__) . "template/page_metabox.php";

    $template = ob_get_contents();

    ob_end_clean();

    echo $template;
}

// Save Data of Custom Metabox
add_action("save_post", "mmp_save_page_metabox_data");

function mmp_save_page_metabox_data($post_id){

    // Check and Verify Nonce Value
    if(!wp_verify_nonce($_POST['mmp_save_pmetabox_nonce'], "mmp_save_page_metabox_data")){
        return;
    }

    // Check and Verify Auto save of Wordpress
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){
        return;
    }

    if(isset($_POST['pmeta_title'])){
        update_post_meta($post_id, "pmeta_title", $_POST['pmeta_title']);
    }

    if(isset($_POST['pmeta_description'])){
        update_post_meta($post_id, "pmeta_description", $_POST['pmeta_description']);
    }
}

// Add Meta tags in Head Tag
add_action("wp_head", "mmp_add_head_meta_tags");

function mmp_add_head_meta_tags(){

    if(is_page()){

        global $post;

        $post_id = $post->ID;

        $title = get_post_meta($post_id, "pmeta_title", true);
        $description = get_post_meta($post_id, "pmeta_description", true);

        if(!empty($title)){
            echo '<meta name="title" content="'.$title.'"/>';
        }

        if(!empty($description)){
            echo '<meta name="description" content="'.$description.'"/>';
        }
    }
}