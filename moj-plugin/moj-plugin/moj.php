<?php
/**
 * Plugin Name: Band Profiles
 * Description: Adds a custom post type for band profiles.
 * Version: 1.0
 * Author: Your Name
 */

// Hook into the 'init' action
add_action('init', 'register_band_profile_cpt');

function register_band_profile_cpt() {
    $args = array(
        'public' => true,
        'label'  => 'Band Profiles',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
    );
    register_post_type('band_profile', $args);
}

// Add meta boxes for additional information
add_action('add_meta_boxes', 'band_profile_add_meta_boxes');
function band_profile_add_meta_boxes() {
    add_meta_box('band_profile_details', 'Band Details', 'band_profile_meta_box_display', 'band_profile', 'normal', 'high');
}

// HTML for the meta box content
function band_profile_meta_box_display($post) {
    ?>
    <p>
        <label for="youtube_link">YouTube Link:</label>
        <input type="text" name="youtube_link" id="youtube_link" value="<?php echo get_post_meta($post->ID, 'youtube_link', true); ?>" class="widefat">
    </p>
    <p>
        <label for="spotify_link">Spotify Link:</label>
        <input type="text" name="spotify_link" id="spotify_link" value="<?php echo get_post_meta($post->ID, 'spotify_link', true); ?>" class="widefat">
    </p>
    <!-- Add other fields as necessary -->
    <?php
}

// Save meta box content
add_action('save_post', 'band_profile_save_meta_box');
function band_profile_save_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (isset($_POST['youtube_link'])) {
        update_post_meta($post_id, 'youtube_link', sanitize_text_field($_POST['youtube_link']));
    }
    if (isset($_POST['spotify_link'])) {
        update_post_meta($post_id, 'spotify_link', sanitize_text_field($_POST['spotify_link']));
    }
    // Save other fields as necessary
}

?>
