<?php 

/**
 * Plugin Name: WP API for CRUD
 * Description: This plugin enables APIs endpoints to perform CRUD operation with Database
 * Version: 1.0
 * Author: Sanjay
 * Plugin URI: https://example.com/wp-api-crud
 */

if(!defined("WPINC")){
    exit;
}

register_activation_hook(__FILE__, "wcp_create_students_table");

function wcp_create_students_table(){

    global $wpdb;
    $table_name = $wpdb->prefix . "students_table";
    $collate = $wpdb->get_charset_collate();

    $students_table = "
        CREATE TABLE `".$table_name."` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        `email` varchar(50) NOT NULL,
        `phone` varchar(25) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ".$collate."
    ";

    include_once ABSPATH . "wp-admin/includes/upgrade.php";

    dbDelta($students_table);
}

// Action hook for APIs registration
add_action("rest_api_init", function(){

    // Registration of API Routes

    // List Students (GET)
    register_rest_route("students/v1", "students", array(
        "methods" => "GET",
        "callback" => "wcp_handle_get_students_routes"
    ));

    // Add Student (POST)
    register_rest_route("students/v1", "student", array(
        "methods" => "POST",
        "callback" => "wcp_handle_post_student",
        "args" => array(
            "name" => array( 
                "type" => "string",
                "required" => true
             ),
            "email" => array( 
                "type" => "string", 
                "required" => true
             ),
            "phone" => array( 
                "type" => "string",
                "required" => false
             )
         )
    ));

    // Update Student (PUT)
    register_rest_route("students/v1", "student/(?P<id>\d+)", array( 
        "methods" => "PUT",
        "callback" => "wcp_handle_put_update_student",
        "args" => array( 
            "name" => array( 
                "type" => "string",
                "required" => true
             ),
            "email" => array( 
                "type" => "string",
                "required" => true
             ),
            "phone" => array( 
                "type" => "string",
                "required" => false
             )
         )
    ));

    // Delete Student (DELETE)
    register_rest_route("students/v1", "student/(?P<id>\d+)", array( 
        "methods" => "DELETE",
        "callback" => "wcp_handle_delete_student"
     ));
});

// List all Students
function wcp_handle_get_students_routes(){

    global $wpdb;
    $table_name = $wpdb->prefix . "students_table";

    $students = $wpdb->get_results(
        "SELECT * FROM {$table_name}", ARRAY_A
    );

    return rest_ensure_response([
        "status" => true,
        "message" => "Students List",
        "data" => $students
    ]);
}

// Add Student
function wcp_handle_post_student($request){

    global $wpdb;
    $table_name = $wpdb->prefix . "students_table";

    $name = $request->get_param("name");
    $email = $request->get_param("email");
    $phone = $request->get_param("phone");

    $wpdb->insert($table_name, array(
        "name"=> $name,
        "email" => $email,
        "phone" => $phone
    ));

    if($wpdb->insert_id > 0){

        return rest_ensure_response([
            "status" => true,
            "message" => "student Created Successfully",
            "data" => $request->get_params()
        ]);
    }else{

        return rest_ensure_response([
            "status" => false,
            "message" => "Failed to create student",
            "data" => $request->get_params()
        ]);
    }
}

// Update Student
function wcp_handle_put_update_student($request){

    global $wpdb;
    $table_name = $wpdb->prefix . "students_table";

    $id = $request['id'];

    $student = $wpdb->get_row(
        "SELECT * FROM {$table_name} WHERE id = {$id}"
    );

    if(!empty($student)){

        $wpdb->update($table_name, [
            "name" => $request->get_param("name"),
            "email" => $request->get_param("email")
        ], [
            "id" => $id
        ]);
    
        return rest_ensure_response([
            "status" => true,
            "message" => "Student data updated successfully"
        ]);
    }else{

        return rest_ensure_response([
            "status" => false,
            "message" => "Student doesn't exists"
        ]);
    }
}

// Delete Student
function wcp_handle_delete_student($request){

    global $wpdb;
    $table_name = $wpdb->prefix . "students_table";

    $id = $request['id'];

    $student = $wpdb->get_row( "SELECT * FROM {$table_name} WHERE id = {$id}" );

    if(!empty($student)){

        $wpdb->delete($table_name, [
            "id" => $id
        ]);

        return rest_ensure_response([
            "status" => true, 
            "message" => "Student deleted successfully"
        ]);
    }else{

        return rest_ensure_response([
            "status" => false,
            "message" => "Student doesn't exists"
        ]);
    }
}