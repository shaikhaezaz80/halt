<?php

if( ! function_exists('chc_post_types_init') ) :

function chc_post_types_init() {
    register_post_type( 'knowledgebase',
        array(
        	'label' => __( 'KB Article', 'chc' ),
            'labels' => array(
				'name' => __( 'KB Articles', 'chc' ),
				'singular_name' => __( 'KB Article', 'chc' ),
				'add_new' => __( 'Add New', 'chc' ),
				'add_new_item' => __( 'Add New KB Article', 'chc' ),
				'edit' => __( 'Edit', 'chc' ),
				'edit_item' => __( 'Edit KB Article', 'chc' ),
				'new_item' => __( 'New KB Article', 'chc' ),
				'view' => __( 'View KB articles', 'chc' ),
				'view_item' => __( 'View KB Article', 'chc' ),
				'search_items' => __( 'Search KB articles', 'chc' ),
				'not_found' => __( 'No KB articles found', 'chc' ),
				'not_found_in_trash' => __( 'No KB articles found in trash', 'chc' ),
				'parent' => __( 'Parent KB Article', 'chc' ),
            ),
            'description' => __( 'This is where you can create new knowledgebase articles for your site.', 'chc' ),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'hierarchical' => false,
            'rewrite' => array( 'slug' => 'knowledgebase', 'with_front' => false ),
            'query_var' => true,
            'has_archive' => 'knowledgebase',
            'supports' => array( 'title', 'editor', 'author' ),
        )
    );

	register_taxonomy( 'knowledgebase_category',
	    array('knowledgebase'),
	    array(
	        'hierarchical' => true,
	        'labels' => array(
	                'name' => __( 'KB Category', 'chc'),
	                'singular_name' => __( 'KB Categories', 'chc'),
	                'search_items' =>  __( 'Search KB Categories', 'chc'),
	                'all_items' => __( 'All KB Categories', 'chc'),
	                'parent_item' => __( 'Parent KB Category', 'chc'),
	                'parent_item_colon' => __( 'Parent KB Category:', 'chc'),
	                'edit_item' => __( 'Edit KB Category', 'chc'),
	                'update_item' => __( 'Update KB Category', 'chc'),
	                'add_new_item' => __( 'Add New KB Category', 'chc'),
	                'new_item_name' => __( 'New KB Category', 'chc')
	        ),
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'knowledgebase-category' ),
	    )
	);

	register_taxonomy( 'knowledgebase_tags',
	    array('knowledgebase'),
	    array(
	        'hierarchical' => false,
	        'labels' => array(
	                'name' => __( 'KB Tag', 'chc'),
	                'singular_name' => __( 'KB Tags', 'chc'),
	                'search_items' =>  __( 'Search KB Tags', 'chc'),
	                'all_items' => __( 'All KB Tags', 'chc'),
	                'parent_item' => __( 'Parent KB Tag', 'chc'),
	                'parent_item_colon' => __( 'Parent KB Tag:', 'chc'),
	                'edit_item' => __( 'Edit KB Tag', 'chc'),
	                'update_item' => __( 'Update KB Tag', 'chc'),
	                'add_new_item' => __( 'Add New KB Tag', 'chc'),
	                'new_item_name' => __( 'New KB Tag', 'chc')
	        ),
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'knowledgebase-tags' ),
	    )
	);

}

endif;

add_action( 'init', 'chc_post_types_init', 0 );
