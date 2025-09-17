<?php
// Добавление метабокса
add_action('add_meta_boxes', 'my_add_colors_metabox');
function my_add_colors_metabox()
{
    add_meta_box(
        'my_product_colors',
        'Доступные цвета / иконки',
        'my_product_colors_callback',
        'product',
        'side',
        'default'
    );
}

function my_product_colors_callback($post)
{
    $value = get_post_meta($post->ID, '_available_colors', true);
?>
    <div id="product-colors-wrapper">
        <ul id="product-colors-list">
            <?php
            if ($value) {
                $items = array_map('trim', explode(',', $value));
                foreach ($items as $item) {
                    $parts = array_map('trim', explode('|', $item));
                    $color = $parts[0] ?? '';
                    $label = $parts[1] ?? '';
                    echo '<li class="product-color-item">';
                    if (filter_var($color, FILTER_VALIDATE_URL)) {
                        echo '<img src="' . esc_url($color) . '" style="width:40px;height:40px;vertical-align:middle;" />';
                    } else {
                        echo '<div style="width:40px;height:40px;background-color:' . esc_attr($color) . ';display:inline-block;"></div>';
                    }
                    echo '<input type="text" class="product-color-value" value="' . esc_attr($color) . '" placeholder="HEX или URL" />';
                    echo '<input type="text" class="product-color-label" value="' . esc_attr($label) . '" placeholder="Название" />';
                    echo '<button class="remove-color button">×</button>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
        <button id="add-color" class="button">Добавить цвет / иконку</button>
        <textarea id="available_colors" name="available_colors" style="display:none;"><?php echo esc_textarea($value); ?></textarea>
    </div>
<?php
    wp_nonce_field('save_product_colors', 'product_colors_nonce');
}

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('product-colors-metabox', get_template_directory_uri() . '/js/product-colors-metabox.js', [], false, true);
    }
});

add_action('save_post_product', 'my_save_product_colors');
function my_save_product_colors($post_id)
{
    if (!isset($_POST['product_colors_nonce']) || !wp_verify_nonce($_POST['product_colors_nonce'], 'save_product_colors')) {
        return;
    }
    if (isset($_POST['available_colors'])) {
        update_post_meta($post_id, '_available_colors', sanitize_text_field($_POST['available_colors']));
    }
}

add_action('woocommerce_before_add_to_cart_button', 'my_custom_color_swatches');
function my_custom_color_swatches()
{
    global $product;
    $colors = get_post_meta($product->get_id(), '_available_colors', true);
    if (!empty($colors)) {
        $colors_array = array_map('trim', explode(',', $colors));
        echo '<div class="custom-color-swatches"><p>Цвет:</p>';
        foreach ($colors_array as $index => $color) {
            $parts = array_map('trim', explode('|', $color));
            $val   = $parts[0] ?? '';
            $label = $parts[1] ?? $val;

            echo '<label class="color-swatch">';
            if (filter_var($val, FILTER_VALIDATE_URL)) {
                echo '<img src="' . esc_url($val) . '" alt="' . esc_attr($label) . '" />';
            } else {
                echo '<div style="width:30px;height:30px;background-color:' . esc_attr($val) . ';display:inline-block;"></div>';
            }
            echo '<input type="radio" name="product_color" value="' . esc_attr($label) . '" ' . ($index === 0 ? 'required' : '') . '>';
            echo '<span class="swatch-tooltip">' . esc_html($label) . '</span>';
            echo '</label>';
        }
        echo '</div>';
    }
}

add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id) {
    if (!empty($_POST['product_color'])) {
        $cart_item_data['product_color'] = sanitize_text_field($_POST['product_color']);
    }
    return $cart_item_data;
}, 10, 2);

add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (isset($cart_item['product_color'])) {
        $item_data[] = ['name' => 'Вариант', 'value' => sanitize_text_field($cart_item['product_color'])];
    }
    return $item_data;
}, 10, 2);

add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
    if (isset($values['product_color'])) {
        $item->add_meta_data('Вариант', $values['product_color'], true);
    }
}, 10, 4);
