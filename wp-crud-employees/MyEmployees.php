<?php 

class MyEmployees{

    private $wpdb;
    private $table_name;
    private $table_prefix;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_prefix = $this->wpdb->prefix; // wp_
        $this->table_name = $this->table_prefix . "employees_table"; // wp_employees_table
    }

    // Create DB Table + WordPress Page
    public function callPluginActivationFunctions(){

        $collate = $this->wpdb->get_charset_collate();

        $createCommand = "
            CREATE TABLE `".$this->table_name."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `email` varchar(50) DEFAULT NULL,
            `designation` varchar(50) DEFAULT NULL,
            `profile_image` varchar(220) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ".$collate."
        ";

        require_once (ABSPATH. "/wp-admin/includes/upgrade.php");

        dbDelta($createCommand);

        // Wp Page
        $page_title = "Employee CRUD System";
        $page_content = "[wp-employee-form]";

        if(!get_page_by_title($page_title)){
            wp_insert_post(array(
                "post_title" => $page_title,
                "post_content" => $page_content,
                "post_type" => "page",
                "post_status" => "publish"
            ));
        }
    }

    // Drop Table
    public function dropEmployeesTable(){

        $delete_command = "DROP TABLE IF EXISTS {$this->table_name}";

        $this->wpdb->query($delete_command);
    }

    // Render Employee Form Layout
    public function createEmployeesForm(){

        ob_start();

        include_once WCE_DIR_PATH . "template/employee_form.php";

        $template = ob_get_contents();

        ob_end_clean();

        return $template;
    }

    // Add CSS / JS
    public function addAssetsToPlugin(){

        // Style
        wp_enqueue_style("employee-crud-css", WCE_DIR_URL . "assets/style.css");

        // Validation
        wp_enqueue_script("wce-validation", WCE_DIR_URL . "assets/jquery.validate.min.js", array("jquery"));

        // JS
        wp_enqueue_script("employee-crud-js", WCE_DIR_URL . "assets/script.js", array("jquery"), "3.0");

        wp_localize_script("employee-crud-js", "wce_object", array(
            "ajax_url" => admin_url("admin-ajax.php")
        ));
    }

    // Process Ajax Request: Add Employee Form
    public function handleAddEmployeeFormData(){

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $designation = sanitize_text_field($_POST['designation']);

        $profile_url = "";

        /**
         * 
         * array("test_form" => false) -> wp_handle_upload is not going to check any file attributes or even file submission
         * 
         * array("test_form" => true) -> wp_handle_upload will validate form request, nonce value and other form parameters
         */

        // Check for File
        if(isset($_FILES['profile_image']['name'])){

            $UploadFile = $_FILES['profile_image'];

            // $UploadFile['name'] - employee-1.webp

            // Original File Name
            $originalFileName = pathinfo($UploadFile['name'], PATHINFO_FILENAME); // employee-1

            // File Extension
            $file_extension = pathinfo($UploadFile['name'], PATHINFO_EXTENSION); // webp

            // New Image Name
            $newImageName = $originalFileName."_".time().".".$file_extension; // employee-1_89465133.webp

            $_FILES['profile_image']['name'] = $newImageName;
            
            $fileUploaded = wp_handle_upload($_FILES['profile_image'], array("test_form" => false));

            $profile_url = $fileUploaded['url'];
        }

        $this->wpdb->insert($this->table_name, [
            "name" => $name,
            "email" => $email,
            "designation" => $designation,
            "profile_image" => $profile_url
        ]);

        $employee_id = $this->wpdb->insert_id;

        if($employee_id > 0){

            echo json_encode([
                "status" => 1,
                "message" => "Successfully, Employee created"
            ]);
        }else{

            echo json_encode([
                "status" => 0,
                "message" => "Failed to save employee"
            ]);
        }

        die;
    }

    /** Load DB Table Employees */
    public function handleLoadEmployeesData(){

        $employees = $this->wpdb->get_results(
            "SELECT * FROM {$this->table_name}",
            ARRAY_A
        );

        return wp_send_json([
            "status" => true,
            "message" => "Employees Data",
            "employees" => $employees
        ]);
    }

    // Delete Employee Data
    public function handleDeleteEmployeeData(){

        $employee_id = $_GET['empId'];

        $this->wpdb->delete($this->table_name, [
            "id" => $employee_id
        ]);

        return wp_send_json([
            "status" => true,
            "message" => "Employee Deleted Successfully"
        ]);
    }

    // Read Single Employee Data
    public function handleToGetSingleEmployeeData(){

        $employee_id = $_GET['empId'];

        if($employee_id > 0){

            $employeeData = $this->wpdb->get_row(
                "SELECT * FROM {$this->table_name} WHERE id = {$employee_id}", ARRAY_A
            );

            return wp_send_json([
                "status" => true,
                "message" => "Employee Data Found",
                "data" => $employeeData
            ]);
        }else{

            return wp_send_json([
                "status" => false,
                "message" => "Please pass employee ID"
            ]);
        }
    }

    // Update Employee Data
    public function handleUpdateEmployeeData(){
        $name = sanitize_text_field($_POST['employee_name']);
        $email = sanitize_text_field($_POST['employee_email']);
        $designation = sanitize_text_field($_POST['employee_designation']);
        $id = sanitize_text_field($_POST['employee_id']);

        $employeeData = $this->getEmployeeData($id);

        $profile_image_url = "";

        if(!empty($employeeData)){

            // Existing Profile Image
            $profile_image_url = $employeeData['profile_image'];

            // New File Image Object
            $profile_file_image = isset($_FILES['employee_profile_image']['name']) ? $_FILES['employee_profile_image']['name'] : "";

            // Check Image Exists
            if(!empty($profile_file_image)){
                
                if(!empty($profile_image_url)){

                    // http://localhost/wp/wp_plugin_course/wp-content/uploads/2024/08/employee-1.webp
                    $wp_site_url = get_site_url(); // http://localhost/wp/wp_plugin_course
                    $file_path = str_replace($wp_site_url."/", "", $profile_image_url); // wp-content/uploads/2024/08/employee-1.webp

                    if(file_exists(ABSPATH . $file_path)){
                        // Remove that file from uploads folder
                        unlink(ABSPATH . $file_path);
                    }
                }

                $UploadFile = $_FILES['employee_profile_image'];

                // $UploadFile['name'] - employee-1.webp

                // Original File Name
                $originalFileName = pathinfo($UploadFile['name'], PATHINFO_FILENAME); // employee-1

                // File Extension
                $file_extension = pathinfo($UploadFile['name'], PATHINFO_EXTENSION); // webp

                // New Image Name
                $newImageName = $originalFileName."_".time().".".$file_extension; // employee-1_89465133.webp

                $_FILES['employee_profile_image']['name'] = $newImageName;

                $fileUploaded = wp_handle_upload($_FILES['employee_profile_image'], array("test_form" => false));

                $profile_image_url = $fileUploaded['url'];
            }

            $this->wpdb->update($this->table_name, [
                "name" => $name,
                "email" => $email,
                "designation" => $designation,
                "profile_image" => $profile_image_url
            ], [
                "id" => $id
            ]);

            return wp_send_json([
                "status" => true,
                "message" => "Employee Updated successfully"
            ]);
        }else{

            return wp_send_json([
                "status" => false,
                "message" => "No Employee found with this ID"
            ]);
        }
    }

    // Get employee Data
    private function getEmployeeData($employee_id){

        $employeeData = $this->wpdb->get_row(
            "SELECT * FROM {$this->table_name} WHERE id = {$employee_id}", ARRAY_A
        );

        return $employeeData;
    }
}