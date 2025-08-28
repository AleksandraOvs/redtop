<?php

/**
 * Single Product Image with Swiper + Thumbnails + Fancybox
 *
 * @version 9.7.0 (customized)
 */

use Automattic\WooCommerce\Enums\ProductType;

defined('ABSPATH') || exit;

if (! function_exists('wc_get_gallery_image_html')) {
	return;
}

global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
?>

<div class="woocommerce-product-gallery">

	<!-- Основной слайдер -->
	<div class="swiper swiper-main">
		<div class="swiper-wrapper">
			<?php
			if ($post_thumbnail_id) {
				// главное изображение
				$full_url = wp_get_attachment_image_url($post_thumbnail_id, 'full');
				$img      = wp_get_attachment_image($post_thumbnail_id, 'woocommerce_single', false, array('class' => 'wp-post-image'));

				echo '<div class="woocommerce-product-gallery__image swiper-slide">';
				echo '<a href="' . esc_url($full_url) . '" data-fancybox="product-gallery">';
				echo $img;
				echo '</a>';
				echo '</div>';
			} else {
				// плейсхолдер
				echo '<div class="woocommerce-product-gallery__image swiper-slide">';
				echo '<img src="' . esc_url(wc_placeholder_img_src('woocommerce_single')) . '" alt="' . esc_attr__('Awaiting product image', 'woocommerce') . '" />';
				echo '</div>';
			}

			// остальные изображения галереи
			if ($attachment_ids) {
				foreach ($attachment_ids as $attachment_id) {
					$full_url = wp_get_attachment_image_url($attachment_id, 'full');
					$img      = wp_get_attachment_image($attachment_id, 'woocommerce_single');

					echo '<div class="woocommerce-product-gallery__image swiper-slide">';
					echo '<a href="' . esc_url($full_url) . '" data-fancybox="product-gallery">';
					echo $img;
					echo '</a>';
					echo '</div>';
				}
			}
			?>
		</div>

		<!-- Кнопки -->
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>

	<!-- Слайдер миниатюр -->
	<div class="swiper swiper-thumbs">
		<div class="swiper-wrapper">
			<?php
			if ($post_thumbnail_id) {
				// миниатюра главного изображения
				$thumb = wp_get_attachment_image($post_thumbnail_id, 'woocommerce_gallery_thumbnail');
				echo '<div class="woocommerce-product-gallery__image swiper-slide">' . $thumb . '</div>';
			}

			if ($attachment_ids) {
				foreach ($attachment_ids as $attachment_id) {
					// миниатюра галереи
					$thumb = wp_get_attachment_image($attachment_id, 'woocommerce_gallery_thumbnail');
					echo '<div class="woocommerce-product-gallery__image swiper-slide">' . $thumb . '</div>';
				}
			}
			?>
		</div>
	</div>

</div>