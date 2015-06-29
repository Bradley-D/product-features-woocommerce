<?php
/*
 * Wcpk_Cmb
 *
 * Set up CMB2 metaboxes
 *
 * @author Bradley Davis
 * @package WooCommerce Product Key
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Wcpk_Cmb {

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	function __construct() {
		add_action( 'init', array( $this, 'wcpk_add_cmb_engine' ) );
		add_action( 'cmb2_init', array( $this, 'wcpk_add_metaboxes' ) );
	}

	/**
	* Get CMB2 awesomeness.
	* @since 1.0
	*/
	function wcpk_add_cmb_engine() {
		if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) :
			require_once dirname( __FILE__ ) . '/cmb2/init.php';
		elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) :
			require_once dirname( __FILE__ ) . '/CMB2/init.php';
		endif;
	}

	/**
	* Add CMB2 metaboxes to product-key custom post type.
	* @since 1.0
	*/
	function wcpk_add_metaboxes() {
		// Start with an underscore to hide fields from custom fields list
		$prefix = '_wcpk_';

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$wcpk_metaboxes = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Product Key', 'wcpk' ),
			'object_types'  => array( 'product-key', ), // Post type
			// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
			// 'context'    => 'normal',
			// 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) );
		$wcpk_metaboxes->add_field( array(
			'name'    => __( 'Tooltip Text', 'wcpk' ),
			'desc'    => __( 'This will be the text that will show when you hover over the product key anchor in the tooltip.', 'wcpk' ),
			'id'      => $prefix . 'wysiwyg',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 5, ),
		) );
		$wcpk_metaboxes->add_field( array(
			'name'       => __( 'Text or Icon Font Anchor', 'wcpk' ),
			'desc'       => __( 'Add the text or icon font to use for your product key tooltip anchor. ', 'wcpk' ),
			'id'         => $prefix . 'text',
			'type'       => 'text',
			'show_on_cb' => '_wcpk_hide_if_no_cats', // function should return a bool value
		) );
		$wcpk_metaboxes->add_field( array(
			'name' => __( 'Image Anchor', 'wcpk' ),
			'desc' => __( 'Upload an image or enter a URL.', 'wcpk' ),
			'id'   => $prefix . 'image',
			'type' => 'file',
		) );
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wooc_cmb = new Wcpk_Cmb();