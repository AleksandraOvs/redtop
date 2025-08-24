<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package untheme
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="page-section">
	<div class="fixed-container">
		<?php
		if (have_posts()) :

			if ( ! is_front_page()) :
		?>
				<header>
					<ul class="breadcrumbs__list">
						<?php echo site_breadcrumbs(); ?>
					</ul>
					<h2 class="page-title"><?php single_post_title(); ?></h2>
				</header>

				<div class="posts-list">

				
		<?php
			endif;

			/* Start the Loop */
			while (have_posts()) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part('template-parts/content', get_post_type());

			endwhile;

			the_posts_navigation();

			if ( ! is_front_page()) : echo '</div>'; endif; 

		else :

			get_template_part('template-parts/content', 'none');

		endif;
		?>
	</div>


	</section>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
