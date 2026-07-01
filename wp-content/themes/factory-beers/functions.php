<?php
/**
 * Factory Beers functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Factory_Beers
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function factory_beers_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Factory Beers, use a find and replace
		* to change 'factory-beers' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'factory-beers', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'factory-beers' ),
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
			'factory_beers_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

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
add_action( 'after_setup_theme', 'factory_beers_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function factory_beers_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'factory_beers_content_width', 640 );
}
add_action( 'after_setup_theme', 'factory_beers_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function factory_beers_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'factory-beers' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'factory-beers' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'factory_beers_widgets_init' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


function get_svg( $filename, $args = [] ) {
    $defaults = [
        'class' => '',
        'aria'  => true,
    ];
    $args = wp_parse_args( $args, $defaults );

    $path = get_template_directory() . '/assets/' . $filename . '.svg';

    if ( ! file_exists( $path ) ) {
        return '';
    }

    $svg = file_get_contents( $path );

    if ( ! empty( $args['class'] ) ) {
        $svg = str_replace( '<svg', '<svg class="' . esc_attr( $args['class'] ) . '"', $svg );
    }

    if ( ! $args['aria'] ) {
        $svg = str_replace( '<svg', '<svg aria-hidden="true" focusable="false"', $svg );
    }

    return $svg;
}

function the_svg( $filename, $args = [] ) {
    echo get_svg( $filename, $args );
}


/**
 * Enqueue scripts and styles.
 */
function factory_beers_scripts() {
	wp_enqueue_style( 'factory-beers-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'factory-beers-style', 'rtl', 'replace' );

	wp_enqueue_script( 'factory-beers-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_style(
        'mytheme-style',
        get_template_directory_uri() . '/build/main.css',
        [],
        '1.0.0'
    );
    wp_enqueue_script(
        'mytheme-script',
        get_template_directory_uri() . '/build/main.js',
        [],
        '1.0.0',
        true // loads in footer
    );

}
add_action( 'wp_enqueue_scripts', 'factory_beers_scripts' );

function mytheme_editor_styles() {
    add_editor_style( get_template_directory_uri() . '/build/editor.css' );
}
add_action( 'after_setup_theme', 'mytheme_editor_styles' );