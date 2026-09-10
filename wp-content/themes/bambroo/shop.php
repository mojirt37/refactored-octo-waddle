<?php
/**
 * Shop Template for Bambroo Theme
 *
 * @package Bambroo
 */

get_header();

// Get current page for pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Get product categories for sidebar
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'parent' => 0
));

// Get product tags for sidebar
$product_tags = get_terms(array(
    'taxonomy' => 'product_tag',
    'hide_empty' => true,
    'number' => 10
));

// Get color filter options
$color_options = array();
$products = wc_get_products(array('limit' => -1));
foreach ($products as $product) {
    $color_code = get_post_meta($product->get_id(), '_product_color_code', true);
    if (!empty($color_code) && !in_array($color_code, $color_options)) {
        $color_options[] = $color_code;
    }
}

// Get brand filter options
$brand_options = array();
foreach ($products as $product) {
    $brand = get_post_meta($product->get_id(), '_product_brand', true);
    if (!empty($brand) && !in_array($brand, $brand_options)) {
        $brand_options[] = $brand;
    }
}

// Schema Markup for shop page
$schema_markup = array(
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "name" => get_the_title(),
    "url" => get_permalink(),
    "description" => get_the_excerpt()
);

?>

<!-- Schema Markup -->
<script type="application/ld+json">
<?php echo json_encode($schema_markup, JSON_UNESCAPED_UNICODE); ?>
</script>

