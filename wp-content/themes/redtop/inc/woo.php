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

// --- 1. Убираем /product/ из ссылок ---
function custom_remove_product_slug($post_link, $post)
{
    if ('product' === $post->post_type && 'publish' === $post->post_status) {
        return home_url('/' . $post->post_name . '/');
    }
    return $post_link;
}
add_filter('post_type_link', 'custom_remove_product_slug', 10, 2);

// --- 2. Добавляем правила только для товаров ---
function custom_product_rewrite_rules()
{
    $products = get_posts(array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids'
    ));

    if ($products) {
        foreach ($products as $product_id) {
            $slug = get_post_field('post_name', $product_id);
            add_rewrite_rule(
                '^' . $slug . '/?$',
                'index.php?product=' . $slug,
                'top'
            );
        }
    }
}
add_action('init', 'custom_product_rewrite_rules');

// --- 3. Редирект со старых ссылок ---
function custom_product_redirect()
{
    if (is_singular('product') && strpos($_SERVER['REQUEST_URI'], '/product/') !== false) {
        $new_url = home_url('/' . basename(get_permalink()) . '/');
        wp_redirect($new_url, 301);
        exit;
    }
}
add_action('template_redirect', 'custom_product_redirect');

// --- 4. Проверка на конфликты slug'ов ---
function check_product_slug_conflicts($post_id, $post, $update)
{
    if ($post->post_type !== 'product') {
        return;
    }

    $slug = $post->post_name;

    // Проверяем конфликт со страницами
    $page = get_page_by_path($slug, OBJECT, 'page');
    if ($page && $page->ID != $post_id) {
        error_log("⚠️ Конфликт slug: у товара и страницы одинаковый slug '$slug'");
    }

    // Проверяем конфликт с записями
    $post_check = get_page_by_path($slug, OBJECT, 'post');
    if ($post_check && $post_check->ID != $post_id) {
        error_log("⚠️ Конфликт slug: у товара и поста одинаковый slug '$slug'");
    }
}
add_action('save_post', 'check_product_slug_conflicts', 10, 3);


// добавление цвета для товаров

// 1. Метабокс для задания HEX + название
add_action('add_meta_boxes', 'my_add_colors_metabox');
function my_add_colors_metabox()
{
    add_meta_box(
        'my_product_colors',
        'Доступные цвета',
        'my_product_colors_callback',
        'product',
        'side',
        'default'
    );
}

function my_product_colors_callback($post)
{
    $value = get_post_meta($post->ID, '_available_colors', true);
    echo '<label for="available_colors">Цвета (HEX|Название, через запятую):</label>';
    echo '<textarea style="width:100%" id="available_colors" name="available_colors">' . esc_textarea($value) . '</textarea>';
    echo '<p style="font-size:12px;color:#666">
        Пример: <code>#ff0000|Красный, #0000ff|Синий, #00ff00|Зелёный</code>
    </p>';
}

add_action('save_post_product', 'my_save_product_colors');
function my_save_product_colors($post_id)
{
    if (isset($_POST['available_colors'])) {
        update_post_meta($post_id, '_available_colors', sanitize_text_field($_POST['available_colors']));
    }
}

// 2. Свотчи на витрине
add_action('woocommerce_before_add_to_cart_button', 'my_custom_color_swatches');
function my_custom_color_swatches()
{
    global $product;
    $colors = get_post_meta($product->get_id(), '_available_colors', true);
    if (!empty($colors)) {
        $colors_array = array_map('trim', explode(',', $colors));

        echo '<div class="custom-color-swatches"><p>Выберите цвет:</p>';
        foreach ($colors_array as $index => $color) {
            // Разделяем HEX и название
            $parts = array_map('trim', explode('|', $color));
            $hex   = $parts[0] ?? '#000';
            $label = $parts[1] ?? $hex;

            echo '<label class="color-swatch" style="background-color:' . esc_attr($hex) . '">
                    <input type="radio" name="product_color" value="' . esc_attr($label) . '" ' . ($index === 0 ? 'required' : '') . '>
                    <span class="swatch-tooltip">' . esc_html($label) . '</span>
                  </label>';
        }
        echo '</div>';
    }
}

// 3. Сохраняем выбор в корзину
add_filter('woocommerce_add_cart_item_data', 'my_save_color_cart_item_data_swatches', 10, 2);
function my_save_color_cart_item_data_swatches($cart_item_data, $product_id)
{
    if (isset($_POST['product_color']) && !empty($_POST['product_color'])) {
        $cart_item_data['product_color'] = sanitize_text_field($_POST['product_color']);
    }
    return $cart_item_data;
}

// 4. Показываем в корзине
add_filter('woocommerce_get_item_data', 'my_display_color_cart_swatches', 10, 2);
function my_display_color_cart_swatches($item_data, $cart_item)
{
    if (isset($cart_item['product_color'])) {
        $item_data[] = array(
            'name'  => 'Цвет',
            'value' => sanitize_text_field($cart_item['product_color'])
        );
    }
    return $item_data;
}

// 5. Сохраняем в заказ
add_action('woocommerce_checkout_create_order_line_item', 'my_save_color_to_order_items_swatches', 10, 4);
function my_save_color_to_order_items_swatches($item, $cart_item_key, $values, $order)
{
    if (isset($values['product_color'])) {
        $item->add_meta_data('Цвет', $values['product_color'], true);
    }
}
