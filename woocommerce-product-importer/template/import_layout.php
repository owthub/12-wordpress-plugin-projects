
<h3>WooCommerce Product Importer</h3>

<form action="" method="post" enctype="multipart/form-data">

    <?php wp_nonce_field("wpi_handle_form_upload", "wpi_nonce_value"); ?>

    <p>
        <label for="">
            Choose CSV File
        </label>
        <input type="file" name="product_csv" id="product_csv">
    </p>
    <p>
        <?php submit_button("Upload CSV Products", "primary", "btn_import_csv_products"); ?>
    </p>
</form>