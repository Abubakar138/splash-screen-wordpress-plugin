<?php
// Add menu item for splash screen settings
function custom_splash_screen_add_admin_menu() {
    add_menu_page(
        __('Splash Screen Settings', 'custom-splash-screen'),
        __('Splash Screen', 'custom-splash-screen'),
        'manage_options',
        'custom-splash-screen',
        'custom_splash_screen_settings_page'
    );
}
add_action('admin_menu', 'custom_splash_screen_add_admin_menu');

// Register settings and fields
function custom_splash_screen_settings_init() {
    register_setting('customSplashScreen', 'custom_splash_enabled');
    register_setting('customSplashScreen', 'custom_splash_image');
    register_setting('customSplashScreen', 'custom_splash_text');
    register_setting('customSplashScreen', 'custom_splash_button_text');
    register_setting('customSplashScreen', 'custom_splash_custom_css');

    add_settings_section(
        'custom_splash_screen_section',
        __('Splash Screen Settings', 'custom-splash-screen'),
        null,
        'customSplashScreen'
    );

    add_settings_field(
        'custom_splash_enabled',
        __('Enable Splash Screen', 'custom-splash-screen'),
        'custom_splash_enabled_render',
        'customSplashScreen',
        'custom_splash_screen_section'
    );

    add_settings_field(
        'custom_splash_image',
        __('Splash Image', 'custom-splash-screen'),
        'custom_splash_image_render',
        'customSplashScreen',
        'custom_splash_screen_section'
    );

    add_settings_field(
        'custom_splash_text',
        __('Splash Text', 'custom-splash-screen'),
        'custom_splash_text_render',
        'customSplashScreen',
        'custom_splash_screen_section'
    );

    add_settings_field(
        'custom_splash_button_text',
        __('Button Text', 'custom-splash-screen'),
        'custom_splash_button_text_render',
        'customSplashScreen',
        'custom_splash_screen_section'
    );

    add_settings_field(
        'custom_splash_custom_css',
        __('Custom CSS', 'custom-splash-screen'),
        'custom_splash_custom_css_render',
        'customSplashScreen',
        'custom_splash_screen_section'
    );
}
add_action('admin_init', 'custom_splash_screen_settings_init');

// Render the enable/disable checkbox field
function custom_splash_enabled_render() {
    $value = get_option('custom_splash_enabled', 'yes'); // Default to enabled
    echo '<input type="checkbox" name="custom_splash_enabled" value="yes"' . checked('yes', $value, false) . '>';
    echo '<label for="custom_splash_enabled">' . __('Enable the splash screen', 'custom-splash-screen') . '</label>';
}

// Render the image upload field
function custom_splash_image_render() {
    $value = get_option('custom_splash_image');
    echo '<input type="text" id="custom_splash_image" name="custom_splash_image" value="' . esc_url($value) . '" />';
    echo '<button type="button" class="button" id="upload_image_button">' . __('Upload Image', 'custom-splash-screen') . '</button>';
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        var custom_uploader;
        $('#upload_image_button').click(function(e) {
            e.preventDefault();
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: '<?php _e('Choose Image', 'custom-splash-screen'); ?>',
                button: {
                    text: '<?php _e('Choose Image', 'custom-splash-screen'); ?>'
                },
                multiple: false
            });
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#custom_splash_image').val(attachment.url);
            });
            custom_uploader.open();
        });
    });
    </script>
    <?php
}

// Render the WYSIWYG editor field
function custom_splash_text_render() {
    $content = get_option('custom_splash_text');
    wp_editor($content, 'custom_splash_text', array('textarea_name' => 'custom_splash_text'));
}

// Render the button text field
function custom_splash_button_text_render() {
    $value = get_option('custom_splash_button_text', __('Enter Home Page', 'custom-splash-screen')); // Default text
    echo '<input type="text" name="custom_splash_button_text" value="' . esc_attr($value) . '" />';
}

// Render the custom CSS field
function custom_splash_custom_css_render() {
    $value = get_option('custom_splash_custom_css');
    echo '<textarea cols="60" rows="5" name="custom_splash_custom_css">' . esc_textarea($value) . '</textarea>';
}

// Display the settings page
function custom_splash_screen_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Splash Screen Settings', 'custom-splash-screen'); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('customSplashScreen');
            do_settings_sections('customSplashScreen');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
