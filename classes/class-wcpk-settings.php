<?php
/*
 * Wcpk_Settings
 *
 * Set up the admin settings
 *
 * @author Bradley Davis
 * @package WooCommerce Product Key
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Wcpk_Settings {

	function __construct() {
		$this->init();
		$this->wcpk_media();
	}

	function init() {
		add_filter( 'woocommerce_get_sections_products', array( $this, 'wcpk_add_section' ) );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'wcpk_add_settings' ), 10, 2 );
	}

	/**
	 * Set media image sizes
	 * @since 1.0
	 */
	function wcpk_media() {
		add_image_size( 'product_key_thumb', 100, 100, true );
		add_image_size( 'product_key_main', 300, 300, true );
	}

	/**
	* Create the WCPK Section Tab under Product
	* @since 1.0
	*/
	// http://docs.woothemes.com/document/adding-a-section-to-a-settings-tab/
	function wcpk_add_section( $sections ) {
		$sections['wcpk_section'] = __( 'Product Key Settings', 'wcpk' );
		return $sections;
	}

	/**
	 * Create the WCPK settings
	 * @since 1.0
	 */
	function wcpk_add_settings( $settings, $current_section ) {
		
		if ( $current_section == 'wcpk_section' ) :

			$wcpk_add_settings = array();

			// Add title to section
			$wcpk_add_settings[] = array( 
				'name' => __( 'WooCommerce Product Key', 'wcpk' ), 
				'type' => 'title', 
				'desc' => __( 'The following options are used to configure WooCommerce Product Key. Start by choosing your key type (Feature Image, Font Awesome or Text), then set the size and choose the display location. ', 'wcpk' ), 
				'id'   => 'wcpk',
			);
			// Choose key
			$wcpk_add_settings[] = array(
				'title'    => __( 'Choose Key Type', 'wcpk' ),
				'desc'     => __( 'Choose Key Type.', 'wcpk' ),
				'id'       => 'wcpk_key_type',
				'type'     => 'select',
				'class'    => 'wcpk-select',
				'css'      => 'min-width:300px;',
				'default'  => 'wcpk-image-thumb',
				'desc_tip' =>  true,
				'options'  => array(
					'wcpk-image-thumb'      => __( 'Featured Image', 'wcpk' ),
					'wcpk-image-font'       => __( 'Font Awesome', 'wcpk' ),
					'wcpk-image-text'       => __( 'Text', 'wcpk' ),
				),
				'autoload' => false,
			);
			// Choose location to show product key
			$wcpk_add_settings[] = array(
				'title'    => __( 'Choose A Location', 'wcpk' ),
				'desc'     => __( 'Please be aware some themes may have moved features from their defult hooks so you may need to test location to get the desired result.', 'wcpk' ),
				'id'       => 'wcpk_render_location',
				'type'     => 'select',
				'class'    => 'wcpk-select',
				'css'      => 'min-width:300px;',
				'default'  => 'wcpk-after-add_cart',
				'desc_tip' =>  true,
				'options'  => array(
					'wcpk-after-gallery'      => __( 'After product gallery', 'wcpk' ),
					'wcpk-after-heading'        => __( 'After product heading', 'wcpk' ),
					'wcpk-after-price'        => __( 'After product price', 'wcpk' ),
					'wcpk-after-short-desc'   => __( 'After short description', 'wcpk' ),
					'wcpk-after-add-cart'     => __( 'After add to cart', 'wcpk' ),
					'wcpk-after-product-meta' => __( 'After product meta', 'wcpk' ),
				),
				'autoload' => false,
			);
			// Set image size
			$wcpk_add_settings[] = array(
				'title'       => __( 'Set Image Width', 'wcpk' ),
				'desc'        => __( 'Set image width with px, eg, 100px', 'wcpk' ),
				'placeholder' => 'Eg, 100px',
				'id'          => 'wcpk-image-width',
				'type'        => 'text',
				'css'         => '',
				'desc_tip'    => true,
			);
			$wcpk_add_settings[] = array(
				'title'       => __( 'Set Image Height', 'wcpk' ),
				'desc'        => __( 'Set image height with px, eg, 100px', 'wcpk' ),
				'placeholder' => 'Eg, 100px',
				'id'          => 'wcpk-image-height',
				'type'        => 'text',
				'css'         => '',
				'desc_tip'    => true,
			);
			// Set Font Awesome size
			$wcpk_add_settings[] = array(
				'title'  => __( 'Set Font Awesome Size', 'wcpk' ),
				'desc'   => __( 'Set font size with px or em, eg, 24px or 2em', 'wcpk' ),
				'placeholder' => 'Eg, 20px or 2em',
				'id'     => 'wcpk_fa_size',
				'type'   => 'text',
				'css'    => '',
				'desc_tip' => true,
			);
			$wcpk_add_settings[] = array(
				'title'  => __( 'Set Text Size', 'wcpk' ),
				'desc'   => __( 'Set text size with px or em, eg, 24px or 2em', 'wcpk' ),
				'placeholder' => 'Eg, 20px or 2em',
				'id'     => 'wcpk_text_size',
				'type'   => 'text',
				'css'    => '',
				'desc_tip' => true,
			);
			$wcpk_add_settings[] = array(
				'type' => 'sectionend',
				'id'   => 'wcpk_image'
			);
			// What creating a new tab? 

			$wcpk_add_settings[] = array(
				'type'     => 'sectionend',
				'id'       => 'wcpk',
			);
			return $wcpk_add_settings;
		else :
			return $settings;
		endif;
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_settings = new Wcpk_Settings();