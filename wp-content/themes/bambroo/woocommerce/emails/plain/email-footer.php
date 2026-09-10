<?php
/**
 * Plain Text Email Footer Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/plain/email-footer.php
 */

if (!defined('ABSPATH')) {
    exit;
}

$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
$site_url = home_url();
$year = date('Y');

echo "\n----------------------------------------\n";
echo "این ایمیل به صورت خودکار ارسال شده است. لطفاً به آن پاسخ ندهید.\n";
echo "\n";
echo $site_name . " - " . $year . " &copy; تمام حقوق محفوظ است.\n";
echo $site_url . "\n";
