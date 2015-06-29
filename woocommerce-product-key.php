<?php
/*
Plugin Name: WooCommerce Product Key
Plugin URI: 
Description: WooCommerce Product Key allows you to ceasily create a key of features for your products.
Version: 1.0
Author: Bradley Davis
Author URI: http://bradley-davis.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: wcpk

@author		 Bradley Davis
@package	 WooCommerce Product Key
@since		 1.0

WooCommerce Product Key. A Plugin that works with the WooCommerce plugin for WordPress.
Copyright (C) 2014 Bradley Davis - bd@bradley-davis.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

/**
 * Check if WooCommerce is active.
 * @since 1.0
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :

	class WooC_PK {

		/**
		 * The Constructor.
		 * @since 1.0
		 */
		public function __construct() {
			$this->wcpk_includes();

			add_action( 'wp_enqueue_scripts', array( $this, 'wcpk_enqueue_style' ) );
			//add_action( 'init', array( $this, 'wcpk_media' ) );
			//add_action( 'init', array( $this, 'wcpk_cpt' ) );
			//add_filter( 'woocommerce_single_product_summary', array( $this, 'wcpk_render_output_single_product'), 12 );
		}

		/**
		 * Add the includes.
		 * @since 1.0
		 */
		private function wcpk_includes() {
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-wcpk-cpt.php';
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-wcpk-cmb.php';
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-wcpk-settings.php';
		}

		/**
		 * Add Product Key styles.
		 * @since 1.0
		 */
		function wcpk_enqueue_style() {
			wp_enqueue_style( 'wcpk-style', trailingslashit( dirname( __FILE__ ) ) . 'css/wcpk.css', array(), '22062015' );
		}

	} // END WooC_PK class

	/**
	 * Instantiate the class and let the awesomeness happen!
	 * @since 1.0
	 */
	$wooc_pk = new WooC_PK();

endif;