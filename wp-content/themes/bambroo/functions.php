<?php
/**
 * Bambroo Theme Functions
 *
 * @package Bambroo
 */

// Define theme constants
define('BAMBROO_VERSION', '1.0.0');
define('BAMBROO_THEME_DIR', get_template_directory_uri());
define('BAMBROO_THEME_PATH', get_template_directory());

// Security: Hide WordPress version
remove_action('wp_head', 'wp_generator');

// Disable file editing from WordPress admin
define('DISALLOW_FILE_EDIT', true);

// Disable file modifications
define('DISALLOW_FILE_MODS', true);

// ===== THEME SETUP =====
function bambroo_setup() {
    // Text domain for translations
    load_theme_textdomain('bambroo', BAMBROO_THEME_PATH . '/languages');

    // Title tag support
    add_theme_support('title-tag');

    // Custom logo support
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'bambroo'),
        'footer' => __('منوی پاورقی', 'bambroo'),
    ));

    // Post thumbnail support
    add_theme_support('post-thumbnails');

    // Custom image sizes
    add_image_size('bambroo-thumbnail', 300, 300, true);
    add_image_size('bambroo-medium', 600, 400, true);
    add_image_size('bambroo-large', 1200, 800, true);

    // RTL support
    add_theme_support('rtl');

    // WooCommerce support
    add_theme_support('woocommerce');

    // HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Automatic feed links
    add_theme_support('automatic-feed-links');

    // Custom header support
    add_theme_support('custom-header', array(
        'default-image' => BAMBROO_THEME_DIR . '/images/header-bg.jpg',
        'width' => 1920,
        'height' => 600,
        'flex-height' => true,
    ));

    // Custom background support
    add_theme_support('custom-background', array(
        'default-color' => '#f5f5f5',
    ));
}
add_action('after_setup_theme', 'bambroo_setup');

