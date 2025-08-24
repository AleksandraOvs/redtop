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
                    <?php
                    // Хлебные крошки, если нужно включить:
                    // echo site_breadcrumbs();
                    the_archive_title('<h2 class="page-title">', '</h2>');
                    ?>
                </div>
            </header><!-- .page-header -->

            <div class="page-section__content">
                <div class="fixed-container">
                    <div class="projects-grid">

                        <?php while (have_posts()) : the_post();
                            $post_id      = get_the_ID();
                            $thumb_url    = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '';
                            $title        = get_the_title();
                            $excerpt      = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content(null, false, $post_id)), 20, '…');
                            $link         = carbon_get_post_meta($post_id, 'crb_project_link');
                            $link_text    = carbon_get_post_meta($post_id, 'crb_project_link_text');
                            $video_iframe = carbon_get_post_meta($post_id, 'crb_project_video_iframe');
                        ?>
                            <article class="project-card">
                                <?php if ($thumb_url): ?>
                                    <a href="<?php the_permalink(); ?>" class="project-thumb-wrapper">
                                        <img class="project-thumb" src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                    </a>
                                <?php endif; ?>

                                <div class="project-card__content">
                                    <h3 class="project-title"><?php echo esc_html($title); ?></h3>

                                    <?php if (!empty($excerpt)): ?>
                                        <div class="project-excerpt"><?php echo esc_html($excerpt); ?></div>
                                    <?php endif; ?>

                                    <?php if ($link): ?>
                                        <div class="project-link">
                                            <a class="btn" href="<?php echo esc_url($link); ?>">
                                                <?php echo esc_html($link_text ?: 'Перейти'); ?>
                                            </a>
                                        </div>

                                    <?php elseif ($video_iframe): ?>
                                        <div class="project-link">
                                            <a class="btn js-fancybox"
                                               data-fancybox
                                               data-src="#popup-video-<?php the_ID(); ?>"
                                               href="javascript:;">
                                                <?php echo esc_html($link_text ?: 'Смотреть видео'); ?>
                                            </a>
                                        </div>

                                        <!-- Скрытый контейнер для Fancybox -->
                                        <div style="display:none;" id="popup-video-<?php the_ID(); ?>">
                                            <div class="video-popup-content">
                                                <?php echo $video_iframe; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; ?>

                    </div><!-- .projects-grid -->

                    <?php the_posts_navigation(); ?>

                </div><!-- .fixed-container -->
            </div><!-- .page-section__content -->

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
    </section>
</main><!-- #primary -->

<?php
//get_sidebar();
get_footer();