<?php
/**
 * Email Header Template for Bambroo
 *
 * Override this template by copying it to yourtheme/woocommerce/emails/email-header.php
 */

if (!defined('ABSPATH')) {
    exit;
}

// Set email content type to HTML
if (!isset($content_type)) {
    $content_type = 'text/html';
}

// Set email charset
if (!isset($charset)) {
    $charset = get_bloginfo('charset');
}

// Set email heading
if (!isset($heading)) {
    $heading = '';
}

// Get the site name
$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

// Set the email logo
$logo = get_theme_mod('custom_logo');
$logo_url = $logo ? wp_get_attachment_image_url($logo, 'full') : get_template_directory_uri() . '/images/logo.png';

// Start HTML email
echo '<!DOCTYPE html>';
echo '<html dir="rtl">';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="' . esc_attr($content_type) . '; charset=' . esc_attr($charset) . '">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>' . esc_html($heading) . '</title>';
echo '<style type="text/css">';
echo 'body { font-family: "IRANSans", Tahoma, Arial, sans-serif; direction: rtl; text-align: right; color: #333; }';
echo 'h1, h2, h3 { color: #2E7D32; }';
echo 'table { width: 100%; border-collapse: collapse; }';
echo 'th, td { padding: 8px; border: 1px solid #eee; }';
echo 'th { background-color: #f5f5f5; }';
echo '.button { background-color: #2E7D32; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; }';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
echo '<tr>';
echo '<td align="center" style="padding: 20px 0;">';
echo '<table width="600" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #eee;">';
echo '<tr>';
echo '<td style="padding: 20px; text-align: center; border-bottom: 1px solid #eee;">';
echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($site_name) . '" style="max-width: 200px;">';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td style="padding: 20px;">';
echo '<h1 style="color: #2E7D32; margin: 0 0 20px;">' . esc_html($heading) . '</h1>';
