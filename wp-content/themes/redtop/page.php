<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package untheme
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="page-section">
		<div class="page-section__content">
			<div class="fixed-container">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php get_template_part('template-parts/socials'); ?>
</main><!-- #main -->

<?php
get_footer();
