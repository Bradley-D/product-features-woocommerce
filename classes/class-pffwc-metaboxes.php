<?php
/*
 * Product Features For WooCommerce Metaboxes
 *
 * Add metaboxes
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;


class Pffwc_Metaboxes {

	/**
	 * The Constructor.
	 * @since 1.0
	 */
	public function __construct() {
		$this->pffwc_add_remove_actions();
	}

	public function pffwc_add_remove_actions() {
		// Product Features
		add_action( 'add_meta_boxes', array( $this, 'pffwc_add_metabox' ) );
		add_action( 'save_post', array( $this, 'pffwc_save_metabox' ) );
		// WooCommerce Product
		add_action( 'add_meta_boxes', array( $this, 'pffwc_wc_add_metabox' ) );
		add_action( 'save_post', array( $this, 'pffwc_wc_save_metabox' ) );
	}

	/**
	 * Product Features: Adds metabox container
	 * @since 1.0
	 */
	public function pffwc_add_metabox() {
		add_meta_box( 'pffwc_metaboxes', __( 'Product Features For WooCommerce', 'pffwc' ),
			array( $this, 'pffwc_render_metabox_content' ), 'product-features', 'normal', 'low' );
	}

	/**
	 * Product Features: Save the meta when the post is saved.
	 * @since 1.0
	 */
	public function pffwc_save_metabox( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['pffwc_inner_custom_box_nonce'] ) ) :
			return $post_id;
		endif;

		$nonce = $_POST['pffwc_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'pffwc_inner_custom_box' ) ) :
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

		// OK, its safe for us to save the data now.
		if ( ! isset( $_POST['pffwc_textarea_field'] ) ) :
			return;
		endif;
		// Sanitize the user input.
		$pffwc_textarea_data = sanitize_textarea_field( $_POST['pffwc_textarea_field'] );

		// Update the meta field.
		update_post_meta( $post_id, '_pffwc_textarea_meta_value_key', $pffwc_textarea_data );
	}

	/**
	 * Product Features: Render Meta Box content.
	 * @since 1.0
	 */
	public function pffwc_render_metabox_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'pffwc_inner_custom_box', 'pffwc_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$pffwc_textarea_field = get_post_meta( $post->ID, '_pffwc_textarea_meta_value_key', true );

		// Display the form, using the current value.?>
		<p><label for="pffwc-textarea_field"><?php echo _e( 'Tooltip Text', 'pffwc' ); ?></label><br/>
			<textarea name="pffwc_textarea_field" id="pffwc_textarea_field" cols="60" rows="2"><?php echo esc_attr( $pffwc_textarea_field ); ?></textarea></p><?php
	}

	/**
	 * WC Product: Adds metabox container
	 * @since 1.0
	 */
	public function pffwc_wc_add_metabox() {
		add_meta_box( 'pffwc_wc_metaboxes', __( 'Product Features', 'pffwc' ),
			array( $this, 'pffwc_wc_render_metabox_content' ), 'product', 'side', 'default' );
	}

	/**
	 * WC Product: Save the meta when the post is saved.
	 * @since 1.0
	 */
	public function pffwc_wc_save_metabox( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['pffwc_wc_metabox_nonce'] ) ) :
			return $post_id;
		endif;

		$nonce = $_POST['pffwc_wc_metabox_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'pffwc_wc_save_metabox_nonce' ) ) :
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

		// Update the post meta field.
    update_post_meta( $post_id, '_pffwc_product_key_values', $_POST['pffwc_selected_values'] );

	}

	/**
	 * WC Product: Render the output for the metabox.
	 * @since 1.0
	 */
	public function pffwc_wc_render_metabox_content( $post ) {

		// Add a nonce field to check for
		wp_nonce_field( 'pffwc_wc_save_metabox_nonce', 'pffwc_wc_metabox_nonce' );

		// Get existing value from the database
		$pffwc_product_key_data = get_post_meta( $post->ID, '_pffwc_product_key_values', true );

		// Product Key args for display
		$pffwc_product_key_args = array(
			'post_type' => 'product-features',
			'orderby'   => 'title',
			'order'     => 'ASC'
		);

		// Use get_posts with args to return product keys
		$pffwc_product_keys = get_posts( $pffwc_product_key_args );

		// Output the select list of product keys ?>
		<p>Hold down Ctrl (Windows) or Command (Mac) to select multiple options.</p>
		<select name="pffwc_selected_values[]" id="pffwc_selected_values" multiple style="width:100%;">
			<!-- First Option-->
			<option value="null" <?php
				if ( '' == $pffwc_product_key_data || '1' == sizeof( $pffwc_product_key_data ) && in_array( 'null', $pffwc_product_key_data ) ) : ?>
					selected<?php
				endif; ?>
			><!-- DONT REMOVE - ENDS option -->
			<?php echo __( 'None', 'pffwc' ); ?></option><?php
			foreach ( $pffwc_product_keys as $pffwc_product_key ) :
				$pffwc_key_value = $pffwc_product_key->ID; ?>
				<option value="<?php echo esc_attr( $pffwc_key_value ); ?>"<?php
					if ( '' != $pffwc_product_key_data ) :
						if ( in_array( $pffwc_key_value, $pffwc_product_key_data ) ) : ?>
							selected<?php
						endif;
					endif; ?>
				><!-- DONT REMOVE - ENDS option --><?php
					echo esc_attr( $pffwc_product_key->post_title ); ?>
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
function call_pffwc_metabox() {
	new Pffwc_Metaboxes();
}

/**
 * Calls the metabox if user is admin
 * @since 1.0
 */
if ( is_admin() ) {
	add_action( 'load-post.php', 'call_pffwc_metabox' );
	add_action( 'load-post-new.php', 'call_pffwc_metabox' );
}
