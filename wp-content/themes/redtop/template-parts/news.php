<?php

/**
 * Вывод 3-х последних постов из категории 'news'
 */
$args = [
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'ignore_sticky_posts' => true,
    'category_name'  => 'news',
];
$query = new WP_Query($args);
?>

<?php if ($query->have_posts()): ?>
    <section class="news-section">
        <div class="fixed-container">
            <h2>Новости</h2>
            <div class="archive-list">
                <?php while ($query->have_posts()): $query->the_post();
                    get_template_part('template-parts/content-news');
                endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>