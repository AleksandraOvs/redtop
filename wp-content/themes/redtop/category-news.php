<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package untheme
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="page-section _services-archive">


        <?php if (have_posts()) : ?>

            <header class="page-header">
                <div class="fixed-container">
                    <!-- <ul class="breadcrumbs__list">
                        <?php //echo site_breadcrumbs(); ?>
                    </ul> -->
                    <?php
                    the_archive_title('<h2 class="page-title">', '</h2>');
                    ?>
                </div>
            </header><!-- .page-header -->

            <div class="page-section__content">
                <div class="fixed-container">

                    <div class="archive-list">
                        <?php
                        /* Start the Loop */
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/content-news');
                        ?>

                    <?php
                        endwhile;

                        echo '</div>';

                        the_posts_navigation();

                    else :

                        get_template_part('template-parts/content', 'none');

                    endif;
                    ?>
                    </div>
                </div>
    </section>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
