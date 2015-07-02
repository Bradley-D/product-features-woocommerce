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
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcpk_output_single_product' ), 35 );
	}

	/**
	 * Render output - Single Product
	 * @since 1.0
	 */
	// Need to add function in here
	// - only applicable to the product
	public function wcpk_output_single_product() {
		// Get some post keys args
		$wcpk_args = array(
			'post_type' => 'product-key',
		);

		// WCPK Query
		$wcpk_query = new WP_Query( $wcpk_args );

		// Loop through the WCPK query
		if ( $wcpk_query->have_posts() ) :
			echo '<div class="wcpk-wrapper">';
				while ( $wcpk_query->have_posts() ) : $wcpk_query->the_post();
					$wcpk_tooltip_text = get_post_meta( get_the_ID(), '_wcpk_textarea_meta_value_key', true );
					$wcpk_image = get_the_post_thumbnail( get_the_ID(), 'thumbnail');
					echo '<div class="wcpk-item"><a class="wcpk-tooltip" href="#" data-tooltip="' . $wcpk_tooltip_text . '">' . $wcpk_image . '</div></a>';

				endwhile;
			echo '</div>';
		endif;

		// Restore the data
		wp_reset_postdata();
	}

	// function wcpk_render_output_archive() {}

	// function wcpk_render_output_single_key() {}
}

$wcpk_ouput = new Wcpk_Output();