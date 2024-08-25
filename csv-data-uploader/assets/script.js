jQuery(document).ready(function(){

    jQuery("#frm-csv-upload").on("submit", function(event){

        event.preventDefault();

        var formData = new FormData(this);

        jQuery.ajax({
            url: cdu_object.ajax_url,
            data: formData,
            dataType: "json",
            method: "POST",
            processData: false,
            contentType: false,
            success: function(response){
                if(response.status){
                    jQuery("#show_upload_message").html(response.message).css({
                        color: "green"
                    });
                    jQuery("#frm-csv-upload")[0].reset();
                }
            }
        });
    });
});