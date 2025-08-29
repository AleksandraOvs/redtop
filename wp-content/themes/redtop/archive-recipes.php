<?php
defined('ABSPATH') || exit;
get_header();
?>

<main id="primary" class="site-main">
    <section class="page-section">
        <div class="page-section__content">
            <div class="fixed-container">
                <h2 class="page-title">Рецепты</h2>

                <?php
                // Получаем все термины таксономии 'category' (или свою таксономию, если есть)
                $all_terms = get_terms(array(
                    'taxonomy'   => 'recipes_category',
                    'hide_empty' => false, // Чтобы получить все категории, включая пустые
                ));

                //print_r($all_terms);

                // Отфильтровываем только те категории, в которых есть записи типа 'works'
                $terms = array();

                if (! empty($all_terms) && ! is_wp_error($all_terms)) {
                    foreach ($all_terms as $term) {
                        // Подсчитываем сколько постов 'works' в категории $term->term_id
                        $count = new WP_Query(array(
                            'post_type'      => 'recipes',
                            'posts_per_page' => 1,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'recipes_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ),
                            ),
                            'post_status'    => 'publish',
                            'fields'         => 'ids',
                        ));

                        if ($count->have_posts()) {
                            $terms[] = $term;
                        }
                        wp_reset_postdata();
                    }
                }
                ?>
                <?php if (! empty($terms)) : ?>
                    <ul id="category-filter">
                        <li><a href="#" class="active" data-term="all">Показать все</a></li>
                        <?php foreach ($terms as $term) : ?>
                            <li><a href="#" data-term="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>


                <div id="recipes-list" class="content-inner">
                    <?php if (have_posts()): ?>
                        <?php while (have_posts()): the_post(); ?>

                            <?php get_template_part('template-parts/content-recipe'); ?>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <p><?php esc_html_e('No works found.', 'textdomain'); ?></p>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </section>

</main><!-- #main -->
<?php get_footer(); ?>