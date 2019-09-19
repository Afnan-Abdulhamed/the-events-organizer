<?php
/**
 * events-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package events-theme
 */

if ( ! function_exists( 'events_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function events_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on events-theme, use a find and replace
		 * to change 'events-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'events-theme', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'events-theme' ),
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
		add_theme_support( 'custom-background', apply_filters( 'events_theme_custom_background_args', array(
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
add_action( 'after_setup_theme', 'events_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function events_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'events_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'events_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function events_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'events-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'events-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'events_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function events_theme_scripts() {
	wp_enqueue_style( 'events-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'events-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'events-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'events_theme_scripts' );

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



define('temp_file', ABSPATH.'/_temp_out.txt' );

add_action("activated_plugin", "activation_handler1");
function activation_handler1(){
    $cont = ob_get_contents();
    if(!empty($cont)) file_put_contents(temp_file, $cont );
}

add_action( "pre_current_active_plugins", "pre_output1" );
function pre_output1($action){
    if(is_admin() && file_exists(temp_file))
    {
        $cont= file_get_contents(temp_file);
        if(!empty($cont))
        {
            echo '<div class="error"> Error Message:' . $cont . '</div>';
            @unlink(temp_file);
        }
    }
}

// add_action('pre_post_update', 'before_data_is_saved_function');

// function before_data_is_saved_function($post_id) {
// 	$msg = '<pre>' . var_export($post_id, true) . '</pre>';
// return true;
// }
// function wpb_custom_post_status(){
//     register_post_status('rejected', array(
//         'label'                     => 'rejected',
//         'public'                    => false,
//         'exclude_from_search'       => false,
//         'show_in_admin_all_list'    => false,
//         'show_in_admin_status_list' => false,
//         'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>' ),
//     ) );
// }
// add_action( 'init', 'wpb_custom_post_status' );

// add_filter( 'wp_insert_post_data', 'post_publish_filter_wpse_82356',99,2 );

// function post_publish_filter_wpse_82356( $data,  $postarr ) {
// 	global $wpdb;
//     // view/manipulate $data
//     if ($data['post_type'] == 'events') {
// 		$wpdb->insert('wp_wpeo_events', 
// 			array("event_author" => 0, 
// 			"event_date" => "2019-09-17 00:00:00", 
// 			"event_title"=>"addd",
// 			"event_content"=>"ssssssssssss"));
// 			// $data['post_status'] = '';
// 			// var_dump($data); wp_die('dd');
// 			$data['post_status'] = 'rejected';
// 		return $data ;

//     }
//     return $data;
// }

// function save_post_callback($post_id){wp_die("kj");
//     global $post; 
//     if ($post->post_type == 'events'){
// 		$wpdb->insert('wp_wpeo_events', 
// 			array("event_author" => 0, 
// 			"event_date" => "2019-09-17 00:00:00", 
// 			"event_title"=>"addd",
// 			"event_content"=>"ssssssssssss"));
//         return 0;
// 	}
//     //if you get here then it's your post type so do your thing....
// }


// function my_custom_save_post( $post_id ) {
// global $wpdb;
//     $wpdb->insert('wp_wpeo_events', 
// 		array("event_author" => 0, 
// 		"event_date" => "2019-09-17 00:00:00", 
// 		"event_title"=>"addd",
// 		"event_content"=>"ssssssssssss"));
// }
// add_action( 'save_post_events', 'my_custom_save_post' );




function populate_posts_data( $posts, $query ) {
	global $wpdb;
        $table_name = $wpdb->prefix . 'wpeo_events';

       $results= $wpdb->get_results(
            "SELECT * 
            FROM $table_name"
		);
		// print_r($query);wp_die();		
	print_r($results);wp_die();

	
	// if ( !count( $posts ) ) 
	// 	return $posts;  // posts array is empty send it back with thanks.
	// while( $posts as $post ) {
	// 	// query to get custom post data from custom table
	// 	$query = "SELECT * FROM {$wpdb->prefix}my_plugin_table WHERE post_id={$post->ID}";
	// 	$results = $wpdb->get_results( $query );
	// }
	return $posts = $results;
}
// add_filter( 'the_posts', 'populate_posts_data',99,2 );







// add_filter( 'manage_events_posts_columns', 'set_custom_edit_book_columns' );
// add_action( 'manage_events_posts_custom_column' , 'custom_book_column', 99, 2 );

// function set_custom_edit_book_columns($columns) {
// 	$cat = $columns['categories'];
// 	unset( $columns['tags'], $columns['title'], $columns['date'], $columns['categories']  );
//     $columns['event_title'] = 'Title';
// 	$columns['event_author'] = 'Organizer';
// 	$columns['categories'] = $cat;
	

//     return $columns;
// }

// function custom_book_column( $column, $post_id ) {
	
// 	global $wpdb;
// 	$table_name = $wpdb->prefix . 'wpeo_events';

// 	$results= $wpdb->get_results(
// 		"SELECT * 
// 		FROM $table_name
// 		"
// 	);
//     switch ( $column ) {
//         case 'event_title' : echo "sss";
//     }
// }


// /**
//  * Meta box display callback.
//  *
//  * @param WP_Post $post Current post object.
//  */
// function wpdocs_my_display_callback( $post ) {
//     // Display code/markup goes here. Don't forget to include nonces!
// }
 
// /**
//  * Save meta box content.
//  *
//  * @param int $post_id Post ID
//  */
// function wpdocs_save_meta_box( $post_id ) {
//     // Save logic goes here. Don't forget to include nonce checks!
// }
// add_action( 'save_post', 'wpdocs_save_meta_box' );