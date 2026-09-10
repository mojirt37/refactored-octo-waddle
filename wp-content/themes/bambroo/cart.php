<?php
/**
 * Template Name: Cart
 * Description: صفحه سبد خرید سفارشی برای تم بامبرو
 */

get_header();
?>

<main id="main-content" class="rtl">
    <div class="cart-header container">
        <h1>سبد خرید</h1>
        <p>محصولات انتخاب شده توسط شما</p>
    </div>

    <div class="cart-container container">
        <?php
        // نمایش پیام‌های WooCommerce
        wc_print_notices();
        
        // بررسی خالی بودن سبد خرید
        if (WC()->cart->is_empty()) {
            echo '<p class="cart-empty text-center">سبد خرید شما خالی است.</p>';
            echo '<div class="text-center"><a href="' . esc_url(wc_get_page_permalink('shop')) . '" class="button">بازگشت به فروشگاه</a></div>';
        } else {
            // نمایش جدول سبد خرید
            do_action('woocommerce_before_cart');
            ?>
            <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="product-remove">&nbsp;</th>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name">محصول</th>
                            <th class="product-price">قیمت</th>
                            <th class="product-quantity">تعداد</th>
                            <th class="product-subtotal">جمع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            
                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                ?>
                                <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                                    <td class="product-remove">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                __('حذف', 'woocommerce'),
                                                esc_attr($cart_item['product_id']),
                                                esc_attr($_product->get_sku())
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </td>

                                    <td class="product-thumbnail">
                                        <?php
                                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                                        if (!$product_permalink) {
                                            echo $thumbnail;
                                        } else {
                                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                        }
                                        ?>
                                    </td>

                                    <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                        <?php
                                        if (!$product_permalink) {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                        } else {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                        }
                                        
                                        // نمایش متا دیتا (مثل کد رنگ)
                                        echo wc_get_formatted_cart_item_data($cart_item);
                                        ?>
                                    </td>

                                    <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                        ?>
                                    </td>

                                    <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                        <?php
                                        if ($_product->is_sold_individually()) {
                                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name' => "cart[{$cart_item_key}][qty]",
                                                    'input_value' => $cart_item['quantity'],
                                                    'max_value' => $_product->get_max_purchase_quantity(),
                                                    'min_value' => '0',
                                                    'product_name' => $_product->get_name(),
                                                ),
                                                $_product,
                                                false
                                            );
                                        }
                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                        ?>
                                    </td>

                                    <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <?php do_action('woocommerce_after_cart_table'); ?>
            </form>

            <div class="cart-collaterals">
                <div class="cart_totals">
                    <?php do_action('woocommerce_cart_collaterals'); ?>
                </div>
            </div>

            <?php do_action('woocommerce_after_cart'); ?>
            <?php
        }
        ?>
    </div>
</main>

<?php
get_footer();
?>