<?php

function theme_enqueue_mini_cart_scripts()
{
    wp_enqueue_script(
        'mini-cart',
        get_stylesheet_directory_uri() . '/js/mini-cart.js',
        array('jquery', 'wc-cart-fragments'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_mini_cart_scripts');

function enqueue_wc_ajax_scripts()
{
    if (is_front_page() || is_home()) {
        // Подключаем стандартные скрипты WooCommerce для AJAX-корзины
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_wc_ajax_scripts');

//изменение логики вывода базовой/акционной цены
add_filter('woocommerce_get_price_html', function ($price_html, $product) {
    if ($product->is_on_sale()) {
        $price_html  = '<div class="price-inner">';
        $price_html .= '<ins>' . wc_price($product->get_sale_price()) . '</ins> ';
        $price_html .= '<del>' . wc_price($product->get_regular_price()) . '</del>';
        $price_html .= '</div>';
    }
    return $price_html;
}, 10, 2);

// Включаем AJAX для кнопок в каталоге
add_theme_support('woocommerce', array(
    'ajax_add_to_cart' => true
));

// // Не перенаправлять в корзину после добавления
// add_filter( 'woocommerce_add_to_cart_redirect', '__return_false' );
// add_filter( 'wc_add_to_cart_params', function($params) {
//     $params['cart_redirect_after_add'] = false;
//     return $params;
// });

// Обновление фрагментов мини-корзины через AJAX
add_filter('woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment');
function my_header_add_to_cart_fragment($fragments)
{
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

// Полностью отключить редирект после добавления в корзину
add_filter('woocommerce_add_to_cart_redirect', '__return_empty_string', 999);

// Отключаем стандартный редирект
add_filter('woocommerce_add_to_cart_redirect', '__return_false');


//меняем кнопку для товаров, которые добавлены в корзину
// === Меняем текст кнопки ===
add_filter('woocommerce_product_add_to_cart_text', 'rt_custom_add_to_cart_text', 20, 2);
add_filter('woocommerce_product_single_add_to_cart_text', 'rt_custom_add_to_cart_text', 20, 2);

function rt_custom_add_to_cart_text($text, $product)
{
    if (WC()->cart && rt_is_product_in_cart($product->get_id())) {
        return 'В корзине';
    }
    return $text;
}

// === Добавляем класс кнопке в каталоге ===
add_filter('woocommerce_loop_add_to_cart_link', 'rt_custom_add_to_cart_class', 20, 2);

function rt_custom_add_to_cart_class($html, $product)
{
    if (WC()->cart && rt_is_product_in_cart($product->get_id())) {
        // добавляем сразу два класса: .in-cart и .added
        $html = str_replace('add_to_cart_button', 'add_to_cart_button in-cart added', $html);
    }
    return $html;
}

// === Вспомогательная функция ===
function rt_is_product_in_cart($product_id)
{
    if (! WC()->cart) {
        return false;
    }
    foreach (WC()->cart->get_cart() as $cart_item) {
        if (intval($cart_item['product_id']) === intval($product_id)) {
            return true;
        }
    }
    return false;
}

