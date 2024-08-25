jQuery(document).ready(function(){

    console.log("Welcome To WooCommerce Product Creator Plugin");

    jQuery(document).on("click", "#btn_upload_product_image", function(){

        var fileInfo = wp.media({
            title: "Select Product Image",
            multiple: false
        }).open().on("select", function(){

            var uploadedFile = fileInfo.state().get("selection").first();

            var fileObject = uploadedFile.toJSON();

            var productImageUrl = fileObject.url;
            jQuery("#product_media_id").val(fileObject.id);

            jQuery("#product_image_preview").attr("src", productImageUrl);
        });
    });
});