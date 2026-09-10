<?php
/**
 * Admin New Order Email Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/admin-new-order.php
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load email header
get_template_part('emails/email-header', '', array('heading' => 'سفارش جدید دریافت شد'));
?>

<p>سلام مدیر،</p>

<p>یک سفارش جدید در فروشگاه <strong><?php echo esc_html(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES)); ?></strong> دریافت شد. جزئیات سفارش به شرح زیر است:</p>

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

<h2>اطلاعات مشتری</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
    <thead>
        <tr>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">نام و نام خانوادگی</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">ایمیل</th>
            <th scope="col" style="text-align: right; border: 1px solid #eee;">تلفن</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?></td>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html($order->get_billing_email()); ?></td>
            <td style="text-align: right; border: 1px solid #eee;"><?php echo esc_html($order->get_billing_phone()); ?></td>
        </tr>
    </tbody>
</table>

<h2>آدرس ارسال</h2>

<p>
    <strong>آدرس:</strong> <?php echo esc_html($order->get_shipping_address_1()); ?><br>
    <strong>شهر:</strong> <?php echo esc_html($order->get_shipping_city()); ?><br>
    <strong>استان:</strong> <?php echo esc_html($order->get_shipping_state()); ?><br>
    <strong>کد پستی:</strong> <?php echo esc_html($order->get_shipping_postcode()); ?><br>
    <strong>کشور:</strong> <?php echo esc_html($order->get_shipping_country()); ?>
</p>

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
    </tfoot>
</table>

<p>
    <a href="<?php echo esc_url(admin_url('post.php?post=' . $order->get_id() . '&action=edit')); ?>" class="button">مشاهده سفارش در پنل مدیریت</a>
</p>

<?php
// Load email footer
get_template_part('emails/email-footer');
