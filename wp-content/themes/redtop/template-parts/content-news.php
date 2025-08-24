<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package untheme
 */

?>
<?php
$post_id = get_the_ID();
$thumb_url = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '';
$title = get_the_title();
$excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content(null, false, $post_id)), 20, '…');
?>

<article class="post fromBottom">
    <?php if ($thumb_url): ?>
        <a href="<?php the_permalink() ?>" class="post-thumb-wrapper">
            <img class="project-thumb" src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>">
        </a>
    <?php endif; ?>

    <div class="post-card__content">
        <h3 class="post-title"><?php echo esc_html($title); ?></h3>

        <?php if (!empty($excerpt)): ?>
            <div class="post-excerpt"><?php echo esc_html($excerpt); ?></div>
        <?php endif; ?>
        <?php
        $link        = carbon_get_post_meta(get_the_ID(), 'crb_news_link');
        $link_text   = carbon_get_post_meta(get_the_ID(), 'crb_news_link_text');
        ?>

        <?php if ($link) { ?>

            <a class="btn" target="_blank" href="<?php echo $link ?>">
                <?php echo $link_text ?>
            </a>

        <?php } else {
        ?>
            <a href="<?php the_permalink() ?>" class="btn">Читать</a>
        <?php

        } ?>

    </div>


</article>