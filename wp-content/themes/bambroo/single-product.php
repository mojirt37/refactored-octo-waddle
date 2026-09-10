<?php
/**
 * Template Name: Single Product
 * Description: صفحه محصول سفارشی برای تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <?php
    while (have_posts()) : the_post();
        global $product;
        ?>
        <div class="single-product-header container">
            <nav class="woocommerce-breadcrumb">
                <?php woocommerce_breadcrumb(); ?>
            </nav>
        </div>

        <div class="single-product-container container">
            <div class="product-gallery">
                <?php
                // نمایش گالری محصول
                woocommerce_show_product_images();
                ?>
            </div>

            <div class="product-summary">
                <h1 class="product-title"><?php the_title(); ?></h1>
                
                <div class="product-price">
                    <?php woocommerce_template_single_price(); ?>
                </div>

                <div class="product-description">
                    <?php woocommerce_template_single_excerpt(); ?>
                </div>

                <div class="product-meta">
                    <?php
                    // نمایش کد رنگ
                    $color_code = get_post_meta($product->get_id(), '_product_color_code', true);
                    if (!empty($color_code)) {
                        echo '<div class="product-color-code"><strong>کد رنگ:</strong> <span style="color: ' . esc_attr($color_code) . ';">' . esc_html($color_code) . '</span></div>';
                    }
                    
                    // نمایش دسته‌بندی‌ها
                    echo '<div class="product-categories"><strong>دسته‌بندی:</strong> ';
                    echo get_the_term_list($product->get_id(), 'product_cat', '', ', ', '');
                    echo '</div>';
                    
                    // نمایش برچسب‌ها
                    echo '<div class="product-tags"><strong>برچسب‌ها:</strong> ';
                    echo get_the_term_list($product->get_id(), 'product_tag', '', ', ', '');
                    echo '</div>';
                    ?>
                </div>

                <div class="product-purchase">
                    <?php
                    // نمایش فرم افزودن به سبد خرید
                    woocommerce_template_single_add_to_cart();
                    ?>
                </div>
            </div>
        </div>

        <div class="product-tabs container margin-bottom">
            <?php
            // نمایش تب‌های محصول
            woocommerce_output_product_data_tabs();
            ?>
        </div>

        <div class="related-products container margin-bottom">
            <?php
            // نمایش محصولات مرتبط
            woocommerce_output_related_products();
            ?>
        </div>

        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
?>