<?php 

/**
 * Plugin Name: ShortCode Plugin
 * Description: This is second plugin of this course which gives idea about shorcode basics
 * Version: 1.0
 * Author: Sanjay Kumar
 * Plugin URI: https://example.com/shortcode-plugin
 * Author URI: https://onlinewebtutorblog.com
 */

// Basic Shortcode

 add_shortcode("message", "sp_show_static_message"); // [message]

 function sp_show_static_message(){

    return "<p style='color:red;font-size:36px;font-weight:bold;'>Hello I am a simple shortcode message</p>";
 }

 // Shortcode with Parameters

 //[student name="Sanjay" email="Sanjay"]

 add_shortcode("student", "sp_handle_student_data");

 function sp_handle_student_data($attributes){

    $attributes = shortcode_atts(array(
        "name" => "Default Student",
        "email" => "Default Email"
    ), $attributes, "student");

    return "<h3 style='color:blue;'>Student Data: Name - ".$attributes['name'].", Email - ".$attributes['email']."</h3>";
 }

 // Shortcode with DB Operation
 add_shortcode("list-posts", "sp_handle_list_posts_wp_query_class");

 function sp_handle_list_posts(){

    global $wpdb;

    $table_prefix = $wpdb->prefix; // wp_
    $table_name = $table_prefix . "posts"; // wp_posts

    // Get post whose post_type = post and post_status = publish

    $posts = $wpdb->get_results(
        "SELECT post_title from {$table_name} WHERE post_type = 'post' AND post_status = 'publish'"
    );

    if(count($posts) > 0){

        $outputHtml = "<ul>";

        foreach($posts as $post){
            $outputHtml .= '<li>'.$post->post_title.'</li>';
        }

        $outputHtml .= "</ul>";

        return $outputHtml;
    }

    return 'No Post Found';
 }

 // [list-posts number="10"]

 function sp_handle_list_posts_wp_query_class($attributes){

    $attributes = shortcode_atts(array(
        "number" => 5
    ), $attributes, "list-posts");

    $query = new WP_Query(array(
        "posts_per_page" => $attributes['number'],
        "post_status" => "publish"
    ));

    if($query->have_posts()){

        $outputHtml = '<ul>';
        while($query->have_posts()){
            $query->the_post();
            $outputHtml .= '<li class="my_class"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>'; // Hello World
        }
        $outputHtml .= '</ul>';

        return $outputHtml;
    }

    return "No Post Found";
 }