// ===== ENQUEUE STYLES AND SCRIPTS =====
function bambroo_scripts() {
    // Load IRANSans font from CDN
    wp_enqueue_style('bambroo-font', 'https://cdn.font-store.ir/IRANSans.css', array(), BAMBROO_VERSION);

    // Load Font Awesome from CDN
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Load design tokens
    wp_enqueue_style('bambroo-variables', BAMBROO_THEME_DIR . '/css/variables.css', array(), BAMBROO_VERSION);

    // Load main stylesheet
    wp_enqueue_style('bambroo-style', get_stylesheet_uri(), array('bambroo-variables'), BAMBROO_VERSION);

    // Load WooCommerce styles
    wp_enqueue_style('bambroo-woocommerce', BAMBROO_THEME_DIR . '/css/woocommerce.css', array('bambroo-style'), BAMBROO_VERSION);

    // Load RTL styles if needed
    if (is_rtl()) {
        wp_enqueue_style('bambroo-woocommerce-rtl', BAMBROO_THEME_DIR . '/css/woocommerce-rtl.css', array('bambroo-woocommerce'), BAMBROO_VERSION);
    }

    // Load main script
    wp_enqueue_script('bambroo-script', BAMBROO_THEME_DIR . '/js/main.js', array('jquery'), BAMBROO_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('bambroo-script', 'bambroo_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bambroo_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'bambroo_scripts');

// ===== WOOCOMMERCE CUSTOMIZATIONS =====

// Change WooCommerce texts to Persian
function bambroo_woocommerce_persian_text($translated_text, $text, $domain) {
    if ($domain === 'woocommerce') {
        $translations = array(
            'Add to cart' => 'افزودن به سبد خرید',
            'Shop' => 'فروشگاه',
            'Cart' => 'سبد خرید',
            'Checkout' => 'تسویه حساب',
            'My Account' => 'حساب کاربری',
            'Related products' => 'محصولات مرتبط',
            'Description' => 'توضیحات',
            'Additional information' => 'اطلاعات بیشتر',
            'Reviews' => 'نظرات',
            'Search' => 'جستجو',
            'Categories' => 'دسته‌بندی‌ها',
            'Filter by price' => 'فیلتر بر اساس قیمت',
            'Price: Low to High' => 'قیمت: ارزان به گران',
            'Price: High to Low' => 'قیمت: گران به ارزان',
            'Sort by popularity' => 'مرتب‌سازی بر اساس محبوبیت',
            'Sort by average rating' => 'مرتب‌سازی بر اساس امتیاز',
            'Sort by newness' => 'مرتب‌سازی بر اساس جدیدترین',
            'Sort by price: low to high' => 'مرتب‌سازی بر اساس قیمت: ارزان به گران',
            'Sort by price: high to low' => 'مرتب‌سازی بر اساس قیمت: گران به ارزان',
            'In stock' => 'موجود',
            'Out of stock' => 'اتمام موجودی',
            'Add to wishlist' => 'افزودن به لیست علاقه‌مندی',
            'Remove from wishlist' => 'حذف از لیست علاقه‌مندی',
            'Your wishlist' => 'لیست علاقه‌مندی شما',
            'No products in the wishlist' => 'هیچ محصولی در لیست علاقه‌مندی وجود ندارد',
            'Proceed to checkout' => 'ادامه به تسویه حساب',
            'Update cart' => 'به‌روزرسانی سبد خرید',
            'Cart totals' => 'جمع سبد خرید',
            'Subtotal' => 'جمع جزئی',
            'Total' => 'جمع کل',
            'Shipping' => 'هزینه ارسال',
            'Free shipping' => 'ارسال رایگان',
            'Billing details' => 'جزئیات فاکتور',
            'Shipping details' => 'جزئیات ارسال',
            'Payment method' => 'روش پرداخت',
            'Order notes' => 'یادداشت‌های سفارش',
            'Place order' => 'ثبت سفارش',
            'Your order' => 'سفارش شما',
            'Product' => 'محصول',
            'Quantity' => 'تعداد',
            'Price' => 'قیمت',
            'Remove' => 'حذف',
            'Apply coupon' => 'اعمال کوپن',
            'Coupon code' => 'کد کوپن',
            'Enter your coupon code if you have one' => 'اگر کد کوپن دارید، وارد کنید',
            'Coupon has been applied successfully' => 'کوپن با موفقیت اعمال شد',
            'Sorry, this coupon does not exist' => 'متأسفانه این کوپن وجود ندارد',
            'Please enter a coupon code' => 'لطفاً کد کوپن وارد کنید',
        );

        if (isset($translations[$translated_text])) {
            return $translations[$translated_text];
        }
    }
    return $translated_text;
}
add_filter('gettext', 'bambroo_woocommerce_persian_text', 20, 3);

// RTL support for WooCommerce
function bambroo_woocommerce_rtl_support() {
    if (is_rtl()) {
        add_filter('woocommerce_dir', function() {
            return 'rtl';
        });
    }
}
add_action('init', 'bambroo_woocommerce_rtl_support');

// Add body classes
function bambroo_body_classes($classes) {
    $classes[] = 'rtl';
    if (is_woocommerce()) {
        $classes[] = 'woocommerce-page';
    }
    return $classes;
}
add_filter('body_class', 'bambroo_body_classes');

// Custom product fields
function bambroo_add_custom_product_fields() {
    woocommerce_wp_text_input(array(
        'id' => '_product_color_code',
        'label' => 'کد رنگ',
        'placeholder' => 'مثال: #FFFFFF',
        'desc_tip' => true,
        'description' => 'کد رنگ محصول را وارد کنید.',
    ));

    woocommerce_wp_text_input(array(
        'id' => '_product_brand',
        'label' => 'برند',
        'placeholder' => 'مثال: بامبرو',
        'desc_tip' => true,
        'description' => 'برند محصول را وارد کنید.',
    ));

    woocommerce_wp_textarea_input(array(
        'id' => '_product_additional_info',
        'label' => 'اطلاعات اضافی',
        'placeholder' => 'اطلاعات اضافی محصول را وارد کنید.',
        'desc_tip' => true,
        'description' => 'اطلاعات اضافی در مورد محصول.',
    ));
}
add_action('woocommerce_product_options_general_product_data', 'bambroo_add_custom_product_fields');

// Save custom product fields
function bambroo_save_custom_product_fields($post_id) {
    $product_color_code = isset($_POST['_product_color_code']) ? sanitize_text_field($_POST['_product_color_code']) : '';
    $product_brand = isset($_POST['_product_brand']) ? sanitize_text_field($_POST['_product_brand']) : '';
    $product_additional_info = isset($_POST['_product_additional_info']) ? sanitize_textarea_field($_POST['_product_additional_info']) : '';

    update_post_meta($post_id, '_product_color_code', $product_color_code);
    update_post_meta($post_id, '_product_brand', $product_brand);
    update_post_meta($post_id, '_product_additional_info', $product_additional_info);
}
add_action('woocommerce_process_product_meta', 'bambroo_save_custom_product_fields');

// Display custom product fields
function bambroo_display_custom_product_fields() {
    global $product;

    $color_code = get_post_meta($product->get_id(), '_product_color_code', true);
    $brand = get_post_meta($product->get_id(), '_product_brand', true);
    $additional_info = get_post_meta($product->get_id(), '_product_additional_info', true);

    if (!empty($color_code)) {
        echo '<div class="product-color-code"><strong>کد رنگ:</strong> <span style="background-color: ' . esc_attr($color_code) . '; color: ' . bambroo_get_contrast_color($color_code) . '; padding: 0.25rem 0.5rem; border-radius: 3px;">' . esc_html($color_code) . '</span></div>';
    }

    if (!empty($brand)) {
        echo '<div class="product-brand"><strong>برند:</strong> <span>' . esc_html($brand) . '</span></div>';
    }

    if (!empty($additional_info)) {
        echo '<div class="product-additional-info"><strong>اطلاعات اضافی:</strong> <p>' . wp_kses_post(nl2br($additional_info)) . '</p></div>';
    }
}
add_action('woocommerce_product_meta_end', 'bambroo_display_custom_product_fields', 10);

// Get contrast color for text
function bambroo_get_contrast_color($hex_color) {
    $r = hexdec(substr($hex_color, 1, 2));
    $g = hexdec(substr($hex_color, 3, 2));
    $b = hexdec(substr($hex_color, 5, 2));
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    return ($brightness > 128) ? '#000000' : '#FFFFFF';
}

// Custom product tabs
function bambroo_custom_product_tabs($tabs) {
    global $product;

    $additional_info = get_post_meta($product->get_id(), '_product_additional_info', true);
    if (!empty($additional_info)) {
        $tabs['additional_info'] = array(
            'title' => 'اطلاعات بیشتر',
            'priority' => 50,
            'callback' => 'bambroo_additional_info_tab_content',
        );
    }

    return $tabs;
}
add_filter('woocommerce_product_tabs', 'bambroo_custom_product_tabs');

// Additional info tab content
function bambroo_additional_info_tab_content() {
    global $product;
    $additional_info = get_post_meta($product->get_id(), '_product_additional_info', true);
    echo '<div class="additional-info-content">' . wp_kses_post(nl2br($additional_info)) . '</div>';
}

// ===== CUSTOM SHORTCODES =====

// Color consultation shortcode
function bambroo_color_consultation_shortcode() {
    ob_start();
    ?>
    <div class="color-consultation-form">
        <h2>مشاوره رنگ</h2>
        <p>برای دریافت مشاوره رایگان در مورد انتخاب رنگ، فرم زیر را تکمیل کنید.</p>
        
        <?php
        if (isset($_GET['consultation_success'])) {
            echo '<div class="woocommerce-message">درخواست مشاوره شما با موفقیت ارسال شد!</div>';
        }
        ?>
        
        <form id="color-consultation-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('color_consultation_action', 'color_consultation_nonce'); ?>
            <input type="hidden" name="action" value="color_consultation">
            
            <div class="form-group">
                <label for="consultation-name">نام و نام خانوادگی:</label>
                <input type="text" id="consultation-name" name="name" required aria-required="true">
            </div>

            <div class="form-group">
                <label for="consultation-email">ایمیل:</label>
                <input type="email" id="consultation-email" name="email" required aria-required="true">
            </div>

            <div class="form-group">
                <label for="consultation-phone">تلفن:</label>
                <input type="tel" id="consultation-phone" name="phone" required aria-required="true">
            </div>

            <div class="form-group">
                <label for="consultation-message">پیام:</label>
                <textarea id="consultation-message" name="message" required aria-required="true"></textarea>
            </div>

            <input type="submit" value="ارسال درخواست" class="button">
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('bambroo_color_consultation', 'bambroo_color_consultation_shortcode');

// Process color consultation form
function bambroo_process_color_consultation() {
    if (!isset($_POST['action']) || $_POST['action'] !== 'color_consultation') {
        return;
    }

    if (!isset($_POST['color_consultation_nonce']) || !wp_verify_nonce($_POST['color_consultation_nonce'], 'color_consultation_action')) {
        wp_die('CSRF validation failed.');
    }

    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_die('لطفاً تمام فیلدهای اجباری را پر کنید.');
    }

    $to = get_option('admin_email');
    $subject = 'درخواست مشاوره رنگ جدید - ' . get_bloginfo('name');
    $body = "
        نام و نام خانوادگی: $name
        ایمیل: $email
        تلفن: $phone
        پیام: $message
    ";

    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);

    wp_redirect(add_query_arg('consultation_success', '1', wp_get_referer()));
    exit;
}
add_action('admin_post_color_consultation', 'bambroo_process_color_consultation');
add_action('admin_post_nopriv_color_consultation', 'bambroo_process_color_consultation');

// ===== CUSTOM WOOCOMMERCE FUNCTIONS =====

// Remove WooCommerce default styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Custom WooCommerce breadcrumb
function bambroo_woocommerce_breadcrumb() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter' => ' <i class="fas fa-chevron-left"></i> ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="مسیر ناوبری">',
            'wrap_after' => '</nav>',
        ));
    }
}

