<div class="wcp_custom_plugin">
    <div class="form-container">
        <h2>Product Form</h2>
        <form action="" method="post">

            <?php wp_nonce_field("wcp_handle_add_product_form_submit", "wcp_nonce_value"); ?>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" required id="name" name="wcp_name" required>
            </div>
            <div class="form-group">
                <label for="regular-price">Regular Price</label>
                <input type="number" required id="regular-price" name="wcp_regular_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="sale-price">Sale Price</label>
                <input type="number" required id="sale-price" name="wcp_sale_price" step="0.01">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" required name="wcp_description"></textarea>
            </div>
            <div class="form-group">
                <label for="short-description">Short Description</label>
                <input type="text" id="short-description" name="wcp_short_description">
            </div>
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" required id="sku" name="wc_sku">
            </div>
            <div class="form-group">
                <label for="product-image">Product Image</label>
                <button type="button" id="btn_upload_product_image">Upload Product Image</button>
                <input type="hidden" name="product_media_id" id="product_media_id">
                <img src="" alt="" id="product_image_preview" style="height: 100px; width: 100px;">
            </div>
            <div class="form-group">
                <button type="submit" name="btn_submit_woocom_product">Submit</button>
            </div>
        </form>
    </div>
</div>