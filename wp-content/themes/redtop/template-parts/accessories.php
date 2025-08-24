<?php
// WP_Query для вывода товаров из категории "accessories"
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'accessories',
        ),
    ),
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
    <section class="section-accessories">
        <div class="fixed-container">
            <h2 class="title">Аксессуары:</h2>
            <!-- Swiper контейнер -->
            <div class="swiper accessories-slider">
                <div class="swiper-wrapper">
                    <?php while ($query->have_posts()) : $query->the_post();
                        global $product;

                        // Получаем изображения из Carbon Fields
                        $gif_image    = carbon_get_post_meta(get_the_ID(), 'product_gif');
                        $extra_image  = carbon_get_post_meta(get_the_ID(), 'product_image');

                        // Фолбек, если нету кастомных картинок — берем стандартную
                        $image_url = $extra_image ? $extra_image : get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    ?>
                        <div class="swiper-slide">
                            <div class="product-card">
                                <?php if ($gif_image || $extra_image) { ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" />
                                <?php } else {
                                ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/svg/placeholder.svg" alt="<?php the_title(); ?>" />
                                <?php
                                }  ?>

                                <div class="product-card__content">
                                    <h3 class="product-title"><?php the_title(); ?></h3>

                                    <div class="product-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>

                                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                                        class="button product_type_<?php echo esc_attr($product->get_type()); ?> add_to_cart_button ajax_add_to_cart"
                                        data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                                        data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                                        data-quantity="1"
                                        aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>"
                                        rel="nofollow">
                                        <?php echo esc_html($product->add_to_cart_text()); ?>
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
<?php endif;
wp_reset_postdata(); ?>