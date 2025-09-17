<?php

// Убираем блок "Похожие товары"
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
// Убираем все табы
add_filter('woocommerce_product_tabs', 'remove_all_product_tabs', 98);
function remove_all_product_tabs($tabs)
{
    return array(); // возвращаем пустой массив — табов не будет
}

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

// кастомный бейдж распродажи
add_filter('woocommerce_sale_flash', 'custom_sale_flash', 10, 2);
function custom_sale_flash($html, $post)
{
    return '<span class="onsale">' . __('Акция', 'woocommerce') . '</span>';
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
