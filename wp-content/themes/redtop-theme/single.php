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

	<section class="page-section _single">
		<div class="fixed-container">
			<?php the_title('<h1 class="page-title">', '</h1>'); ?>

			<?php
			$thumb_url = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '';

			if ($thumb_url): ?>
				<div class="post-thumbnail">
					<img class="recipe-thumb" src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>">
				</div>
			<?php endif; ?>

			<div class="page-section__content">

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

</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
