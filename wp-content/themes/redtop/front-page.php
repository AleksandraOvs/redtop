<?php get_header() ?>
<main>
    <?php get_template_part('template-parts/hero'); ?>
    <?php get_template_part('template-parts/main-products'); ?>
    <?php get_template_part('template-parts/banners'); ?>
    <?php get_template_part('template-parts/testimonials'); ?>
    <?php get_template_part('template-parts/accessories'); ?>

    <?php
    if ($ass_text = carbon_get_post_meta(get_the_ID(), 'crb_accessories_text')) {
    ?>
        <section class="accessories-text">
            <div class="fixed-container">
                <?php echo $ass_text ?>
            </div>
        </section>
    <?php
    }
    ?>

    <?php get_template_part('template-parts/socials'); ?>



    <div class="page-content">
        <?php the_content() ?>
    </div>

    <?php get_template_part('template-parts/news') ?>
    <?php get_template_part('template-parts/projects') ?>
</main>
<?php get_footer() ?>