<?php
/**
 * Plain Text Admin New Order Email Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/plain/admin-new-order.php
 */

if (!defined('ABSPATH')) {
    exit;
}

echo "= سفارش جدید دریافت شد =\n\n";

echo "سلام مدیر،\n\n";

echo "یک سفارش جدید در فروشگاه " . wp_specialchars_decode(get_option('blogname'), ENT_QUOTES) . " دریافت شد.\n\n";

echo "--- جزئیات سفارش ---\n";
echo "شماره سفارش: #" . $order->get_order_number() . "\n";
echo "تاریخ: " . wc_format_datetime($order->get_date_created()) . "\n";
echo "مبلغ کل: " . wc_price($order->get_total()) . "\n";
echo "روش پرداخت: " . $order->get_payment_method_title() . "\n\n";

echo "--- اطلاعات مشتری ---\n";
echo "نام و نام خانوادگی: " . $order->get_billing_first_name() . " " . $order->get_billing_last_name() . "\n";
echo "ایمیل: " . $order->get_billing_email() . "\n";
echo "تلفن: " . $order->get_billing_phone() . "\n\n";

echo "--- آدرس ارسال ---\n";
echo "آدرس: " . $order->get_shipping_address_1() . "\n";
echo "شهر: " . $order->get_shipping_city() . "\n";
echo "استان: " . $order->get_shipping_state() . "\n";
echo "کد پستی: " . $order->get_shipping_postcode() . "\n";
echo "کشور: " . $order->get_shipping_country() . "\n\n";

echo "--- محصولات سفارش داده شده ---\n";

foreach ($order->get_items() as $item) {
    echo "محصول: " . $item->get_name() . "\n";
    echo "تعداد: " . $item->get_quantity() . "\n";
    echo "قیمت: " . wc_price($item->get_total()) . "\n\n";
}

echo "جمع کل: " . wc_price($order->get_total()) . "\n\n";

echo "برای مشاهده سفارش در پنل مدیریت، به آدرس زیر مراجعه کنید:\n";
echo admin_url('post.php?post=' . $order->get_id() . '&action=edit') . "\n";
