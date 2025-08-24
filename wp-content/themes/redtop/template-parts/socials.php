<?php


if ($socials_list = carbon_get_theme_option('crb_socials')) {
?>

    <section class="socials-section">
        <div class="fixed-container">
            <ul class="socials-list">
                <?php
                foreach ($socials_list as $social) {
                    $social_img = wp_get_attachment_image_url($social['crb_social_image'], 'full');
                    $social_name = $social['crb_social_name'];
                    $social_link = $social['crb_social_link'];
                ?>

                    <li class="social-item">

                        <a href="<?php echo $social_link ?>" class="social-link">
                            <?php
                            if (!empty($social_link)) {
                                echo '<img src="' . $social_img . '" alt="' . $social_name . '">';
                            } else {
                                echo '<img src="' . get_stylesheet_directory_uri() . '/images/svg/placeholder.svg" alt="Связаться с нами">';
                            }
                            ?>
                        </a>
                    </li>
                <?php


                }
                ?>
            </ul>
        </div>
    </section>

<?php
}
?>