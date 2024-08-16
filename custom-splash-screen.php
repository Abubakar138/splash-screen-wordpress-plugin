<?php
/*
Plugin Name: Custom Splash Screen
Description: Displays a splash screen with an image, text, and a button. The splash screen hides when the button is clicked.
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue Scripts and Styles
function custom_splash_screen_enqueue_scripts() {
    if (get_option('custom_splash_enabled') !== 'yes') {
        return; // Do not display the splash screen if it's disabled
    }
    wp_enqueue_script('custom-splash-screen', plugin_dir_url(__FILE__) . 'splash-screen.js', array('jquery'), '1.0', true);
    wp_enqueue_style('custom-splash-screen-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'custom_splash_screen_enqueue_scripts');

// Include the admin settings page
require_once plugin_dir_path(__FILE__) . 'admin-settings.php';

// Display the splash screen
function display_custom_splash_screen() {
    if (get_option('custom_splash_enabled') !== 'yes') {
        return; // Do not display the splash screen if it's disabled
    }

    if (get_option('custom_splash_image') || get_option('custom_splash_text')) {
        $button_text = get_option('custom_splash_button_text', __('Enter Home Page', 'custom-splash-screen'));
        ?>
        <div id="custom-splash-screen">
            <?php if ($image = get_option('custom_splash_image')) : ?>
                <img src="<?php echo esc_url($image); ?>" alt="Splash Image">
            <?php endif; ?>

            <div class="splash-content">
                <?php echo wp_kses_post(get_option('custom_splash_text')); ?>
            </div>

            <button id="enter-homepage"><?php echo esc_html($button_text); ?></button>
        </div>
        <?php
    }
}

add_action('wp_footer', 'display_custom_splash_screen');

// Custom CSS Output
function custom_splash_screen_custom_css() {
    if ($custom_css = get_option('custom_splash_custom_css')) {
        echo '<style type="text/css">' . esc_html($custom_css) . '</style>';
    }
}
add_action('wp_head', 'custom_splash_screen_custom_css');
