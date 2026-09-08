<?php
/**
 * Bambroo Theme Functions
 *
 * @package Bambroo
 */

// تعریف ثابت‌ها
define('BAMBROO_VERSION', '1.0.0');

// فعال‌سازی پشتیبانی از ویژگی‌های تم
function bambroo_setup() {
    // پشتیبانی از عنوان سایت
    add_theme_support('title-tag');

    // پشتیبانی از لوگو
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // ثبت منوهای ناوبری
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'bambroo'),
        'footer' => __('منوی پاورقی', 'bambroo'),
    ));

    // پشتیبانی از تصویر شاخص
    add_theme_support('post-thumbnails');

    // پشتیبانی از RTL
    add_theme_support('rtl');

    // پشتیبانی از WooCommerce
    add_theme_support('woocommerce');

    // پشتیبانی از فیدها
    add_theme_support('automatic-feed-links');

    // پشتیبانی از HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'bambroo_setup');

// ثبت فایل‌های CSS و JS
function bambroo_scripts() {
    // ثبت فایل CSS اصلی
    wp_enqueue_style('bambroo-style', get_stylesheet_uri(), array(), BAMBROO_VERSION);

    // ثبت فایل JS اصلی
    wp_enqueue_script('bambroo-script', get_template_directory_uri() . '/js/main.js', array('jquery'), BAMBROO_VERSION, true);

    // ثبت فونت فارسی
    wp_enqueue_style('bambroo-font', get_template_directory_uri() . '/fonts/IRANSans.css', array(), BAMBROO_VERSION);
}
add_action('wp_enqueue_scripts', 'bambroo_scripts');

// ثبت سایزهای تصویر سفارشی
function bambroo_image_sizes() {
    add_image_size('bambroo-product-thumbnail', 300, 300, true);
    add_image_size('bambroo-product-large', 800, 800, true);
}
add_action('after_setup_theme', 'bambroo_image_sizes');

// تغییر جهت‌دار بودن WooCommerce به RTL
function bambroo_woocommerce_rtl() {
    if (is_rtl()) {
        wp_enqueue_style('woocommerce-rtl', get_template_directory_uri() . '/css/woocommerce-rtl.css', array('woocommerce-general'), BAMBROO_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'bambroo_woocommerce_rtl');

// تغییر متن‌های پیش‌فرض WooCommerce به فارسی
function bambroo_woocommerce_persian_text($translated_text, $text, $domain) {
    if ($domain === 'woocommerce') {
        switch ($translated_text) {
            case 'Add to cart':
                $translated_text = 'افزودن به سبد خرید';
                break;
            case 'Shop':
                $translated_text = 'فروشگاه';
                break;
            case 'Cart':
                $translated_text = 'سبد خرید';
                break;
        }
    }
    return $translated_text;
}
add_filter('gettext', 'bambroo_woocommerce_persian_text', 20, 3);
