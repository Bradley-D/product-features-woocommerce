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
	function __construct() {
		$this->init();
	}

	/**
	 * Init.
	 * @since 1.0
	 */
	function init() {

		// Location to add the product key(s)
		$wcpk_render_location_setting = get_theme_mod( 'wcpk_render_location', 'wcpk-after-short-desc' );
		var_dump( $wcpk_render_location_setting );
		switch ( $wcpk_render_location_setting ) :
			case 'wcpk-after-gallery' :
				add_action( 'woocommerce_before_single_product_summary', array( $this, 'wcpk_output_single_product'), 21 );
				break;
			case 'wcpk-after-heading' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 6 );
				break;
			case 'wcpk-after-price' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 11 );
				break;
			case 'wcpk-after-short-desc' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 21 );
				break;
			case 'wcpk-after-add-cart' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 31 );
				break;
			case 'wcpk-after-product-meta' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ),  41 );
				break;
		endswitch;
	}

	/**
	 * Render output - Single Product
	 * @since 1.0
	 */
	function wcpk_output_single_product() {
		// Get the product key(s) ID for the product
		$wcpk_product_key_check = get_post_meta( get_the_ID(), '_wcpk_product_key_values', true );

		// If product keys are assigned to product output
		if ( '' != $wcpk_product_key_check ) :

			// Get post type product key for query
			$wcpk_args = array(
				'post_type' => 'product-key',
			);

			// WCPK Query
			$wcpk_query = new WP_Query( $wcpk_args );

			// Loop through the WCPK query
			if ( $wcpk_query->have_posts() ) :

				echo '<div class="wcpk-wrapper">';

					while ( $wcpk_query->have_posts() ) : $wcpk_query->the_post();
						// The product key ID(s) are in the product key check variable it is time to party
						if ( in_array( get_the_ID(), $wcpk_product_key_check ) ) :

							// Get the product key assets
							$wcpk_tooltip_text = get_the_content();
							$wcpk_image = get_the_post_thumbnail( get_the_ID(), 'product_key_thumb' );

							// Output the product keys
							echo '<div class="wcpk-item"><a class="wcpk-tooltip" href="#" data-tooltip="' . $wcpk_tooltip_text . '">' . $wcpk_image . '</div></a>';

						 endif;
					endwhile;

				echo '</div>';

			endif;

			// Restore the data
			wp_reset_postdata();

		endif;
	}

	// function wcpk_render_output_archive() {}

	// function wcpk_render_output_single_key() {}
}

$wcpk_ouput = new Wcpk_Output();