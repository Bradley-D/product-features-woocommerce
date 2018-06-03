<?php
/*
 * pffwc_Settings
 *
 * Set up the admin settings
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class Pffwc_Settings {

	public function __construct() {
		$this->pffwc_add_remove_actions();
		$this->pffwc_media();
	}

	public function pffwc_add_remove_actions() {
		add_action( 'customize_register', array( $this, 'pffwc_add_settings' ) );
	}

	/**
	 * Set media image sizes
	 * @since 1.0
	 */
	public function pffwc_media() {
		add_image_size( 'product_key_thumb', 100, 100, true );
	}

	/**
	 * Create the pffwc settings in the customizer
	 * @since 1.0
	 */
	public function pffwc_add_settings( $wp_customize ) {
		// Add pffwc panel
		$wp_customize->add_panel( 'pffwc_settings',
			array(
				'title'       => __( 'Product Key Settings', 'pffwc' ),
				'description' => __( 'Personalize your product keys.', 'pffwc' ),
				'priority'    => 1000,
			)
		);
		// General options section
		$wp_customize->add_section( 'pffwc_options',
			array(
				'title'      => __( 'General Options', 'pffwc' ),
			  	'panel'      => 'pffwc_settings',
			  	'capability' => '',
			  	'priority'   => 1,
			)
		);
		// Feature Image Section
		$wp_customize->add_section( 'pffwc_options_fi',
			array(
				'title'      => __( 'Feature Image Settings', 'pffwc' ),
				'panel'      => 'pffwc_settings',
				'capability' => '',
				'priority'   => 2,
			)
		);
		// Tooltip Section
		$wp_customize->add_section( 'pffwc_options_tt',
			array(
				'title'      => __( 'Tooltip Settings', 'pffwc' ),
				'panel'      => 'pffwc_settings',
				'capability' => '',
				'priority'   => 4,
			)
		);
		/*
		 * General options
		 * @since 1.0
		 */
		// Choose PK Location
		$wp_customize->add_setting( 'pffwc_render_location',
			array(
				'default' => 'pffwc_after_short_desc',
				'sanitize_callback' => array( $this, 'pffwc_sanitize_location' ),
			)
		);
		$wp_customize->add_control( 'pffwc_render_location',
			array(
				'label'    => __( 'Choose Display Location', 'pffwc' ),
				'settings' => 'pffwc_render_location',
				'section'  => 'pffwc_options',
				'type'     => 'select',
				'choices'  => array(
					'pffwc_after_gallery'      => __( 'After product gallery', 'pffwc' ),
					'pffwc_after_heading'      => __( 'After product heading', 'pffwc' ),
					'pffwc_after_price'        => __( 'After product price', 'pffwc' ),
					'pffwc_after_short_desc'   => __( 'After short description', 'pffwc' ),
					'pffwc_after_add_cart'     => __( 'After add to cart', 'pffwc' ),
					'pffwc_after_product_meta' => __( 'After product meta', 'pffwc' ),
				),
			)
		);

		/*
		 * Feature Image Options
		 * @since 1.0
		 */
		// Image Width
		$wp_customize->add_setting( 'pffwc_image_width',
			array(
				'default'           => '16.5%',
				'sanitize_callback' => array( $this, 'pffwc_sanitize_image_width' ),
			)
		);
		$wp_customize->add_control( 'pffwc_image_width',
			array(
				'label'    => __( 'Choose Image Width', 'pffwc' ),
				'settings' => 'pffwc_image_width',
				'section'  => 'pffwc_options_fi',
				'type'     => 'select',
				'choices'  => array(
					'12.5%'  => __( '8 Per Row', 'pffwc' ), // 8
					'16.5%'  => __( '6 Per Row', 'pffwc' ), // 6
					'20%'    => __( '5 Per Row', 'pffwc' ), // 5
					'25%'    => __( '4 Per Row', 'pffwc' ), // 4
					'33.33%' => __( '3 Per Row', 'pffwc' ), // 3
					'50%'    => __( '2 Per Row', 'pffwc' ), // 2
				),
			)
		);
		// Border Width
		$wp_customize->add_setting( 'pffwc_image_border',
			array(
				'default'           => 'pffwc_image_border_zero',
				'sanitize_callback' => array( $this, 'pffwc_sanitize_border_width' ),
			)
		);
		$wp_customize->add_control( 'pffwc_image_border',
			array(
				'label'     => __( 'Image Border Width', 'pffwc' ),
				'settings'  => 'pffwc_image_border',
				'section'   => 'pffwc_options_fi',
				'type'      => 'select',
				'choices'   => array(
					'pffwc_image_border_zero'   => __( '0px', 'pffwc' ),
					'pffwc_image_border_one'    => __( '1px', 'pffwc' ),
					'pffwc_image_border_two'    => __( '2px', 'pffwc' ),
					'pffwc_image_border_three'  => __( '3px', 'pffwc' ),
					'pffwc_image_border_four'   => __( '4px', 'pffwc' ),
					'pffwc_image_border_five'   => __( '5px', 'pffwc' ),
					'pffwc_image_border_six'    => __( '6px', 'pffwc' ),
					'pffwc_image_border_seven'  => __( '7px', 'pffwc' ),
					'pffwc_image_border_eight'  => __( '8px', 'pffwc' ),
				),
			)
		);
		// Border Color
		$wp_customize->add_setting( 'pffwc_border_color',
			array(
				'default'           => '#ddd',
				'sanitize_callback' => array( $this, 'sanitize_hex_color' ),
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pffwc_border_color',
			array(
				'label'    => __( 'Border Color', 'pffwc' ),
				'settings' => 'pffwc_border_color',
				'section'  => 'pffwc_options_fi',
			)
		) );
		// Image Padding
		$wp_customize->add_setting( 'pffwc_image_padding',
			array(
				'default'           => 'pffwc_image_padding_zero',
				'sanitize_callback' => array( $this, 'pffwc_sanitize_image_padding' ),
			)
		);
		$wp_customize->add_control( 'pffwc_image_padding',
			array(
				'label'      => __( 'Image Padding', 'pffwc' ),
				'settings'   => 'pffwc_image_padding',
				'section'    => 'pffwc_options_fi',
				'type'       => 'select',
				'choices'    => array(
					'pffwc_image_padding_zero'   => __( '0px', 'pffwc' ),
					'pffwc_image_padding_one'    => __( '1px', 'pffwc' ),
					'pffwc_image_padding_two'    => __( '2px', 'pffwc' ),
					'pffwc_image_padding_three'  => __( '3px', 'pffwc' ),
					'pffwc_image_padding_four'   => __( '4px', 'pffwc' ),
					'pffwc_image_padding_five'   => __( '5px', 'pffwc' ),
					'pffwc_image_padding_six'    => __( '6px', 'pffwc' ),
					'pffwc_image_padding_seven'  => __( '7px', 'pffwc' ),
					'pffwc_image_padding_eight'  => __( '8px', 'pffwc' ),
				),
			)
		);
		// Image background color
		$wp_customize->add_setting( 'pffwc_image_bg',
			array(
				'default'           => '#fff',
				'sanitize_callback' => array( $this, 'sanitize_hex_color' ),
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pffwc_image_bg',
			array(
				'label'    => __( 'Background Color', 'pffwc' ),
				'settings' => 'pffwc_image_bg',
				'section'  => 'pffwc_options_fi',
			)
		) );

		/*
		 * Tooltip Options
		 * @since 1.0
		 */
		// Tooltip Font Color
		$wp_customize->add_setting( 'pffwc_tooltip_font_color',
			array(
				'default'           => '#fff',
				'sanitize_callback' => array( $this, 'sanitize_hex_color' ),
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pffwc_tooltip_font_color',
			array(
				'label'    => __( 'Font Color', 'pffwc' ),
				'settings' => 'pffwc_tooltip_font_color',
				'section'  => 'pffwc_options_tt',
			)
		) );
		// Tooltip Background
		$wp_customize->add_setting( 'pffwc_tooltip_bg',
			array(
				'default'           => '#333',
				'sanitize_callback' => array( $this, 'sanitize_hex_color' ),
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pffwc_tooltip_bg',
			array(
				'label'    => __( 'Background Color', 'pffwc' ),
				'settings' => 'pffwc_tooltip_bg',
				'section'  => 'pffwc_options_tt',
			)
		) );
		// Tooltip Opacity
		$wp_customize->add_setting( 'pffwc_tooltip_opacity',
			array(
				'default'           => '10',
				'sanitize_callback' => '',
			)
		);
		$wp_customize->add_control( 'pffwc_tooltip_opacity',
			array(
				'label'    => __( 'Background Opacity', 'pffwc' ),
				'settings' => 'pffwc_tooltip_opacity',
				'section'  => 'pffwc_options_tt',
				'type'     => 'range',
				'input_attrs' => array(
					'min'     => 0,
					'max'     => 10,
					'steps'   => 1,
				),
			)
		);
	}

	/**
	 * pffwc Customizer callbacks/sanitize all the things
	 * @since 1.0
	 */
	// Location
	function pffwc_sanitize_location( $input ) {
		$pffwc_valid_location = array(
			'pffwc_after_gallery'      => 'After product gallery',
			'pffwc_after_heading'      => 'After product heading',
			'pffwc_after_price'        => 'After product price',
			'pffwc_after_short_desc'   => 'After short description',
			'pffwc_after_add_cart'     => 'After add to cart',
			'pffwc_after_product_meta' => 'After product meta',
		);

		if ( array_key_exists( $input, $pffwc_valid_location ) ) :
			return $input;
		else :
			return '';
		endif;
	}

	// Image Width
	public function pffwc_sanitize_image_width( $input ) {
		$pffwc_valid_image_width = array(
			'pffwc_image_width_eight' => '8 Per Row',
			'pffwc_image_width_six'   => '6 Per Row',
			'pffwc_image_width_five'  => '5 Per Row',
			'pffwc_image_width_four'  => '4 Per Row',
			'pffwc_image_width_three' => '3 Per Row',
			'pffwc_image_width_two'   => '2 Per Row',
		);

		if ( array_key_exists( $input, $pffwc_valid_image_width ) ) :
			return $pffwc_valid_image_width;
		else :
			return '';
		endif;
	}
	// Border Width
	public function pffwc_sanitize_border_width( $input ) {
		$pffwc_valid_border_width = array(
			'pffwc_image_border_zero'   => '0px',
			'pffwc_image_border_one'    => '1px',
			'pffwc_image_border_two'    => '2px',
			'pffwc_image_border_three'  => '3px',
			'pffwc_image_border_four'   => '4px',
			'pffwc_image_border_five'   => '5px',
			'pffwc_image_border_six'    => '6px',
			'pffwc_image_border_seven'  => '7px',
			'pffwc_image_border_eight'  => '8px',
		);

		if ( array_key_exists( $input, $pffwc_valid_border_width ) ) :
			return $pffwc_valid_border_width;
		else :
			return '';
		endif;
	}
	// Image padding
	public function pffwc_sanitize_image_padding( $input ) {
		$pffwc_valid_image_padding = array(
			'pffwc_image_padding_zero'   => '0px',
			'pffwc_image_padding_one'    => '1px',
			'pffwc_image_padding_two'    => '2px',
			'pffwc_image_padding_three'  => '3px',
			'pffwc_image_padding_four'   => '4px',
			'pffwc_image_padding_five'   => '5px',
			'pffwc_image_padding_six'    => '6px',
			'pffwc_image_padding_seven'  => '7px',
			'pffwc_image_padding_eight'  => '8px',
		);

		if ( array_key_exists( $input, $pffwc_valid_image_padding ) ) :
			return $pffwc_valid_image_padding;
		else :
			return '';
		endif;
	}
	// Font Awesome size
	public function pffwc_sanitize_fa_size( $input ) {
		$pffwc_valid_fa_size = array(
			'pffwc-fa-ten'       => '10px',
			'pffwc_fa_twelve'    => '12px',
			'pffwc_fa_fourteen'  => '14px',
			'pffwc_fa_sixteen'   => '16px',
			'pffwc_fa_eightteen' => '18px',
		);

		if ( array_key_exists( $input, $pffwc_valid_fa_size ) ) :
			return $pffwc_valid_fa_size;
		else :
			return '';
		endif;
	}

} // END Pffwc_Settings class

/**
 * Instantiate the class.
 * @since 1.0
 */
$pffwc_settings = new Pffwc_Settings();
