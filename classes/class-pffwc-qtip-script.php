<?php
/*
 * Add the qTip script to the dom
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Pffwc_qtip_script {

	public function __construct() {
	  $this->pffwc_add_remove_actions();
	}

	public function pffwc_add_remove_actions() {
		add_action( 'wp_footer', array( $this, 'pffwc_add_js_head' ), 999 );
	}

	/**
	 * Add qTip function to DOM so we can pass it vars from php in the future.
	 * @since 1.0
	 */
	public function pffwc_add_js_head() { ?>
		<script type="text/javascript">
			(function($) {
				$('.pffwc-wrapper .pffwc-item a[data-tooltip != ""]').qtip({
					content: {
						attr: 'data-tooltip'
					},
					position: {
						my: 'bottom center',
						at: 'top  center',
					},
					style: {
						classes: 'pffwc-item-tooltip'
					},
				})
			})( jQuery );
		</script> <?php
	}

}

/**
 * Instantiate the class and let the awesomeness happen!
 * @since 1.0
 */
 $Pffwc_qTip_script = new Pffwc_qtip_script();
