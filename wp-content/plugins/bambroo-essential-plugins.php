<?php
/**
 * Plugin Name: Bambroo Essential Plugins
 * Plugin URI: https://github.com/mojirt37/refactored-octo-waddle
 * Description: پلاگین برای نصب و فعال‌سازی خودکار پلاگین‌های ضروری برای فروشگاه بامبرو.
 * Version: 1.0.0
 * Author: Moji Moji
 * Author URI: https://github.com/mojirt37
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: bambroo-essential-plugins
 */

// جلوگیری از دسترسی مستقیم به فایل
if (!defined('ABSPATH')) {
    exit;
}

// لیست پلاگین‌های ضروری
function bambroo_get_essential_plugins() {
    return array(
        // WooCommerce
        array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'required' => true,
        ),
        // YITH WooCommerce Wishlist
        array(
            'name' => 'YITH WooCommerce Wishlist',
            'slug' => 'yith-woocommerce-wishlist',
            'required' => true,
        ),
        // WooCommerce Zarinpal Gateway
        array(
            'name' => 'WooCommerce Zarinpal Gateway',
            'slug' => 'woocommerce-zarinpal',
            'source' => 'https://github.com/mohammad-azadi/woocommerce-zarinpal/archive/refs/heads/master.zip',
            'required' => true,
        ),
        // Autoptimize
        array(
            'name' => 'Autoptimize',
            'slug' => 'autoptimize',
            'required' => true,
        ),
        // WP Super Cache
        array(
            'name' => 'WP Super Cache',
            'slug' => 'wp-super-cache',
            'required' => true,
        ),
        // Rank Math SEO
        array(
            'name' => 'Rank Math SEO',
            'slug' => 'seo-by-rank-math',
            'required' => true,
        ),
        // Wordfence Security
        array(
            'name' => 'Wordfence Security',
            'slug' => 'wordfence',
            'required' => true,
        ),
        // Contact Form 7
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => false,
        ),
    );
}

// نصب و فعال‌سازی خودکار پلاگین‌ها
function bambroo_install_essential_plugins() {
    $plugins = bambroo_get_essential_plugins();
    
    foreach ($plugins as $plugin) {
        $plugin_path = WP_PLUGIN_DIR . '/' . $plugin['slug'] . '/index.php';
        
        // بررسی اینکه آیا پلاگین نصب است
        if (!file_exists($plugin_path)) {
            // نصب پلاگین
            if (isset($plugin['source'])) {
                // نصب از منبع سفارشی
                $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
                $upgrader->install($plugin['source']);
            } else {
                // نصب از مخزن WordPress
                include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
                include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
                
                $api = plugins_api('plugin_information', array('slug' => $plugin['slug'], 'fields' => array('sections' => false)));
                
                if (!is_wp_error($api)) {
                    $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
                    $upgrader->install($api->download_link);
                }
            }
        }
        
        // فعال‌سازی پلاگین
        if (file_exists($plugin_path)) {
            activate_plugin($plugin_path);
        }
    }
}

// فعال‌سازی پلاگین‌ها پس از نصب WordPress
function bambroo_activate_essential_plugins() {
    if (current_user_can('activate_plugins')) {
        bambroo_install_essential_plugins();
    }
}

// اضافه کردن منوی تنظیمات پلاگین‌ها
function bambroo_add_essential_plugins_page() {
    add_submenu_page(
        'options-general.php',
        'پلاگین‌های ضروری بامبرو',
        'پلاگین‌های ضروری',
        'manage_options',
        'bambroo-essential-plugins',
        'bambroo_essential_plugins_page_html'
    );
}
add_action('admin_menu', 'bambroo_add_essential_plugins_page');

// صفحه تنظیمات پلاگین‌ها
function bambroo_essential_plugins_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $plugins = bambroo_get_essential_plugins();
    
    echo '<div class="wrap">';
    echo '<h1>پلاگین‌های ضروری بامبرو</h1>';
    echo '<p>این صفحه برای مدیریت پلاگین‌های ضروری برای فروشگاه بامبرو است.</p>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>نام پلاگین</th><th>وضعیت</th><th>عملیات</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($plugins as $plugin) {
        $plugin_path = WP_PLUGIN_DIR . '/' . $plugin['slug'] . '/index.php';
        $is_active = is_plugin_active($plugin['slug'] . '/index.php');
        $is_installed = file_exists($plugin_path);
        
        echo '<tr>';
        echo '<td>' . esc_html($plugin['name']) . '</td>';
        echo '<td>' . ($is_active ? 'فعال' : ($is_installed ? 'نصب شده' : 'نصب نشده')) . '</td>';
        echo '<td>';
        if ($is_active) {
            echo '<a href="' . wp_nonce_url(admin_url('plugins.php?action=deactivate&plugin=' . $plugin['slug'] . '/index.php'), 'deactivate-plugin_' . $plugin['slug'] . '/index.php') . '" class="button button-secondary">غیرفعال کردن</a>';
        } elseif ($is_installed) {
            echo '<a href="' . wp_nonce_url(admin_url('plugins.php?action=activate&plugin=' . $plugin['slug'] . '/index.php'), 'activate-plugin_' . $plugin['slug'] . '/index.php') . '" class="button button-primary">فعال کردن</a>';
        } else {
            echo '<a href="' . wp_nonce_url(admin_url('admin.php?page=bambroo-essential-plugins&action=install&plugin=' . $plugin['slug']), 'install-plugin_' . $plugin['slug']) . '" class="button button-primary">نصب و فعال کردن</a>';
        }
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// نصب پلاگین‌ها هنگام فعال‌سازی این پلاگین
register_activation_hook(__FILE__, 'bambroo_activate_essential_plugins');
