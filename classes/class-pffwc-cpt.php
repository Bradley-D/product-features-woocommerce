<?php
/*
 * Register custom post type Product Features
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Pffwc_Cpt {

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	public function __construct() {
		$this->pffwc_add_remove_actions();
	}

	public function pffwc_add_remove_actions() {
		add_action( 'init', array( $this, 'pffwc_cpt' ) );
	}

	/**
	 * Register Product Key custom post type
	 * @since 1.0
	 */
	public function pffwc_cpt() {
		$labels = array(
			'name'               => _x( 'Product Features', 'post type general name', 'pffwc' ),
			'singular_name'      => _x( 'Product Feature', 'post type singular name', 'pffwc' ),
			'menu_name'          => _x( 'Product Features', 'admin menu', 'pffwc' ),
			'name_admin_bar'     => _x( 'Product Feature', 'add new on admin bar', 'pffwc' ),
			'add_new'            => _x( 'Add New', 'Product Feature', 'pffwc' ),
			'add_new_item'       => __( 'Add New Product Feature', 'pffwc' ),
			'new_item'           => __( 'New Product Feature', 'pffwc' ),
			'edit_item'          => __( 'Edit Product Feature', 'pffwc' ),
			'view_item'          => __( 'View Product Feature', 'pffwc' ),
			'all_items'          => __( 'All Product Features', 'pffwc' ),
			'search_items'       => __( 'Search Product Features', 'pffwc' ),
			'parent_item_colon'  => __( 'Parent Product Features:', 'pffwc' ),
			'not_found'          => __( 'No Product Features found.', 'pffwc' ),
			'not_found_in_trash' => __( 'No Product Features found in Trash.', 'pffwc' )
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'product-features' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 58,
			'menu_icon'          => 'dashicons-admin-network',
			'supports'           => array( 'title', 'thumbnail' )
		);
		register_post_type( 'product-features', $args );
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$pffwc_cpt = new Pffwc_Cpt();
