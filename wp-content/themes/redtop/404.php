<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package untheme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">

			<div class="page-content">
				<p>404</p>
				<h2 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'untheme' ); ?></h2>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
