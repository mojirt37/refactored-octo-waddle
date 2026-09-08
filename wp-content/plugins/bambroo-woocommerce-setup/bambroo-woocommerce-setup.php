<?php
/**
 * Plugin Name: Bambroo WooCommerce Setup
 * Plugin URI: https://github.com/mojirt37/refactored-octo-waddle
 * Description: پلاگین تنظیمات WooCommerce برای فروشگاه بامبرو - تنظیمات پایه، دسته‌بندی‌ها، محصولات نمونه، و درگاه‌های پرداخت.
 * Version: 1.0.0
 * Author: Moji Moji
 * Author URI: https://github.com/mojirt37
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: bambroo-woocommerce-setup
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

// تعریف ثابت‌ها
define('BAMBROO_WC_SETUP_VERSION', '1.0.0');

// فعال‌سازی پلاگین
function bambroo_wc_setup_activate() {
    // بررسی فعال بودن WooCommerce
    if (!class_exists('WooCommerce')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(__('این پلاگین به WooCommerce نیاز دارد. لطفاً ابتدا WooCommerce را نصب و فعال کنید.', 'bambroo-woocommerce-setup'));
    }

    // ایجاد دسته‌بندی‌ها و برچسب‌ها
    bambroo_create_product_categories();
    bambroo_create_product_tags();

    // ایجاد محصولات نمونه
    bambroo_create_sample_products();

    // تنظیمات پایه WooCommerce
    bambroo_configure_woocommerce();

    // فلاش کردن قوانین بازنویسی
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'bambroo_wc_setup_activate');

// غیرفعال‌سازی پلاگین
function bambroo_wc_setup_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'bambroo_wc_setup_deactivate');

// ایجاد دسته‌بندی‌های محصول
function bambroo_create_product_categories() {
    $categories = array(
        'رنگ ساختمانی' => array(
            'description' => 'رنگ‌های ساختمانی با کیفیت بالا',
        ),
        'پوشش‌ها' => array(
            'description' => 'پوشش‌های محافظ برای دیوارها و سقف‌ها',
        ),
        'زیرسازی' => array(
            'description' => 'مواد زیرسازی برای آماده‌سازی سطوح',
        ),
        'عایق/محافظ' => array(
            'description' => 'عایق‌ها و مواد محافظ برای ساختمان',
        ),
        'ابزار' => array(
            'description' => 'ابزارهای لازم برای نقاشی و ساختمانی',
        ),
    );

    foreach ($categories as $name => $args) {
        if (!term_exists($name, 'product_cat')) {
            wp_insert_term($name, 'product_cat', $args);
        }
    }
}

// ایجاد برچسب‌های محصول
function bambroo_create_product_tags() {
    $tags = array(
        'پرفروش',
        'تخفیف',
        'جدید',
        'مخصوص نقاشان',
        'مقاوم در برابر رطوبت',
    );

    foreach ($tags as $name) {
        if (!term_exists($name, 'product_tag')) {
            wp_insert_term($name, 'product_tag');
        }
    }
}

// ایجاد محصولات نمونه
function bambroo_create_sample_products() {
    $products = array(
        array(
            'name' => 'رنگ دیواری سفید مات',
            'description' => 'رنگ دیواری سفید مات با کیفیت بالا برای استفاده در داخلی ساختمان.',
            'price' => 250000,
            'category' => 'رنگ ساختمانی',
            'tags' => array('پرفروش', 'مخصوص نقاشان'),
            'image_url' => 'https://example.com/wp-content/uploads/white-paint.jpg',
            'color_code' => '#FFFFFF',
        ),
        array(
            'name' => 'پوشش ضد آب',
            'description' => 'پوشش ضد آب برای حفاظت از دیوارها در برابر رطوبت.',
            'price' => 350000,
            'category' => 'پوشش‌ها',
            'tags' => array('مقاوم در برابر رطوبت', 'جدید'),
            'image_url' => 'https://example.com/wp-content/uploads/waterproof-coating.jpg',
        ),
        array(
            'name' => 'چسب زیرسازی',
            'description' => 'چسب زیرسازی برای آماده‌سازی سطوح قبل از رنگ‌آمیزی.',
            'price' => 180000,
            'category' => 'زیرسازی',
            'tags' => array('پرفروش'),
            'image_url' => 'https://example.com/wp-content/uploads/primer-glue.jpg',
        ),
        array(
            'name' => 'عایق حرارتی',
            'description' => 'عایق حرارتی برای بهبود کارایی انرژی ساختمان.',
            'price' => 450000,
            'category' => 'عایق/محافظ',
            'tags' => array('جدید'),
            'image_url' => 'https://example.com/wp-content/uploads/thermal-insulation.jpg',
        ),
        array(
            'name' => 'غلتک نقاشی',
            'description' => 'غلتک نقاشی با کیفیت برای استفاده حرفه‌ای.',
            'price' => 80000,
            'category' => 'ابزار',
            'tags' => array('مخصوص نقاشان'),
            'image_url' => 'https://example.com/wp-content/uploads/paint-roller.jpg',
        ),
    );

    foreach ($products as $product) {
        // بررسی وجود محصول
        $existing_product = get_page_by_title($product['name'], OBJECT, 'product');
        if ($existing_product) {
            continue;
        }

        // ایجاد محصول
        $product_id = wp_insert_post(array(
            'post_title' => $product['name'],
            'post_content' => $product['description'],
            'post_status' => 'publish',
            'post_type' => 'product',
        ));

        // تنظیم نوع محصول به ساده
        wp_set_object_terms($product_id, 'simple', 'product_type');

        // تنظیم قیمت
        update_post_meta($product_id, '_regular_price', $product['price']);
        update_post_meta($product_id, '_price', $product['price']);

        // تنظیم دسته‌بندی
        $category = get_term_by('name', $product['category'], 'product_cat');
        if ($category) {
            wp_set_object_terms($product_id, $category->term_id, 'product_cat');
        }

        // تنظیم برچسب‌ها
        $tags = array();
        foreach ($product['tags'] as $tag) {
            $tag_obj = get_term_by('name', $tag, 'product_tag');
            if ($tag_obj) {
                $tags[] = $tag_obj->term_id;
            }
        }
        if (!empty($tags)) {
            wp_set_object_terms($product_id, $tags, 'product_tag');
        }

        // تنظیم کد رنگ
        if (isset($product['color_code'])) {
            update_post_meta($product_id, '_product_color_code', $product['color_code']);
        }

        // افزودن تصویر محصول (اگر URL تصویر معتبر باشد)
        if (isset($product['image_url'])) {
            bambroo_add_product_image($product_id, $product['image_url']);
        }
    }
}

// افزودن تصویر به محصول
function bambroo_add_product_image($product_id, $image_url) {
    media_sideload_image($image_url, $product_id, '', 'id');
    $attachment_id = media_sideload_image($image_url, $product_id, '', 'id');
    if (!is_wp_error($attachment_id)) {
        set_post_thumbnail($product_id, $attachment_id);
    }
}

// تنظیمات پایه WooCommerce
function bambroo_configure_woocommerce() {
    // تنظیمات عمومی
    update_option('woocommerce_currency', 'IRR');
    update_option('woocommerce_currency_pos', 'right_space');
    update_option('woocommerce_price_thousand_sep', ',');
    update_option('woocommerce_price_decimal_sep', '/');
    update_option('woocommerce_price_num_decimals', '0');

    // تنظیمات صفحه فروشگاه
    update_option('woocommerce_shop_page_id', get_page_by_path('shop')->ID);
    update_option('woocommerce_cart_page_id', get_page_by_path('cart')->ID);
    update_option('woocommerce_checkout_page_id', get_page_by_path('checkout')->ID);
    update_option('woocommerce_myaccount_page_id', get_page_by_path('my-account')->ID);

    // تنظیمات پرداخت
    update_option('woocommerce_enable_guest_checkout', 'no');
    update_option('woocommerce_enable_checkout_login_reminder', 'yes');

    // تنظیمات ارسال
    update_option('woocommerce_ship_to_countries', array('IR'));
    update_option('woocommerce_default_country', 'IR');

    // تنظیمات نمایش
    update_option('woocommerce_product_image_width', 800);
    update_option('woocommerce_product_image_height', 800);
    update_option('woocommerce_thumbnail_image_width', 300);
    update_option('woocommerce_thumbnail_image_height', 300);
    update_option('woocommerce_catalog_image_width', 500);
    update_option('woocommerce_catalog_image_height', 500);

    // تنظیمات RTL
    update_option('woocommerce_enable_rtl', 'yes');
}
