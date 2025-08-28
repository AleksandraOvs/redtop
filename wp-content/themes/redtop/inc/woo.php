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

// Оборачиваем quantity в div с кнопками
add_action('woocommerce_after_quantity_input_field', 'custom_quantity_plus_button');
function custom_quantity_plus_button()
{
    echo '<button type="button" class="plus"><svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0 7.3359H7.26027V0H8.99971V7.3359H16.26V8.92408H8.99971V16.26H7.26027V8.92408H0V7.3359Z" fill="black"/>
</svg>

</button>';
}

add_action('woocommerce_before_quantity_input_field', 'custom_quantity_minus_button');
function custom_quantity_minus_button()
{
    echo '<button type="button" class="minus"><svg width="17" height="2" viewBox="0 0 17 2" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0 0.335938H7.26027H8.99971H16.26V1.92412H8.99971H7.26027H0V0.335938Z" fill="black"/>
</svg>

</button>';
}

//распродажа / акция

add_filter('woocommerce_sale_flash', 'custom_sale_flash', 10, 3);
function custom_sale_flash($html, $post, $product)
{
    return '<span class="onsale">' . __('Акция', 'woocommerce') . '</span>';
}



// Убираем блок "Похожие товары"
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
// Убираем все табы
add_filter('woocommerce_product_tabs', 'remove_all_product_tabs', 98);
function remove_all_product_tabs($tabs)
{
    return array(); // возвращаем пустой массив — табов не будет
}

// Убираем стандартный редактор полного описания у товаров
add_action('init', 'remove_product_description_editor', 100);
function remove_product_description_editor()
{
    remove_post_type_support('product', 'editor'); // full description
}
