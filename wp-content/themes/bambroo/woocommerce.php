<?php
/**
 * WooCommerce Template Overrides for Bambroo Theme
 *
 * @package Bambroo
 */

// Exit if WooCommerce is not active
if (!class_exists('WooCommerce')) {
    return;
}

// Remove default WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Enqueue custom WooCommerce styles
function bambroo_woocommerce_styles() {
    wp_enqueue_style('bambroo-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array('bambroo-style'), BAMBROO_VERSION);
    
    if (is_rtl()) {
        wp_enqueue_style('bambroo-woocommerce-rtl', get_template_directory_uri() . '/css/woocommerce-rtl.css', array('bambroo-woocommerce'), BAMBROO_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'bambroo_woocommerce_styles');

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

// Custom WooCommerce container
function bambroo_woocommerce_before_main_content() {
    echo '<div class="woocommerce-container container">';
}
add_action('woocommerce_before_main_content', 'bambroo_woocommerce_before_main_content', 10);

function bambroo_woocommerce_after_main_content() {
    echo '</div>';
}
add_action('woocommerce_after_main_content', 'bambroo_woocommerce_after_main_content', 10);

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

// Custom product loop start
function bambroo_woocommerce_product_loop_start() {
    echo '<div class="products-grid">';
}
add_action('woocommerce_before_shop_loop', 'bambroo_woocommerce_product_loop_start', 20);

// Custom product loop end
function bambroo_woocommerce_product_loop_end() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop', 'bambroo_woocommerce_product_loop_end', 20);

// Custom product loop item start
function bambroo_woocommerce_before_shop_loop_item() {
    echo '<div class="product-card">';
}
add_action('woocommerce_before_shop_loop_item', 'bambroo_woocommerce_before_shop_loop_item', 10);

// Custom product loop item end
function bambroo_woocommerce_after_shop_loop_item() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'bambroo_woocommerce_after_shop_loop_item', 10);

// Custom product thumbnail
function bambroo_woocommerce_product_get_image($image, $product) {
    $image_size = 'bambroo-thumbnail';
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), $image_size);
    if ($image) {
        return '<img src="' . esc_url($image[0]) . '" alt="' . esc_attr($product->get_name()) . '" class="product-image" />';
    }
    return $image;
}
add_filter('woocommerce_product_get_image', 'bambroo_woocommerce_product_get_image', 10, 2);

// Custom add to cart button
function bambroo_woocommerce_loop_add_to_cart_link($link, $product) {
    if ($product->is_type('simple')) {
        $link = sprintf(
            '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url($product->add_to_cart_url()),
            esc_attr(isset($quantity) ? $quantity : 1),
            esc_attr(isset($class) ? $class : 'button add_to_cart_button'),
            isset($attributes) ? wc_implode_html_attributes($attributes) : '',
            esc_html($product->add_to_cart_text())
        );
    }
    return $link;
}
add_filter('woocommerce_loop_add_to_cart_link', 'bambroo_woocommerce_loop_add_to_cart_link', 10, 2);

// Custom product price
function bambroo_woocommerce_get_price_html($price, $product) {
    if ($product->is_on_sale()) {
        $regular_price = wc_get_price_to_display($product, array('price' => $product->get_regular_price()));
        $sale_price = wc_get_price_to_display($product, array('price' => $product->get_sale_price()));
        $price = '<span class="price"><del>' . wc_price($regular_price) . '</del> <ins>' . wc_price($sale_price) . '</ins></span>';
    }
    return $price;
}
add_filter('woocommerce_get_price_html', 'bambroo_woocommerce_get_price_html', 10, 2);

// Custom product title
function bambroo_woocommerce_shop_loop_item_title($title, $product) {
    return '<h3 class="product-title"><a href="' . esc_url(get_permalink($product->get_id())) . '">' . esc_html($product->get_name()) . '</a></h3>';
}
add_filter('woocommerce_shop_loop_item_title', 'bambroo_woocommerce_shop_loop_item_title', 10, 2);

// Custom product rating
function bambroo_woocommerce_product_rating() {
    global $product;
    if (get_option('woocommerce_enable_review_rating') === 'yes') {
        echo wc_get_rating_html($product->get_average_rating());
    }
}

