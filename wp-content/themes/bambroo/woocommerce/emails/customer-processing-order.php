<?php
/**
 * Customer Processing Order Email Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/customer-processing-order.php
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load email header
get_template_part('emails/email-header', '', array('heading' => 'سفارش شما در حال پردازش است'));
?>

<p>سلام <?php echo esc_html($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?>،</p>

<p>از سفارش شما در فروشگاه <strong><?php echo esc_html(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES)); ?></strong> سپاسگزاریم. سفارش شما در حال پردازش است و به زودی برای شما ارسال خواهد شد.</p>

<h2>جزئیات سفارش</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
    <thead>
        <tr>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">شماره سفارش</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">تاریخ</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">مبلغ کل</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">روش پرداخت</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right; border: 1px solid #eee;">#<?php echo $order->get_order_number(); ?></td>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></td>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo wc_price($order->get_total()); ?></td>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html($order->get_payment_method_title()); ?></td>
        </tr>
    </tbody>
</table>

<h2>محصولات سفارش داده شده</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
    <thead>
        <tr>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">محصول</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">تعداد</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">قیمت</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order->get_items() as $item) : ?>
            <tr>
                <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html($item->get_name()); ?></td>
                <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html($item->get_quantity()); ?></td>
                <td style="text-align: right; border: 1px solid #eee;"><?php echo wc_price($item->get_total()); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th scope="row" colspan="2" style="text-align: right; border: 1px solid #eee;">جمع کل:</th>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo wc_price($order->get_total()); ?></td>
        </tr>
        <?php if ($order->get_shipping_total() > 0) : ?>
            <tr>
                <th scope="row" colspan="2" style="text-align: right; border: 1px solid #eee;">هزینه ارسال:</th>
                <td style="text-align: right; border: 1px solid #eee;"><?php echo wc_price($order->get_shipping_total()); ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($order->get_discount_total() > 0) : ?>
            <tr>
                <th scope="row" colspan="2" style="text-align: right; border: 1px solid #eee;">تخفیف:</th>
                <td style="text-align: right; border: 1px solid #eee;">-<?php echo wc_price($order->get_discount_total()); ?></td>
            </tr>
        <?php endif; ?>
    </tfoot>
</table>

<h2>آدرس ارسال</h2>

<p>
    <strong>نام و نام خانوادگی:</strong> <?php echo esc_html($order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name()); ?><br>
    <strong>آدرس:</strong> <?php echo esc_html($order->get_shipping_address_1()); ?><br>
    <strong>شهر:</strong> <?php echo esc_html($order->get_shipping_city()); ?><br>
    <strong>استان:</strong> <?php echo esc_html($order->get_shipping_state()); ?><br>
    <strong>کد پستی:</strong> <?php echo esc_html($order->get_shipping_postcode()); ?><br>
    <strong>کشور:</strong> <?php echo esc_html($order->get_shipping_country()); ?>
</p>

<p>
    شما می‌توانید وضعیت سفارش خود را از طریق <a href="<?php echo esc_url($order->get_view_order_url()); ?>">این لینک</a> پیگیری کنید.
</p>

<p>
    در صورت داشتن هر گونه سوال، لطفاً با ما تماس بگیرید:
    <br>
    <strong>ایمیل:</strong> info@bambroo.ir
    <br>
    <strong>تلفن:</strong> ۰۲۱-۱۲۳۴۵۶۷۸
</p>

<?php
// Load email footer
get_template_part('emails/email-footer');