<main id="main-content" class="rtl">
    <!-- Page Header -->
    <div class="shop-header container">
        <h1><?php echo esc_html__('فروشگاه', 'bambroo'); ?></h1>
        <p><?php echo esc_html__('مرجع رنگ و محصولات ساختمانی در ایران', 'bambroo'); ?></p>
    </div>

    <!-- Shop Container -->
    <div class="shop-container container">
        <!-- Sidebar -->
        <aside class="shop-sidebar" aria-label="فیلترها">
            <!-- Search Widget -->
            <div class="sidebar-widget widget_search">
                <h3><?php echo esc_html__('جستجو', 'bambroo'); ?></h3>
                <?php get_product_search_form(); ?>
            </div>

            <!-- Categories Widget -->
            <div class="sidebar-widget widget_product_categories">
                <h3><?php echo esc_html__('دسته‌بندی‌ها', 'bambroo'); ?></h3>
                <ul class="product-categories">
                    <?php
                    foreach ($product_categories as $category) {
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        $placeholder = BAMBROO_THEME_DIR . '/images/category-placeholder.png';
                        
                        if (!$image) {
                            $image = $placeholder;
                        }
                        
                        $count = $category->count;
                        $has_children = get_term_children($category->term_id, 'product_cat');
                        
                        echo '<li class="cat-item cat-item-' . esc_attr($category->term_id) . '">';
                        echo '<a href="' . esc_url(get_term_link($category)) . '" class="cat-link">';
                        if (!empty($image)) {
                            echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '" width="30" height="30" loading="lazy" />';
                        }
                        echo '<span>' . esc_html($category->name) . '</span>';
                        echo '<span class="cat-count">(' . esc_html($count) . ')</span>';
                        echo '</a>';
                        
                        if (!empty($has_children)) {
                            echo '<button class="toggle-children" aria-expanded="false" aria-controls="children-' . esc_attr($category->term_id) . '">';
                            echo '<i class="fas fa-chevron-left"></i>';
                            echo '</button>';
                            
                            // Get child categories
                            $child_categories = get_term_children($category->term_id, 'product_cat');
                            if (!empty($child_categories)) {
                                echo '<ul class="children" id="children-' . esc_attr($category->term_id) . '" aria-hidden="true">';
                                foreach ($child_categories as $child_id) {
                                    $child = get_term($child_id, 'product_cat');
                                    echo '<li class="cat-item cat-item-' . esc_attr($child->term_id) . '">';
                                    echo '<a href="' . esc_url(get_term_link($child)) . '" class="cat-link">';
                                    echo '<span>' . esc_html($child->name) . '</span>';
                                    echo '<span class="cat-count">(' . esc_html($child->count) . ')</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Price Filter Widget -->
            <div class="sidebar-widget widget_price_filter">
                <h3><?php echo esc_html__('فیلتر بر اساس قیمت', 'bambroo'); ?></h3>
                <?php the_widget('WC_Widget_Price_Filter', array('title' => '')); ?>
            </div>

            <!-- Color Filter Widget -->
            <?php if (!empty($color_options)) : ?>
            <div class="sidebar-widget widget_color_filter">
                <h3><?php echo esc_html__('فیلتر بر اساس رنگ', 'bambroo'); ?></h3>
                <form method="get" action="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
                    <select name="product_color" class="color-filter-select">
                        <option value=""><?php echo esc_html__('همه رنگ‌ها', 'bambroo'); ?></option>
                        <?php foreach ($color_options as $color) : ?>
                            <option value="<?php echo esc_attr($color); ?>" <?php selected(isset($_GET['product_color']) ? $_GET['product_color'] : '', $color); ?>>
                                <?php echo esc_html($color); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                    // Keep other query vars
                    foreach ($_GET as $key => $value) {
                        if ($key !== 'product_color') {
                            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
                        }
                    }
                    ?>
                    <button type="submit" class="button filter-button">
                        <?php echo esc_html__('اعمال فیلتر', 'bambroo'); ?>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Brand Filter Widget -->
            <?php if (!empty($brand_options)) : ?>
            <div class="sidebar-widget widget_brand_filter">
                <h3><?php echo esc_html__('فیلتر بر اساس برند', 'bambroo'); ?></h3>
                <form method="get" action="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
                    <select name="product_brand" class="brand-filter-select">
                        <option value=""><?php echo esc_html__('همه برندها', 'bambroo'); ?></option>
                        <?php foreach ($brand_options as $brand) : ?>
                            <option value="<?php echo esc_attr($brand); ?>" <?php selected(isset($_GET['product_brand']) ? $_GET['product_brand'] : '', $brand); ?>>
                                <?php echo esc_html($brand); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                    // Keep other query vars
                    foreach ($_GET as $key => $value) {
                        if ($key !== 'product_brand') {
                            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
                        }
                    }
                    ?>
                    <button type="submit" class="button filter-button">
                        <?php echo esc_html__('اعمال فیلتر', 'bambroo'); ?>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Tags Widget -->
            <div class="sidebar-widget widget_product_tag_cloud">
                <h3><?php echo esc_html__('برچسب‌های محبوب', 'bambroo'); ?></h3>
                <div class="tagcloud">
                    <?php
                    foreach ($product_tags as $tag) {
                        echo '<a href="' . esc_url(get_term_link($tag)) . '" class="tag-cloud-link" style="font-size: ' . esc_attr(0.8 + ($tag->count / 10)) . 'rem;">' . esc_html($tag->name) . '</a>';
                    }
                    ?>
                </div>
            </div>

            <!-- Banner Widget -->
            <div class="sidebar-widget widget_banner">
                <a href="/consultation" class="banner-link">
                    <img src="<?php echo esc_url(BAMBROO_THEME_DIR . '/images/sidebar-banner.jpg'); ?>" alt="<?php echo esc_attr__('مشاوره رنگ', 'bambroo'); ?>" loading="lazy" />
                    <div class="banner-content">
                        <h4><?php echo esc_html__('نیاز به مشاوره دارید؟', 'bambroo'); ?></h4>
                        <p><?php echo esc_html__('تیم ما آماده ارائه مشاوره رایگان است.', 'bambroo'); ?></p>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="shop-main">
            <!-- WooCommerce Notices -->
            <?php wc_print_notices(); ?>

            <!-- Toolbar -->
            <div class="woocommerce-toolbar">
                <div class="toolbar-left">
                    <div class="woocommerce-result-count">
                        <?php
                        global $wp_query;
                        $total = $wp_query->found_posts;
                        echo esc_html(sprintf(_n('%d محصول یافت شد', '%d محصول یافت شد', $total, 'bambroo'), $total));
                        ?>
                    </div>
                </div>
                <div class="toolbar-right">
                    <form class="woocommerce-ordering" method="get">
                        <select name="orderby" class="orderby">
                            <?php
                            $catalog_orderby = apply_filters('woocommerce_catalog_orderby', array(
                                'menu_order' => esc_html__('مرتب‌سازی پیش‌فرض', 'bambroo'),
                                'popularity' => esc_html__('مرتب‌سازی بر اساس محبوبیت', 'bambroo'),
                                'rating' => esc_html__('مرتب‌سازی بر اساس امتیاز', 'bambroo'),
                                'date' => esc_html__('مرتب‌سازی بر اساس جدیدترین', 'bambroo'),
                                'price' => esc_html__('مرتب‌سازی بر اساس قیمت: ارزان به گران', 'bambroo'),
                                'price-desc' => esc_html__('مرتب‌سازی بر اساس قیمت: گران به ارزان', 'bambroo'),
                            ));
                            
                            foreach ($catalog_orderby as $id => $name) {
                                echo '<option value="' . esc_attr($id) . '" ' . selected(get_query_var('orderby'), $id, false) . '>' . esc_html($name) . '</option>';
                            }
                            ?>
                        </select>
                        <?php
                        // Keep other query vars
                        foreach ($_GET as $key => $value) {
                            if ($key !== 'orderby') {
                                echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
                            }
                        }
                        ?>
                    </form>
                    <div class="woocommerce-view-switcher">
                        <a href="?view=grid" class="view-switcher-button <?php echo !isset($_GET['view']) || $_GET['view'] === 'grid' ? 'active' : ''; ?>" aria-label="نمایش شبکه‌ای">
                            <i class="fas fa-th"></i>
                        </a>
                        <a href="?view=list" class="view-switcher-button <?php echo isset($_GET['view']) && $_GET['view'] === 'list' ? 'active' : ''; ?>" aria-label="نمایش لیستی">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products Grid/List -->
            <?php
            if (have_posts()) :
                // Start the loop
                if (isset($_GET['view']) && $_GET['view'] === 'list') {
                    echo '<div class="products-list">';
                } else {
                    echo '<div class="products-grid">';
                }

                while (have_posts()) : the_post();
                    global $product;
                    
                    if (isset($_GET['view']) && $_GET['view'] === 'list') {
                        // List view
                        echo '<div class="product-list-item">';
                        echo '<div class="product-list-image">';
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('bambroo-thumbnail');
                        } else {
                            echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                        }
                        echo '</div>';
                        echo '<div class="product-list-content">';
                        echo '<h3><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>';
                        echo '<div class="product-list-meta">';
                        echo '<span class="price">' . wc_price($product->get_price()) . '</span>';
                        if ($product->is_on_sale()) {
                            echo '<span class="onsale">' . esc_html__('تخفیف', 'bambroo') . '</span>';
                        }
                        echo '</div>';
                        echo '<div class="product-list-description">' . wp_kses_post(get_the_excerpt()) . '</div>';
                        echo '<div class="product-list-actions">';
                        woocommerce_template_loop_add_to_cart();
                        if (class_exists('YITH_WCWL')) {
                            echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Grid view
                        echo '<div class="product-card">';
                        echo '<a href="' . esc_url(get_permalink()) . '">';
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('bambroo-thumbnail');
                        } else {
                            echo '<img src="' . esc_url(BAMBROO_THEME_DIR . '/images/placeholder.png') . '" alt="' . esc_attr(get_the_title()) . '" />';
                        }
                        if ($product->is_on_sale()) {
                            echo '<span class="onsale">' . esc_html__('تخفیف', 'bambroo') . '</span>';
                        }
                        echo '<h3>' . esc_html(get_the_title()) . '</h3>';
                        echo '<span class="price">' . wc_price($product->get_price()) . '</span>';
                        echo '</a>';
                        echo '<div class="product-actions">';
                        woocommerce_template_loop_add_to_cart();
                        if (class_exists('YITH_WCWL')) {
                            echo '<div class="product-wishlist">';
                            echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                endwhile;

                if (isset($_GET['view']) && $_GET['view'] === 'list') {
                    echo '</div>';
                } else {
                    echo '</div>';
                }

                // Pagination
                echo '<div class="woocommerce-pagination">';
                woocommerce_pagination();
                echo '</div>';

            else :
                echo '<p class="woocommerce-info">' . esc_html__('هیچ محصولی یافت نشد.', 'bambroo') . '</p>';
            endif;
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
?>