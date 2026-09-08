<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="site-header" class="rtl">
        <div class="container">
            <?php
            // نمایش لوگو
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">بامبرو</a></h1>';
            }
            
            // نمایش منوی اصلی
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => 'nav',
                'container_class' => 'main-navigation',
                'fallback_cb' => false,
            ));
            ?>
        </div>
    </header>
    <main id="main">