<?php
$products = wc_get_products([
    'limit'    => 3,
    'orderby'  => 'date',
    'order'    => 'DESC',
    'category' => ['main'],
]);

if ($products) :
?>
    <section class="main-products">
        <div class="fixed-container">

            <!-- Контейнер для уведомлений WooCommerce -->
            <div class="woocommerce-notices-wrapper"></div>

            <ul class="main-products__list">
                <?php foreach ($products as $product) :
                    $product_id = $product->get_id();
                    $gif_url    = carbon_get_post_meta($product_id, 'product_gif');
                ?>
                    <li class="product-item">
                        <a href="<?php echo get_permalink($product_id); ?>">
                            <?php if ($gif_url) : ?>
                                <img src="<?php echo esc_url($gif_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="product-gif" />
                            <?php else : ?>
                                <?php echo $product->get_image(); ?>
                            <?php endif; ?>
                            <h3><?php echo $product->get_name(); ?></h3>
                            <span class="price"><?php echo $product->get_price_html(); ?></span>
                        </a>


                        <?php
                        $product_id = $product->get_id();
                        $classes = 'button add_to_cart_button ajax_add_to_cart';

                        // если товар уже в корзине → добавляем классы
                        if (WC()->cart && rt_is_product_in_cart($product_id)) {
                            $classes .= ' in-cart added';
                        }
                        ?>

                        <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                            class="<?php echo esc_attr($classes); ?>"
                            data-product_id="<?php echo esc_attr($product_id); ?>"
                            data-quantity="1"
                            rel="nofollow">
                            <?php echo esc_html($product->add_to_cart_text()); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php
endif;
?>