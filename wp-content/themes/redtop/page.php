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
		<header class="page-header">
			<?php

			if (has_post_thumbnail()) {
				the_post_thumbnail();
			} else {
				echo '<img src="' . get_bloginfo("template_url") . '/images/svg/placeholder.svg" />';
			}
			?>
			<div class="fixed-container">
				<ul class="breadcrumbs__list">
					<?php echo site_breadcrumbs(); ?>
				</ul>
				<?php
				the_title('<h2 class="page-title">', '</h2>');
				?>
			</div>
		</header><!-- .page-header -->

		<div class="page-section__content">
			<div class="fixed-container">
				<?php
				while (have_posts()) :
					the_post();

					//get_template_part('template-parts/content', 'page');
					the_content();

				endwhile; // End of the loop.
				?>
			</div>
		</div>

	</section>

	<?php get_template_part('template-parts/messengers-block'); ?>
</main><!-- #main -->

<?php
get_footer();
