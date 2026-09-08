<?php
/**
 * Plugin Name: Bambroo Custom Plugin
 * Plugin URI: https://github.com/mojirt37/refactored-octo-waddle
 * Description: پلاگین سفارشی برای فروشگاه بامبرو - افزودن ویژگی‌های اختصاصی مانند فیلترهای پیشرفته و مشاوره رنگ.
 * Version: 1.0.0
 * Author: Moji Moji
 * Author URI: https://github.com/mojirt37
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: bambroo-custom-plugin
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

// تعریف ثابت‌ها
define('BAMBROO_PLUGIN_VERSION', '1.0.0');
define('BAMBROO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BAMBROO_PLUGIN_URL', plugin_dir_url(__FILE__));

// فعال‌سازی پلاگین
function bambroo_custom_plugin_activate() {
    // ایجاد صفحات سفارشی هنگام فعال‌سازی
    bambroo_create_custom_pages();
    
    // فلاش کردن قوانین بازنویسی
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'bambroo_custom_plugin_activate');

// غیرفعال‌سازی پلاگین
function bambroo_custom_plugin_deactivate() {
    // فلاش کردن قوانین بازنویسی
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'bambroo_custom_plugin_deactivate');

// ایجاد صفحات سفارشی
function bambroo_create_custom_pages() {
    $pages = array(
        'consultation' => array(
            'title' => 'مشاوره رنگ',
            'content' => '[bambroo_color_consultation]',
        ),
        'about-us' => array(
            'title' => 'درباره ما',
            'content' => '<p>بامبرو با سال‌ها تجربه در زمینه فروش رنگ و محصولات ساختمانی، آماده ارائه بهترین خدمات به شما مشتریان عزیز است.</p>',
        ),
    );

    foreach ($pages as $slug => $page) {
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            wp_insert_post(array(
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_name' => $slug,
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_author' => 1,
            ));
        }
    }
}

// ثبت شورت‌کد برای مشاوره رنگ
function bambroo_color_consultation_shortcode() {
    ob_start();
    ?>
    <div class="color-consultation">
        <h2>مشاوره رنگ</h2>
        <p>برای دریافت مشاوره رایگان در مورد انتخاب رنگ، فرم زیر را تکمیل کنید.</p>
        <form id="color-consultation-form" method="post" action="">
            <label for="name">نام و نام خانوادگی:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">ایمیل:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">تلفن:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="message">پیام:</label>
            <textarea id="message" name="message" required></textarea>

            <input type="submit" value="ارسال درخواست">
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('bambroo_color_consultation', 'bambroo_color_consultation_shortcode');

// ثبت فیلترهای سفارشی برای WooCommerce
function bambroo_add_custom_product_filters() {
    if (is_woocommerce()) {
        // فیلتر بر اساس نوع محصول
        add_action('woocommerce_product_query', 'bambroo_filter_products_by_type');
    }
}
add_action('init', 'bambroo_add_custom_product_filters');

// فیلتر محصولات بر اساس نوع
function bambroo_filter_products_by_type($q) {
    if (isset($_GET['product_type']) && !empty($_GET['product_type'])) {
        $meta_query = $q->get('meta_query');
        if (!is_array($meta_query)) {
            $meta_query = array();
        }
        $meta_query[] = array(
            'key' => '_product_type',
            'value' => sanitize_text_field($_GET['product_type']),
            'compare' => 'LIKE',
        );
        $q->set('meta_query', $meta_query);
    }
}

// افزودن فیلدهای سفارشی به محصولات
function bambroo_add_custom_product_fields() {
    woocommerce_wp_text_input(array(
        'id' => '_product_color_code',
        'label' => 'کد رنگ',
        'placeholder' => 'مثال: #FFFFFF',
        'desc_tip' => true,
        'description' => 'کد رنگ محصول را وارد کنید.',
    ));
}
add_action('woocommerce_product_options_general_product_data', 'bambroo_add_custom_product_fields');

// ذخیره فیلدهای سفارشی محصولات
function bambroo_save_custom_product_fields($post_id) {
    $product_color_code = isset($_POST['_product_color_code']) ? sanitize_text_field($_POST['_product_color_code']) : '';
    update_post_meta($post_id, '_product_color_code', $product_color_code);
}
add_action('woocommerce_process_product_meta', 'bambroo_save_custom_product_fields');

// نمایش فیلدهای سفارشی در صفحه محصول
function bambroo_display_custom_product_fields() {
    global $product;
    $color_code = get_post_meta($product->get_id(), '_product_color_code', true);
    if (!empty($color_code)) {
        echo '<p><strong>کد رنگ:</strong> ' . esc_html($color_code) . '</p>';
    }
}
add_action('woocommerce_product_meta_end', 'bambroo_display_custom_product_fields');
