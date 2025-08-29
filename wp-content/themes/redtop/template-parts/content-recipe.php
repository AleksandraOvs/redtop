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

<article class="recipe">
    <?php if ($thumb_url): ?>
        <a href="<?php the_permalink() ?>" class="recipe-thumb__wrapper">
            <img class="recipe-thumb" src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>">
        </a>
    <?php endif; ?>


    <h3 class="post-title"><?php echo esc_html($title); ?></h3>


</article>