// Custom product stock status
function bambroo_woocommerce_product_stock_status() {
    global $product;
    if ($product->is_in_stock()) {
        $stock = $product->get_stock_quantity();
        if ($stock > 0) {
            echo '<span class="stock-status in-stock">موجودی: ' . esc_html($stock) . '</span>';
        }
    } else {
        echo '<span class="stock-status out-of-stock">اتمام موجودی</span>';
    }
}

// Custom product meta
function bambroo_woocommerce_product_meta() {
    global $product;

    $color_code = get_post_meta($product->get_id(), '_product_color_code', true);
    $brand = get_post_meta($product->get_id(), '_product_brand', true);

    if (!empty($color_code)) {
        echo '<div class="product-color-code"><strong>کد رنگ:</strong> <span style="background-color: ' . esc_attr($color_code) . '; color: ' . bambroo_get_contrast_color($color_code) . '; padding: 0.25rem 0.5rem; border-radius: 3px;">' . esc_html($color_code) . '</span></div>';
    }

    if (!empty($brand)) {
        echo '<div class="product-brand"><strong>برند:</strong> <span>' . esc_html($brand) . '</span></div>';
    }

    bambroo_woocommerce_product_stock_status();
    bambroo_woocommerce_product_rating();
}

// Get contrast color for text
function bambroo_get_contrast_color($hex_color) {
    $r = hexdec(substr($hex_color, 1, 2));
    $g = hexdec(substr($hex_color, 3, 2));
    $b = hexdec(substr($hex_color, 5, 2));
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    return ($brightness > 128) ? '#000000' : '#FFFFFF';
}

// Custom product tabs
function bambroo_woocommerce_product_tabs($tabs) {
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
add_filter('woocommerce_product_tabs', 'bambroo_woocommerce_product_tabs');

// Additional info tab content
function bambroo_additional_info_tab_content() {
    global $product;
    $additional_info = get_post_meta($product->get_id(), '_product_additional_info', true);
    echo '<div class="additional-info-content">' . wp_kses_post(nl2br($additional_info)) . '</div>';
}

// Custom cart table
function bambroo_woocommerce_cart_table() {
    global $woocommerce;

    if (sizeof($woocommerce->cart->get_cart()) > 0) {
        echo '<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">';
        echo '<thead><tr>';
        echo '<th class="product-remove">&nbsp;</th>';
        echo '<th class="product-thumbnail">&nbsp;</th>';
        echo '<th class="product-name">' . esc_html__('Product', 'woocommerce') . '</th>';
        echo '<th class="product-price">' . esc_html__('Price', 'woocommerce') . '</th>';
        echo '<th class="product-quantity">' . esc_html__('Quantity', 'woocommerce') . '</th>';
        echo '<th class="product-subtotal">' . esc_html__('Subtotal', 'woocommerce') . '</th>';
        echo '</tr></thead>';
        echo '<tbody>';

        foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                echo '<tr class="woocommerce-cart-form__cart-item ' . esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)) . '">';

                // Remove button
                echo '<td class="product-remove">';
                echo apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                        esc_html__('Remove this item', 'woocommerce'),
                        esc_attr($cart_item['product_id']),
                        esc_attr($_product->get_sku())
                    ),
                    $cart_item_key
                );
                echo '</td>';

                // Thumbnail
                echo '<td class="product-thumbnail">';
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                if (!$_product->is_visible()) {
                    echo $thumbnail;
                } else {
                    printf('<a href="%s">%s</a>', esc_url($_product->get_permalink($cart_item)), $thumbnail);
                }
                echo '</td>';

                // Product name
                echo '<td class="product-name" data-title="' . esc_attr__('Product', 'woocommerce') . '">';
                if (!$_product->is_visible()) {
                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                } else {
                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($_product->get_permalink($cart_item)), $_product->get_name()), $cart_item, $cart_item_key));
                }
                echo wc_get_formatted_cart_item_data($cart_item);
                echo '</td>';

                // Price
                echo '<td class="product-price" data-title="' . esc_attr__('Price', 'woocommerce') . '">';
                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                echo '</td>';

                // Quantity
                echo '<td class="product-quantity" data-title="' . esc_attr__('Quantity', 'woocommerce') . '">';
                if ($_product->is_sold_individually()) {
                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                } else {
                    $product_quantity = woocommerce_quantity_input(
                        array(
                            'input_name' => "cart[{$cart_item_key}][qty]",
                            'input_value' => $cart_item['quantity'],
                            'max_value' => $_product->get_max_purchase_quantity(),
                            'min_value' => '0',
                            'product_name' => $_product->get_name(),
                        ),
                        $_product,
                        false
                    );
                }
                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                echo '</td>';

                // Subtotal
                echo '<td class="product-subtotal" data-title="' . esc_attr__('Subtotal', 'woocommerce') . '">';
                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                echo '</td>';

                echo '</tr>';
            }
        }

        echo '</tbody></table>';
    }
}

