<h3>
    Form Data
</h3>

<p id="show_upload_message"></p>
<form action="javscript:void(0)" id="frm-csv-upload" enctype="multipart/form-data">
    <p>
        <label for="csv_data_file">Upload CSV File</label>
        <input type="file" name="csv_data_file" id="csv_data_file">
        <input type="hidden" name="action" value="cdu_submit_form_data">
    </p>
    <p>
        <button type="submit">Upload CSV</button>
    </p>
</form>