<form action="options.php" method="post">
    <?php 
        settings_fields("wlc_login_page_settings_field_group");
        do_settings_sections("wp-login-page-customizer");
        submit_button("Save Settings");
    ?>
</form>