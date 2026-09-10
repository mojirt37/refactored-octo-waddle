<?php
/**
 * Homepage Template for Bambroo Theme
 *
 * @package Bambroo
 */

get_header();

// Get featured products
$featured_products = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 8,
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'featured',
        ),
    ),
));

// Get product categories
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'number' => 4,
));

// Get latest products
$latest_products = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'orderby' => 'date',
    'order' => 'DESC',
));

// Get on sale products
$on_sale_products = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'meta_query' => array(
        array(
            'key' => '_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'NUMERIC',
        ),
    ),
));

// Schema Markup for homepage
$schema_markup = array(
    "@context" => "https://schema.org",
    "@type" => "WebSite",
    "name" => get_bloginfo('name'),
    "url" => home_url('/'),
    "description" => get_bloginfo('description'),
    "potentialAction" => array(
        "@type" => "SearchAction",
        "target" => home_url('/?s={search_term_string}&post_type=product'),
        "query-input" => "required name=search_term_string"
    )
);

?>

<!-- Schema Markup -->
<script type="application/ld+json">
<?php echo json_encode($schema_markup, JSON_UNESCAPED_UNICODE); ?>
</script>

<main id="main-content" class="rtl">
    <!-- Hero Banner -->
    <section class="hero-banner" aria-label="بنر اصلی">
        <div class="hero-content container">
            <h1><?php echo esc_html__('رنگ‌های باکیفیت برای ساختمان شما', 'bambroo'); ?></h1>
            <p><?php echo esc_html__('مرجع رنگ و محصولات ساختمانی در ایران', 'bambroo'); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button cta-button">
                    <i class="fas fa-shopping-bag"></i> <?php echo esc_html__('مشاهده محصولات', 'bambroo'); ?>
                </a>
                <a href="/consultation" class="button button-secondary">
                    <i class="fas fa-comments"></i> <?php echo esc_html__('دریافت مشاوره رایگان', 'bambroo'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products container" aria-label="محصولات پرفروش">
        <div class="section-header">
            <h2><?php echo esc_html__('محصولات پرفروش', 'bambroo'); ?></h2>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="view-all-link">
                <?php echo esc_html__('مشاهده همه', 'bambroo'); ?> <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        <div class="products-grid">
            <?php
            if ($featured_products->have_posts()) :
                while ($featured_products->have_posts()) : $featured_products->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('bambroo-thumbnail');
                            } else {
                                echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                            }
                            ?>
                            <h3><?php the_title(); ?></h3>
                            <span class="price"><?php echo wc_price($product->get_price()); ?></span>
                        </a>
                        <div class="product-actions">
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                            <?php if (class_exists('YITH_WCWL')) : ?>
                                <div class="product-wishlist">
                                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-center">' . esc_html__('هیچ محصول پرفروشی یافت نشد.', 'bambroo') . '</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- Product Categories -->
    <section class="product-categories container" aria-label="دسته‌بندی محصولات">
        <div class="section-header">
            <h2><?php echo esc_html__('دسته‌بندی محصولات', 'bambroo'); ?></h2>
        </div>
        <div class="categories-grid">
            <?php
            foreach ($product_categories as $category) :
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                $placeholder = BAMBROO_THEME_DIR . '/images/category-placeholder.png';
                
                if (!$image) {
                    $image = $placeholder;
                }
                ?>
                <div class="category-card">
                    <a href="<?php echo esc_url(get_term_link($category)); ?>">
                        <div class="category-image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>" loading="lazy" />
                        </div>
                        <h3><?php echo esc_html($category->name); ?></h3>
                        <span class="category-count">
                            <?php echo esc_html($category->count); ?> <?php echo esc_html__('محصول', 'bambroo'); ?>
                        </span>
                    </a>
                </div>
                <?php
            endforeach;
            ?>
        </div>
    </section>

    <!-- Latest Products -->
    <section class="latest-products container" aria-label="جدیدترین محصولات">
        <div class="section-header">
            <h2><?php echo esc_html__('جدیدترین محصولات', 'bambroo'); ?></h2>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?orderby=date" class="view-all-link">
                <?php echo esc_html__('مشاهده همه', 'bambroo'); ?> <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        <div class="products-grid">
            <?php
            if ($latest_products->have_posts()) :
                while ($latest_products->have_posts()) : $latest_products->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('bambroo-thumbnail');
                            } else {
                                echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                            }
                            ?>
                            <h3><?php the_title(); ?></h3>
                            <span class="price"><?php echo wc_price($product->get_price()); ?></span>
                        </a>
                        <div class="product-actions">
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-center">' . esc_html__('هیچ محصول جدیدی یافت نشد.', 'bambroo') . '</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- On Sale Products -->
    <?php if ($on_sale_products->have_posts()) : ?>
    <section class="on-sale-products container" aria-label="محصولات تخفیف‌دار">
        <div class="section-header">
            <h2><?php echo esc_html__('محصولات تخفیف‌دار', 'bambroo'); ?></h2>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>?orderby=price-desc" class="view-all-link">
                <?php echo esc_html__('مشاهده همه', 'bambroo'); ?> <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        <div class="products-grid">
            <?php
            while ($on_sale_products->have_posts()) : $on_sale_products->the_post();
                global $product;
                ?>
                <div class="product-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('bambroo-thumbnail');
                        } else {
                            echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                        }
                        ?>
                        <?php if ($product->is_on_sale()) : ?>
                            <span class="onsale"><?php echo esc_html__('تخفیف', 'bambroo'); ?></span>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                        <span class="price"><?php echo wc_price($product->get_price()); ?></span>
                    </a>
                    <div class="product-actions">
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- About Section -->
    <section class="about-section container" aria-label="درباره بامبرو">
        <div class="about-content">
            <h2><?php echo esc_html__('درباره بامبرو', 'bambroo'); ?></h2>
            <p><?php echo esc_html__('بامبرو با سال‌ها تجربه در زمینه فروش رنگ و محصولات ساختمانی، آماده ارائه بهترین خدمات به شما مشتریان عزیز است. ما با هدف ارائه محصولات با کیفیت بالا و خدمات استثنایی، همواره در حال بهبود و نوآوری بوده‌ایم.', 'bambroo'); ?></p>
            <div class="about-features">
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <h3><?php echo esc_html__('کیفیت بالا', 'bambroo'); ?></h3>
                    <p><?php echo esc_html__('تمام محصولات ما از برندهای معتبر و با کیفیت بالا هستند.', 'bambroo'); ?></p>
                </div>
                <div class="feature">
                    <i class="fas fa-tag"></i>
                    <h3><?php echo esc_html__('قیمت مناسب', 'bambroo'); ?></h3>
                    <p><?php echo esc_html__('ما همواره سعی می‌کنیم بهترین قیمت‌ها را به شما ارائه دهیم.', 'bambroo'); ?></p>
                </div>
                <div class="feature">
                    <i class="fas fa-shipping-fast"></i>
                    <h3><?php echo esc_html__('تحویل سریع', 'bambroo'); ?></h3>
                    <p><?php echo esc_html__('سفارشات شما در سریع‌ترین زمان ممکن تحویل داده می‌شوند.', 'bambroo'); ?></p>
                </div>
                <div class="feature">
                    <i class="fas fa-comments"></i>
                    <h3><?php echo esc_html__('مشاوره رایگان', 'bambroo'); ?></h3>
                    <p><?php echo esc_html__('تیم ما آماده ارائه مشاوره رایگان در مورد انتخاب رنگ و محصولات است.', 'bambroo'); ?></p>
                </div>
            </div>
            <div class="about-cta">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="button">
                    <?php echo esc_html__('بیشتر بدانید', 'bambroo'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="brands-section container" aria-label="برندهای همکار">
        <h2><?php echo esc_html__('برندهای همکار', 'bambroo'); ?></h2>
        <div class="brands-grid">
            <div class="brand">
                <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/brand-1.png'); ?>" alt="برند ۱" loading="lazy" />
            </div>
            <div class="brand">
                <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/brand-2.png'); ?>" alt="برند ۲" loading="lazy" />
            </div>
            <div class="brand">
                <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/brand-3.png'); ?>" alt="برند ۳" loading="lazy" />
            </div>
            <div class="brand">
                <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/brand-4.png'); ?>" alt="برند ۴" loading="lazy" />
            </div>
            <div class="brand">
                <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/brand-5.png'); ?>" alt="برند ۵" loading="lazy" />
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>