<?php
/**
 * Template Name: Bambroo Homepage
 * Description: صفحه اصلی تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="hero-content container">
            <h1>رنگ‌های باکیفیت برای ساختمان شما</h1>
            <p>مرجع رنگ و محصولات ساختمانی در ایران</p>
            <a href="/consultation" class="button cta-button">دریافت مشاوره رایگان</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products container margin-bottom">
        <h2 class="text-center">محصولات پرفروش</h2>
        <div class="products-grid">
            <?php
            // نمایش ۴ محصول پرفروش
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            );
            $featured_products = new WP_Query($args);
            
            if ($featured_products->have_posts()) :
                while ($featured_products->have_posts()) : $featured_products->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                            <h3><?php the_title(); ?></h3>
                            <span class="price"><?php echo wc_price($product->get_price()); ?></span>
                        </a>
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-center">هیچ محصول پرفروشی یافت نشد.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- Categories -->
    <section class="product-categories container margin-bottom">
        <h2 class="text-center">دسته‌بندی محصولات</h2>
        <div class="categories-grid">
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'number' => 4,
            ));
            
            foreach ($categories as $category) :
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                ?>
                <div class="category-card">
                    <a href="<?php echo get_term_link($category); ?>">
                        <?php if ($image) : ?>
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                        <?php endif; ?>
                        <h3><?php echo esc_html($category->name); ?></h3>
                    </a>
                </div>
                <?php
            endforeach;
            ?>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section container margin-bottom">
        <h2 class="text-center">درباره بامبرو</h2>
        <p class="text-center">
            بامبرو با سال‌ها تجربه در زمینه فروش رنگ و محصولات ساختمانی، آماده ارائه بهترین خدمات به شما مشتریان عزیز است.
        </p>
        <div class="about-cta text-center">
            <a href="/about" class="button">بیشتر بدانید</a>
        </div>
    </section>
</main>

<?php
get_footer();
?>