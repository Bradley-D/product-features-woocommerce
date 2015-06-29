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
		$this->wcpk_media();
		$this->wcpk_settings();
	}

	/**
	 * Set media image sizes
	 * @since 1.0
	 */
	private function wcpk_media() {
		add_image_size( 'product_key_thumb', 100, 100, true );
		add_image_size( 'product_key_main', 300, 300, true );
	}

	/**
	* Add product key fields to WC Settings UI
	* @since 1.0
	*/
	private function wcpk_settings() {}
	
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_settings = new Wcpk_Settings();