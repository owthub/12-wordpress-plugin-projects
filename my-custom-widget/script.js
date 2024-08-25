jQuery(document).ready(function(){

    console.log("Welcome to Custom Widget Development");

    jQuery(".mcw_dd_options").on("change", function(){

        let mcw_option_value = jQuery(this).val(); // mcw_display_recent_posts, mcw_display_static_message

        if(mcw_option_value == "recent_posts"){

            console.log("here 1");
            
            jQuery("p#mcw_display_recent_posts").removeClass("hide_element");
            jQuery("p#mcw_display_static_message").addClass("hide_element");

        } else if(mcw_option_value == "static_message"){

            console.log("here 2");

            jQuery("p#mcw_display_recent_posts").addClass("hide_element");
            jQuery("p#mcw_display_static_message").removeClass("hide_element");
        }
    });
});