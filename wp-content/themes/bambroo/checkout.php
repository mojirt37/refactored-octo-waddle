<?php
/**
 * Template Name: Checkout
 * Description: صفحه تسویه حساب سفارشی برای تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <div class="checkout-header">
        <h1>تسویه حساب</h1>
        <p>تکمیل اطلاعات برای خرید</p>
    </div>

    <div class="checkout-container">
        <?php
        // نمایش پیام‌های WooCommerce
        wc_print_notices();
        
        // بررسی اینکه آیا سبد خرید خالی است
        if (WC()->cart->is_empty()) {
            echo '<p class="checkout-empty">سبد خرید شما خالی است. لطفاً ابتدا محصولاتی را به سبد خرید اضافه کنید.</p>';
            echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '" class="button">بازگشت به فروشگاه</a>';
        } else {
            // نمایش فرم تسویه حساب
            do_action('woocommerce_before_checkout_form', $checkout);
            
            // بررسی اینکه آیا کاربر وارد شده است
            if (!is_user_logged_in() && 'no' === get_option('woocommerce_enable_guest_checkout')) {
                echo '<p class="woocommerce-info">لطفاً برای تسویه حساب وارد حساب کاربری خود شوید.</p>';
                woocommerce_login_form(array(
                    'message' => __('برای تسویه حساب وارد شوید.', 'woocommerce'),
                    'redirect' => wc_get_page_permalink('checkout'),
                ));
            } else {
                // نمایش فرم تسویه حساب
                form_start($checkout);
                
                if (sizeof($checkout->checkouts) > 1) {
                    foreach ($checkout->checkouts as $checkout) {
                        do_action('woocommerce_checkout_before_customer_details', $checkout);
                        do_action('woocommerce_checkout_form', $checkout);
                        do_action('woocommerce_checkout_after_customer_details', $checkout);
                    }
                } else {
                    $checkout = $checkout->checkouts[0];
                    do_action('woocommerce_checkout_before_customer_details', $checkout);
                    
                    // نمایش فیلدهای فاکتور
                    do_action('woocommerce_checkout_billing');
                    
                    // نمایش فیلدهای ارسال
                    do_action('woocommerce_checkout_shipping');
                    
                    do_action('woocommerce_checkout_after_customer_details', $checkout);
                    
                    // نمایش بخش بررسی سفارش
                    do_action('woocommerce_checkout_before_order_review');
                    
                    echo '<div id="order_review" class="woocommerce-checkout-review-order">';
                    do_action('woocommerce_checkout_order_review');
                    echo '</div>';
                    
                    do_action('woocommerce_checkout_after_order_review');
                }
                
                form_end($checkout);
            }
            
            do_action('woocommerce_after_checkout_form', $checkout);
        }
        ?>
    </div>
</main>

<?php
// تابع کمکی برای شروع فرم تسویه حساب
function form_start($checkout) {
    echo '<form name="checkout" method="post" class="checkout woocommerce-checkout" action="' . esc_url(wc_get_checkout_url()) . '" enctype="multipart/form-data">';
}

// تابع کمکی برای پایان فرم تسویه حساب
function form_end($checkout) {
    wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce');
    echo '<input type="hidden" name="woocommerce_checkout_update_totals" value="update" />';
    echo '</form>';
}

get_footer();
?>