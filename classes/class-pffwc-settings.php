<?php
/*
 * pffwc_Settings
 *
 * Set up the admin settings
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Pffwc_Settings {

	public function __construct() {
		$this->pffwc_add_remove_actions();
		$this->pffwc_media();
	}

	public function pffwc_add_remove_actions() {
		add_action( 'customize_register', array( $this, 'pffwc_add_settings' ) );
	}

	/**
	 * Set media image sizes
	 * @since 1.0
	 */
	public function pffwc_media() {
		add_image_size( 'product_key_thumb', 100, 100, true );
	}

	/**
	 * Create the pffwc settings in the customizer
	 * @since 1.0
	 */
	public function pffwc_add_settings( $wp_customize ) {
		// Add section to WooCommerce Panel
		$wp_customize->add_section( 'pffwc_options',
			array(
				'title'      => __( 'Product Features', 'pffwc' ),
				'panel'      => 'woocommerce',
				'type'       => 'option',
				'capability' => '',
				'priority'   => 500,
			)
		);

		/*
		 * General options
		 * @since 1.0
		 */
		// Choose Product Feature location
		$wp_customize->add_setting( 'pffwc_render_location',
			array(
				'default' => 'pffwc_after_short_desc',
				'sanitize_callback' => array( $this, 'pffwc_sanitize_location' ),
			)
		);
		$wp_customize->add_control( 'pffwc_render_location',
			array(
				'label'    => __( 'Product Feature Location', 'pffwc' ),
				'description' => __( 'Choose the location that you would like the product feature to display.', 'pffwc'),
				'settings' => 'pffwc_render_location',
				'section'  => 'pffwc_options',
				'type'     => 'select',
				'choices'  => array(
					'pffwc_after_heading'      => __( 'After product heading', 'pffwc' ),
					'pffwc_after_price'        => __( 'After product price', 'pffwc' ),
					'pffwc_after_short_desc'   => __( 'After short description', 'pffwc' ),
					'pffwc_after_add_cart'     => __( 'After add to cart', 'pffwc' ),
					'pffwc_after_product_meta' => __( 'After product meta', 'pffwc' ),
				),
			)
		);
	}

	/**
	 * Customizer callbacks/sanitize all the things
	 * @since 1.0
	 */
	// Location
	function pffwc_sanitize_location( $input ) {
		$pffwc_valid_location = array(
			'pffwc_after_gallery'      => 'After product gallery',
			'pffwc_after_heading'      => 'After product heading',
			'pffwc_after_price'        => 'After product price',
			'pffwc_after_short_desc'   => 'After short description',
			'pffwc_after_add_cart'     => 'After add to cart',
			'pffwc_after_product_meta' => 'After product meta',
		);

		if ( array_key_exists( $input, $pffwc_valid_location ) ) :
			return $input;
		else :
			return '';
		endif;
	}

} // END Pffwc_Settings class

/**
 * Instantiate the class.
 * @since 1.0
 */
$pffwc_settings = new Pffwc_Settings();
