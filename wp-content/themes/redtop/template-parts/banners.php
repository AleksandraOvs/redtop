<?php
$banners = carbon_get_post_meta(get_the_ID(), 'crb_main_page_banners');

if ($banners) :
?>
    <section class="section-banners">
        <ul class="banners-list">
            <?php

            foreach ($banners as $banner) :
                $desk   = wp_get_attachment_image_url($banner['crb_banner_desk'], 'full');
                $tablet = wp_get_attachment_image_url($banner['crb_banner_tablet'], 'full');
                $mobile = wp_get_attachment_image_url($banner['crb_banner_mobile'], 'full');
            ?>
                <li class="banners-list__item fromOpacity">
                    <picture class="banners-list__item__pic">
                        <?php if ($mobile) : ?>
                            <source srcset="<?php echo esc_url($mobile); ?>" media="(max-width: 767px)">
                        <?php endif; ?>

                        <?php if ($tablet) : ?>
                            <source srcset="<?php echo esc_url($tablet); ?>" media="(max-width: 1024px)">
                        <?php endif; ?>

                        <?php if ($desk) : ?>
                            <img src="<?php echo esc_url($desk); ?>" alt="Баннер">
                        <?php endif; ?>
                    </picture>
                </li>
            <?php
            endforeach;
            ?>
        </ul>
    </section>
<?php

endif;
