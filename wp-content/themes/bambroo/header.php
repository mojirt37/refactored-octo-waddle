<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
    <meta property="og:description" content="<?php echo esc_attr(get_bloginfo('description')); ?>" />
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
    <meta property="og:locale" content="fa_IR" />
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <meta name="twitter:image" content="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/logo.png'); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/favicon.png'); ?>" />
    
    <!-- Preload critical resources -->
    <link rel="preload" href="<?php echo esc_url(BAMBROO_THEME_DIR . '/css/variables.css'); ?>" as="style" />
    <link rel="preload" href="<?php echo esc_url(BAMBROO_THEME_DIR . '/css/style.css'); ?>" as="style" />
    <link rel="preload" href="<?php echo esc_url(BAMBROO_THEME_DIR . '/js/main.js'); ?>" as="script" />
    
    <!-- Preconnect to external resources -->
    <link rel="preconnect" href="https://cdn.font-store.ir" />
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" />
    <link rel="preconnect" href="https://ajax.googleapis.com" />
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php
    // Skip to content link for accessibility
    bambroo_skip_to_content_link();
    ?>

    <header id="site-header" class="rtl">
        <div class="container">
            <!-- Top Bar -->
            <div class="header-top-bar">
                <div class="top-bar-left">
                    <span><?php echo esc_html__('به فروشگاه بامبرو خوش آمدید!', 'bambroo'); ?></span>
                </div>
                <div class="top-bar-right">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                            <i class="fas fa-user"></i> <?php echo esc_html__('حساب کاربری', 'bambroo'); ?>
                        </a>
                        <a href="<?php echo esc_url(wc_get_page_permalink('checkout')); ?>">
                            <i class="fas fa-shopping-bag"></i> <?php echo esc_html__('تسویه حساب', 'bambroo'); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                            <i class="fas fa-sign-in-alt"></i> <?php echo esc_html__('ورود / ثبت‌نام', 'bambroo'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Mini Cart -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="mini-cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-contents-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php echo esc_html__('سبد خرید', 'bambroo'); ?>
                    </a>
                </div>
            </div>
            
            <!-- Main Header -->
            <div class="header-main">
                <!-- Logo -->
                <div class="logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a></h1>';
                    }
                    ?>
                </div>
                
                <!-- Navigation -->
                <nav class="main-navigation" aria-label="منوی اصلی">
                    <button class="mobile-menu-toggle" aria-label="منوی موبایل" aria-expanded="false" aria-controls="primary-menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'container_id' => 'primary-menu',
                        'fallback_cb' => false,
                        'depth' => 3,
                    ));
                    ?>
                </nav>
                
                <!-- Header CTA -->
                <div class="header-cta">
                    <a href="/consultation" class="button cta-button">
                        <i class="fas fa-comments"></i> <?php echo esc_html__('دریافت مشاوره', 'bambroo'); ?>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <main id="main-content">