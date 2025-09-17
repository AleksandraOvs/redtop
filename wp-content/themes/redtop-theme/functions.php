<?php

/**
 * redtop-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package redtop-theme
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function redtop_theme_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on redtop-theme, use a find and replace
		* to change 'redtop-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('redtop-theme', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main_menu' => esc_html__('Primary', 'redtop'),
			'footer_menu' => esc_html__('Footer menu', 'redtop'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'redtop_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'redtop_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function redtop_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('redtop_theme_content_width', 640);
}
add_action('after_setup_theme', 'redtop_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function redtop_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Footer-info', 'redtop-theme'),
			'id'            => 'footer-info',
			'description'   => esc_html__('Add widgets here.', 'redtop-theme'),
			// 'before_widget' => '<section id="%1$s" class="widget %2$s">',
			// 'after_widget'  => '</section>',
			// 'before_title'  => '<h2 class="widget-title">',
			// 'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Footer-widget #1', 'redtop'),
			'id'            => 'footer-sidebar1',
			'description'   => esc_html__('Add widgets here.', 'redtop'),
			'before_widget' => '<div id="%1$s" class="widget-item">',
			'after_widget'  => '</div>',
			// 'before_title'  => '<h2 class="widget-title">',
			// 'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Footer widget #2', 'redtop'),
			'id'            => 'footer-sidebar2',
			'description'   => esc_html__('Add widgets here.', 'redtop'),
			'before_widget' => '<div id="%1$s" class="widget-item">',
			'after_widget'  => '</div>',
			// 'before_title'  => '<h2 class="widget-title">',
			// 'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Footer widget #3', 'redtop'),
			'id'            => 'footer-sidebar3',
			'description'   => esc_html__('Add widgets here.', 'redtop'),
			'before_widget' => '<div id="%1$s" class="widget-item">',
			'after_widget'  => '</div>',
			// 'before_title'  => '<h2 class="widget-title">',
			// 'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Footer widget #4', 'redtop'),
			'id'            => 'footer-sidebar4',
			'description'   => esc_html__('Add widgets here.', 'redtop'),
			'before_widget' => '<div id="%1$s" class="widget-item">',
			'after_widget'  => '</div>',
			// 'before_title'  => '<h2 class="widget-title">',
			// 'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'redtop_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function redtop_theme_scripts()
{
	wp_enqueue_style('redtop-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('redtop-theme-style', 'rtl', 'replace');

	wp_enqueue_style('fonts', get_stylesheet_directory_uri() . '/css/fonts.css', array(), time());
	wp_enqueue_style('color_palette', get_stylesheet_directory_uri() . '/css/color-palette.css', array(), time());
	wp_enqueue_style('fancy_styles', get_stylesheet_directory_uri() . '/css/jquery.fancybox.min.css', array(), time());
	wp_enqueue_style('normalize_styles', get_stylesheet_directory_uri() . '/css/normalize.css', array(), time());
	wp_enqueue_style('swiper_styles', get_stylesheet_directory_uri() . '/css/swiper-bundle.min.css', array(), time());
	wp_enqueue_style('redtop_styles', get_stylesheet_directory_uri() . '/css/style.css', array(), time());
	wp_enqueue_style('animate_styles', get_stylesheet_directory_uri() . '/css/animate.css', array(), time());
	wp_enqueue_style('woo_styles', get_stylesheet_directory_uri() . '/css/woo-styles.css', array(), time());


	// wp_deregister_script('jquery');
	// wp_enqueue_script('jquery_scripts', get_template_directory_uri() . '/js/jquery-3.7.1.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('redtop-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('redtop_scripts', get_template_directory_uri() . '/js/scripts.js', array(), _S_VERSION, true);
	wp_enqueue_script('fancy_scripts', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('swiper_scripts', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('slider_scripts', get_template_directory_uri() . '/js/slider-scripts.js', array(), _S_VERSION, true);
	wp_enqueue_script('woo_scripts', get_template_directory_uri() . '/js/woo.js', array(), _S_VERSION, true);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// Подключаем скрипт
	wp_enqueue_script(
		'filter-recipes', // ← ID скрипта
		get_template_directory_uri() . '/js/posts-script.js',
		array(),
		null,
		true // в футере
	);

	// Передаём ajaxurlObj в скрипт
	wp_localize_script('filter-recipes', 'ajaxurlObj', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));
}
add_action('wp_enqueue_scripts', 'redtop_theme_scripts');

function gut_styles()
{
	add_theme_support('editor-styles');
	add_editor_style('css/editor-styles.css');
}
add_action('after_setup_theme', 'gut_styles');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Initialization Carbon Fields
 */

require 'inc/carbon-fields.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


require 'inc/woo.php';

require 'inc/post-types.php';

require 'inc/current-temp.php';

//require 'inc/mini-cart.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

## Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
add_filter('get_the_archive_title', function ($title) {
	return preg_replace('~^[^:]+: ~', '', $title);
});

// Contact Form 7 remove auto added p tags
add_filter('wpcf7_autop_or_not', '__return_false');

//разрешить загрузку свг только админам
function allow_svg_upload_for_admins($mimes)
{
	if (current_user_can('administrator')) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload_for_admins');

// Обработка ajax-запроса
add_action('wp_ajax_filter_recipes', 'handle_filter_recipes_ajax');
add_action('wp_ajax_nopriv_filter_recipes', 'handle_filter_recipes_ajax');

function handle_filter_recipes_ajax()
{
	$term_id = isset($_POST['term_id']) ? $_POST['term_id'] : 0;

	$args = array(
		'post_type'      => 'recipes',
		'posts_per_page' => -1,
	);

	if ($term_id && $term_id !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'recipes_category',
				'field'    => 'term_id',
				'terms'    => intval($term_id),
			),
		);
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/content-recipe');
		}
	} else {
		echo '<p>Посты не найдены.</p>';
	}

	wp_die(); // завершает ajax-запрос
}

// Добавляем класс .tag-sale товарам с меткой sale
add_filter('post_class', function ($classes, $class, $post_id) {
	if ('product' === get_post_type($post_id)) {
		if (has_term('sale', 'product_tag', $post_id)) {
			$classes[] = 'tag-sale';
		}
	}
	return $classes;
}, 10, 3);
