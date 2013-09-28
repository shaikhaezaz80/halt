<?php
/**
 * Post Type Functions
 *
 * @package     Halt
 * @subpackage  Functions
 * @author   	Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers and sets up the custom post types
 *
 * @since 1.0
 * @return void
 */
function halt_setup_halt_post_types() {
	
	$article_archives = defined( 'HALT_ARTICLE_ENABLE_ARCHIVE' ) && HALT_ARTICLE_ENABLE_ARCHIVE ? true : false;
	$article_slug     = defined( 'HALT_ARTICLE_SLUG' ) ? HALT_ARTICLE_SLUG : 'article';
	$article_rewrite  = defined( 'HALT_ARTICLE_DISABLE_REWRITE' ) && HALT_ARTICLE_DISABLE_REWRITE ? false : array( 'slug' => $article_slug, 'with_front' => false );

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
	   $article_labels[ $key ] = sprintf( $value, halt_get_label_singular('article'), halt_get_label_plural('article') );
	}

	$article_args = array(
		'labels'             => $article_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'query_var'          => true,
		'rewrite'            => $article_rewrite,
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'has_archive'        => $article_archives,
		'hierarchical'       => false,
		'supports'           => apply_filters( 'halt_article_supports', array( 'title', 'editor', 'revisions' ) )
	);

	register_post_type( 'article', apply_filters( 'halt_article_post_type_args', $article_args ) );

	$ticket_archives = defined( 'HALT_TICKET_ENABLE_ARCHIVE' ) && HALT_TICKET_ENABLE_ARCHIVE ? false : true;
	$ticket_slug     = defined( 'HALT_TICKET_SLUG' ) ? HALT_TICKET_SLUG : 'ticket';
	$ticket_rewrite  = defined( 'HALT_TICKET_DISABLE_REWRITE' ) && HALT_TICKET_DISABLE_REWRITE ? false : array( 'slug' => $ticket_slug, 'with_front' => false );
	
	/** Tickets Post Type */
	$ticket_labels =  apply_filters( 'halt_ticket_labels', array(
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

	foreach ( $ticket_labels as $key => $value ) {
	   $ticket_labels[ $key ] = sprintf( $value, halt_get_label_singular('ticket'), halt_get_label_plural('ticket') );
	}

	$ticket_args = array(
		'labels'             => $ticket_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'query_var'          => true,
		'rewrite'            => $ticket_rewrite,
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'has_archive'        => $ticket_archives,
		'hierarchical'       => false,
		'supports'           => apply_filters( 'halt_ticket_supports', array( 'title', 'editor', 'author', 'comments' ) )
	);

	register_post_type( 'ticket', apply_filters( 'halt_ticket_post_type_args', $ticket_args ) );

}

add_action( 'init', 'halt_setup_halt_post_types', 1 );

/**
 * Registers the custom taxonomies for the custom post types
 *
 * @since 1.0
 * @return void
*/
function halt_setup_halt_taxonomies() {
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
	register_taxonomy_for_object_type( 'article_cat', 'article' );

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
	register_taxonomy_for_object_type( 'article_tag', 'article' );

	register_taxonomy( 'ticket_cat',
	    array('ticket'),
	    array(
	        'hierarchical' => true,
	        'labels' => array(
				'name'              => __( 'Ticket Categories', 'halt'),
				'singular_name'     => __( 'Ticket Category', 'halt'),
				'search_items'      =>  __( 'Search Ticket Categories', 'halt'),
				'all_items'         => __( 'All Ticket Categories', 'halt'),
				'parent_item'       => __( 'Parent Ticket Category', 'halt'),
				'parent_item_colon' => __( 'Parent Ticket Category:', 'halt'),
				'edit_item'         => __( 'Edit Ticket Category', 'halt'),
				'update_item'       => __( 'Update Ticket Category', 'halt'),
				'add_new_item'      => __( 'Add New Ticket Category', 'halt'),
				'new_item_name'     => __( 'New Ticket Category', 'halt')
	        ),
			'show_ui'   => true,
			'query_var' => true,
			'rewrite'   => array( 'slug' => 'ticket-category' ),
	    )
	);
	register_taxonomy_for_object_type( 'ticket_cat', 'ticket' );

	register_taxonomy( 'ticket_tag',
	    array('ticket'),
	    array(
	        'hierarchical' => false,
	        'labels' => array(
				'name'              => __( 'Ticket Tags', 'halt'),
				'singular_name'     => __( 'Ticket Tag', 'halt'),
				'search_items'      =>  __( 'Search Ticket Tags', 'halt'),
				'all_items'         => __( 'All Ticket Tags', 'halt'),
				'parent_item'       => __( 'Parent Ticket Tag', 'halt'),
				'parent_item_colon' => __( 'Parent Ticket Tag:', 'halt'),
				'edit_item'         => __( 'Edit Ticket Tag', 'halt'),
				'update_item'       => __( 'Update Ticket Tag', 'halt'),
				'add_new_item'      => __( 'Add New Ticket Tag', 'halt'),
				'new_item_name'     => __( 'New Ticket Tag', 'halt')
	        ),
			'show_ui'           => true,
			'query_var'         => true,
			'show_in_nav_menus' => false,
			'rewrite'           => array( 'slug' => 'ticket-tags' ),
	    )
	);
	register_taxonomy_for_object_type( 'ticket_tag', 'ticket' );
}
add_action( 'init', 'halt_setup_halt_taxonomies', 0 );

/**
 * Get Default Labels
 *
 * @since 1.0
 * @param string $post_type Post type
 * @return array $defaults Default labels
 */
function halt_get_default_article_labels( $post_type ) {

	if ( $post_type == 'article' ) {
		$defaults = array(
		   'singular' => __( 'Article', 'halt' ),
		   'plural' => __( 'Articles', 'halt')
		);
	} elseif ( $post_type == 'ticket' ) {
		$defaults = array(
		   'singular' => __( 'Ticket', 'halt' ),
		   'plural' => __( 'Tickets', 'halt')
		);
	}

	return apply_filters( 'halt_default_article_name', $defaults );
}

/**
 * Get Singular Label
 *
 * @since 1.0
 * @return string $defaults['singular'] Singular label
 */
function halt_get_label_singular( $post_type, $lowercase = false ) {
	$defaults = halt_get_default_article_labels($post_type);
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0
 * @return string $defaults['plural'] Plural label
 */
function halt_get_label_plural( $post_type, $lowercase = false ) {
	$defaults = halt_get_default_article_labels($post_type);
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

/**
 * Change default "Enter title here" input
 *
 * @since 1.0
 * @param string $title Default title placeholder text
 * @return string $title New placeholder text
 */
function halt_change_default_title( $title ) {
     $screen = get_current_screen();

     if ( 'article' == $screen->post_type ) {
     	$label = halt_get_label_singular('article');
        $title = sprintf( __( 'Enter %s title here', 'halt' ), $label );
     } elseif ( 'ticket' == $screen->post_type ) {
     	$label = halt_get_label_singular('ticket');
        $title = sprintf( __( 'Enter %s title here', 'halt' ), $label );
     }

     return $title;
}
add_filter( 'enter_title_here', 'halt_change_default_title' );
