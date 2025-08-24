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

    Container::make('post_meta', __('Доп. настройки товара', 'mytheme'))
        ->where('post_type', '=', 'product')
        ->add_fields(array(
            Field::make('image', 'product_gif', 'GIF изображение')
                ->set_value_type('url') // чтобы сохранялся URL
                ->set_help_text('Загрузите GIF для отображения на странице товара на главной странице'),

            Field::make('image', 'product_image', 'Дополнительное изображение товара')
                ->set_value_type('url') // чтобы сохранялся URL
                ->set_help_text('Отображается на главной странице'),
        ));

    Container::make('post_meta', 'Main page content')
        ->show_on_page(get_option('page_on_front'))

        ->add_tab(__('Первый экран'), array(

            Field::make('complex', 'crb_hero_slides', 'Слайды первого экрана')
                ->add_fields(array(
                    // Field::make("checkbox", "crb_darker_pic", "Включить затемнение слайда")
                    //     ->set_option_value('yes'),
                    Field::make('image', 'crb_hero_img', 'Hero Picture')
                        ->set_width(50),
                    Field::make('image', 'crb_hero_img_mob', 'Hero Picture (mobile)')
                        ->set_width(50),
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
}
