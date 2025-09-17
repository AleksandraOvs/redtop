<section class="section-recipes">
    <div class="fixed-container">
        <h2 class="title">Рецепты:</h2>
        <?php
        $args = array(
            'post_type'      => 'recipes',
            'posts_per_page' => 10,
            'post_status'    => 'publish',
        );

        $recipes_query = new WP_Query($args);

        if ($recipes_query->have_posts()) : ?>

            <div class="slider-recipes swiper">
                <div class="swiper-wrapper">
                    <?php while ($recipes_query->have_posts()) : $recipes_query->the_post(); ?>
                        <div class="swiper-slide slider-recipes__slide">
                            <?php get_template_part('template-parts/content-recipe'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Навигация -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p>Рецепты не найдены.</p>
        <?php endif; ?>
    </div>
</section>