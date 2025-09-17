<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>



<button class="close-popup">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13 1L1 13M13 13L1 1" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</button>


<?php if (WC()->cart && ! WC()->cart->is_empty()) : ?>

    <div class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
        <?php
        do_action('woocommerce_before_mini_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                /**
                 * This filter is documented in woocommerce/templates/cart/cart.php.
                 *
                 * @since 2.1.0
                 */
                $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
        ?>
                <li class="woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                    <?php
                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        'woocommerce_cart_item_remove_link',
                        sprintf(
                            '<a role="button" href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" data-success_message="%s">&times;</a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            /* translators: %s is the product name */
                            esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                            esc_attr($product_id),
                            esc_attr($cart_item_key),
                            esc_attr($_product->get_sku()),
                            /* translators: %s is the product name */
                            esc_attr(sprintf(__('&ldquo;%s&rdquo; has been removed from your cart', 'woocommerce'), wp_strip_all_tags($product_name)))
                        ),
                        $cart_item_key
                    );
                    ?>
                    <?php if (empty($product_permalink)) : ?>
                        <?php echo $thumbnail . wp_kses_post($product_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                        ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url($product_permalink); ?>">
                            <?php echo $thumbnail . wp_kses_post($product_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                            ?>
                        </a>
                    <?php endif; ?>
                    <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                    ?>
                    <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                    ?>
                </li>
        <?php
            }
        }

        do_action('woocommerce_mini_cart_contents');
        ?>
    </div>

    <p class="woocommerce-mini-cart__total total">
        <?php
        /**
         * Hook: woocommerce_widget_shopping_cart_total.
         *
         * @hooked woocommerce_widget_shopping_cart_subtotal - 10
         */
        do_action('woocommerce_widget_shopping_cart_total');
        ?>
    </p>

    <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

    <p class="woocommerce-mini-cart__buttons buttons"><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></p>

    <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>

<?php else : ?>

    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e('No products in the cart.', 'woocommerce'); ?></p>

<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>


<?php if (! WC()->cart->is_empty()) : ?>

    <h3 class="mini-cart-title">Ваш заказ:</h3>

    <?php
    do_action('woocommerce_before_mini_cart_contents');

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
            $thumbnail    = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
            $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
    ?>
            <div class="mini_cart_item">
                <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>">
                    <?php echo $thumbnail . $product_name; ?>
                </a>
                <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s × %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); ?>
                <?php
                echo apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                        '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                        __('Remove this item', 'woocommerce'),
                        esc_attr($product_id),
                        esc_attr($cart_item_key),
                        esc_attr($_product->get_sku())
                    ),
                    $cart_item_key
                );
                ?>
            </div>
    <?php
        }
    }
    do_action('woocommerce_mini_cart_contents');
    ?>

<?php else : ?>
    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e('No products in the cart.', 'woocommerce'); ?></p>
<?php endif; ?>