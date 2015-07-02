<?php
/*
 * Wcpk_Cpt
 *
 * Register custom post type project-key
 *
 * @author Bradley Davis
 * @package WooCommerce Product Key
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Wcpk_Cpt {

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	function __construct() {
		add_action( 'init', array( $this, 'wcpk_cpt' ) );
	}

	/**
	 * Register Product Key custom post type
	 * @since 1.0
	 */
	function wcpk_cpt() {
		$labels = array(
			'name'               => _x( 'Product Keys', 'post type general name', 'wcpk' ),
			'singular_name'      => _x( 'Product Key', 'post type singular name', 'wcpk' ),
			'menu_name'          => _x( 'Product Keys', 'admin menu', 'wcpk' ),
			'name_admin_bar'     => _x( 'Product Key', 'add new on admin bar', 'wcpk' ),
			'add_new'            => _x( 'Add New', 'Product Key', 'wcpk' ),
			'add_new_item'       => __( 'Add New Product Key', 'wcpk' ),
			'new_item'           => __( 'New Product Key', 'wcpk' ),
			'edit_item'          => __( 'Edit Product Key', 'wcpk' ),
			'view_item'          => __( 'View Product Key', 'wcpk' ),
			'all_items'          => __( 'All Product Keys', 'wcpk' ),
			'search_items'       => __( 'Search Product Keys', 'wcpk' ),
			'parent_item_colon'  => __( 'Parent Product Keys:', 'wcpk' ),
			'not_found'          => __( 'No Product Keys found.', 'wcpk' ),
			'not_found_in_trash' => __( 'No Product Keys found in Trash.', 'wcpk' )
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'product-key' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-admin-network',
			'supports'           => array( 'title', 'thumbnail' )
		);
		register_post_type( 'product-key', $args );
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wooc_cpt = new Wcpk_Cpt();