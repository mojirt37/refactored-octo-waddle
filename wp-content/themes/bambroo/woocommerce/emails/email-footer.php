<?php
/**
 * Email Footer Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/email-footer.php
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get the site name
$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
$site_url = home_url();

// Get the current year
$year = date('Y');

// Close the email body
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';
echo '</table>';

// Add footer content
echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
echo '<tr>';
echo '<td align="center" style="padding: 20px 0;">';
echo '<table width="600" cellpadding="0" cellspacing="0" border="0">';
echo '<tr>';
echo '<td style="padding: 20px; text-align: center; border-top: 1px solid #eee; color: #777; font-size: 14px;">';
echo '<p>این ایمیل به صورت خودکار ارسال شده است. لطفاً به آن پاسخ ندهید.</p>';
echo '<p>';
echo '<a href="' . esc_url($site_url) . '" style="color: #2E7D32; text-decoration: none;">' . esc_html($site_name) . '</a>';
echo '<br>';
echo '<span>' . esc_html($year) . ' &copy; تمام حقوق محفوظ است.</span>';
echo '</p>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';
echo '</table>';

// Close the email HTML
echo '</body>';
echo '</html>';
