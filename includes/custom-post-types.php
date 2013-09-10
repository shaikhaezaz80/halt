<?php

if( ! function_exists('chc_post_types_init') ) :

function chc_post_types_init() {
	
	$archives = defined( 'CHC_KB_DISABLE_ARCHIVE' ) && CHC_KB_DISABLE_ARCHIVE ? false : true;
	$slug     = defined( 'CHC_KB_SLUG' ) ? CHC_KB_SLUG : 'knowledgebase';
	$rewrite  = defined( 'CHC_KB_DISABLE_REWRITE' ) && CHC_KB_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$knowledgebase_labels =  apply_filters( 'chc_knowledgebase_labels', array(
		'name' 				=> '%2$s',
		'singular_name' 	=> '%1$s',
		'add_new' 			=> __( 'Add New', 'chc' ),
		'add_new_item' 		=> __( 'Add New %1$s', 'chc' ),
		'edit_item' 		=> __( 'Edit %1$s', 'chc' ),
		'new_item' 			=> __( 'New %1$s', 'chc' ),
		'all_items' 		=> __( 'All %2$s', 'chc' ),
		'view_item' 		=> __( 'View %1$s', 'chc' ),
		'search_items' 		=> __( 'Search %2$s', 'chc' ),
		'not_found' 		=> __( 'No %2$s found', 'chc' ),
		'not_found_in_trash'=> __( 'No %2$s found in Trash', 'chc' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( '%2$s', 'chc' )
	) );

	foreach ( $knowledgebase_labels as $key => $value ) {
	   $knowledgebase_labels[ $key ] = sprintf( $value, chc_get_label_singular(), chc_get_label_plural() );
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
		'supports' 			=> apply_filters( 'chc_knowledgebase_supports', array( 'title', 'editor', 'thumbnail' ) ),
	);

	register_post_type( 'knowledgebase', apply_filters( 'chc_knowledgebase_post_type_args', $knowledgebase_args ) );

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

	register_taxonomy( 'knowledgebase_tag',
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

add_action( 'init', 'chc_post_types_init', 1 );


/**
 * Get Default Labels
 *
 * @since 1.0
 * @return array $defaults Default labels
 */
function chc_get_default_knowledgebase_labels() {
	$defaults = array(
	   'singular' => __( 'Knowledgebase', 'chc' ),
	   'plural' => __( 'Knowledgebases', 'chc')
	);
	return apply_filters( 'chc_default_knowledgebase_name', $defaults );
}

/**
 * Get Singular Label
 *
 * @since 1.0.8.3
 * @return string $defaults['singular'] Singular label
 */
function chc_get_label_singular( $lowercase = false ) {
	$defaults = chc_get_default_knowledgebase_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0.8.3
 * @return string $defaults['plural'] Plural label
 */
function chc_get_label_plural( $lowercase = false ) {
	$defaults = chc_get_default_knowledgebase_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}
