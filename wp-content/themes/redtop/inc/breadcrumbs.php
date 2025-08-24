<?php

function site_breadcrumbs()
{
    $page_num = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $separator = ' <svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10" fill="none">
      <path d="M11.269 9.207L15.4761 5L11.269 0.792999L10.5619 1.50012L13.5619 4.50003L0.499949 4.50003L0.499949 5.50003L13.5618 5.50003L10.5619 8.49987L11.269 9.207Z" fill="#313131"/>
    </svg> ';

    if (is_front_page()) {
        if ($page_num > 1) {
            echo '<a class="home-link" href="' . site_url() . '"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.743 10.3309L10.743 0.330904C10.364 -0.0910957 9.63599 -0.0910957 9.25699 0.330904L0.256994 10.3309C0.127674 10.4746 0.0427905 10.6528 0.0126187 10.8437C-0.017553 11.0347 0.00828102 11.2303 0.0869934 11.4069C0.246993 11.7679 0.604993 11.9999 0.999994 11.9999H2.99999V18.9999C2.99999 19.2651 3.10535 19.5195 3.29289 19.707C3.48042 19.8945 3.73478 19.9999 3.99999 19.9999H6.99999C7.26521 19.9999 7.51956 19.8945 7.7071 19.707C7.89464 19.5195 7.99999 19.2651 7.99999 18.9999V14.9999H12V18.9999C12 19.2651 12.1054 19.5195 12.2929 19.707C12.4804 19.8945 12.7348 19.9999 13 19.9999H16C16.2652 19.9999 16.5196 19.8945 16.7071 19.707C16.8946 19.5195 17 19.2651 17 18.9999V11.9999H19C19.1937 12.0007 19.3834 11.9452 19.546 11.8401C19.7087 11.7349 19.8372 11.5847 19.916 11.4078C19.9947 11.2309 20.0203 11.0348 19.9896 10.8436C19.9589 10.6524 19.8732 10.4743 19.743 10.3309Z" fill="#313131"/>
</svg>
</a>' . $separator . $page_num . '-page';
        } else {
            echo 'Вы находитесь на главной странице';
        }
    } else {
        echo '<a class="home-link" href="' . site_url() . '"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.743 10.3309L10.743 0.330904C10.364 -0.0910957 9.63599 -0.0910957 9.25699 0.330904L0.256994 10.3309C0.127674 10.4746 0.0427905 10.6528 0.0126187 10.8437C-0.017553 11.0347 0.00828102 11.2303 0.0869934 11.4069C0.246993 11.7679 0.604993 11.9999 0.999994 11.9999H2.99999V18.9999C2.99999 19.2651 3.10535 19.5195 3.29289 19.707C3.48042 19.8945 3.73478 19.9999 3.99999 19.9999H6.99999C7.26521 19.9999 7.51956 19.8945 7.7071 19.707C7.89464 19.5195 7.99999 19.2651 7.99999 18.9999V14.9999H12V18.9999C12 19.2651 12.1054 19.5195 12.2929 19.707C12.4804 19.8945 12.7348 19.9999 13 19.9999H16C16.2652 19.9999 16.5196 19.8945 16.7071 19.707C16.8946 19.5195 17 19.2651 17 18.9999V11.9999H19C19.1937 12.0007 19.3834 11.9452 19.546 11.8401C19.7087 11.7349 19.8372 11.5847 19.916 11.4078C19.9947 11.2309 20.0203 11.0348 19.9896 10.8436C19.9589 10.6524 19.8732 10.4743 19.743 10.3309Z" fill="#313131"/>
</svg>
</a>' . $separator;

        // Универсально для записей любых типов
        if (is_singular()) {
            $post_type = get_post_type();
            $post_type_obj = get_post_type_object($post_type);

            // Если это не обычный пост, а CPT
            if ($post_type !== 'post' && $post_type_obj && $post_type_obj->has_archive) {
                echo '<a href="' . get_post_type_archive_link($post_type) . '">' . esc_html($post_type_obj->labels->name) . '</a>' . $separator;
            } elseif ($post_type === 'post') {
                //the_category(', ');
                //echo $separator;
            }

            // Автоматический вывод таксономий, привязанных к CPT
            $taxonomies = get_object_taxonomies($post_type);
            foreach ($taxonomies as $taxonomy) {
                $terms = get_the_terms(get_the_ID(), $taxonomy);
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        echo '<a href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a>' . $separator;
                        // Показываем только первую таксономию
                        break 2;
                    }
                }
            }

            the_title();

        } elseif (is_post_type_archive()) {
            $post_type = get_post_type();
            $post_type_obj = get_post_type_object($post_type);
            echo esc_html($post_type_obj->labels->name);

        } elseif (is_tax()) {
            $term = get_queried_object();
            if ($term) {
                $taxonomy = get_taxonomy($term->taxonomy);
                // Пытаемся определить связанный тип записи (если есть)
                if (!empty($taxonomy->object_type)) {
                    $post_type = $taxonomy->object_type[0];
                    $post_type_obj = get_post_type_object($post_type);
                    if ($post_type_obj && $post_type_obj->has_archive) {
                        echo '<a href="' . get_post_type_archive_link($post_type) . '">' . esc_html($post_type_obj->labels->name) . '</a>' . $separator;
                    }
                }
                echo esc_html($term->name);
            }

        } elseif (is_page()) {
            the_title();

        } elseif (is_tag()) {
            single_tag_title();

        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $separator;
            echo get_the_time('d');

        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
            echo get_the_time('F');

        } elseif (is_year()) {
            echo get_the_time('Y');

        } elseif (is_author()) {
            $userdata = get_userdata(get_query_var('author'));
            echo 'Опубликовал(а) ' . esc_html($userdata->display_name);

        } elseif (is_404()) {
            echo 'Error 404';
        }

        if ($page_num > 1) {
            echo ' (' . $page_num . '-page)';
        }
    }
}