<?php

/**
 * The Template for displaying all WooCommerce pages
 *
 * @package YourTheme
 */

get_header(); ?>

<main id="primary" class="site-main woocommerce-page">
    <section class="page-section">
        <div class="fixed-container">
            <?php
            // Хук для вывода содержимого WooCommerce
            woocommerce_content();
            ?>
        </div>
    </section>

</main><!-- #primary -->

<?php
get_footer();
