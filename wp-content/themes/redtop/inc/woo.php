<?php
//изменение логики вывода базовой/акционной цены
add_filter( 'woocommerce_get_price_html', function( $price_html, $product ) {
    if ( $product->is_on_sale() ) {
        $price_html  = '<div class="price-inner">';
        $price_html .= '<ins>' . wc_price( $product->get_sale_price() ) . '</ins> ';
        $price_html .= '<del>' . wc_price( $product->get_regular_price() ) . '</del>';
        $price_html .= '</div>';
    }
    return $price_html;
}, 10, 2 );

// Включаем AJAX для кнопок в каталоге
add_theme_support( 'woocommerce', array(
    'ajax_add_to_cart' => true
) );

// // Не перенаправлять в корзину после добавления
// add_filter( 'woocommerce_add_to_cart_redirect', '__return_false' );
// add_filter( 'wc_add_to_cart_params', function($params) {
//     $params['cart_redirect_after_add'] = false;
//     return $params;
// });

// Обновление фрагментов мини-корзины через AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );
function my_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();

    ob_start();
    woocommerce_mini_cart();
    $fragments['.mini-cart-dropdown'] = ob_get_clean();

    return $fragments;
}