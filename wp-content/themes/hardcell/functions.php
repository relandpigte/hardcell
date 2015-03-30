<?php
/**
 * Hard Cell functions and definitions
 *
 * @package Hard Cell
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'hardcell_awesome_cooltheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hardcell_awesome_cooltheme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Hard Cell, use a find and replace
	 * to change 'hardcell-awesome-cooltheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'hardcell-awesome-cooltheme', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hardcell-awesome-cooltheme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hardcell_awesome_cooltheme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // hardcell_awesome_cooltheme_setup
add_action( 'after_setup_theme', 'hardcell_awesome_cooltheme_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function hardcell_awesome_cooltheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'hardcell-awesome-cooltheme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	/* register_sidebar( array(
		'name'          => __( 'Footer widget', 'hardcell-awesome-cooltheme' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) ); */
}
add_action( 'widgets_init', 'hardcell_awesome_cooltheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hardcell_awesome_cooltheme_scripts() {
	wp_enqueue_style( 'hardcell-awesome-cooltheme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'hardcell-awesome-cooltheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	
	wp_enqueue_script( 'cufon', '//cdnjs.cloudflare.com/ajax/libs/cufon/1.09i/cufon-yui.js', array('jquery'), '21120206' );
	wp_enqueue_script( 'AkzidenzGrotesk_500', get_template_directory_uri() . '/fonts/AkzidenzGrotesk_500.font.js', array(), '22120206' );
	wp_enqueue_script( 'AkzidenzGroteskExtraBold_700', get_template_directory_uri() . '/fonts/AkzidenzGroteskExtraBold_700.font.js', array(), '22120206' );
	
	wp_enqueue_script( 'rhinoslider', get_template_directory_uri() . '/js/slider/rhinoslider-1.05.min.js', array(), '22120206' );
	wp_enqueue_script( 'mousewheel', get_template_directory_uri() . '/js/slider/mousewheel.js', array(), '22120206' );
	wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/slider/easing.js', array(), '22120206' );
	
	
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'cufon'), '23120206' );

	wp_enqueue_script( 'hardcell-awesome-cooltheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hardcell_awesome_cooltheme_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/* Remove the breadcrumbs */
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);


/* This snippet removes the action that inserts thumbnails to products in teh loop
 * and re-adds the function customized with our wrapper in it.
 * It applies to all archives with products.
 *
 * @original plugin: WooCommerce
 * @author of snippet: Brian Krogsard
 */

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
 * WooCommerce Loop Product Thumbs
 **/

 if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {

	function woocommerce_template_loop_product_thumbnail() {
		echo woocommerce_get_product_thumbnail();
	} 
 }


/**
 * WooCommerce Product Thumbnail
 **/
 if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
	
	function woocommerce_get_product_thumbnail( $size = 'full', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post, $woocommerce;

		if ( ! $placeholder_width )
			$placeholder_width = wc_get_image_size('shop_catalog_image_width');
		if ( ! $placeholder_height )
			$placeholder_height = wc_get_image_size('shop_catalog_image_width');
			
			$output = '<div class="thumb-wrapper">';

			if ( has_post_thumbnail() ) {
				
				$output .= get_the_post_thumbnail( $post->ID, $size ); 
				
			} else {
			
				$output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
			
			}
			
			$output .= '</div>';
			
			return $output;
	}
 }
 
 
 /**
 * Comment template callback
 **/
 
 function hardcell_awesome_cooltheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
	</div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<br />
	<?php endif; ?>
	
	<?php comment_text(); ?>

	<div class="reply">
	<?php printf( __('%1$s'), get_comment_date() ); ?> | <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}