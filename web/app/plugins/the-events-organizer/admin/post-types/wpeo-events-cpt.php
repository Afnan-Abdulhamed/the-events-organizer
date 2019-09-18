<?php
/**
 * Register a custom post type called "events".
 *
 * @package the events organizer
 */
    $labels = array(
        'name'                  => __( 'Events', 'Post type general name', 'events-organizer' ),
        'singular_name'         => __( 'Event', 'Post type singular name', 'events-organizer' ),
        'menu_name'             => __( 'Events', 'Admin Menu text', 'events-organizer' ),
        'name_admin_bar'        => __( 'Events', 'Add New on Toolbar', 'events-organizer' ),
        'add_new'               => __( 'Add New', 'events-organizer' ),
        'add_new_item'          => __( 'Add New Events', 'events-organizer' ),
        'new_item'              => __( 'New Events', 'events-organizer' ),
        'edit_item'             => __( 'Edit Events', 'events-organizer' ),
        'view_item'             => __( 'View Events', 'events-organizer' ),
        'all_items'             => __( 'All Events', 'events-organizer' ),
        'search_items'          => __( 'Search Events', 'events-organizer' ),
        'parent_item_colon'     => __( 'Parent Events:', 'events-organizer' ),
        'not_found'             => __( 'No Events found.', 'events-organizer' ),
        'not_found_in_trash'    => __( 'No Events found in Trash.', 'events-organizer' ),
        'featured_image'        => __( 'Events Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'events-organizer' ),
        'set_featured_image'    => __( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'events-organizer' ),
        'remove_featured_image' => __( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'events-organizer' ),
        'use_featured_image'    => __( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'events-organizer' ),
        'archives'              => __( 'Events archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'events-organizer' ),
        'insert_into_item'      => __( 'Insert into Events', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'events-organizer' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Events', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'events-organizer' ),
        'filter_items_list'     => __( 'Filter Events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'events-organizer' ),
        'items_list_navigation' => __( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'events-organizer' ),
        'items_list'            => __( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'events-organizer' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'events' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'  => array( 'post_tag', 'category' ),
    );
 
    register_post_type( 'events', $args );
    
