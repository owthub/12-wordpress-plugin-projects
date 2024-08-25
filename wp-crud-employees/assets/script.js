jQuery(document).ready(function(){

    console.log("Welcome to CRUD Plugin of Employees");

    // Add Form Validation
    jQuery("#frm_add_employee").validate();

    // form Submit
    jQuery("#frm_add_employee").on("submit", function(event){

        event.preventDefault();

        var formdata = new FormData(this);

        jQuery.ajax({
            url: wce_object.ajax_url,
            data: formdata,
            method: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status){
                    alert(response.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        })
    });

    // Render Employees
    loadEmployeeData();

    // Delete Function 
    jQuery(document).on("click", ".btn_delete_employee", function(){

        var employeeId = jQuery(this).data("id");

        if(confirm("Are you sure want to delete")){ // true
            jQuery.ajax({
                url: wce_object.ajax_url,
                data: {
                    action: "wce_delete_employee",
                    empId: employeeId
                },
                method: "GET",
                dataType: "json",
                success: function(response){
                    if(response){
                        alert(response.message);
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }
                }
            })
        }
        // false
    });

    // Open Add Employee Form
    jQuery(document).on("click", "#btn_open_add_employee_form", function(){
        jQuery(".add_employee_form").toggleClass("hide_element");
        jQuery(this).addClass("hide_element");
    });

    // Close Add Employee Form
    jQuery(document).on("click", "#btn_close_add_employee_form", function(){
        jQuery(".add_employee_form").toggleClass("hide_element");
        jQuery("#btn_open_add_employee_form").removeClass("hide_element");
    });

    // Open Edit Layout
    jQuery(document).on("click", ".btn_edit_employee", function(){
        jQuery(".edit_employee_form").removeClass("hide_element");
        jQuery("#btn_open_add_employee_form").addClass("hide_element");
        // Get Existing data of an Employee by Employee ID
        var employeeId = jQuery(this).data("id"); // jQuery(this).attr("data-id");
        jQuery.ajax({
            url: wce_object.ajax_url,
            data: {
                action: "wce_get_employee_data",
                empId: employeeId
            },
            method: "GET",
            dataType: "json",
            success: function(response){
                jQuery("#employee_name").val(response?.data?.name);
                jQuery("#employee_email").val(response?.data?.email);
                jQuery("#employee_designation").val(response?.data?.designation);
                jQuery("#employee_id").val(response?.data?.id);
                jQuery("#employee_profile_icon").attr("src", response?.data?.profile_image);
            }
        })
    });

    // Close Edit Layout
    jQuery(document).on("click", "#btn_close_edit_employee_form", function(){
        jQuery(".edit_employee_form").toggleClass("hide_element");
        jQuery("#btn_open_add_employee_form").removeClass("hide_element");
    });

    // Submit Edit Form
    jQuery(document).on("submit", "#frm_edit_employee", function(event){
        event.preventDefault();
        var formdata = new FormData(this);
        jQuery.ajax({
            url: wce_object.ajax_url,
            data: formdata,
            method: "POST",
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response){
                if(response){
                    alert(response?.message);
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        })
    });
});

// Load All Employees From DB Table
function loadEmployeeData(){
    jQuery.ajax({
        url: wce_object.ajax_url,
        data: {
            action: "wce_load_employees_data"
        },
        method: "GET",
        dataType: "json",
        success: function(response){
            var employeesDataHTML = "";
            jQuery.each(response.employees, function(index, employee){

                let employeeProfileImage = "--";

                if(employee.profile_image){
                    employeeProfileImage = `<img src="${employee.profile_image}" height="80px" width="80px"/>`;
                }

                employeesDataHTML += `
                    <tr>
                        <td>${employee.id}</td>
                        <td>${employee.name}</td>
                        <td>${employee.email}</td>
                        <td>${employee.designation}</td>
                        <td>${employeeProfileImage}</td>
                        <td>
                            <button data-id="${employee.id}" class="btn_edit_employee">Edit</button>
                            <button data-id="${employee.id}" class="btn_delete_employee">Delete</button>
                        </td>
                    </tr>
                `;
            });

            // Bind data with Table
            jQuery("#employees_data_tbody").html(employeesDataHTML);
        }
    })
}