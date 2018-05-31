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
		$wcpk_product_key_check = get_post_meta( get_the_ID(), '_wcpk_product_key_values', true );
		print_r( $wcpk_product_key_check );

		// If product keys are assigned to product output
		if ( '' != $wcpk_product_key_check ) :

			// Get post type product key for query
			$wcpk_args = array(
				'post_type' => 'product-key',
			);

			// WCPK Query
			$wcpk_query = new WP_Query( $wcpk_args );

			// Loop through the WCPK query
			if ( $wcpk_query->have_posts() ) : ?>
				<div class="wcpk-wrapper"><?php
					while ( $wcpk_query->have_posts() ) : $wcpk_query->the_post();
						// The product key ID(s) are in the product key check variable it is time to party
						if ( in_array( get_the_ID(), $wcpk_product_key_check ) ) :
							// Get the product key assets
							$wcpk_tooltip_text = get_the_content();
							print_r( "tooltip check" . $wcpk_tooltip_text);
							$wcpk_image = get_the_post_thumbnail( get_the_ID(), 'product_key_thumb' );
							// Output the product keys ?>
							<div class="wcpk-item"><a class="wcpk-tooltip" href="#" data-tooltip="<?php echo $wcpk_tooltip_text; ?>"><?php echo $wcpk_image; ?></div></a><?php
						endif;
					endwhile; ?>
				</div><?php
			endif;

			// Restore the data
			wp_reset_postdata();

		endif;
	}

	// function wcpk_render_output_archive() {}

	// function wcpk_render_output_single_key() {}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_ouput = new Wcpk_Output();
