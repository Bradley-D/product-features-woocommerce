<?php
/*
 * WooCommerce Product Key Metaboxes
 *
 * Add metaboxes
 *
 * @author Bradley Davis
 * @package WooCommerce Product Key
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;


class Wcpk_Metaboxes { 

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	function __construct() {
		$this->init();
	}

	function init() {
		// Product Key
		add_action( 'add_meta_boxes', array( $this, 'wcpk_add_metabox' ) );
		add_action( 'save_post', array( $this, 'wcpk_save_metabox' ) );
		// WooCommerce Product
		add_action( 'add_meta_boxes', array( $this, 'wcpk_wc_add_metabox' ) );
		add_action( 'save_post', array( $this, 'wcpk_wc_save_metabox' ) );
	}

	/**
	 * Product Key: Adds metabox container
	 * @since 1.0
	 */
	function wcpk_add_metabox() {
		add_meta_box(
			'wcpk_metaboxes', 
			__( 'WooCommerce Product Key', 'wcpk' ),
			array( $this, 'wcpk_render_metabox_content' ),
			'product-key',
			'normal',
			'low'
		);
	}

	/**
	 * Product Key: Save the meta when the post is saved.
	 * @since 1.0
	 */
	public function wcpk_save_metabox( $post_id ) {	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['wcpk_inner_custom_box_nonce'] ) ) :
			return $post_id;
		endif;

		$nonce = $_POST['wcpk_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wcpk_inner_custom_box' ) ) :
			return $post_id;
		endif;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
			return $post_id;
		endif;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) :
			if ( ! current_user_can( 'edit_page', $post_id ) ) :
				return $post_id;
			endif;
		else :
			if ( ! current_user_can( 'edit_post', $post_id ) ) :
				return $post_id;
			endif;
		endif;

		/* OK, its safe for us to save the data now. */
		if ( ! isset( $_POST['wcpk_text_field'] ) ) :
			return;
		endif;
		// Sanitize the user input.
		$wcpk_textarea_data = sanitize_text_field( $_POST['wcpk_textarea_field'] );
		$wcpk_text_data = sanitize_text_field( $_POST['wcpk_text_field'] );

		// Update the meta field.
		update_post_meta( $post_id, '_wcpk_textarea_meta_value_key', $wcpk_textarea_data );
		update_post_meta( $post_id, '_wcpk_text_field_meta_value_key', $wcpk_text_data );
	}

	/**
	 * Product Key: Render Meta Box content.
	 * @since 1.0
	 */
	public function wcpk_render_metabox_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wcpk_inner_custom_box', 'wcpk_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$wcpk_textarea_field = get_post_meta( $post->ID, '_wcpk_textarea_meta_value_key', true );
		$wcpk_text_field = get_post_meta( $post->ID, '_wcpk_text_field_meta_value_key', true );

		// Display the form, using the current value.
		echo '<p><label for="wcpk-textarea_field">' . _e( 'Tooltip Text', 'wcpk' ) . '</label>
				<textarea name="wcpk_textarea_field" id="wcpk_textarea_field" cols="60" rows="4">' . esc_attr( $wcpk_textarea_field ) . '</textarea></p>';

		echo '<p><label for="wcpk_text_field">' . _e( 'Description for this field', 'wcpk' ) . '</label> 
				<input type="text" id="wcpk_text_field" name="wcpk_text_field" value="' . esc_attr( $wcpk_text_field ) . '" size="60" /></p>';
	}

	/**
	 * WC Product: Adds metabox container
	 * @since 1.0
	 */
	function wcpk_wc_add_metabox() {	
		add_meta_box(
			'wcpk_wc_metaboxes', 
			__( 'Select Product Key', 'wcpk' ),
			array( $this, 'wcpk_wc_render_metabox_content' ),
			'product',
			'side',
			'default'
		);
	}

	/**
	 * WC Product: Save the meta when the post is saved.
	 * @since 1.0
	 */
	public function wcpk_wc_save_metabox( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['wcpk_wc_metabox_nonce'] ) ) :
			return $post_id;
		endif;

		$nonce = $_POST['wcpk_wc_metabox_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wcpk_wc_save_metabox_nonce' ) ) :
			return $post_id;
		endif;

		// If this is an autosave, out form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
			return $post_id;
		endif;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) :
			if ( ! current_user_can( 'edit_post', $post_id ) ) :
				return $post_id;
			endif;
		else :
			if ( ! current_user_can( 'edit_post', $post_id ) ) :
				return $post_id;
			endif;
		endif;

	    // OK, its safe for us to save the data now.
		// Sanitize the user input.
        $wcpk_product_key_data = sanitize_text_field( $_POST['wcpk_selected_values'] );

		// Update the meta field.
        update_post_meta($post_id, '_wcpk_product_key_values', $wcpk_product_key_data);
	}

	public function wcpk_wc_render_metabox_content( $post ) {

		// Add a nonce field to check for
		wp_nonce_field( 'wcpk_wc_save_metabox_nonce', 'wcpk_wc_metabox_nonce' );

		// Get existing value from the database
		$wcpk_product_key_data = get_post_meta( $post->ID, '_wcpk_product_key_values', true );
		var_dump( $wcpk_product_key_data );

		// Product Key args for display
		$wcpk_product_key_args = array(
			'post_type' => 'product-key',
			'orderby'   => 'title',
			'order'     => 'ASC'
		);

		// Use get_posts with args to return product keys
		$wcpk_product_keys = get_posts( $wcpk_product_key_args ); 

		// Output the select list of product keys ?>
		<select name="wcpk_selected_values" id="wcpk_selected_values" style="width:100%;"><?php
			foreach ( $wcpk_product_keys as $wcpk_product_key ) : 
				$wcpk_key_value = $wcpk_product_key->ID; ?>
				<option value="<?php echo esc_attr( $wcpk_key_value); ?>"<?php 
					if ( $wcpk_key_value == $wcpk_product_key_data ) :
						echo 'selected';
					endif; ?>
				><!-- DONT REMOVE - ENDS option --><?php 
					echo esc_attr( $wcpk_product_key->post_title ); ?>
				</option><?php
			endforeach; ?>
		</select><?php

		// Reset postdata cause that's the rad thing to do.
		wp_reset_postdata(); 
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
function call_wcpk_metaboxe() {
	new Wcpk_Metaboxes();
}

/**
 * Calls the metabox if user is admin
 * @since 1.0
 */
if ( is_admin() ) {
	add_action( 'load-post.php', 'call_wcpk_metaboxe' );
	add_action( 'load-post-new.php', 'call_wcpk_metaboxe' );
}