// Custom cart fragment
function bambroo_woocommerce_header_add_to_cart_fragment($fragments) {
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'bambroo'); ?>">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'bambroo_woocommerce_header_add_to_cart_fragment');

// Custom product search form
function bambroo_product_search_form($form) {
    $form = '<form role="search" method="get" class="woocommerce-product-search" action="' . esc_url(home_url('/')) . '">';
    $form .= '<label class="screen-reader-text" for="woocommerce-product-search-field-' . esc_attr(uniqid()) . '">' . _x('Search for:', 'label', 'woocommerce') . '</label>';
    $form .= '<input type="search" id="woocommerce-product-search-field-' . esc_attr(uniqid()) . '" class="search-field" placeholder="' . esc_attr__('جستجوی محصولات...', 'bambroo') . '" value="' . get_search_query() . '" name="s" />';
    $form .= '<button type="submit" value="' . esc_attr_x('Search', 'submit button', 'woocommerce') . '"><i class="fas fa-search"></i></button>';
    $form .= '<input type="hidden" name="post_type" value="product" />';
    $form .= '</form>';
    return $form;
}
add_filter('get_product_search_form', 'bambroo_product_search_form');

// ===== ACCESSIBILITY IMPROVEMENTS =====

// Add skip to content link
function bambroo_skip_to_content_link() {
    echo '<a href="#main-content" class="skip-to-content">برو به محتوا</a>';
}
add_action('wp_body_open', 'bambroo_skip_to_content_link');

