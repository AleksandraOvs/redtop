<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package redtop-theme
 */

?>

<footer id="colophon" class="site-footer">

	<div class="fixed-container">
		<?php get_template_part('template-parts/footer-widgets'); ?>
	</div>

	<div class="footer-bottom">
		<div class="fixed-container">

			<div class="site-footer__left">
				<?php
				$footer_logo = get_theme_mod('footer_logo');
				$img = wp_get_attachment_image_src($footer_logo, 'full');
				if ($img) : echo '<img class="footer-logo-img" src="' . $img[0] . '" alt="">';
				endif;
				?>

				<div class="copyright">
					<div><span><?php bloginfo('name'); ?></span><span>&copy;</span><span><?php echo ', ' . date('Y') . 'г.'; ?></span></div>
					<p><?php bloginfo('description'); ?></p>
				</div>
			</div><!-- .site-info -->

		</div>


	</div>

	<?php
	if (current_user_can('administrator')) {
	?>
		<div class="show-temp"><?php echo get_current_template(); ?> </div>
	<?php
	}
	?>

</footer><!-- #colophon -->


</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>