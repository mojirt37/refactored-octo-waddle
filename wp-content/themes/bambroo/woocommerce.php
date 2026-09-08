<?php
/**
 * WooCommerce Template Overrides for Bambroo Theme
 *
 * @package Bambroo
 */

// بررسی فعال بودن WooCommerce
if (!class_exists('WooCommerce')) {
    return;
}

// حذف استایل‌های پیش‌فرض WooCommerce
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// اضافه کردن استایل‌های سفارشی WooCommerce
function bambroo_woocommerce_styles() {
    wp_enqueue_style('bambroo-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), BAMBROO_VERSION);
    
    // استایل‌های RTL برای WooCommerce
    if (is_rtl()) {
        wp_enqueue_style('bambroo-woocommerce-rtl', get_template_directory_uri() . '/css/woocommerce-rtl.css', array(), BAMBROO_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'bambroo_woocommerce_styles');

// تغییر متن‌های WooCommerce به فارسی
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
            case 'Checkout':
                $translated_text = 'تسویه حساب';
                break;
            case 'My Account':
                $translated_text = 'حساب کاربری';
                break;
            case 'Related products':
                $translated_text = 'محصولات مرتبط';
                break;
            case 'Description':
                $translated_text = 'توضیحات';
                break;
            case 'Additional information':
                $translated_text = 'اطلاعات بیشتر';
                break;
            case 'Reviews':
                $translated_text = 'نظرات';
                break;
            case 'Search':
                $translated_text = 'جستجو';
                break;
            case 'Categories':
                $translated_text = 'دسته‌بندی‌ها';
                break;
            case 'Filter by price':
                $translated_text = 'فیلتر بر اساس قیمت';
                break;
        }
    }
    return $translated_text;
}
add_filter('gettext', 'bambroo_woocommerce_persian_text', 20, 3);

// تغییر جهت‌دار بودن WooCommerce به RTL
function bambroo_woocommerce_rtl_support() {
    if (is_rtl()) {
        add_filter('woocommerce_dir', function() {
            return 'rtl';
        });
    }
}
add_action('init', 'bambroo_woocommerce_rtl_support');

// سفارشی‌سازی صفحه فروشگاه
function bambroo_woocommerce_before_main_content() {
    echo '<div class="woocommerce-container">';
}
add_action('woocommerce_before_main_content', 'bambroo_woocommerce_before_main_content', 10);

function bambroo_woocommerce_after_main_content() {
    echo '</div>';
}
add_action('woocommerce_after_main_content', 'bambroo_woocommerce_after_main_content', 10);

// سفارشی‌سازی صفحه محصول
function bambroo_woocommerce_before_single_product() {
    echo '<div class="single-product-container">';
}
add_action('woocommerce_before_single_product', 'bambroo_woocommerce_before_single_product', 10);

function bambroo_woocommerce_after_single_product() {
    echo '</div>';
}
add_action('woocommerce_after_single_product', 'bambroo_woocommerce_after_single_product', 10);

// سفارشی‌سازی سبد خرید
function bambroo_woocommerce_before_cart() {
    echo '<div class="cart-container">';
}
add_action('woocommerce_before_cart', 'bambroo_woocommerce_before_cart', 10);

function bambroo_woocommerce_after_cart() {
    echo '</div>';
}
add_action('woocommerce_after_cart', 'bambroo_woocommerce_after_cart', 10);

// سفارشی‌سازی صفحه پرداخت
function bambroo_woocommerce_before_checkout_form() {
    echo '<div class="checkout-container">';
}
add_action('woocommerce_before_checkout_form', 'bambroo_woocommerce_before_checkout_form', 10);

function bambroo_woocommerce_after_checkout_form() {
    echo '</div>';
}
add_action('woocommerce_after_checkout_form', 'bambroo_woocommerce_after_checkout_form', 10);

// افزودن فیلترهای سفارشی به صفحه فروشگاه
function bambroo_woocommerce_before_shop_loop() {
    echo '<div class="woocommerce-filters">';
    
    // فیلتر بر اساس دسته‌بندی
    echo '<div class="filter-by-category">';
    echo '<h3>دسته‌بندی‌ها</h3>';
    echo '<ul>';
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ));
    foreach ($categories as $category) {
        echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
    }
    echo '</ul>';
    echo '</div>';
    
    // فیلتر بر اساس برچسب
    echo '<div class="filter-by-tag">';
    echo '<h3>برچسب‌ها</h3>';
    echo '<ul>';
    $tags = get_terms(array(
        'taxonomy' => 'product_tag',
        'hide_empty' => true,
    ));
    foreach ($tags as $tag) {
        echo '<li><a href="' . esc_url(get_term_link($tag)) . '">' . esc_html($tag->name) . '</a></li>';
    }
    echo '</ul>';
    echo '</div>';
    
    echo '</div>';
}
add_action('woocommerce_before_shop_loop', 'bambroo_woocommerce_before_shop_loop', 20);

// سفارشی‌سازی کارت محصول
function bambroo_woocommerce_before_shop_loop_item() {
    echo '<div class="product-card">';
}
add_action('woocommerce_before_shop_loop_item', 'bambroo_woocommerce_before_shop_loop_item', 10);

function bambroo_woocommerce_after_shop_loop_item() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'bambroo_woocommerce_after_shop_loop_item', 10);

// نمایش کد رنگ در صفحه محصول
function bambroo_display_product_color_code() {
    global $product;
    $color_code = get_post_meta($product->get_id(), '_product_color_code', true);
    if (!empty($color_code)) {
        echo '<div class="product-color-code"><strong>کد رنگ:</strong> <span style="color: ' . esc_attr($color_code) . ';">' . esc_html($color_code) . '</span></div>';
    }
}
add_action('woocommerce_product_meta_end', 'bambroo_display_product_color_code', 10);
