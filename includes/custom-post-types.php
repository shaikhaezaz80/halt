<?php

if( ! function_exists('halt_post_types_init') ) :

function halt_post_types_init() {
	
	$archives = defined( 'HALT_KB_DISABLE_ARCHIVE' ) && HALT_KB_DISABLE_ARCHIVE ? false : true;
	$slug     = defined( 'HALT_KB_SLUG' ) ? HALT_KB_SLUG : 'knowledgebase';
	$rewrite  = defined( 'HALT_KB_DISABLE_REWRITE' ) && HALT_KB_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$knowledgebase_labels =  apply_filters( 'halt_knowledgebase_labels', array(
		'name' 				=> '%2$s',
		'singular_name' 	=> '%1$s',
		'add_new' 			=> __( 'Add New', 'halt' ),
		'add_new_item' 		=> __( 'Add New %1$s', 'halt' ),
		'edit_item' 		=> __( 'Edit %1$s', 'halt' ),
		'new_item' 			=> __( 'New %1$s', 'halt' ),
		'all_items' 		=> __( 'All %2$s', 'halt' ),
		'view_item' 		=> __( 'View %1$s', 'halt' ),
		'search_items' 		=> __( 'Search %2$s', 'halt' ),
		'not_found' 		=> __( 'No %2$s found', 'halt' ),
		'not_found_in_trash'=> __( 'No %2$s found in Trash', 'halt' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( '%2$s', 'halt' )
	) );

	foreach ( $knowledgebase_labels as $key => $value ) {
	   $knowledgebase_labels[ $key ] = sprintf( $value, halt_get_label_singular(), halt_get_label_plural() );
	}

	$knowledgebase_args = array(
		'labels' 			=> $knowledgebase_labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> true,
		'rewrite' 			=> $rewrite,
		'capability_type' 	=> 'post',
		'map_meta_cap'      => true,
		'has_archive' 		=> $archives,
		'hierarchical' 		=> false,
		'supports' 			=> apply_filters( 'halt_knowledgebase_supports', array( 'title', 'editor', 'thumbnail' ) ),
	);

	register_post_type( 'knowledgebase', apply_filters( 'halt_knowledgebase_post_type_args', $knowledgebase_args ) );

	register_taxonomy( 'knowledgebase_category',
	    array('knowledgebase'),
	    array(
	        'hierarchical' => true,
	        'labels' => array(
	                'name' => __( 'KB Category', 'halt'),
	                'singular_name' => __( 'KB Categories', 'halt'),
	                'search_items' =>  __( 'Search KB Categories', 'halt'),
	                'all_items' => __( 'All KB Categories', 'halt'),
	                'parent_item' => __( 'Parent KB Category', 'halt'),
	                'parent_item_colon' => __( 'Parent KB Category:', 'halt'),
	                'edit_item' => __( 'Edit KB Category', 'halt'),
	                'update_item' => __( 'Update KB Category', 'halt'),
	                'add_new_item' => __( 'Add New KB Category', 'halt'),
	                'new_item_name' => __( 'New KB Category', 'halt')
	        ),
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'knowledgebase-category' ),
	    )
	);

	register_taxonomy( 'knowledgebase_tag',
	    array('knowledgebase'),
	    array(
	        'hierarchical' => false,
	        'labels' => array(
	                'name' => __( 'KB Tag', 'halt'),
	                'singular_name' => __( 'KB Tags', 'halt'),
	                'search_items' =>  __( 'Search KB Tags', 'halt'),
	                'all_items' => __( 'All KB Tags', 'halt'),
	                'parent_item' => __( 'Parent KB Tag', 'halt'),
	                'parent_item_colon' => __( 'Parent KB Tag:', 'halt'),
	                'edit_item' => __( 'Edit KB Tag', 'halt'),
	                'update_item' => __( 'Update KB Tag', 'halt'),
	                'add_new_item' => __( 'Add New KB Tag', 'halt'),
	                'new_item_name' => __( 'New KB Tag', 'halt')
	        ),
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'knowledgebase-tags' ),
	    )
	);

}

endif;

add_action( 'init', 'halt_post_types_init', 1 );


/**
 * Get Default Labels
 *
 * @since 1.0
 * @return array $defaults Default labels
 */
function halt_get_default_knowledgebase_labels() {
	$defaults = array(
	   'singular' => __( 'Knowledgebase', 'halt' ),
	   'plural' => __( 'Knowledgebases', 'halt')
	);
	return apply_filters( 'halt_default_knowledgebase_name', $defaults );
}

/**
 * Get Singular Label
 *
 * @since 1.0
 * @return string $defaults['singular'] Singular label
 */
function halt_get_label_singular( $lowercase = false ) {
	$defaults = halt_get_default_knowledgebase_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0
 * @return string $defaults['plural'] Plural label
 */
function halt_get_label_plural( $lowercase = false ) {
	$defaults = halt_get_default_knowledgebase_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}
