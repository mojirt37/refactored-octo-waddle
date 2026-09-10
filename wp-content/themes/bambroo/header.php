<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    
    <!-- Schema Markup for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "بامبرو",
        "url": "<?php echo esc_url(home_url('/')); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo esc_url(home_url('/?s={search_term_string}')); ?>",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="site-header" class="rtl">
        <div class="container">
            <div class="header-top-bar">
                <div class="top-bar-left">
                    <span>به فروشگاه بامبرو خوش آمدید!</span>
                </div>
                <div class="top-bar-right">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo wc_get_page_permalink('myaccount'); ?>">حساب کاربری</a>
                        <a href="<?php echo wc_get_page_permalink('checkout'); ?>">تسویه حساب</a>
                    <?php else : ?>
                        <a href="<?php echo wc_get_page_permalink('myaccount'); ?>">ورود / ثبت‌نام</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="header-main">
                <div class="logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">بامبرو</a></h1>';
                    }
                    ?>
                </div>
                
                <nav class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </nav>
                
                <div class="header-cta">
                    <a href="/consultation" class="button">دریافت مشاوره</a>
                </div>
            </div>
        </div>
    </header>
    <main id="main">