<?php
/**
 * Airi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Airi
 */
define( 'AIRI_SKIP_AIRI_KIRKI_CUSTOM', 1 );
define( 'AIRI_SKIP_KIRKI', 1 );
if ( ! function_exists( 'airi_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function airi_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Airi, use a find and replace
		 * to change 'airi' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'airi', get_template_directory() . '/languages' );

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

		add_image_size( 'airi-720', 720 );
		add_image_size( 'airi-360-360', 360, 360, true );
		add_image_size( 'airi-850-485', 850, 485, true );
		add_image_size( 'airi-390-280', 390, 280, true );
		add_image_size( 'airi-969-485', 969, 485, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'airi' ),
			'menu-2' => esc_html__( 'Footer', 'airi' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'airi_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

	}
endif;
add_action( 'after_setup_theme', 'airi_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function airi_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'airi_content_width', 1170 ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound
}
add_action( 'after_setup_theme', 'airi_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function airi_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'airi' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'airi' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header', 'airi' ),
		'id'            => 'header-social',
		'description'   => esc_html__( 'Add widgets here.', 'airi' ),
		'before_widget' => '',
		// 'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '',
		// 'after_widget'  => '</section>',
		// 'before_title'  => '<h4 class="widget-title">',
		// 'after_title'   => '</h4>',
	) );


	//Footer widget areas
	$widget_areas = get_theme_mod( 'footer_widget_areas', '4' );
	for ( $i=1; $i <= $widget_areas; $i++ ) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'airi' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	register_widget( 'Airi_Logo' );
	register_widget( 'Airi_Social' );
	register_widget( 'Airi_Recent_Posts' );

}
add_action( 'widgets_init', 'airi_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function airi_scripts() {
	wp_enqueue_style( 'airi-style', get_stylesheet_uri() );

	wp_enqueue_script( 'airi-skip-link-focus-fix', get_template_directory_uri() . '/js/vendor/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_style( 'airi-font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );

	//Deregister FontAwesome from Elementor
	wp_deregister_style( 'font-awesome' );

	airi_fonts_load();

	//Load masonry
	$blog_layout = airi_blog_layout();
	if ( $blog_layout == 'layout-masonry' ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	wp_enqueue_script( 'airi-scripts', get_template_directory_uri() . '/js/vendor/scripts.js', array( 'jquery' ), '20180223', true );

	wp_enqueue_script( 'airi-main', get_template_directory_uri() . '/js/custom/custom.min.js', array( 'jquery' ), '20181017', true );	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'airi_scripts' );

 /**
 * Enqueue custom Elementor scripts
 */
function airi_elementor_scripts() {
	wp_enqueue_script( 'airi-navigation', get_template_directory_uri() . '/js/vendor/navigation.js', array( 'jquery', 'jquery-slick', 'imagesloaded' ), '20180717', true );
}
add_action('elementor/frontend/after_register_scripts', 'airi_elementor_scripts');

 /**
 * Enqueue Bootstrap (version)
 */
function airi_enqueue_bootstrap() {
	$_v = '';
	$_v = '5';
	wp_enqueue_style( 'airi-bootstrap', get_template_directory_uri() . "/css/bootstrap{$_v}/bootstrap.min.css", array(), true );
	// wp_enqueue_style( 'airi-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'airi_enqueue_bootstrap', 9 );

/**
 * Gutenberg
 */
function airi_editor_styles() {
	
	wp_enqueue_style( 'airi-block-editor-styles', get_theme_file_uri( '/editor-styles.css' ), '', '1.0', 'all' );
	
	airi_fonts_load();
}
add_action( 'enqueue_block_editor_assets', 'airi_editor_styles' );

/**
 * Disable Elementor globals on theme activation
 */
function airi_disable_elementor_globals () {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
}
add_action('after_switch_theme', 'airi_disable_elementor_globals');

/**
 * Custom Elementor widgets
 */
function airi_register_elementor_widgets() {

	if ( defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base') ) {

		require get_template_directory() . '/inc/compatibility/elementor/blocks/block-blog.php';
	}
}
add_action( 'elementor/widgets/widgets_registered', 'airi_register_elementor_widgets' );

/**
 * Custom Elementor category
 */
function airi_block_category() {
	
	if ( defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base') ) {
		\Elementor\Plugin::$instance->elements_manager->add_category( 
		'airi-elements',
		[
			'title' => __( 'Airi Elements', 'airi' ),
			'icon' => 'fa fa-plug',
		],
		1
		);		
	}	
}
add_action( 'elementor/elements/categories_registered', 'airi_block_category' );

/**
 * Customize Gutenberg Blocks
 */
/*
function airi_gutenberg_block( $blockContent, $block)
{
	if( $block['blockName'] === 'core/gallery' ) {
		$blockContent = $blockContent . '<pre>' . htmlspecialchars( print_r( $block, true ) ) . '</pre>';
	}
	return $blockContent;
}

add_filter('render_block', 'airi_gutenberg_block', 10, 2);
*/

add_shortcode( 'gallery_airi', 'airi_gallery_shortcode' );

/**
 * Builds the Gallery shortcode output.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @param array $attr {
 *     Attributes of the gallery shortcode.
 *
 *     @type string       $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
 *     @type string       $orderby    The field to use when ordering the images. Default 'menu_order ID'.
 *                                    Accepts any valid SQL ORDERBY statement.
 *     @type int          $id         Post ID.
 *     @type string       $itemtag    HTML tag to use for each image in the gallery.
 *                                    Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
 *     @type string       $icontag    HTML tag to use for each image's icon.
 *                                    Default 'dt', or 'div' when the theme registers HTML5 gallery support.
 *     @type string       $captiontag HTML tag to use for each image's caption.
 *                                    Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
 *     @type int          $columns    Number of columns of images to display. Default 3.
 *     @type string|int[] $size       Size of the images to display. Accepts any registered image size name, or an array
 *                                    of width and height values in pixels (in that order). Default 'thumbnail'.
 *     @type string		  $mode		  How to treat categories list
 * 										empty - display from all
 * 										rand - choose one randomly - every refresh
 *      								day - displayed category changes daily
 *	   @type string		  $categories A comma-separated list of IDs of categories to display. Default empty.
 * 	   @type string       $ids        A comma-separated list of IDs of attachments to display. Default empty.
 *     @type string       $include    A comma-separated list of IDs of attachments to include. Default empty.
 *     @type string       $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
 *     @type string       $link       What to link each image to. Default empty (links to the attachment page).
 *                                    Accepts 'file', 'none'.
 * }
 * @return string HTML content to display gallery.
 */
function airi_gallery_shortcode( $attr ) {
	if( ! empty( $attr['categories'] ) )
	{
		$catIds = array_filter( explode( ',', $attr['categories'] ) );
		if( $catIds )
		{
			$ids = empty( $attr['ids'] ) ? [] : explode( ',', $attr['ids'] );
			if( ! empty( $attr['mode'] ) ) {
				$count = count( $catIds );
				switch( $attr['mode'] ) {
					case 'day':
						$idx = intdiv( time(), 86400 ) % $count;
						break;
					case 'rand':
						$idx = mt_rand( 0, $count - 1 );
						break; 
				}
				$catIds = [ $catIds[$idx] ];
			}
			// $catIds = 5;
			$params = [
				'tax_query' => [
					[
						'taxonomy' => 'media_category',
						'terms' => $catIds
						// 'terms' => implode( ',', $catIds )
					]
				],
				'numberposts' => -1,
				'post_type' => 'attachment',
				'fields' => 'ids'
			];
			$att = get_posts( $params );
			$ids = array_merge( $ids, $att );
			// var_dump($idx, $ids, $params, $att);
			$attr['ids'] = implode( ',', $ids );
		}
	}
	return gallery_shortcode( $attr );
}

/**
 * Elementor skins
 */
add_action( 'elementor/init', 'airi_add_elementor_skins' );
function airi_add_elementor_skins(){
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-google-maps-skin.php';
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-image-icon-box-skin.php';
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin.php';
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-2.php';
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-3.php';
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-4.php';
	require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-6.php';
}

/**
 * Widgets
 */
require get_template_directory() . '/widgets/class-airi-logo.php';
require get_template_directory() . '/widgets/class-airi-social.php';
require get_template_directory() . '/widgets/class-airi-recent-posts.php';

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
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load Learnpress compatibility file.
 */
if ( class_exists( 'LearnPress' ) ) {
	require get_template_directory() . '/inc/compatibility/learnpress.php';
}

/**
 * WPML
 */
if ( class_exists( 'SitePress' ) ) {
	require get_template_directory() . '/inc/wpml/class-airi-wpml.php';
}

/**
 * Upsell
 */
require get_template_directory() . '/inc/customizer/upsell/class-customize.php';

/**
 * Theme dashboard.
 */
require get_template_directory() . '/theme-dashboard/class-theme-dashboard.php';

/**
 * Theme dashboard settings.
 */
require get_template_directory() . '/inc/theme-dashboard-settings.php';

/**
 * Review notice
 */
require get_template_directory() . '/inc/notices/class-airi-review.php';

function airi_fonts_load()
{
	/*
	if ( !class_exists( 'Kirki_Fonts' ) ) {
		wp_enqueue_style( 'airi-fonts', '//fonts.googleapis.com/css?family=Work+Sans:400,500,600', array(), null );
	}
	*/
	if ( !class_exists( 'Kirki_Fonts' ) ) {
		wp_enqueue_style( 'airi-fonts', '//fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', array(), null );
		/*
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
		*/
	}
}