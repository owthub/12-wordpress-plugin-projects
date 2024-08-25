<?php 
  $post_id = isset($post->ID) ? $post->ID : "";

  $title = get_post_meta($post_id, "pmeta_title", true);
  $description = get_post_meta($post_id, "pmeta_description", true);

  wp_nonce_field("mmp_save_page_metabox_data", "mmp_save_pmetabox_nonce");
?>

<p>
    <label for="pmeta_title">Meta Title</label>
    <input type="text" name="pmeta_title" placeholder="Meta Title..." value="<?php echo $title; ?>" id="pmeta_title">
</p>

<p>
    <label for="pmeta_description">Meta Description</label>
    <input type="text" name="pmeta_description" value="<?php echo $description; ?>" id="pmeta_description" placeholder="Meta Description...">
</p>