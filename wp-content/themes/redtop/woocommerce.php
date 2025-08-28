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

    <?php
    if (function_exists('is_product') && is_product()) {
        echo '<div class="product-add">';
        get_template_part('woocommerce/additional-blocks');
        echo '</div>';
    }
    ?>

</main><!-- #primary -->

<?php
get_footer();
