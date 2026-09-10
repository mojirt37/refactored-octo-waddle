<?php
/**
 * Plain Text Customer Processing Order Email Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/plain/customer-processing-order.php
 */

if (!defined('ABSPATH')) {
    exit;
}

echo "= سفارش شما در حال پردازش است =\n\n";

echo "سلام " . $order->get_billing_first_name() . " " . $order->get_billing_last_name() . ",\n\n";

echo "از سفارش شما در فروشگاه " . wp_specialchars_decode(get_option('blogname'), ENT_QUOTES) . " سپاسگزاریم.\n";
echo "سفارش شما در حال پردازش است و به زودی برای شما ارسال خواهد شد.\n\n";

echo "--- جزئیات سفارش ---\n";
echo "شماره سفارش: #" . $order->get_order_number() . "\n";
echo "تاریخ: " . wc_format_datetime($order->get_date_created()) . "\n";
echo "مبلغ کل: " . wc_price($order->get_total()) . "\n";
echo "روش پرداخت: " . $order->get_payment_method_title() . "\n\n";

echo "--- محصولات سفارش داده شده ---\n";

foreach ($order->get_items() as $item) {
    echo "محصول: " . $item->get_name() . "\n";
    echo "تعداد: " . $item->get_quantity() . "\n";
    echo "قیمت: " . wc_price($item->get_total()) . "\n\n";
}

echo "جمع کل: " . wc_price($order->get_total()) . "\n";

if ($order->get_shipping_total() > 0) {
    echo "هزینه ارسال: " . wc_price($order->get_shipping_total()) . "\n";
}

if ($order->get_discount_total() > 0) {
    echo "تخفیف: -" . wc_price($order->get_discount_total()) . "\n";
}

echo "\n--- آدرس ارسال ---\n";
echo "نام و نام خانوادگی: " . $order->get_shipping_first_name() . " " . $order->get_shipping_last_name() . "\n";
echo "آدرس: " . $order->get_shipping_address_1() . "\n";
echo "شهر: " . $order->get_shipping_city() . "\n";
echo "استان: " . $order->get_shipping_state() . "\n";
echo "کد پستی: " . $order->get_shipping_postcode() . "\n";
echo "کشور: " . $order->get_shipping_country() . "\n\n";

echo "شما می‌توانید وضعیت سفارش خود را از طریق لینک زیر پیگیری کنید:\n";
echo $order->get_view_order_url() . "\n\n";

echo "در صورت داشتن هر گونه سوال، لطفاً با ما تماس بگیرید:\n";
echo "ایمیل: info@bambroo.ir\n";
echo "تلفن: ۰۲۱-۱۲۳۴۵۶۷۸\n";
