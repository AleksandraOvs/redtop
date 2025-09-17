<section class="testimonials-section">
    <div class="fixed-container">
        <?php
        $testimonials = carbon_get_theme_option('crb_testimonials');

        if ($testimonials): ?>
            <!-- Обертка для слайдера -->
            <div class="swiper testimonials-slider">
                <div class="testimonials-title">
                    <h2 class="title">Что о нас говорят:</h2>
                    <div class="testimonials-slider-controls">
                        <!-- Навигация -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>

                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $testi): ?>
                        <div class="swiper-slide testimonials-slider__slide">
                            <div class="testimonial-card">
                                <div class="testimonial-card__top">
                                    <div class="testimonial-image">
                                        <?php if (!empty($testi['crb_testi_image'])) { ?>
                                            <img src="<?php echo wp_get_attachment_image_url($testi['crb_testi_image'], 'medium'); ?>" alt="<?php echo esc_attr($testi['crb_testi_name']); ?>">
                                        <?php } else {
                                            echo
                                            '<img src="' . get_stylesheet_directory_uri() . '/images/svg/placeholder.svg" alt="' . esc_attr($testi['crb_testi_name']) . '">';
                                        } ?>
                                    </div>

                                    <div class="testimonial-card__top__heading">
                                        <?php if (!empty($testi['crb_testi_name'])): ?>
                                            <div class="testimonial-name"><?php echo esc_html($testi['crb_testi_name']); ?></div>
                                        <?php endif; ?>

                                        <?php if (!empty($testi['crb_testi_subhead'])): ?>
                                            <p class="testimonial-subhead"><?php echo esc_html($testi['crb_testi_subhead']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if (!empty($testi['crb_testi_text'])): ?>
                                    <div class="testimonial-text">
                                        <?php echo wp_kses_post($testi['crb_testi_text']); ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>