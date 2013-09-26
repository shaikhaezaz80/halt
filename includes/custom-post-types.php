<?php

if( ! function_exists('halt_setup_halt_post_types') ) :

function halt_setup_halt_post_types() {
	
	$archives = defined( 'HALT_ARTICLE_ENABLE_ARCHIVE' ) && HALT_ARTICLE_ENABLE_ARCHIVE ? true : false;
	$slug     = defined( 'HALT_ARTICLE_SLUG' ) ? HALT_ARTICLE_SLUG : 'article';
	$rewrite  = defined( 'HALT_ARTICLE_DISABLE_REWRITE' ) && HALT_ARTICLE_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$article_labels =  apply_filters( 'halt_article_labels', array(
		'name'               => '%2$s',
		'singular_name'      => '%1$s',
		'add_new'            => __( 'Add New', 'halt' ),
		'add_new_item'       => __( 'Add New %1$s', 'halt' ),
		'edit_item'          => __( 'Edit %1$s', 'halt' ),
		'new_item'           => __( 'New %1$s', 'halt' ),
		'all_items'          => __( 'All %2$s', 'halt' ),
		'view_item'          => __( 'View %1$s', 'halt' ),
		'search_items'       => __( 'Search %2$s', 'halt' ),
		'not_found'          => __( 'No %2$s found', 'halt' ),
		'not_found_in_trash' => __( 'No %2$s found in Trash', 'halt' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( '%2$s', 'halt' )
	) );

	foreach ( $article_labels as $key => $value ) {
	   $article_labels[ $key ] = sprintf( $value, halt_get_label_singular(), halt_get_label_plural() );
	}

	$article_args = array(
		'labels'             => $article_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'query_var'          => true,
		'rewrite'            => $rewrite,
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'has_archive'        => $archives,
		'hierarchical'       => false,
		'supports'           => apply_filters( 'halt_article_supports', array( 'title', 'editor', 'revisions' ) )
	);

	register_post_type( 'article', apply_filters( 'halt_article_post_type_args', $article_args ) );

	register_taxonomy( 'article_cat',
	    array('article'),
	    array(
	        'hierarchical' => true,
	        'labels' => array(
				'name'              => __( 'Article Categories', 'halt'),
				'singular_name'     => __( 'Article Category', 'halt'),
				'search_items'      =>  __( 'Search Article Categories', 'halt'),
				'all_items'         => __( 'All Article Categories', 'halt'),
				'parent_item'       => __( 'Parent Article Category', 'halt'),
				'parent_item_colon' => __( 'Parent Article Category:', 'halt'),
				'edit_item'         => __( 'Edit Article Category', 'halt'),
				'update_item'       => __( 'Update Article Category', 'halt'),
				'add_new_item'      => __( 'Add New Article Category', 'halt'),
				'new_item_name'     => __( 'New Article Category', 'halt')
	        ),
			'show_ui'   => true,
			'query_var' => true,
			'rewrite'   => array( 'slug' => 'article-category' ),
	    )
	);

	register_taxonomy( 'article_tag',
	    array('article'),
	    array(
	        'hierarchical' => false,
	        'labels' => array(
				'name'              => __( 'Article Tags', 'halt'),
				'singular_name'     => __( 'Article Tag', 'halt'),
				'search_items'      =>  __( 'Search Article Tags', 'halt'),
				'all_items'         => __( 'All Article Tags', 'halt'),
				'parent_item'       => __( 'Parent Article Tag', 'halt'),
				'parent_item_colon' => __( 'Parent Article Tag:', 'halt'),
				'edit_item'         => __( 'Edit Article Tag', 'halt'),
				'update_item'       => __( 'Update Article Tag', 'halt'),
				'add_new_item'      => __( 'Add New Article Tag', 'halt'),
				'new_item_name'     => __( 'New Article Tag', 'halt')
	        ),
			'show_ui'           => true,
			'query_var'         => true,
			'show_in_nav_menus' => false,
			'rewrite'           => array( 'slug' => 'article-tags' ),
	    )
	);

}

endif;

add_action( 'init', 'halt_setup_halt_post_types', 1 );


/**
 * Get Default Labels
 *
 * @since 1.0
 * @return array $defaults Default labels
 */
function halt_get_default_article_labels() {
	$defaults = array(
	   'singular' => __( 'Article', 'halt' ),
	   'plural' => __( 'Articles', 'halt')
	);
	return apply_filters( 'halt_default_article_name', $defaults );
}

/**
 * Get Singular Label
 *
 * @since 1.0
 * @return string $defaults['singular'] Singular label
 */
function halt_get_label_singular( $lowercase = false ) {
	$defaults = halt_get_default_article_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0
 * @return string $defaults['plural'] Plural label
 */
function halt_get_label_plural( $lowercase = false ) {
	$defaults = halt_get_default_article_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}
