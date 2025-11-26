<?php
/**
 * Plugin Name: Bootstrap Document Downloads
 * Description: Display downloadable files (PDF, Doc, Excel) in a Bootstrap grid with a download button.
 * Version: 1.0
 * Author: D Kandekore
 */

if (!defined('ABSPATH')) exit;

define('BDD_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * --------------------------------------------------------
 * 1. REGISTER CPT & TAXONOMY
 * --------------------------------------------------------
 */
add_action('init', 'bdd_register_cpt_and_tax');

function bdd_register_cpt_and_tax() {
    // 1. Taxonomy: Download Categories
    register_taxonomy('download_cat', 'download_item', [
        'labels' => [
            'name' => 'Download Categories',
            'singular_name' => 'Download Category',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
    ]);

    // 2. Custom Post Type: Download Item
    register_post_type('download_item', [
        'labels' => [
            'name' => 'Download Items',
            'singular_name' => 'Download Item',
            'add_new' => 'Add New Download',
            'add_new_item' => 'Add New Download Item',
            'edit_item' => 'Edit Download Item',
        ],
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-media-document',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);
}

/**
 * --------------------------------------------------------
 * 2. CUSTOM FIELDS (Meta Boxes)
 * --------------------------------------------------------
 */
add_action('add_meta_boxes', 'bdd_add_meta_boxes');
add_action('save_post', 'bdd_save_meta_data');

function bdd_add_meta_boxes() {
    add_meta_box(
        'bdd_file_details',
        'File Details',
        'bdd_render_meta_box',
        'download_item',
        'normal',
        'high'
    );
}

function bdd_render_meta_box($post) {
    $file_url = get_post_meta($post->ID, '_bdd_file_url', true);
    $icon_class = get_post_meta($post->ID, '_bdd_icon_class', true);
    ?>
    <p>
        <label for="bdd_file_url" style="font-weight:bold;">File URL (Download Link):</label><br>
        <input type="text" id="bdd_file_url" name="bdd_file_url" value="<?php echo esc_attr($file_url); ?>" style="width:100%;" placeholder="https://example.com/uploads/brochure.pdf">
        <small>Paste the full URL of the file from your Media Library.</small>
    </p>
    <p>
        <label for="bdd_icon_class" style="font-weight:bold;">Card Icon Class (Divider):</label><br>
        <input type="text" id="bdd_icon_class" name="bdd_icon_class" value="<?php echo esc_attr($icon_class); ?>" style="width:100%;" placeholder="e.g. fa-solid fa-file-pdf">
    </p>
    <?php
}

function bdd_save_meta_data($post_id) {
    if (array_key_exists('bdd_file_url', $_POST)) {
        update_post_meta($post_id, '_bdd_file_url', esc_url_raw($_POST['bdd_file_url']));
    }
    if (array_key_exists('bdd_icon_class', $_POST)) {
        update_post_meta($post_id, '_bdd_icon_class', sanitize_text_field($_POST['bdd_icon_class']));
    }
}

/**
 * --------------------------------------------------------
 * 3. ADMIN SETTINGS (Styles)
 * --------------------------------------------------------
 */
add_action('admin_menu', 'bdd_add_admin_menu');
add_action('admin_init', 'bdd_register_settings');

function bdd_add_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=download_item',
        'Display Settings',
        'Display Settings',
        'manage_options',
        'bdd-settings',
        'bdd_options_page'
    );
}

function bdd_register_settings() {
    register_setting('bdd_settings_group', 'bdd_border_color');
    register_setting('bdd_settings_group', 'bdd_divider_color');
    register_setting('bdd_settings_group', 'bdd_bg_color');
    register_setting('bdd_settings_group', 'bdd_desc_length');
    register_setting('bdd_settings_group', 'bdd_button_text'); // HTML allowed for icon
    register_setting('bdd_settings_group', 'bdd_default_image');
    register_setting('bdd_settings_group', 'bdd_button_color');
    register_setting('bdd_settings_group', 'bdd_text_color');
}

function bdd_options_page() { ?>
    <div class="wrap">
        <h1>Download Grid Design Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('bdd_settings_group'); ?>
            <?php do_settings_sections('bdd_settings_group'); ?>
            <table class="form-table">
                <tr>
                    <th>Border Color</th>
                    <td><input type="text" name="bdd_border_color" value="<?php echo esc_attr(get_option('bdd_border_color', '#cccccc')); ?>" /></td>
                </tr>
                <tr>
                    <th>Divider Color</th>
                    <td><input type="text" name="bdd_divider_color" value="<?php echo esc_attr(get_option('bdd_divider_color', '#eeeeee')); ?>" /></td>
                </tr>
                <tr>
                    <th>Background Color</th>
                    <td><input type="text" name="bdd_bg_color" value="<?php echo esc_attr(get_option('bdd_bg_color', '#ffffff')); ?>" /></td>
                </tr>
                <tr>
                    <th>Text Color</th>
                    <td><input type="text" name="bdd_text_color" value="<?php echo esc_attr(get_option('bdd_text_color', '#333333')); ?>" /></td>
                </tr>
                <tr>
                    <th>Button Color</th>
                    <td><input type="text" name="bdd_button_color" value="<?php echo esc_attr(get_option('bdd_button_color', '#28a745')); ?>" /></td>
                </tr>
                <tr>
                    <th>Description Limit (characters)</th>
                    <td><input type="number" name="bdd_desc_length" value="<?php echo esc_attr(get_option('bdd_desc_length', 300)); ?>" min="50" max="2000" /></td>
                </tr>
                <tr>
                    <th>Download Button Content</th>
                    <td>
                        <input type="text" name="bdd_button_text" value="<?php echo esc_attr(get_option('bdd_button_text', '<i class="fa-solid fa-download"></i> Download')); ?>" style="width:50%;" />
                        <p><em>You can include HTML, e.g., <code>&lt;i class="fa-solid fa-download"&gt;&lt;/i&gt; Download</code></em></p>
                    </td>
                </tr>
                <tr>
                    <th>Default Image (URL)</th>
                    <td>
                        <input type="text" name="bdd_default_image" value="<?php echo esc_attr(get_option('bdd_default_image', '')); ?>" style="width:80%;" placeholder="https://example.com/default-doc.jpg" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }

/**
 * --------------------------------------------------------
 * 4. SHORTCODE
 * --------------------------------------------------------
 */
add_shortcode('bootstrap_downloads', 'bdd_display_grid');

function bdd_display_grid($atts) {
    $atts = shortcode_atts([
        'category'   => '',
        'columns'    => '3',
        'limit'      => '12',
    ], $atts, 'bootstrap_downloads');

    return bdd_render_grid(
        $atts['category'],
        $atts['columns'],
        $atts['limit']
    );
}

/**
 * --------------------------------------------------------
 * 5. RENDER FUNCTION
 * --------------------------------------------------------
 */
function bdd_render_grid($category = '', $columns = 3, $limit = 12) {
    // Styles
    $border_color  = get_option('bdd_border_color', '#cccccc');
    $divider_color = get_option('bdd_divider_color', '#eeeeee');
    $bg_color      = get_option('bdd_bg_color', '#ffffff');
    $text_color    = get_option('bdd_text_color', '#333333');
    $button_color  = get_option('bdd_button_color', '#28a745'); // Default Green for download
    $desc_length   = intval(get_option('bdd_desc_length', 300));
    // We allow HTML in button text for the icon
    $button_content = get_option('bdd_button_text', '<i class="fa-solid fa-download"></i> Download'); 
    $default_image = trim(get_option('bdd_default_image', ''));

    $args = [
        'post_type'      => 'download_item',
        'posts_per_page' => intval($limit),
        'tax_query'      => [],
    ];

    if (!empty($category)) {
        $args['tax_query'][] = [
            'taxonomy' => 'download_cat',
            'field'    => 'slug',
            'terms'    => explode(',', $category),
        ];
    }

    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        return '<p>No downloads found.</p>';
    }

    // Assets
    wp_enqueue_style('bdd-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', [], '5.3.2');
    wp_enqueue_style('bdd-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', [], '6.5.2');

    $col_class = 'col-md-' . (12 / max(1, intval($columns)));

    ob_start(); ?>
    <style>
        .bdd-card-body { display:flex; flex-direction:column; }
        .bdd-section-divider { width:75%; margin:0.75rem auto; border:0; border-top:1px solid var(--bdd-divider-color, #cccccc); align-self:center; }
        .bdd-image-divider-wrapper { position: relative; text-align:center; margin: 0; padding: 0px 0 30px; border-top: 10px solid var(--bdd-divider-color, #cccccc); }
        .bdd-image-divider-line { border: none; border-top: 10px solid #ccc; margin: 0 auto; width: 100%; }
        .bdd-image-divider-icon { position: absolute; top: 0; left: 50%; transform: translate(-50%, -50%); width: 56px; height: 56px; border-radius: 50%; display: flex; justify-content: center; align-items: center; background: var(--bdd-divider-color, #fff)!important; z-index: 3; font-size: x-large; }
    </style>

    <div class="container my-4">
        <div class="row g-4">
            <?php while ($query->have_posts()) : $query->the_post();
                $post_id = get_the_ID();
                $file_url = get_post_meta($post_id, '_bdd_file_url', true);
                $icon_class = get_post_meta($post_id, '_bdd_icon_class', true);

                $content = wp_strip_all_tags(get_the_content());
                if (strlen($content) > $desc_length) {
                    $content = substr($content, 0, $desc_length) . '...';
                }

                $image_url = '';
                if (has_post_thumbnail()) {
                    $image_url = get_the_post_thumbnail_url($post_id, 'medium');
                } elseif (!empty($default_image)) {
                    $image_url = esc_url($default_image);
                } else {
                    $image_url = 'https://via.placeholder.com/800x500?text=Download';
                }
                ?>
                <div class="<?php echo esc_attr($col_class); ?>">
                    <div class="card h-100 shadow-sm"
                         style="border:2px solid <?php echo esc_attr($border_color); ?>;
                                background-color:<?php echo esc_attr($bg_color); ?>;">
                        
                        <?php if ($image_url): ?>
                            <img src="<?php echo esc_url($image_url); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>

                        <div class="bdd-image-divider-wrapper" style="--bdd-divider-color:<?php echo esc_attr($divider_color); ?>;">
                            <hr class="bdd-image-divider-line" style="border-top:1px solid <?php echo esc_attr($divider_color); ?>;">
                            <?php if (!empty($icon_class)): ?>
                                <span class="bdd-image-divider-icon" style="background-color:<?php echo esc_attr($bg_color); ?>;">
                                    <i class="<?php echo esc_attr($icon_class); ?>" style="color:<?php echo esc_attr($bg_color); ?>;"></i>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body bdd-card-body"
                             style="color:<?php echo esc_attr($text_color); ?>; --bdd-divider-color:<?php echo esc_attr($divider_color); ?>;">
                            
                            <h5 class="card-title text-center mb-2"><?php the_title(); ?></h5>
                            <hr class="bdd-section-divider">

                            <?php if (!empty($content)): ?>
                                <p class="small text-center flex-grow-1 mb-3"><?php echo esc_html($content); ?></p>
                                <hr class="bdd-section-divider">
                            <?php endif; ?>

                            <?php if (!empty($file_url)): ?>
                                <a href="<?php echo esc_url($file_url); ?>"
                                   class="btn w-100 mt-auto"
                                   download
                                   target="_blank"
                                   style="background-color:<?php echo esc_attr($button_color); ?>; color:#fff;">
                                    <?php echo wp_kses_post($button_content); ?>
                                </a>
                            <?php else: ?>
                                <button class="btn w-100 mt-auto" disabled style="background-color:#ccc; color:#fff;">File Not Available</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

/**
 * --------------------------------------------------------
 * 6. ELEMENTOR WIDGET REGISTER
 * --------------------------------------------------------
 */
function bdd_register_elementor_widget($widgets_manager) {
    require_once BDD_PLUGIN_DIR . 'includes/class-bdd-elementor-widget.php';
    $widgets_manager->register(new \BDD_Elementor_Widget());
}
add_action('elementor/widgets/register', 'bdd_register_elementor_widget');