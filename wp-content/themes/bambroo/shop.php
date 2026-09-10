<?php
/**
 * Template Name: Shop
 * Description: صفحه فروشگاه سفارشی برای تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <div class="shop-header container">
        <h1>فروشگاه بامبرو</h1>
        <p>مرجع رنگ و محصولات ساختمانی در ایران</p>
    </div>

    <div class="shop-container container">
        <aside class="shop-sidebar">
            <div class="sidebar-widget">
                <h3>دسته‌بندی‌ها</h3>
                <ul class="product-categories">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                    ));
                    foreach ($categories as $category) {
                        echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="sidebar-widget">
                <h3>برچسب‌ها</h3>
                <ul class="product-tags">
                    <?php
                    $tags = get_terms(array(
                        'taxonomy' => 'product_tag',
                        'hide_empty' => true,
                    ));
                    foreach ($tags as $tag) {
                        echo '<li><a href="' . esc_url(get_term_link($tag)) . '">' . esc_html($tag->name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="sidebar-widget">
                <h3>فیلتر بر اساس قیمت</h3>
                <?php
                if (class_exists('WooCommerce')) {
                    the_widget('WC_Widget_Price_Filter', array(
                        'title' => '',
                    ));
                }
                ?>
            </div>
        </aside>

        <div class="shop-main">
            <?php
            if (have_posts()) {
                echo '<div class="woocommerce-notices">';
                wc_print_notices();
                echo '</div>';
                
                woocommerce_product_loop_start();
                
                while (have_posts()) : the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
                
                woocommerce_product_loop_end();
                
                // نمایش صفحه‌بندی
                echo '<div class="woocommerce-pagination">';
                woocommerce_pagination();
                echo '</div>';
            } else {
                echo '<p class="woocommerce-info">هیچ محصولی یافت نشد.</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
?>