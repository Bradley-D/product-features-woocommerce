<?php
/*
Plugin Name: Product Features For WooCommerce
Plugin URI:
Description: Product Features For WooCommerce allows you to create many product features for your products and display them in a beautiful way.
Version: 1.1
Author: Bradley Davis
Author URI: http://bradley-davis.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: pffwc
WC requires at least: 3.0.0
WC tested up to: 3.4.3

@author		 Bradley Davis
@package	 Product Features For WooCommerce
@since		 1.0

Product Features For WooCommerce. A Plugin that works with the WooCommerce plugin for WordPress.
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

	class Pffwc {

		/**
		 * The Constructor.
		 * @since 1.0
		 */
		public function __construct() {
			$this->pffwc_add_remove_actions();
			$this->pffwc_includes();
		}

		/**
		 * Init.
		 * @since 1.0
		 */
		public function pffwc_add_remove_actions() {
			add_action( 'wp_enqueue_scripts', array( $this, 'pffwc_enqueue_style' ) );
			add_action( 'admin_head', array( $this, 'pffwc_cpt_ui_style' ) );
		}

		/**
		 * Add the includes.
		 * @since 1.0
		 */
		public function pffwc_includes() {
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-pffwc-cpt.php';
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-pffwc-settings.php';
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-pffwc-metaboxes.php';
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-pffwc-output.php';
			require_once trailingslashit( dirname( __FILE__ ) ) . 'classes/class-pffwc-qtip-script.php';
		}

		/**
		 * Enqueue Product Feature styles.
		 * @since 1.0
		 */
		public function pffwc_enqueue_style() {
			if ( is_product() ) :
				wp_enqueue_style( 'qtip', plugins_url( '/includes/jquery.qtip.min.css', __FILE__ ), null, false, false);
				wp_enqueue_script( 'qtip', plugins_url( '/includes/jquery.qtip.min.js', __FILE__ ), array('jquery'), false, true);
				wp_enqueue_style( 'pffwc-style', plugins_url( '/css/pffwc.css', __FILE__ ), '22062018' );
			endif;
		}

		/**
		 * Enqueue CPT UI style.
		 * @since 1.1
		 */
		 public function pffwc_cpt_ui_style() {
			 wp_enqueue_style( 'cpt-ui-style', plugins_url( '/css/pffwc-cpt-ui.css', __FILE__ ), '22062018' );
		 }

	} // END Pffwc class

	/**
	 * Instantiate the class and let the awesomeness happen!
	 * @since 1.0
	 */
	 $pffwc = new Pffwc();
endif;
