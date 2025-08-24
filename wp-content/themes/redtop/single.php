<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package untheme
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="page-section">
        <div class="fixed-container">

            <header class="page-header">
                <div class="page-header__thumb">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail();
                    } else {
                        echo '<img src="' . get_bloginfo("template_url") . '/images/svg/placeholder.svg" />';
                    } ?>
                </div>

                <?php the_title('<h1 class="page-title">', '</h1>'); ?>

                <!-- <div class="fixed-container">
                    <ul class="breadcrumbs__list">
                        <?php //echo site_breadcrumbs(); 
                        ?>
                    </ul>
                </div> -->
            </header><!-- .page-header -->

        </div>

        <div class="page-section__content">
            <div class="fixed-container">
                <?php
                while (have_posts()) :
                    the_post();

                    //get_template_part('template-parts/content', get_post_type());
                    the_content();

                endwhile; // End of the loop.
                ?>
            </div>
        </div>
    </section>

    <?php
    // --- Читайте также ---
    $categories = wp_get_post_categories(get_the_ID());
    if ($categories) :
        $args = array(
            'category__in'   => $categories,
            'post__not_in'   => array(get_the_ID()),
            'posts_per_page' => 3, // количество постов
            'ignore_sticky_posts' => 1
        );

        $related = new WP_Query($args);

        if ($related->have_posts()) :
    ?>
            <section class="page-section related-posts">
                <div class="fixed-container">
                    <h2 class="related-posts__title">Читайте также</h2>
                    <div class="related-posts__list">
                        <?php while ($related->have_posts()) : $related->the_post(); ?>
                            <article class="related-post">
                                <a class="post-thumb" href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) {
                                        the_post_thumbnail('full');
                                    } ?>
                                    <h3 class="related-post__title"><?php the_title(); ?></h3>
                                </a>

                                <a href="<?php the_permalink() ?>" class="btn">Читать полностью</a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
    <?php
        endif;
        wp_reset_postdata();
    endif;
    ?>

</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
