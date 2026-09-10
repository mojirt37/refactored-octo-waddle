<?php
/**
 * Single Product Template for Bambroo Theme
 *
 * @package Bambroo
 */

get_header();

// Get product data
global $product;
$product_id = $product->get_id();
$color_code = get_post_meta($product_id, '_product_color_code', true);
$brand = get_post_meta($product_id, '_product_brand', true);
$additional_info = get_post_meta($product_id, '_product_additional_info', true);

// Schema Markup for SEO
$schema_markup = array(
    "@context" => "https://schema.org",
    "@type" => "Product",
    "name" => get_the_title(),
    "image" => wp_get_attachment_image_url(get_post_thumbnail_id($product_id), 'full'),
    "description" => get_the_excerpt(),
    "brand" => array(
        "@type" => "Brand",
        "name" => !empty($brand) ? $brand : get_bloginfo('name')
    ),
    "offers" => array(
        "@type" => "Offer",
        "priceCurrency" => get_woocommerce_currency(),
        "price" => $product->get_price(),
        "availability" => "https://schema.org/" . ($product->is_in_stock() ? "InStock" : "OutOfStock"),
        "url" => get_permalink($product_id)
    )
);

?>

<!-- Schema Markup -->
<script type="application/ld+json">
<?php echo json_encode($schema_markup, JSON_UNESCAPED_UNICODE); ?>
</script>

