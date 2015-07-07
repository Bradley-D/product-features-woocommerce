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
		add_action( 'add_meta_boxes', array( $this, 'wcpk_add_metabox' ) );
		add_action( 'save_post', array( $this, 'wcpk_save_metabox' ) );
		add_action( 'add_meta_boxes', array( $this, 'wcpk_wc_add_metabox' ) );
		add_action( 'save_post', array( $this, 'wcpk_wc_save_metabox' ) );
	}

	/**
	 * Product Key: Adds metabox container
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
	function wcpk_wc_add_metabox( $post_type ) {
	
	    $post_types = array( 'product' );
	    if ( in_array( $post_type, $post_types ) ) :
			add_meta_box(
				'wcpk_wc_metaboxes', 
				__( 'Select Product Key', 'wcpk' ),
				array( $this, 'wcpk_wc_render_metabox_content' ),
				$post_type,
				'side',
				'default'
			);
	    endif;
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
		if ( ! isset( $_POST['wcpk_select_field'] ) ) :
			return;
		endif;

		// Sanitize the user input.
		// Need to make a WP_Query to get all product key slugs
		$wcpk_select_args = array(
			'post_type' => 'product-key',
		);
		
		$wcpk_select_query = new WP_Query( $wcpk_select_args );

		$wcpk_valid_selects = array();

		if ( $wcpk_select_query->have_posts() ) :
			while ( $wcpk_select_query->have_posts() ) : $wcpk_select_query->the_post();

				$wcpk_valid_slug = get_post();
				$wcpk_valid_selects[] = $wcpk_valid_slug->post_name;

			endwhile;
		endif;

		$wcpk_select_data = sanitize_text_field( $_POST['wcpk_select_field'] );

		if ( in_array( $wcpk_select_data, $wcpk_valid_selects ) ) :

			update_post_meta( $post->ID, 'wcpk_select_field', $wcpk_select_data );

		endif;
		// Restore the data
		wp_reset_postdata();

	}

	public function wcpk_wc_render_metabox_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wcpk_inner_custom_box', 'wcpk_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		//$wcpk_text_field = get_post_meta( $post->ID, '_wcpk_text_field_meta_value_key', true );

		// Display the select list
		?>
		<p>To select multiple product keys, hold down the Ctrl (Windows) or Command (Mac) button to select multiple options.</p>
		<p>
	        <label for="wcpk_select_label"><strong>Select Product Keys: </strong></label></p><p>
	        <select multiple="multiple" name="wcpk_select_field[]" id="wcpk_select_field" style="width: 100%;"><?php

	        $wcpk_product_keys_args = array(
				'post_type' => 'product-key',
			);
		
			$wcpk_product_keys = new WP_Query( $wcpk_product_keys_args );

			$wcpk_select_selected = get_option( 'wcpk_select_field', array() );

	        if ( $wcpk_product_keys->have_posts() ) :
				while ( $wcpk_product_keys->have_posts() ) : $wcpk_product_keys->the_post(); 

					$wcpk_select_slug = get_post(); ?>
					<option value="<?php echo esc_attr( $wcpk_select_slug->post_name ); ?>" <?php echo selected( in_array( $wcpk_select_slug->post_name, $wcpk_select_selected ) ); ?> ><?php echo '-&nbsp;' . esc_attr( get_the_title() ); ?></option><?php
				
				endwhile;
			endif; ?>


	        </select>
    	</p><?php
    	// Restore the data
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