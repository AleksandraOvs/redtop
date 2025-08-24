<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package untheme
 */
?>
<?php get_template_part('woocommerce/mini-cart')?>
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
<?php get_template_part('template-parts/floating-buttons') ?>
<div class="arrow-up">
	<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M7.24994 15.0001V2.81066L1.53022 8.53039C1.23732 8.82328 0.762563 8.82328 0.46967 8.53039C0.176777 8.2375 0.176777 7.76274 0.46967 7.46984L7.46967 0.469844L7.52631 0.418086C7.82089 0.177777 8.25561 0.19524 8.53022 0.469844L15.5302 7.46984L15.582 7.52648C15.8223 7.82107 15.8048 8.25579 15.5302 8.53039C15.2556 8.80499 14.8209 8.82246 14.5263 8.58215L14.4697 8.53039L8.74994 2.81066V15.0001C8.74994 15.4143 8.41416 15.7501 7.99994 15.7501C7.58573 15.7501 7.24994 15.4143 7.24994 15.0001Z" fill="#ded9e2" />
	</svg>

</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>