<main id="main-content" class="rtl">
    <!-- Breadcrumb -->
    <div class="woocommerce-breadcrumb-container container">
        <?php bambroo_woocommerce_breadcrumb(); ?>
    </div>

    <!-- Product Header -->
    <div class="single-product-header container">
        <h1 class="product-title"><?php the_title(); ?></h1>
    </div>

    <!-- Product Container -->
    <div class="single-product-container container">
        <!-- Product Gallery -->
        <div class="product-gallery">
            <?php
            // Product image
            if (has_post_thumbnail($product_id)) {
                $post_thumbnail_id = get_post_thumbnail_id($product_id);
                $full_size_image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                $thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'bambroo-medium');
                
                echo '<div class="woocommerce-product-gallery__image">';
                echo '<a href="' . esc_url($full_size_image[0]) . '" class="product-image-link">';
                echo '<img src="' . esc_url($thumbnail_image[0]) . '" alt="' . esc_attr(get_the_title()) . '" class="wp-post-image" />';
                echo '</a>';
                echo '</div>';
            } else {
                echo '<div class="woocommerce-product-gallery__image--placeholder">';
                echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                echo '</div>';
            }
            
            // Product thumbnails (if WooCommerce gallery is enabled)
            if (function_exists('woocommerce_show_product_thumbnails')) {
                woocommerce_show_product_thumbnails();
            }
            ?>
        </div>

        <!-- Product Summary -->
        <div class="product-summary">
            <!-- Price -->
            <div class="product-price">
                <?php echo wc_price($product->get_price_html()); ?>
            </div>

            <!-- Rating -->
            <?php if (get_option('woocommerce_enable_review_rating') === 'yes') : ?>
                <div class="product-rating">
                    <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                    <a href="#reviews" class="woocommerce-review-link" rel="[nofollow]">
                        (<?php printf(_n('%d نظر مشتری', '%d نظر مشتری', $product->get_review_count(), 'bambroo'), $product->get_review_count()); ?>)
                    </a>
                </div>
            <?php endif; ?>

            <!-- Short Description -->
            <div class="product-short-description">
                <?php echo wp_kses_post(get_the_excerpt()); ?>
            </div>

            <!-- Meta Information -->
            <div class="product-meta">
                <?php if (!empty($color_code)) : ?>
                    <div class="product-color-code">
                        <strong><?php esc_html_e('کد رنگ:', 'bambroo'); ?></strong>
                        <span><?php echo esc_html($color_code); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($brand)) : ?>
                    <div class="product-brand">
                        <strong><?php esc_html_e('برند:', 'bambroo'); ?></strong>
                        <span><?php echo esc_html($brand); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Stock Status -->
                <div class="product-stock-status">
                    <?php
                    if ($product->is_in_stock()) {
                        $stock_quantity = $product->get_stock_quantity();
                        if ($stock_quantity > 0) {
                            echo '<span class="stock-status in-stock">' . esc_html__('موجودی: ', 'bambroo') . esc_html($stock_quantity) . '</span>';
                        } else {
                            echo '<span class="stock-status in-stock">' . esc_html__('موجود', 'bambroo') . '</span>';
                        }
                    } else {
                        echo '<span class="stock-status out-of-stock">' . esc_html__('اتمام موجودی', 'bambroo') . '</span>';
                    }
                    ?>
                </div>

                <!-- Categories -->
                <div class="product-categories">
                    <strong><?php esc_html_e('دسته‌بندی:', 'bambroo'); ?></strong>
                    <?php echo wc_get_product_category_list($product_id, ', ', '<span class="posted_in">', '</span>'); ?>
                </div>

                <!-- Tags -->
                <?php if (wc_get_product_tag_list($product_id, ', ')) : ?>
                    <div class="product-tags">
                        <strong><?php esc_html_e('برچسب‌ها:', 'bambroo'); ?></strong>
                        <?php echo wc_get_product_tag_list($product_id, ', ', '<span class="tagged_as">', '</span>'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Add to Cart Form -->
            <div class="product-purchase">
                <?php
                // Simple product
                if ($product->is_type('simple')) {
                    woocommerce_quantity_input(array(
                        'min_value' => apply_filters('woocommerce_quantity_input_min', 1, $product),
                        'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : 1,
                    ));
                    
                    echo '<button type="submit" name="add-to-cart" value="' . esc_attr($product_id) . '" class="single_add_to_cart_button button">' . esc_html__('افزودن به سبد خرید', 'bambroo') . '</button>';
                }
                
                // Variable product
                elseif ($product->is_type('variable')) {
                    woocommerce_variable_add_to_cart();
                }
                
                // Grouped product
                elseif ($product->is_type('grouped')) {
                    woocommerce_grouped_add_to_cart();
                }
                
                // External product
                elseif ($product->is_type('external')) {
                    woocommerce_external_add_to_cart();
                }
                ?>
            </div>

            <!-- Wishlist Button -->
            <?php if (class_exists('YITH_WCWL')) : ?>
                <div class="product-wishlist">
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                </div>
            <?php endif; ?>

            <!-- Social Sharing -->
            <div class="product-sharing">
                <span><?php esc_html_e('اشتراک‌گذاری:', 'bambroo'); ?></span>
                <a href="https://wa.me/?text=<?php echo urlencode(get_permalink($product_id)); ?>" target="_blank" aria-label="اشتراک در واتساپ">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink($product_id)); ?>" target="_blank" aria-label="اشتراک در تلگرام">
                    <i class="fab fa-telegram"></i>
                </a>
                <a href="https://www.instagram.com/" target="_blank" aria-label="اشتراک در اینستاگرام">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="product-tabs-container container">
        <?php
        // Remove additional info tab if no content
        if (empty($additional_info)) {
            remove_filter('woocommerce_product_tabs', 'bambroo_woocommerce_product_tabs');
        }
        
        // Display tabs
        woocommerce_output_product_data_tabs();
        ?>
    </div>

    <!-- Related Products -->
    <div class="related-products-container container">
        <?php
        $related_limit = 4;
        $related_ids = wc_get_related_products($product_id, $related_limit);
        
        if (sizeof($related_ids) > 0) :
            $args = array(
                'post_type' => 'product',
                'ignore_sticky_posts' => 1,
                'no_found_rows' => 1,
                'posts_per_page' => $related_limit,
                'orderby' => $orderby,
                'post__in' => $related_ids
            );
            
            $related_query = new WP_Query($args);
            
            if ($related_query->have_posts()) :
                echo '<div class="related-products">';
                echo '<h2>' . esc_html__('محصولات مرتبط', 'bambroo') . '</h2>';
                echo '<div class="products-grid">';
                
                while ($related_query->have_posts()) : $related_query->the_post();
                    global $post;
                    $related_product = wc_get_product($post->ID);
                    
                    echo '<div class="product-card">';
                    echo '<a href="' . esc_url(get_permalink($post->ID)) . '">';
                    if (has_post_thumbnail($post->ID)) {
                        echo get_the_post_thumbnail($post->ID, 'bambroo-thumbnail');
                    } else {
                        echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                    }
                    echo '<h3>' . esc_html(get_the_title()) . '</h3>';
                    echo '<span class="price">' . wc_price($related_product->get_price()) . '</span>';
                    echo '</a>';
                    echo '<div class="product-actions">';
                    woocommerce_template_loop_add_to_cart();
                    echo '</div>';
                    echo '</div>';
                endwhile;
                
                echo '</div>';
                echo '</div>';
                
                wp_reset_postdata();
            endif;
        endif;
        ?>
    </div>

    <!-- Upsell Products -->
    <?php
    $upsells = $product->get_upsell_ids();
    if (sizeof($upsells) > 0) :
        $args = array(
            'post_type' => 'product',
            'ignore_sticky_posts' => 1,
            'no_found_rows' => 1,
            'posts_per_page' => 4,
            'orderby' => $orderby,
            'post__in' => $upsells
        );
        
        $upsell_query = new WP_Query($args);
        
        if ($upsell_query->have_posts()) :
            echo '<div class="upsell-products-container container">';
            echo '<h2>' . esc_html__('شما ممکن است این محصولات را نیز دوست داشته باشید', 'bambroo') . '</h2>';
            echo '<div class="products-grid">';
            
            while ($upsell_query->have_posts()) : $upsell_query->the_post();
                global $post;
                $upsell_product = wc_get_product($post->ID);
                
                echo '<div class="product-card">';
                echo '<a href="' . esc_url(get_permalink($post->ID)) . '">';
                if (has_post_thumbnail($post->ID)) {
                    echo get_the_post_thumbnail($post->ID, 'bambroo-thumbnail');
                } else {
                    echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                }
                echo '<h3>' . esc_html(get_the_title()) . '</h3>';
                echo '<span class="price">' . wc_price($upsell_product->get_price()) . '</span>';
                echo '</a>';
                echo '<div class="product-actions">';
                woocommerce_template_loop_add_to_cart();
                echo '</div>';
                echo '</div>';
            endwhile;
            
            echo '</div>';
            echo '</div>';
            
            wp_reset_postdata();
        endif;
    endif;
    ?>
</main>

<?php
get_footer();
?>