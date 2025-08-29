<?php
// Подключаем WordPress
require_once(dirname(__FILE__) . '/wp-load.php');

// Подключаем функции для медиа
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

$csvFile = __DIR__ . '/recipes.csv';

if (($handle = fopen($csvFile, 'r')) !== false) {
    $header = fgetcsv($handle, 1000, ','); // читаем заголовки
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $row = array_combine($header, $data);

        // создаём запись
        $post_data = array(
            'post_title'   => $row['title'],
            'post_content' => $row['content'],
            'post_status'  => 'publish',
            'post_type'    => 'recipes',
        );

        $post_id = wp_insert_post($post_data);

        if (!is_wp_error($post_id)) {

            // === Изображение ===
            if (!empty($row['image'])) {
                $image_url = trim($row['image']);
                $image_id  = null;

                // 1) Пробуем скачать (для внешних ссылок)
                $downloaded = media_sideload_image($image_url, $post_id, null, 'id');

                if (!is_wp_error($downloaded)) {
                    $image_id = $downloaded;
                } else {
                    // 2) Если не удалось → ищем в медиабиблиотеке
                    $attachment_id = attachment_url_to_postid($image_url);
                    if ($attachment_id) {
                        $image_id = $attachment_id;
                    } else {
                        error_log("Не удалось обработать изображение: " . $image_url);
                    }
                }

                // Назначаем миниатюру
                if ($image_id) {
                    set_post_thumbnail($post_id, $image_id);
                }
            }

            // === Категории ===
            if (!empty($row['recipes_category'])) {
                $categories = array_map('trim', explode(',', $row['recipes_category']));

                // создаём категории, если их нет
                foreach ($categories as $cat) {
                    if (!term_exists($cat, 'recipes_category')) {
                        wp_insert_term($cat, 'recipes_category');
                    }
                }

                wp_set_object_terms($post_id, $categories, 'recipes_category');
            }
        }
    }
    fclose($handle);
}
