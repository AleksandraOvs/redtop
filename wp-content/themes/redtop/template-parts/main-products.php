<?php
$products = wc_get_products(array(
    'limit'   => 3,
    'orderby' => 'date',
    'order'   => 'DESC',
    'category' => array('main'),
));

if ($products) {
    echo '<section class="main-products">';
    echo '<div class="fixed-container">';
    echo '<ul class="main-products__list">';
    foreach ($products as $product) {
        $product_id = $product->get_id();
        $gif_url    = carbon_get_post_meta($product_id, 'product_gif');

        echo '<li class="product-item">';

        // Ссылка на товар
        echo '<a href="' . get_permalink($product_id) . '">';

        if ($gif_url) {
            echo '<img src="' . esc_url($gif_url) . '" alt="' . esc_attr($product->get_name()) . '" class="product-gif" />';
        } else {
            echo $product->get_image(); // fallback на обычное изображение
        }

        echo '<h3>' . $product->get_name() . '</h3>';
        echo '<span class="price">' . $product->get_price_html() . '</span>';
        echo '</a>';

        // Кнопка "В корзину"
        echo apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<a href="%s" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="%s" aria-label="%s" rel="nofollow">%s</a>',
                esc_url($product->add_to_cart_url()),
                esc_attr($product_id),
                esc_attr(sprintf(__('Добавить «%s» в корзину', 'woocommerce'), $product->get_name())),
                esc_html($product->add_to_cart_text())
            ),
            $product
        );

        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '</section>';
}
