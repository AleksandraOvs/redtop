<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;



add_action('carbon_fields_register_fields', 'site_carbon');
function site_carbon()
{

    Container::make('theme_options', 'Контакты')

        ->set_page_menu_position(2)
        ->set_icon('dashicons-megaphone')
        ->add_tab(__('Контакты'), array(

            // Field::make('complex', 'crb_contacts', 'Контакты')

            //     ->add_fields(array(
            //         Field::make('image', 'crb_contact_image', 'Иконка')
            //             ->set_width(33),
            //         Field::make('text', 'crb_contact_name', 'Название')
            //             ->set_width(33),
            //         Field::make('text', 'crb_contact_link', 'Ссылка')
            //             ->set_width(33),
            //     )),

            Field::make('text', 'crb_header_button_text_link', 'Ссылка кнопки')
                ->set_width(50),

            Field::make('complex', 'crb_socials', 'Соцсети')

                ->add_fields(array(
                    Field::make('image', 'crb_social_image', 'Иконка')
                        ->set_width(33),
                    Field::make('text', 'crb_social_name', 'Название')
                        ->set_width(33),
                    Field::make('text', 'crb_social_link', 'Ссылка')
                        ->set_width(33),
                )),
        ));

    Container::make('theme_options', 'Отзывы')

        ->set_page_menu_position(3)
        ->set_icon('dashicons-thumbs-up')
        ->add_tab(__('Контакты'), array(

            Field::make('complex', 'crb_testimonials', 'Список отзывов')

                ->add_fields(array(
                    Field::make('image', 'crb_testi_image', 'Фото')
                        ->set_width(33),
                    Field::make('text', 'crb_testi_name', 'Имя')
                        ->set_width(33),
                    Field::make('text', 'crb_testi_subhead', 'Подзаголвок')
                        ->set_width(33),
                    Field::make('rich_text', 'crb_testi_text', 'Текст отзыва')
                        ->set_width(33),
                )),
        ));

    /*POST META*/

    Container::make('post_meta', __('Изображения товара для главной страницы', 'mytheme'))
        ->where('post_type', '=', 'product')
        ->add_fields(array(
            Field::make('image', 'product_gif', 'GIF изображение')
                ->set_value_type('url') // чтобы сохранялся URL
                ->set_help_text('Загрузите GIF для отображения на странице товара на главной странице')
                ->set_width(50),

            Field::make('image', 'product_image', 'Дополнительное изображение товара')
                ->set_value_type('url') // чтобы сохранялся URL
                ->set_help_text('Отображается на главной странице')
                ->set_width(50),
        ));

    Container::make('post_meta', 'Main page content')
        ->show_on_page(get_option('page_on_front'))

        ->add_tab(__('Первый экран'), array(

            Field::make('complex', 'crb_hero_slides', 'Слайды первого экрана')
                ->add_fields(array(
                    // Field::make("checkbox", "crb_darker_pic", "Включить затемнение слайда")
                    //     ->set_option_value('yes'),
                    Field::make('image', 'crb_hero_img', 'Hero Picture')
                        ->set_width(33),
                    Field::make('image', 'crb_hero_img_tablet', 'Hero Picture (tablet)')
                        ->set_width(33),
                    Field::make('image', 'crb_hero_img_mob', 'Hero Picture (mobile)')
                        ->set_width(33),
                    Field::make('text', 'crb_hero_content_link', 'Ссылка слайда')
                        ->set_width(50),
                )),
        ))

        ->add_tab(__('Баннеры для главной'), array(
            Field::make('complex', 'crb_main_page_banners', 'Баннеры главной страницы')
                ->add_fields(array(
                    Field::make('image', 'crb_banner_desk', 'Баннер (для десктопа)')
                        ->set_width(33),
                    Field::make('image', 'crb_banner_tablet', 'Баннер (для планшета)')
                        ->set_width(33),
                    Field::make('image', 'crb_banner_mobile', 'Баннер (для мобилки)')
                        ->set_width(33),
                )),
        ))

        ->add_tab(__('Настройки блока Аксессуары'), array(
            Field::make('rich_text', 'crb_accessories_text', 'Текстовая область для блока Аксессуаров')
        ));

    /*Кастомные поля для товара */
    Container::make('post_meta', 'Дополнительные поля товара')
        ->where('post_type', '=', 'product')
        ->add_tab(__('Видео для товара'), array(

            // Вставка видео
            Field::make('complex', 'product_video', 'Видео товара')
                ->set_max(1) // чтобы был только один источник видео
                ->add_fields(array(
                    Field::make('file', 'video_file', 'Загрузить видео')
                        ->set_type(array('video'))
                        ->set_help_text('Выберите видеофайл'),
                    Field::make('text', 'video_url', 'Или ссылка на видео')
                        ->set_help_text('Например, https://www.youtube.com/watch?v=...'),
                ))
        ))

        ->add_tab(__('Ссылки на странице товара'), array(
            Field::make('complex', 'crb_where_buy', 'Ссылки на ИМ')
                ->add_fields(array(
                    Field::make('text', 'link_where', 'Ссылка')
                        ->set_width(33),
                    Field::make('text', 'head_where', 'Заголовок')
                        ->set_width(33),
                    Field::make('image', 'logo_where', 'Логотип')
                        ->set_width(33),
                )),

            // Комплексное поле ссылок
            Field::make('complex', 'product_links', 'Ссылки')
                ->add_fields(array(
                    Field::make('text', 'link_title', 'Заголовок ссылки'),
                    Field::make('text', 'link_url', 'URL'),
                ))
                ->set_layout('tabbed-horizontal'),
        ))

        ->add_tab(__('Баннеры для страницы товара'), array(
            // Баннеры для страницы товара
            Field::make('complex', 'product_banners', 'Баннеры')
                ->add_fields(array(
                    Field::make('image', 'banner_desktop', 'Изображение для десктопа')
                        ->set_help_text('Размер для экрана >768px')
                        ->set_width(50),
                    Field::make('image', 'banner_mobile', 'Изображение для мобильного')
                        ->set_help_text('Размер для экрана ≤768px')
                        ->set_width(50),
                ))
        ))

        ->add_tab(__('Блок характеристик'), array(
            // Поле изображения
            Field::make('image', 'product_extra_image', 'Доп. изображение')
                ->set_width(50),

            // Rich Text
            Field::make('rich_text', 'product_rich_text', 'Текстовое поле')
                ->set_width(50),
        ))

        ->add_tab(__('Как оформить заказ'), array(

            // Комплексное поле "как оформить заказ"
            Field::make('complex', 'product_how_to_order', 'Как оформить заказ')
                ->add_fields(array(
                    Field::make('rich_text', 'step_text', 'Текст шага'),
                    Field::make('image', 'step_image', 'Изображение шага'),
                ))
                ->set_layout('tabbed-horizontal'),

            // Ещё одно Rich Text
            Field::make('rich_text', 'product_additional_rich_text', 'Доп. текстовое поле'),
        ));
}
