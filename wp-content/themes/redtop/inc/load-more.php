<?php
add_action('wp_ajax_load_more_posts', 'ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'ajax_load_more_posts');

function ajax_load_more_posts()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $query_args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => 7,
        'paged' => $paged
    );

    $ajax_query = new WP_Query($query_args);

    if ($ajax_query->have_posts()) :
        while ($ajax_query->have_posts()) : $ajax_query->the_post(); ?>
           <li class="archive-list__item">
                <!-- 
									<a href="<?php //the_permalink() 
                                                ?>"><?php //the_post_thumbnail() 
                                                                            ?>

									</a -->
                <?php
                $project_slides = carbon_get_post_meta(get_the_ID(), 'crb_projects_pics');
                // echo '<pre>';
                // var_dump($project_slides);
                // echo '</pre>';

                if (!empty($project_slides)) {
                ?>
                    <div class="swiper project-slider">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($project_slides as $project_slide) {
                                $project_slide_pic = wp_get_attachment_image_url($project_slide['crb_project_image'], 'full');
                            ?>
                                <div class="swiper-slide single-project-slider__slide">
                                    <a href="<?php echo $project_slide_pic ?>" data-fancybox="gallery">
                                        <img src="<?php echo $project_slide_pic ?>" alt="Our project">
                                    </a>

                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                } else {
                    echo 'nothing';
                }

                ?>
            </li>
<?php endwhile;
    endif;
    wp_reset_postdata();
    wp_die();
}
