<?php 

class My_Custom_Widget extends WP_Widget{

    // Construtor
    public function __construct()
    {
        parent::__construct(
            "my_custom_widget",
            "My Custom Widget",
            array(
                "description" => "Display Recent Posts and a Static Message"
            )
        );
    }

    // Display Widget To Admin Panel
    public function form( $instance ) {

        $mcw_title = !empty($instance['mcw_title']) ? $instance['mcw_title'] : "";
        $mcw_display_option = !empty($instance['mcw_display_option']) ? $instance['mcw_display_option'] : "";
        $mcw_number_of_posts = !empty($instance['mcw_number_of_posts']) ? $instance['mcw_number_of_posts'] : "";
        $mcw_your_message = !empty($instance['mcw_your_message']) ? $instance['mcw_your_message'] : "";
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('mcw_title') ?>">Title</label>
            <input type="text" name="<?php echo $this->get_field_name('mcw_title') ?>" id="<?php echo $this->get_field_id('mcw_title') ?>" class="widefat" value="<?php echo $mcw_title; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_name('mcw_display_option') ?>">Display Type</label>
            <select class="widefat mcw_dd_options" name="<?php echo $this->get_field_name('mcw_display_option') ?>" id="<?php echo $this->get_field_id('mcw_display_option') ?>">
                <option <?php if($mcw_display_option == "recent_posts") { echo "selected"; } ?> value="recent_posts">Recent Posts</option>
                <option <?php if($mcw_display_option == "static_message") { echo "selected"; } ?> value="static_message">Static Message</option>
            </select>
        </p>
        <p id="mcw_display_recent_posts" <?php if($mcw_display_option == "recent_posts") { } else { echo 'class="hide_element"'; }  ?>>
            <label for="<?php echo $this->get_field_name('mcw_number_of_posts') ?>">Number of Posts</label>
            <input type="number" name="<?php echo $this->get_field_name('mcw_number_of_posts') ?>" id="<?php echo $this->get_field_id('mcw_number_of_posts') ?>" value="<?php echo $mcw_number_of_posts; ?>" class="widefat">
        </p>
        <p id="mcw_display_static_message" <?php if($mcw_display_option == "static_message") { } else { echo 'class="hide_element"'; }  ?>>
            <label for="<?php echo $this->get_field_name('mcw_your_message') ?>">Your Message</label>
            <input type="text" name="<?php echo $this->get_field_name('mcw_your_message') ?>" id="<?php echo $this->get_field_id('mcw_your_message') ?>" class="widefat" value="<?php echo $mcw_your_message; ?>">
        </p>
        <?php
    }

    // Save widget Settings to Wordpress
    public function update( $new_instance, $old_instance ) {
		
        $instance = []; // mcw_title, mcw_display_option, mcw_number_of_posts, mcw_your_message

        $instance['mcw_title'] = !empty($new_instance['mcw_title']) ? strip_tags($new_instance['mcw_title']) : "";

        $instance['mcw_display_option'] = !empty($new_instance['mcw_display_option']) ? sanitize_text_field($new_instance['mcw_display_option']) : "";

        $instance['mcw_number_of_posts'] = !empty($new_instance['mcw_number_of_posts']) ? sanitize_text_field($new_instance['mcw_number_of_posts']) : "";

        $instance['mcw_your_message'] = !empty($new_instance['mcw_your_message']) ? sanitize_text_field($new_instance['mcw_your_message']) : "";

        return $instance;
	}

    // Display Widget to Frontend
    public function widget( $args, $instance ) {
		
        $title = apply_filters("widget_title", $instance['mcw_title']);

        echo $args['before_widget'];
            echo $args['before_title'];
                 echo $title;
            echo $args['after_title'];

            // Check for Display Type
            if($instance['mcw_display_option'] == "static_message"){

                echo $instance['mcw_your_message'];

            } elseif($instance['mcw_display_option'] == "recent_posts"){

                $query = new WP_Query(array(
                    "posts_per_page" => $instance['mcw_number_of_posts'],
                    "post_status" => "publish"
                ));

                if($query->have_posts()){

                    echo "<ul>";

                    while( $query->have_posts() ){

                        $query->the_post();

                        echo '<li> <a href="'. get_the_permalink() .'">' .get_the_title(). '</a> </li>';
                    }

                    echo "</ul>";

                    wp_reset_postdata();
                }else{

                    echo "No Post Found";
                }
            }

        echo $args['after_widget'];
	}
}