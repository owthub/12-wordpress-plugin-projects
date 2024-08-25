<div id="wp_employee_crud_plugin">
    <!-- Add Employee Layout -->
    <div class="form-container add_employee_form hide_element">
        
        <button id="btn_close_add_employee_form" style="float: right;">Close Form</button>

        <h3>Add Employee</h3>
        <form action="javascript:void(0)" id="frm_add_employee" enctype="multipart/form-data">

            <input type="hidden" name="action" value="wce_add_employee">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" required name="name" placeholder="Employee name" id="name">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" required name="email" placeholder="Employee Email" id="email">
            </div>

            <div class="form-group">
                <label for="designation">Designation</label>
                <select required name="designation" id="designation">
                    <option value="">-- Choose Designation --</option>
                    <option value="php">PHP Developer</option>
                    <option value="full">Full Stack Developer</option>
                    <option value="wordpress">WordPress Developer</option>
                    <option value="java">Java Developer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="file">Profile Image</label>
                <input type="file" name="profile_image" id="file">
            </div>

            <div class="form-group">
                <button id="btn_save_data" type="submit">Save Data</button>
            </div>
        </form>
    </div>

    <!-- Edit Employee Layout -->
    <div class="form-container edit_employee_form hide_element">

        <button id="btn_close_edit_employee_form" style="float: right;">Close Form</button>

        <h3>Edit Employee</h3>
        <form action="javascript:void(0)" id="frm_edit_employee" enctype="multipart/form-data">

            <input type="hidden" name="action" value="wce_edit_employee">
            <input type="hidden" name="employee_id" id="employee_id">

            <div class="form-group">
                <label for="employee_name">Name</label>
                <input type="text" required name="employee_name" placeholder="Employee name" id="employee_name">
            </div>

            <div class="form-group">
                <label for="employee_email">Email</label>
                <input type="email" required name="employee_email" placeholder="Employee Email" id="employee_email">
            </div>

            <div class="form-group">
                <label for="employee_designation">Designation</label>
                <select required name="employee_designation" id="employee_designation">
                    <option value="">-- Choose Designation --</option>
                    <option value="php">PHP Developer</option>
                    <option value="full">Full Stack Developer</option>
                    <option value="wordpress">WordPress Developer</option>
                    <option value="java">Java Developer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="employee_profile_image">Profile Image</label>
                <input type="file" name="employee_profile_image" id="employee_file">
                <br>
                <img id="employee_profile_icon" style="height: 100px;width: 100px;"/>
            </div>

            <div class="form-group">
                <button id="btn_update_data" type="submit">Update Employee</button>
            </div>
        </form>
    </div>

    <!-- List Employee Layout -->
    <div class="list-container">
        <button id="btn_open_add_employee_form" style="float: right;">Add Employee</button>
        <h3>List Employees</h3>
        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>#Name</th>
                    <th>#Email</th>
                    <th>#Designation</th>
                    <th>#Profile Image</th>
                    <th>#Action</th>
                </tr>
            </thead>
            <tbody id="employees_data_tbody"></tbody>
        </table>
    </div>
</div>
