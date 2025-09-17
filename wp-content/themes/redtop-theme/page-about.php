<?php

/**
 * Template name: About
 *
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-section _about-us">

		<div class="page-section__content">
			<div class="fluid-container">
				<?php the_content(); ?>
			</div>
		</div>



	</section>

	<?php get_template_part('template-parts/socials'); ?>

</main><!-- #main -->

<?php
get_footer();
