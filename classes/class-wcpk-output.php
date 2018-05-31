<?php
/*
 * Wcpk_Output
 *
 * Render the output for single products
 *
 * @author Bradley Davis
 * @package WooCommerce Product Key
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Wcpk_Output {

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	public function __construct() {
		$this->init();
		$this->wcpk_output_location();
	}

	/**
	 * Init.
	 * @since 1.0
	 */
	public function init() {
		$test = get_theme_mod( 'wcpk_image_width' );
	}

	/**
	 * Output location - Single Product.
	 * @since 1.0
	 */
	public function wcpk_output_location() {
		// Location to add the product key(s)
		$wcpk_render_location_setting = get_theme_mod( 'wcpk_render_location', 'wcpk_after_short_desc' );

		switch ( $wcpk_render_location_setting ) :
			case 'wcpk_after_gallery' :
				add_action( 'woocommerce_before_single_product_summary', array( $this, 'wcpk_output_single_product'), 21 );
				break;
			case 'wcpk_after_heading' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 6 );
				break;
			case 'wcpk_after_price' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 11 );
				break;
			case 'wcpk_after_short_desc' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 21 );
				break;
			case 'wcpk_after_add_cart' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 31 );
				break;
			case 'wcpk_after_product_meta' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ),  41 );
				break;
		endswitch;
	}

	/**
	 * Render output - Single Product
	 * @since 1.0
	 */
	public function wcpk_output_single_product() {
		// Get the product key(s) ID for the product
		$wcpk_product_key = get_post_meta( get_the_ID(), '_wcpk_product_key_values', true );

		// If product keys are assigned to product output
		if ( '' != $wcpk_product_key ) :

			$wcpk_render = '<div class="wcpk-wrapper">';

				foreach ( $wcpk_product_key as $keyId => $valueId ) :
					$wcpk_object = get_post( $valueId );
					$wcpk_object_title = $wcpk_object->post_title;
					$wcpk_tooltip = get_post_meta( $valueId, '_wcpk_textarea_meta_value_key', true );
					$wcpk_field_description = get_post_meta( $valueId, '_wcpk_text_field_meta_value_key', true );
					$wcpk_key_icon = ( '' != get_the_post_thumbnail( $valueId, 'product_key_thumb' ) ? get_the_post_thumbnail( $valueId, 'product_key_thumb' ) : $wcpk_object_title );
					//Output the product keys
					$wcpk_render .= '<div class="wcpk-item"><a class="wcpk-tooltip" href="#" data-html="true" data-tooltip="' . $wcpk_object_title . ' - ' . $wcpk_tooltip . '">' . $wcpk_key_icon . '</div></a>';
				endforeach;

			$wcpk_render .= '</div>';

		endif;

		echo $wcpk_render;
		
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_ouput = new Wcpk_Output();
