<?php
/**
 * KarmaDocs Theme Functions
 *
 * @package KarmaDocs
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme setup
 */
function karmadocs_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'karmadocs'),
        'footer'  => __('Footer Menu', 'karmadocs'),
    ));

    // Add image sizes
    add_image_size('karmadocs-logo', 300, 80, false);
}
add_action('after_setup_theme', 'karmadocs_setup');

/**
 * Enqueue scripts and styles
 */
function karmadocs_scripts()
{
    // Google Fonts - Outfit
    wp_enqueue_style('karmadocs-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap', array(), null);

    // Main stylesheet
    wp_enqueue_style('karmadocs-style', get_stylesheet_uri(), array('karmadocs-fonts'), '1.0.0');

    // Custom JavaScript
    wp_enqueue_script('karmadocs-scripts', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'karmadocs_scripts');

/**
 * Register widget areas
 */
function karmadocs_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'karmadocs'),
        'id'            => 'footer-widgets',
        'description'   => __('Widgets in this area will be displayed in the footer.', 'karmadocs'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'karmadocs_widgets_init');

/**
 * Custom excerpt length
 */
function karmadocs_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'karmadocs_excerpt_length');

/**
 * Custom excerpt more text
 */
function karmadocs_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'karmadocs_excerpt_more');

/**
 * Add custom body classes
 */
function karmadocs_body_classes($classes)
{
    if (is_front_page()) {
        $classes[] = 'landing-page';
    }
    return $classes;
}
add_filter('body_class', 'karmadocs_body_classes');

/**
 * Handle contact form submission
 */
function karmadocs_handle_form_submission()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'karmadocs_nonce')) {
        wp_send_json_error(array('message' => 'Security verification failed. Please try again.'));
    }

    // Sanitize input
    $name    = sanitize_text_field($_POST['name']);
    $phone   = sanitize_text_field($_POST['phone']);
    $email   = sanitize_email($_POST['email']);
    $condition = sanitize_text_field($_POST['condition']);
    $location = sanitize_text_field($_POST['location']);
    $message = sanitize_textarea_field($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($condition) || empty($location)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    // Store submission in database
    $post_id = wp_insert_post(array(
        'post_title'   => $name . ' - ' . $condition,
        'post_type'    => 'consultation',
        'post_status'  => 'private',
        'post_content' => '',
    ));

    if ($post_id) {
        // Save meta data
        add_post_meta($post_id, '_consultation_name', $name);
        add_post_meta($post_id, '_consultation_phone', $phone);
        add_post_meta($post_id, '_consultation_email', $email);
        add_post_meta($post_id, '_consultation_condition', $condition);
        add_post_meta($post_id, '_consultation_location', $location);
        add_post_meta($post_id, '_consultation_message', $message);
        add_post_meta($post_id, '_consultation_date', current_time('mysql'));

        // Send email notification
        $to = get_option('admin_email');
        $subject = 'New Consultation Request - ' . get_bloginfo('name');
        $body = "You have received a new consultation request:\n\n";
        $body .= "Name: " . $name . "\n";
        $body .= "Phone: " . $phone . "\n";
        $body .= "Email: " . $email . "\n";
        $body .= "Condition: " . $condition . "\n";
        $body .= "Location: " . $location . "\n";
        $body .= "Message: " . $message . "\n";

        wp_mail($to, $subject, $body);

        // Track Facebook Lead event
        if (function_exists('fbq')) {
            fbq('track', 'Lead', array(
                'content_name' => 'Consultation Request',
                'content_category' => 'Mental Health',
                'value' => $condition,
            ));
        }

        wp_send_json_success(array(
            'message' => 'Thank you! We\'ll be in touch shortly.',
        ));
    } else {
        wp_send_json_error(array('message' => 'Something went wrong. Please try again.'));
    }

    wp_die();
}
add_action('wp_ajax_submit_consultation', 'karmadocs_handle_form_submission');
add_action('wp_ajax_nopriv_submit_consultation', 'karmadocs_handle_form_submission');

/**
 * Register Custom Post Type for Consultations
 */
