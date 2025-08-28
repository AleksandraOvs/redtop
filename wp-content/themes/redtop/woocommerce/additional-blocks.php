<?php
$product_id = get_the_ID();
echo '<div class="fixed-container">';
echo '<div class="product-add__links">';


// ------------------- ВИДЕО -------------------
$video = carbon_get_post_meta($product_id, 'product_video');

if (! empty($video)) {
    $video_file = $video[0]['video_file'] ?? '';
    $video_url  = $video[0]['video_url'] ?? '';

    echo '<div class="product-video">';
    if ($video_file) {
        echo wp_video_shortcode(array('src' => wp_get_attachment_url($video_file)));
    } elseif ($video_url) {
        // Вставляем iframe для ссылки
        echo '<iframe width="560" height="315" src="' . esc_url($video_url) . '" frameborder="0" allowfullscreen></iframe>';
    }
    echo '</div>';
}

// ------------------- КОМПЛЕКСНОЕ ПОЛЕ ССЫЛОК -------------------
$links = carbon_get_post_meta($product_id, 'product_links');
if (! empty($links)) {
    echo '<ul class="product-links">';
    $where_buy = carbon_get_post_meta(get_the_ID(), 'crb_where_buy');

    if (! empty($where_buy)) {
        echo '<li class="sublinks">';
        echo '<ul class="where-buy-links">';

        foreach ($where_buy as $item) {
            $link  = ! empty($item['link_where']) ? $item['link_where'] : '';
            $title = ! empty($item['head_where']) ? $item['head_where'] : '';
            $logo  = ! empty($item['logo_where']) ? wp_get_attachment_url($item['logo_where']) : '';

            echo '<li class="where-buy-item">';


            if ($link) {
?>
                <a href=" <?php echo esc_url($link) ?>" target="_blank" class="where-buy-link">
                    <?php
                    if ($logo) {
                        echo '<img src="' . esc_url($logo) . '" alt="" class="where-buy-logo">';
                    }

                    if ($title) {
                        echo '<h4 class="where-buy-title">' . esc_html($title) . '</h4>';
                    }
                    ?>

                </a>
<?php

            }

            echo '</li>'; // .where-buy-item
        }

        echo '</ul>'; // .where-buy-links
        echo '</li>'; // sublinks
    }
    foreach ($links as $link) {
        echo '<li><a href="' . esc_url($link['link_url']) . '">' . esc_html($link['link_title']) . '</a></li>';
    }
    echo '</ul>';
}
echo '</div>';
echo '</div>'; // end product-add__links


// ------------------- БАННЕРЫ -------------------
$banners = carbon_get_post_meta(get_the_ID(), 'product_banners');

if (! empty($banners)) {
    echo '<div class="product-banners">';
    foreach ($banners as $banner) {

        $desktop_img = !empty($banner['banner_desktop']) ? wp_get_attachment_url($banner['banner_desktop']) : '';
        $mobile_img  = !empty($banner['banner_mobile']) ? wp_get_attachment_url($banner['banner_mobile']) : '';

        echo '<div class="product-banner">';

        if ($desktop_img || $mobile_img) {
            echo '<picture>';
            if ($mobile_img) {
                echo '<source media="(max-width: 768px)" srcset="' . esc_url($mobile_img) . '">';
            }
            if ($desktop_img) {
                echo '<img src="' . esc_url($desktop_img) . '" alt="">';
            }
            echo '</picture>';
        }

        echo '</div>';
    }
    echo '</div>';
}

echo '<section>';
echo '<div class="fixed-container">';
echo '<h2 style="text-align: center">Характеристики</h2>';
echo '<div class="characteristics-inner">';
// ------------------- ДОПОЛНИТЕЛЬНОЕ ИЗОБРАЖЕНИЕ -------------------
$extra_image = carbon_get_post_meta($product_id, 'product_extra_image');
if ($extra_image) {
    echo '<div class="product-extra-image">';
    echo '<img src="' . wp_get_attachment_url($extra_image) . '" alt="">';
    echo '</div>';
}

// ------------------- RICH TEXT -------------------
$rich_text = carbon_get_post_meta($product_id, 'product_rich_text');
if ($rich_text) {
    echo '<div class="product-rich-text">';
    echo wp_kses_post($rich_text);
    echo '</div>';
}
echo '</div>';
echo '</div>';
echo '</section>';

// ------------------- КАК ОФОРМИТЬ ЗАКАЗ -------------------
$how_to_order = carbon_get_post_meta($product_id, 'product_how_to_order');
if (! empty($how_to_order)) {
    echo '<section class="product-how-to-order"><div class="fixed-container">';
    echo '<h2 style="text-align: center;">Как оформить заказ</h2>';
    echo '<ul class="order-steps">';
    foreach ($how_to_order as $step) {
        echo '<li class="order-step">';
        if (! empty($step['step_image'])) {
            echo '<img src="' . wp_get_attachment_url($step['step_image']) . '" alt="">';
        }
        if (! empty($step['step_text'])) {
            echo wp_kses_post($step['step_text']);
        }
        echo '</li>';
    }
    echo '</ul>';

    // ------------------- ДОПОЛНИТЕЛЬНЫЙ RICH TEXT -------------------
    $additional_rich_text = carbon_get_post_meta($product_id, 'product_additional_rich_text');
    if ($additional_rich_text) {
        echo '<div class="product-additional-rich-text">';
        echo wp_kses_post($additional_rich_text);
        echo '</div>';
    }

    echo '</div></section>';
}

get_template_part('template-parts/testimonials');
get_template_part('template-parts/accessories');
get_template_part('template-parts/socials');