// Custom checkout form
function bambroo_woocommerce_checkout_form() {
    global $checkout;

    if (sizeof($checkout->checkouts) > 1) {
        foreach ($checkout->checkouts as $checkout) {
            do_action('woocommerce_checkout_before_customer_details', $checkout);
            do_action('woocommerce_checkout_form', $checkout);
            do_action('woocommerce_checkout_after_customer_details', $checkout);
        }
    } else {
        $checkout = $checkout->checkouts[0];
        do_action('woocommerce_checkout_before_customer_details', $checkout);
        do_action('woocommerce_checkout_billing');
        do_action('woocommerce_checkout_shipping');
        do_action('woocommerce_checkout_after_customer_details', $checkout);
        do_action('woocommerce_checkout_before_order_review');
        echo '<div id="order_review" class="woocommerce-checkout-review-order">';
        do_action('woocommerce_checkout_order_review');
        echo '</div>';
        do_action('woocommerce_checkout_after_order_review');
    }
}

// Custom order review
function bambroo_woocommerce_order_review() {
    global $woocommerce;

    echo '<h3 id="order_review_heading">' . esc_html__('Your order', 'woocommerce') . '</h3>';

    echo '<table class="shop_table woocommerce-checkout-review-order-table" cellspacing="0">';
    echo '<thead><tr>';
    echo '<th class="product-name">' . esc_html__('Product', 'woocommerce') . '</th>';
    echo '<th class="product-total">' . esc_html__('Subtotal', 'woocommerce') . '</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
            echo '<tr class="cart_item">';
            echo '<td class="product-name">' . apply_filters('woocommerce_checkout_cart_item_quantity', '<strong class="product-quantity">' . sprintf('&nbsp;&times;&nbsp;%s', $cart_item['quantity']) . '</strong> <span class="product-name">' . esc_html($_product->get_name()) . '</span>', $cart_item) . '</td>';
            echo '<td class="product-total">' . apply_filters('woocommerce_checkout_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item) . '</td>';
            echo '</tr>';
        }
    }

    echo '</tbody>';
    echo '<tfoot>';

    if (WC()->cart->get_cart_discount_total() > 0) {
        echo '<tr class="cart-discount">';
        echo '<th>' . esc_html__('Discount', 'woocommerce') . '</th>';
        echo '<td data-title="' . esc_html__('Discount', 'woocommerce') . '">-' . wc_price(WC()->cart->get_cart_discount_total()) . '</td>';
        echo '</tr>';
    }

    echo '<tr class="cart-subtotal">';
    echo '<th>' . esc_html__('Subtotal', 'woocommerce') . '</th>';
    echo '<td data-title="' . esc_html__('Subtotal', 'woocommerce') . '">' . WC()->cart->get_cart_subtotal() . '</td>';
    echo '</tr>';

    foreach (WC()->cart->get_fees() as $fee) {
        echo '<tr class="fee">';
        echo '<th>' . esc_html($fee->name) . '</th>';
        echo '<td data-title="' . esc_html($fee->name) . '">' . wc_price($fee->amount) . '</td>';
        echo '</tr>';
    }

    if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) {
        do_action('woocommerce_review_order_before_shipping');

        wc_cart_totals_shipping_html();

        do_action('woocommerce_review_order_after_shipping');
    }

    foreach (WC()->cart->get_tax_totals() as $code => $tax) {
        echo '<tr class="tax-rate tax-rate-' . sanitize_title($code) . '">';
        echo '<th>' . esc_html($tax->label) . '</th>';
        echo '<td data-title="' . esc_html($tax->label) . '">' . wc_price($tax->formatted_amount) . '</td>';
        echo '</tr>';
    }

    if (WC()->cart->get_cart_fees_total() > 0) {
        echo '<tr class="fee-total">';
        echo '<th>' . esc_html__('Fees', 'woocommerce') . '</th>';
        echo '<td data-title="' . esc_html__('Fees', 'woocommerce') . '">' . wc_price(WC()->cart->get_cart_fees_total()) . '</td>';
        echo '</tr>';
    }

    echo '<tr class="order-total">';
    echo '<th>' . esc_html__('Total', 'woocommerce') . '</th>';
    echo '<td data-title="' . esc_html__('Total', 'woocommerce') . '">' . WC()->cart->get_total() . '</td>';
    echo '</tr>';

    echo '</tfoot></table>';
}