function karmadocs_register_cpt()
{
    $labels = array(
        'name'               => __('Consultations', 'karmadocs'),
        'singular_name'      => __('Consultation', 'karmadocs'),
        'menu_name'          => __('Consultations', 'karmadocs'),
        'add_new'            => __('Add New', 'karmadocs'),
        'add_new_item'       => __('Add New Consultation', 'karmadocs'),
        'edit_item'          => __('Edit Consultation', 'karmadocs'),
        'new_item'           => __('New Consultation', 'karmadocs'),
        'view_item'          => __('View Consultation', 'karmadocs'),
        'search_items'       => __('Search Consultations', 'karmadocs'),
        'not_found'          => __('No consultations found', 'karmadocs'),
        'not_found_in_trash' => __('No consultations found in trash', 'karmadocs'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-admin-comments',
        'supports'           => array('title'),
    );

    register_post_type('consultation', $args);
}
add_action('init', 'karmadocs_register_cpt');

/**
 * Add meta boxes for consultation details
 */
function karmadocs_add_meta_boxes()
{
    add_meta_box(
        'consultation_details',
        __('Consultation Details', 'karmadocs'),
        'karmadocs_consultation_meta_box',
        'consultation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'karmadocs_add_meta_boxes');

/**
 * Consultation meta box callback
 */
function karmadocs_consultation_meta_box($post)
{
    wp_nonce_field('karmadocs_consultation_nonce', 'karmadocs_consultation_nonce_field');

    $name = get_post_meta($post->ID, '_consultation_name', true);
    $phone = get_post_meta($post->ID, '_consultation_phone', true);
    $email = get_post_meta($post->ID, '_consultation_email', true);
    $condition = get_post_meta($post->ID, '_consultation_condition', true);
    $location = get_post_meta($post->ID, '_consultation_location', true);
    $message = get_post_meta($post->ID, '_consultation_message', true);
    $date = get_post_meta($post->ID, '_consultation_date', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="consultation_name"><?php _e('Name', 'karmadocs'); ?></label></th>
            <td><input type="text" id="consultation_name" name="consultation_name" value="<?php echo esc_attr($name); ?>" class="regular-text" readonly></td>
        </tr>
        <tr>
            <th><label for="consultation_phone"><?php _e('Phone', 'karmadocs'); ?></label></th>
            <td><input type="text" id="consultation_phone" name="consultation_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" readonly></td>
        </tr>
        <tr>
            <th><label for="consultation_email"><?php _e('Email', 'karmadocs'); ?></label></th>
            <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
        </tr>
        <tr>
            <th><label for="consultation_condition"><?php _e('Condition', 'karmadocs'); ?></label></th>
            <td><input type="text" id="consultation_condition" name="consultation_condition" value="<?php echo esc_attr($condition); ?>" class="regular-text" readonly></td>
        </tr>
        <tr>
            <th><label for="consultation_location"><?php _e('Location', 'karmadocs'); ?></label></th>
            <td><input type="text" id="consultation_location" name="consultation_location" value="<?php echo esc_attr($location); ?>" class="regular-text" readonly></td>
        </tr>
        <tr>
            <th><label for="consultation_message"><?php _e('Message', 'karmadocs'); ?></label></th>
            <td><textarea id="consultation_message" name="consultation_message" rows="4" class="large-text" readonly><?php echo esc_textarea($message); ?></textarea></td>
        </tr>
        <tr>
            <th><label><?php _e('Submitted', 'karmadocs'); ?></label></th>
            <td><?php echo esc_html(date('F j, Y g:i A', strtotime($date))); ?></td>
        </tr>
    </table>
    <?php
}

/**
 * Save consultation meta data
 */
function karmadocs_save_consultation_meta($post_id)
{
    // Verify nonce
    if (!isset($_POST['karmadocs_consultation_nonce_field']) || !wp_verify_nonce($_POST['karmadocs_consultation_nonce_field'], 'karmadocs_consultation_nonce')) {
        return;
    }

    // Prevent autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save meta fields
    if (isset($_POST['consultation_name'])) {
        update_post_meta($post_id, '_consultation_name', sanitize_text_field($_POST['consultation_name']));
    }
    if (isset($_POST['consultation_phone'])) {
        update_post_meta($post_id, '_consultation_phone', sanitize_text_field($_POST['consultation_phone']));
    }
    if (isset($_POST['consultation_email'])) {
        update_post_meta($post_id, '_consultation_email', sanitize_email($_POST['consultation_email']));
    }
    if (isset($_POST['consultation_condition'])) {
        update_post_meta($post_id, '_consultation_condition', sanitize_text_field($_POST['consultation_condition']));
    }
    if (isset($_POST['consultation_location'])) {
        update_post_meta($post_id, '_consultation_location', sanitize_text_field($_POST['consultation_location']));
    }
    if (isset($_POST['consultation_message'])) {
        update_post_meta($post_id, '_consultation_message', sanitize_textarea_field($_POST['consultation_message']));
    }
}
add_action('save_post_consultation', 'karmadocs_save_consultation_meta');

/**
 * Flush rewrite rules on theme activation
 */
function karmadocs_rewrite_flush()
{
    karmadocs_register_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'karmadocs_rewrite_flush');

/**
 * Add custom columns to consultation list
 */
function karmadocs_consultation_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['name'] = __('Name', 'karmadocs');
    $new_columns['condition'] = __('Condition', 'karmadocs');
    $new_columns['location'] = __('Location', 'karmadocs');
    $new_columns['email'] = __('Email', 'karmadocs');
    $new_columns['phone'] = __('Phone', 'karmadocs');
    $new_columns['date'] = __('Submitted', 'karmadocs');
    return $new_columns;
}
add_filter('manage_consultation_posts_columns', 'karmadocs_consultation_columns');

/**
 * Populate custom columns
 */
function karmadocs_consultation_column_data($column, $post_id)
{
    switch ($column) {
        case 'name':
            echo esc_html(get_post_meta($post_id, '_consultation_name', true));
            break;
        case 'condition':
            echo esc_html(get_post_meta($post_id, '_consultation_condition', true));
            break;
        case 'location':
            echo esc_html(get_post_meta($post_id, '_consultation_location', true));
            break;
        case 'email':
            echo esc_html(get_post_meta($post_id, '_consultation_email', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_consultation_phone', true));
            break;
    }
}
add_action('manage_consultation_posts_custom_column', 'karmadocs_consultation_column_data', 10, 2);

/**
 * Enable shortcodes in text widgets
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Add Open Graph meta tags
 */
function karmadocs_add_og_meta()
{
    if (is_front_page()) {
        ?>
        <meta property="og:title" content="<?php bloginfo('name'); ?>" />
        <meta property="og:description" content="<?php bloginfo('description'); ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo home_url(); ?>" />
        <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
        <?php if (has_post_thumbnail()) : ?>
            <meta property="og:image" content="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" />
        <?php endif; ?>
        <?php
    }
}
add_action('wp_head', 'karmadocs_add_og_meta');

/**
 * Customizer settings
 */
function karmadocs_customize_register($wp_customize)
{
    // Hero Section
    $wp_customize->add_section('karmadocs_hero', array(
        'title'    => __('Hero Section', 'karmadocs'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('karmadocs_badge_text', array(
        'default'   => 'Comprehensive Psychiatric Services',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_badge_text', array(
        'label'   => __('Badge Text', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('karmadocs_headline', array(
        'default'   => 'Compassionate Mental Health <em>Care That Works</em>',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_headline', array(
        'label'       => __('Headline', 'karmadocs'),
        'description' => __('You can use HTML tags like <em> for emphasis.', 'karmadocs'),
        'section'     => 'karmadocs_hero',
        'type'        => 'textarea',
    ));

    $wp_customize->add_setting('karmadocs_subheading', array(
        'default'   => 'From advanced TMS therapy and medication management to individual counseling, we offer a full spectrum of psychiatric services tailored to your unique needs. Begin your healing journey today.',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_subheading', array(
        'label'   => __('Subheading', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('karmadocs_hero_video', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_hero_video', array(
        'label'   => __('Hero Video URL', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'url',
        'description' => __('Enter the full URL to your hero video file (MP4 format recommended).', 'karmadocs'),
    ));

    $wp_customize->add_setting('karmadocs_form_title', array(
        'default'   => 'Schedule a Consultation',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_form_title', array(
        'label'   => __('Form Title', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('karmadocs_form_subtitle', array(
        'default'   => 'We\'ll reach out within one business day',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_form_subtitle', array(
        'label'   => __('Form Subtitle', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('karmadocs_form_submit_text', array(
        'default'   => 'Get My Free Consultation',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_form_submit_text', array(
        'label'   => __('Submit Button Text', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('karmadocs_form_trust_text', array(
        'default'   => 'No spam. Your information is safe with us.',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_form_trust_text', array(
        'label'   => __('Trust Text', 'karmadocs'),
        'section' => 'karmadocs_hero',
        'type'    => 'text',
    ));

    // FAQ Section
    $wp_customize->add_section('karmadocs_faq', array(
        'title'    => __('FAQ Section', 'karmadocs'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('karmadocs_faq_title', array(
        'default'   => 'Common Questions',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_faq_title', array(
        'label'   => __('FAQ Title', 'karmadocs'),
        'section' => 'karmadocs_faq',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('karmadocs_faq_subtitle', array(
        'default'   => 'Everything you need to know about our psychiatric services',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_faq_subtitle', array(
        'label'   => __('FAQ Subtitle', 'karmadocs'),
        'section' => 'karmadocs_faq',
        'type'    => 'text',
    ));

    // Footer Section
    $wp_customize->add_section('karmadocs_footer', array(
        'title'    => __('Footer Section', 'karmadocs'),
        'priority' => 50,
    ));

    $wp_customize->add_setting('karmadocs_footer_text', array(
        'default'   => 'Comprehensive psychiatric care in Palm Springs, CA — from TMS therapy and medication management to talk therapy for depression, anxiety, and more.',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('karmadocs_footer_text', array(
        'label'   => __('Footer Text', 'karmadocs'),
        'section' => 'karmadocs_footer',
        'type'    => 'textarea',
    ));

    // Branding
    $wp_customize->add_section('karmadocs_branding', array(
        'title'    => __('Branding', 'karmadocs'),
        'priority' => 10,
    ));

    $wp_customize->add_setting('karmadocs_logo', array(
        'default'   => 'https://res.cloudinary.com/de4kw1t2i/image/upload/v1766060387/Karma-Docs-Logo-Horizental_w48ja1.webp',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'karmadocs_logo', array(
        'label'   => __('Logo', 'karmadocs'),
        'section' => 'karmadocs_branding',
        'settings' => 'karmadocs_logo',
    )));

    // Statistics
    $wp_customize->add_section('karmadocs_stats_section', array(
        'title'    => __('Statistics', 'karmadocs'),
        'priority' => 35,
    ));

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting('karmadocs_stat_' . $i . '_value', array(
            'default'   => '',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control('karmadocs_stat_' . $i . '_value', array(
            'label'   => sprintf(__('Stat %d Value', 'karmadocs'), $i),
            'section' => 'karmadocs_stats_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('karmadocs_stat_' . $i . '_label', array(
            'default'   => '',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control('karmadocs_stat_' . $i . '_label', array(
            'label'   => sprintf(__('Stat %d Label', 'karmadocs'), $i),
            'section' => 'karmadocs_stats_section',
            'type'    => 'text',
        ));
    }
}

add_action('customize_register', 'karmadocs_customize_register');

/**
 * Override stats output to support Customizer
 */
function karmadocs_get_stats()
{
    $stats = array();

    for ($i = 1; $i <= 4; $i++) {
        $value = get_theme_mod('karmadocs_stat_' . $i . '_value', '');
        $label = get_theme_mod('karmadocs_stat_' . $i . '_label', '');

        if (!empty($value) && !empty($label)) {
            $stats[] = array('value' => $value, 'label' => $label);
        }
    }

    // Fallback to defaults if no custom stats set
    if (empty($stats)) {
        $stats = array(
            array('value' => '85%', 'label' => 'Success Rate'),
            array('value' => '10K+', 'label' => 'Patients'),
            array('value' => '4.9', 'label' => 'Rating'),
            array('value' => '5+', 'label' => 'Services'),
        );
    }

    return $stats;
}

/**
 * Override FAQ output to support Customizer
 */
function karmadocs_get_faqs()
{
    $faqs = array(
        array(
            'question' => __('What services does KarmaDocs offer?', 'karmadocs'),
            'answer' => __('KarmaDocs provides a full spectrum of psychiatric care including TMS therapy, medication management, and individual talk therapy. We treat depression, anxiety disorders, PTSD, OCD, women\'s mood disorders, stress & adjustment disorders, and ADHD with evidence-based, personalized treatment plans.', 'karmadocs')
        ),
        array(
            'question' => __('Does insurance cover your services?', 'karmadocs'),
            'answer' => __('Yes. We work with most major insurance providers including Medicare, IEHP, Tricare, Blue Cross Blue Shield, Aetna, and Cigna. Our team handles all benefit verification and pre-authorization for TMS, medication management, and therapy services.', 'karmadocs')
        ),
        array(
            'question' => __('What can I expect from my first visit?', 'karmadocs'),
            'answer' => __('Your first visit is a comprehensive psychiatric evaluation. Our clinician will review your medical history, current symptoms, and treatment goals to create a personalized care plan — whether that involves therapy, medication, TMS, or a combination.', 'karmadocs')
        ),
        array(
            'question' => __('How does medication management work?', 'karmadocs'),
            'answer' => __('Our board-certified providers prescribe and monitor psychiatric medications as part of a broader treatment plan. We focus on finding the right medication and dosage with minimal side effects, checking in regularly to ensure your care stays aligned with your goals.', 'karmadocs')
        ),
        array(
            'question' => __('When should I seek psychiatric care?', 'karmadocs'),
            'answer' => __('You don\'t have to wait until things feel unmanageable. If you\'re struggling with persistent sadness, anxiety, racing thoughts, difficulty sleeping, trauma symptoms, or any mental health concern — we\'re here to help. Early intervention leads to better outcomes.', 'karmadocs')
        ),
        array(
            'question' => __('What conditions do you treat?', 'karmadocs'),
            'answer' => __('KarmaDocs treats depression, anxiety disorders, PTSD, OCD, women\'s mood disorders, stress & adjustment disorders, and ADHD. We believe every individual\'s experience is unique and tailor every treatment plan accordingly.', 'karmadocs')
        )
    );

    return $faqs;
}
