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
		add_action( 'add_meta_boxes', array( $this, 'wcpk_add_metabox' ) );
		add_action( 'save_post', array( $this, 'wcpk_save_metabox' ) );
	}

	/**
	 * Adds metabox container
	 * @since 1.0
	 */
	function wcpk_add_metabox( $post_type ) {
	
	    $post_types = array( 'product-key' );
	    if ( in_array( $post_type, $post_types ) ) :
			add_meta_box(
				'wcpk_metaboxes', 
				__( 'WooCommerce Product Key', 'wcpk' ),
				array( $this, 'wcpk_render_metabox_content' ),
				$post_type,
				'advanced',
				'high'
			);
	    endif;
	}

	/**
	 * Save the meta when the post is saved.
	 * @since 1.0
	 */
	public function wcpk_save_metabox( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wcpk_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['wcpk_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wcpk_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

		if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

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
	 * Render Meta Box content.
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