// Add ARIA labels to navigation
function bambroo_add_aria_labels_to_nav($items, $args) {
    if ($args->theme_location === 'primary') {
        foreach ($items as $item) {
            $item->title = '<span class="sr-only">منوی </span>' . $item->title;
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'bambroo_add_aria_labels_to_nav', 10, 2);

// ===== SECURITY IMPROVEMENTS =====

// Remove WordPress version from RSS feeds
function bambroo_remove_wp_version_rss() {
    return '';
}
add_filter('the_generator', 'bambroo_remove_wp_version_rss');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove REST API links from head
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Disable emojis
function bambroo_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'bambroo_disable_emojis');

// ===== PERFORMANCE IMPROVEMENTS =====

// Defer JavaScript loading
function bambroo_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array(
        'bambroo-script',
        'jquery',
        'jquery-migrate',
        'woocommerce',
        'wc-cart-fragments',
    );

    if (in_array($handle, $defer_scripts)) {
        return '<script type="text/javascript" src="' . $src . '" defer></script>' . "\n";
    }
    return $tag;
}
add_filter('script_loader_tag', 'bambroo_defer_scripts', 10, 3);

// Disable heartbeats in admin
function bambroo_disable_heartbeat() {
    wp_deregister_script('heartbeat');
}
add_action('init', 'bambroo_disable_heartbeat', 1);

// Limit post revisions
function bambroo_limit_post_revisions($num, $post_id) {
    return 5; // Limit to 5 revisions
}
add_filter('wp_revisions_to_keep', 'bambroo_limit_post_revisions', 10, 2);

// ===== CUSTOM TEMPLATE FUNCTIONS =====

// Get product stock status
function bambroo_get_product_stock_status($product_id) {
    $product = wc_get_product($product_id);
    if ($product->is_in_stock()) {
        $stock = $product->get_stock_quantity();
        if ($stock > 0) {
            return '<span class="stock-status in-stock">موجودی: ' . $stock . '</span>';
        }
    }
    return '<span class="stock-status out-of-stock">اتمام موجودی</span>';
}

// Display product rating
function bambroo_display_product_rating($product_id) {
    $product = wc_get_product($product_id);
    if (get_option('woocommerce_enable_review_rating') === 'yes') {
        echo wc_get_rating_html($product->get_average_rating());
    }
}
