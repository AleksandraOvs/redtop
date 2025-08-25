<?php

/**
 * redtop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package redtop
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
function redtop_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on redtop, use a find and replace
		* to change 'redtop' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('redtop', get_template_directory() . '/languages');

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
	add_image_size('medium', 700, 600, true);
	add_image_size('small', 400, 270, true);
	add_image_size('thumb', 250, 250, true);

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

	// Поддержка WooCommerce
	function theme_add_woocommerce_support()
	{
		add_theme_support('woocommerce');
	}
	add_action('after_setup_theme', 'theme_add_woocommerce_support');

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'redtop_custom_background_args',
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
	// add_theme_support(
	// 	'custom-logo',
	// 	array(
	// 		'height'      => 250,
	// 		'width'       => 250,
	// 		'flex-width'  => true,
	// 		'flex-height' => true,
	// 	)
	// );
}
add_action('after_setup_theme', 'redtop_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function redtop_content_width()
{
	$GLOBALS['content_width'] = apply_filters('redtop_content_width', 640);
}
add_action('after_setup_theme', 'redtop_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function redtop_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Footer-info', 'redtop'),
			'id'            => 'footer-info',
			'description'   => esc_html__('Add widgets here.', 'redtop'),
			// 'before_widget' => '<div id="%1$s" class="sidebar-part %2$s">',
			// 'after_widget'  => '</div>',
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
add_action('widgets_init', 'redtop_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function redtop_scripts()
{
	wp_enqueue_style('redtop-style', get_stylesheet_uri(), array(), time());
	wp_style_add_data('redtop-style', 'rtl', 'replace');
	wp_enqueue_style('fonts', get_stylesheet_directory_uri() . '/css/fonts.css', array(), time());
	wp_enqueue_style('color_palette', get_stylesheet_directory_uri() . '/css/color-palette.css', array(), time());
	wp_enqueue_style('fancy_styles', get_stylesheet_directory_uri() . '/css/jquery.fancybox.min.css', array(), time());
	wp_enqueue_style('normalize_styles', get_stylesheet_directory_uri() . '/css/normalize.css', array(), time());
	wp_enqueue_style('swiper_styles', get_stylesheet_directory_uri() . '/css/swiper-bundle.min.css', array(), time());
	wp_enqueue_style('redtop_styles', get_stylesheet_directory_uri() . '/css/style.css', array(), time());
	//wp_enqueue_style('editor_styles', get_stylesheet_directory_uri() . '/css/editor-styles.css', array(), time());
	wp_enqueue_style('animate_styles', get_stylesheet_directory_uri() . '/css/animate.css', array(), time());
	wp_enqueue_style('woo_styles', get_stylesheet_directory_uri() . '/css/woo-styles.css', array(), time());

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery_scripts', get_template_directory_uri() . '/js/jquery-3.7.1.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('redtop-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('js-accordion-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array(), null, true);
	wp_enqueue_script('fancy_scripts', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('swiper_scripts', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('redtop_scripts', get_template_directory_uri() . '/js/scripts.js', array(), _S_VERSION, true);
	wp_enqueue_script('redtop_slider_scripts', get_template_directory_uri() . '/js/slider-scripts.js', array(), _S_VERSION, true);
	//wp_enqueue_script('redtop_masonry_scripts', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js">', array(), _S_VERSION, true);
	wp_enqueue_script('js-accordion', get_template_directory_uri() . '/js/accordion.js', array(), null, true);
	wp_enqueue_script('js-woo', get_template_directory_uri() . '/js/woo.js', array(), null, true);
	wp_enqueue_script('js-loadmore', get_template_directory_uri() . '/js/ajax.js', array(), null, true);
	wp_localize_script('js-loadmore', 'ajaxData', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);

	// Подключаем скрипт
	wp_enqueue_script(
		'filter-posts', // ← ID скрипта
		get_template_directory_uri() . '/js/posts-script.js',
		array(),
		null,
		true // в футере
	);

	// Передаём ajaxurlObj в скрипт
	wp_localize_script('filter-posts', 'ajaxurlObj', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'redtop_scripts');





add_action('after_setup_theme', 'gut_styles');

function gut_styles()
{
	add_theme_support('editor-styles');
	add_editor_style('css/editor-styles.css');
}


add_action('wp_enqueue_scripts', function () {
	// Проверяем, главная страница
	if (is_front_page() || is_home()) {

		// Если скрипт зарегистрирован WooCommerce, подключаем
		if (wp_script_is('wc-add-to-cart', 'registered')) {
			wp_enqueue_script('wc-add-to-cart');
		}

		if (wp_script_is('wc-cart-fragments', 'registered')) {
			wp_enqueue_script('wc-cart-fragments');
		}

		// Иногда нужно подключить локализацию для ajax_add_to_cart
		if (!wp_script_is('wc-add-to-cart', 'enqueued')) {
			wp_localize_script('wc-add-to-cart', 'wc_add_to_cart_params', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'wc_ajax_url' => WC_AJAX::get_endpoint("%%endpoint%%"),
				'i18n_view_cart' => __('View cart', 'woocommerce'),
			));
		}
	}
}, 50); // Приоритет 50, чтобы WooCommerce успел зарегистрировать скрипты


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Initialization Carbon Fields
 */

require 'inc/carbon-fields.php';

/**
 * Initialization Carbon Fields
 */

require 'inc/breadcrumbs.php';

require 'inc/walker.php';

require 'inc/load-more.php';

require 'inc/woo.php';

/**
 * Initialization Post Types
 */

//require 'inc/post-types.php';

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

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


add_filter('template_include', 'var_template_include', 1000);
function var_template_include($t)
{
	$GLOBALS['current_theme_template'] = basename($t);
	return $t;
}

function get_current_template($echo = false)
{
	if (!isset($GLOBALS['current_theme_template']))
		return false;
	if ($echo)
		echo $GLOBALS['current_theme_template'];
	else
		return $GLOBALS['current_theme_template'];
}

## Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
add_filter('get_the_archive_title', function ($title) {
	return preg_replace('~^[^:]+: ~', '', $title);
});

// Contact Form 7 remove auto added p tags
add_filter('wpcf7_autop_or_not', '__return_false');

function add_categories_to_pages()
{
	register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'add_categories_to_pages');

//разрешить загрузку свг только админам
function allow_svg_upload_for_admins($mimes)
{
	if (current_user_can('administrator')) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload_for_admins');


//обработка ajax-запроса
add_action('wp_ajax_filter_works_by_category', 'handle_filter_works_ajax');
add_action('wp_ajax_nopriv_filter_works_by_category', 'handle_filter_works_ajax');

function handle_filter_works_ajax()
{
	$term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;

	$args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => -1,
	);

	if ($term_id && $term_id !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'projects_category',
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		);
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/project-item');
		}
	} else {
		echo '<p>Посты не найдены.</p>';
	}

	wp_die(); // важно завершить ajax
}

add_action('wp_ajax_rt_remove_from_cart', 'rt_remove_from_cart');
add_action('wp_ajax_nopriv_rt_remove_from_cart', 'rt_remove_from_cart');

function rt_remove_from_cart()
{
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

    if ($cart_item_key && WC()->cart->remove_cart_item($cart_item_key)) {
        // обновляем фрагменты мини-корзины
        WC_AJAX::get_refreshed_fragments();
    } else {
        wp_send_json_error();
    }
}