// Custom product search form
function bambroo_woocommerce_product_searchform($form) {
    $form = '<form role="search" method="get" class="woocommerce-product-search" action="' . esc_url(home_url('/')) . '">';
    $form .= '<label class="screen-reader-text" for="woocommerce-product-search-field-' . esc_attr(uniqid()) . '">' . _x('Search for:', 'label', 'woocommerce') . '</label>';
    $form .= '<input type="search" id="woocommerce-product-search-field-' . esc_attr(uniqid()) . '" class="search-field" placeholder="' . esc_attr__('جستجوی محصولات...', 'bambroo') . '" value="' . get_search_query() . '" name="s" />';
    $form .= '<button type="submit" value="' . esc_attr_x('Search', 'submit button', 'woocommerce') . '"><i class="fas fa-search"></i></button>';
    $form .= '<input type="hidden" name="post_type" value="product" />';
    $form .= '</form>';
    return $form;
}
add_filter('get_product_search_form', 'bambroo_woocommerce_product_searchform');

// Custom product categories widget
function bambroo_woocommerce_product_categories_widget($args) {
    $args['walker'] = new Bambroo_WooCommerce_Walker_Category();
    return $args;
}
add_filter('woocommerce_product_categories_widget_args', 'bambroo_woocommerce_product_categories_widget');

// Custom walker for product categories
class Bambroo_WooCommerce_Walker_Category extends Walker_Category {
    function start_el(&$output, $category, $depth = 0, $args = null, $id = 0) {
        $output .= '<li class="cat-item cat-item-' . $category->term_id . '">';
        $output .= '<a href="' . esc_url(get_term_link($category)) . '" class="cat-link">' . esc_html($category->name) . '</a>';
        if ($args->has_children) {
            $output .= '<button class="toggle-children" aria-expanded="false" aria-controls="children-' . $category->term_id . '">';
            $output .= '<i class="fas fa-chevron-down"></i>';
            $output .= '</button>';
        }
        $output .= '</li>';
    }
}

// Custom product filtering
function bambroo_woocommerce_product_filtering() {
    if (isset($_GET['product_color']) && !empty($_GET['product_color'])) {
        add_filter('woocommerce_product_query_meta_query', 'bambroo_filter_products_by_color');
    }
    if (isset($_GET['product_brand']) && !empty($_GET['product_brand'])) {
        add_filter('woocommerce_product_query_meta_query', 'bambroo_filter_products_by_brand');
    }
}
add_action('init', 'bambroo_woocommerce_product_filtering');

// Filter products by color
function bambroo_filter_products_by_color($meta_query) {
    $meta_query[] = array(
        'key' => '_product_color_code',
        'value' => sanitize_text_field($_GET['product_color']),
        'compare' => 'LIKE',
    );
    return $meta_query;
}

// Filter products by brand
function bambroo_filter_products_by_brand($meta_query) {
    $meta_query[] = array(
        'key' => '_product_brand',
        'value' => sanitize_text_field($_GET['product_brand']),
        'compare' => 'LIKE',
    );
    return $meta_query;
}
