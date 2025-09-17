<?php

add_action('init', 'register_post_types');

function register_post_types()
{

    register_post_type('recipes', [
        'label'  => null,
        'labels' => [
            'name'               => 'Рецепты', // основное название для типа записи
            'singular_name'      => 'Рецепт', // название для одной записи этого типа
            'add_new'            => 'Добавить рецепт', // для добавления новой записи
            'add_new_item'       => 'Добавление рецепта', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактировать', // для редактирования типа записи
            'new_item'           => 'Новый рецепт', // текст новой записи
            'view_item'          => 'Перейти', // для просмотра записи этого типа.
            'search_items'       => 'Искать рецепт', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Рецепты', // название меню
        ],
        'description'            => '',
        'public'                 => true,
        // 'publicly_queryable'  => null, // зависит от public
        // 'exclude_from_search' => null, // зависит от public
        // 'show_ui'             => null, // зависит от public
        'show_in_nav_menus'   =>  true, // зависит от public
        'show_in_menu'           => true, // показывать ли в меню админки
        // 'show_in_admin_bar'   => null, // зависит от show_in_menu
        'show_in_rest'        => true, // добавить в REST API. C WP 4.7
        'rest_base'           => false, // $post_type. C WP 4.7
        'menu_position'       => 2,
        'menu_icon'           => 'dashicons-carrot',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => true,
        'supports'            => ['title', 'thumbnail', 'editor'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        //'taxonomies'          => false,
        'has_archive'         => true,
        //'rewrite'             => true,
        'rewrite' => [
            'slug' => 'recepti',
            'with_front' => false,
        ],
        'query_var'           => 'recipes',
    ]);
}

function register_category_taxonomies()
{

    register_taxonomy('recipes_category', array('recipes'), array(
        'labels' => array(
            'name'              => 'Категории рецептов',
            'singular_name'     => 'Категория рецепта',
            'search_items'      => 'Поиск рецептов',
            'all_items'         => 'Все категории',
            'edit_item'         => 'Редактировать категорию',
            'update_item'       => 'Обновить категорию',
            'add_new_item'      => 'Добавить новую категорию',
            'new_item_name'     => 'Название новой категории',
            'menu_name'         => 'Категории рецептов',
        ),
        'hierarchical'      => true, // как рубрики
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'recipes-category'),
        'show_in_rest'      => true, // включить поддержку Gutenberg
    ));
}
add_action('init', 'register_category_taxonomies');
