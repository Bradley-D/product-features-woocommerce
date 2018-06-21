<?php
/**
 * Delete WooCommerce Unit Of Measure data if plugin is deleted.
 *
 * @since 1.0
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) :
	exit;
endif;

class Pffwc_uninstall {

	public function __construct() {
		$this->wpdocs_delete_all_products();
	}

	function pffwc_add_remove_actions() {
		add_action( 'init', array( $this, 'wpdocs_delete_all_products') );
		remove_theme_mod( 'pffwc_render_location' );
	}

	/**
	 * Deletes all posts from Product Feature custom post type.
	 */
	function wpdocs_delete_all_products() {
	    $pffwc_delete_posts = get_pages(
				array(
					'post_type' => 'product-features'
				)
			);
	    foreach ( $pffwc_delete_posts as $pffwc_posts ) :
					wp_delete_attachment( $pffwc_posts->ID, false );
	        wp_delete_post( $pffwc_posts->ID, fase );
	    endforeach;
	}
}

$pffwc_uninstall = new Pffwc_uninstall();
