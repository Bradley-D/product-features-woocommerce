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
		$this->init();
		$this->wcpk_media();
	}

	function init() {
		//add_filter( 'woocommerce_get_sections_products', array( $this, 'wcpk_add_section' ) );
		//add_filter( 'woocommerce_get_settings_products', array( $this, 'wcpk_add_settings' ), 10, 2 );
		
		// if ( is_admin() ) :
			add_action( 'customize_register', array( $this, 'wcpk_add_settings' ) );
		// endif;
	}

	/**
	 * Set media image sizes
	 * @since 1.0
	 */
	function wcpk_media() {
		add_image_size( 'product_key_thumb', 100, 100, true );
		add_image_size( 'product_key_main', 300, 300, true );
	}

	/**
	 * Create the WCPK settings in the customizer
	 * @since 1.0
	 */
	function wcpk_add_settings( $wp_customize ) {
		// Add WCPK panel
		$wp_customize->add_panel( 'wcpk_settings',
			array(
				'title'       => __( 'Product Key Settings', 'wcpk' ),
				'description' => __( 'Personalize your product keys.', 'wcpk' ),
				'priority'    => 1000,
			)
		);
		// General options section
		$wp_customize->add_section( 'wcpk_options',
			array(
				'title'      => __( 'General Options', 'wcpk' ),
			  	'panel'      => 'wcpk_settings',
			  	'capability' => '',
			  	'priority'   => 1,
			)
		);
		// Feature Image Section
		$wp_customize->add_section( 'wcpk_options_fi',
			array(
				'title'      => __( 'Feature Image Settings', 'wcpk' ),
				'panel'      => 'wcpk_settings',
				'capability' => '',
				'priority'   => 2,
			)
		);
		// Font Awesome Section
		$wp_customize->add_section( 'wcpk_options_fa',
			array(
				'title'      => __( 'Font Awesome Settings', 'wcpk'),
				'panel'      => 'wcpk_settings',
				'capability' => '',
				'priority'   => 3,
			)
		);
		// Tooltip Section
		$wp_customize->add_section( 'wcpk_options_tt',
			array(
				'title'      => __( 'Tooltip Settings', 'wcpk' ),
				'panel'      => 'wcpk_settings',
				'capability' => '',
				'priority'   => 4,
			)
		);
		/*
		 * General options
		 * @since 1.0
		 */
		// Choose PK Type
		$wp_customize->add_setting( 'wcpk_key_type',
			array(
				'default' => 'wcpk-image-thumb',
				//'sanitize_callback' => '',
			)
		);
		$wp_customize->add_control( 'wcpk_key_type',
			array(
				'label'    => __( 'Choose Key Type', 'wcpk' ),
				'settings' => 'wcpk_key_type',
				'section'  => 'wcpk_options',
				'type'     => 'select',
				'choices'  => array(
					'wcpk_image_thumb' => __( 'Featured Image', 'wcpk' ),
					'wcpk_image_font'  => __( 'Font Awesome', 'wcpk' ),
					'wcpk_image_text'  => __( 'Text', 'wcpk' ),
				),
			)
		);
		// Choose PK Location
		$wp_customize->add_setting( 'wcpk_render_location',
			array(
				'default' => 'wcpk-after-short-desc',
			)
		);
		$wp_customize->add_control( 'wcpk_render_location',
			array(
				'label'    => __( 'Choose Display Location', 'wcpk' ),
				'settings' => 'wcpk_render_location',
				'section'  => 'wcpk_options',
				'type'     => 'select',
				'choices'  => array(
					'wcpk_after_gallery'      => __( 'After product gallery', 'wcpk' ),
					'wcpk_after_heading'      => __( 'After product heading', 'wcpk' ),
					'wcpk_after_price'        => __( 'After product price', 'wcpk' ),
					'wcpk_after_short_desc'   => __( 'After short description', 'wcpk' ),
					'wcpk_after_add_cart'     => __( 'After add to cart', 'wcpk' ),
					'wcpk_after_product_meta' => __( 'After product meta', 'wcpk' ),
				),
			)
		);

		/*
		 * Feature Image Options
		 * @since 1.0
		 */
		// Image Width 
		$wp_customize->add_setting( 'wcpk_image_width',
			array(
				'default' => 'wcpk-image-width-six',
			)
		);
		$wp_customize->add_control( 'wcpk_image_width',
			array(
				'label'    => __( 'Choose Image Width', 'wcpk' ),
				'settings' => 'wcpk_image_width',
				'section'  => 'wcpk_options_fi',
				'type'     => 'select',
				'choices'  => array(
					'wcpk_image_width_eight'  => __( '8 Per Row', 'wcpk' ), // 8
					'wcpk_image_width_six'    => __( '6 Per Row' , 'wcpk' ), // 6
					'wcpk_image_width_five'   => __( '5 Per Row', 'wcpk' ), // 5
					'wcpk_image_width_four'   => __( '4 Per Row', 'wcpk' ), // 4
					'wcpk_image_width_three'  => __( '3 Per Row', 'wcpk' ), // 3
					'wcpk_image_width_two'    => __( '2 Per Row', 'wcpk' ), // 2
				),
			)
		);
		// Border Width
		$wp_customize->add_setting( 'wcpk_image_border',
			array(
				'default' => 'wcpk_image_border_zero',
			)
		);
		$wp_customize->add_control( 'wcpk_image_border',
			array(
				'label'     => __( 'Image Border Width', 'wcpk' ),
				'settings'  => 'wcpk_image_border',
				'section'   => 'wcpk_options_fi',
				'type'      => 'select',
				'choices'   => array(
					'wcpk_image_border_zero'   => __( '0px', 'wcpk' ),
					'wcpk_image_border_one'    => __( '1px', 'wcpk' ),
					'wcpk_image_border_two'    => __( '2px', 'wcpk' ),
					'wcpk_image_border_three'  => __( '3px', 'wcpk' ),
					'wcpk_image_border_four'   => __( '4px', 'wcpk' ),
					'wcpk_image_border_five'   => __( '5px', 'wcpk' ),
					'wcpk_image_border_six'    => __( '6px', 'wcpk' ),
					'wcpk_image_border_seven'  => __( '7px', 'wcpk' ),
					'wcpk_image_border_eight'  => __( '8px', 'wcpk' ),
				),
			)
		);
		// Border Color
		$wp_customize->add_setting( 'wcpk_border_color',
			array(
				'default' => '#ddd',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wcpk_border_color',
			array(
				'label'    => __( 'Border Color', 'wcpk' ),
				'settings' => 'wcpk_border_color',
				'section'  => 'wcpk_options_fi',
			)
		) );
		// Image Padding
		$wp_customize->add_setting( 'wcpk_image_padding',
			array(
				'default' => 'wcpk_image_padding_zero',
			)
		);
		$wp_customize->add_control( 'wcpk_image_padding',
			array(
				'label'      => __( 'Image Padding', 'wcpk' ),
				'settings'   => 'wcpk_image_padding',
				'section'    => 'wcpk_options_fi',
				'type'       => 'select',
				'choices'    => array(
					'wcpk_image_padding_zero'   => __( '0px', 'wcpk' ),
					'wcpk_image_padding_one'    => __( '1px', 'wcpk' ),
					'wcpk_image_padding_two'    => __( '2px', 'wcpk' ),
					'wcpk_image_padding_three'  => __( '3px', 'wcpk' ),
					'wcpk_image_padding_four'   => __( '4px', 'wcpk' ),
					'wcpk_image_padding_five'   => __( '5px', 'wcpk' ),
					'wcpk_image_padding_six'    => __( '6px', 'wcpk' ),
					'wcpk_image_padding_seven'  => __( '7px', 'wcpk' ),
					'wcpk_image_padding_eight'  => __( '8px', 'wcpk' ),
				),
			)
		);
		// Image background color
		$wp_customize->add_setting( 'wcpk_image_bg',
			array(
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wcpk_border_color',
			array(
				'label'    => __( 'Background Color', 'wcpk' ),
				'settings' => 'wcpk_image_bg',
				'section'  => 'wcpk_options_fi',
			)
		) );

		// $wp_customize->add_setting();
		// $wp_customize->add_control();


		/*
		 * Font Awesome Options
		 * @since 1.0
		 */
		$wp_customize->add_setting( 'wcpk_fa_size',
			array(
				'default' => 'wcpk_fa_sixteen',
			)
		);
		$wp_customize->add_control( 'wcpk_fa_size',
			array(
				'label'    => __( 'Choose Font Size', 'wcpk' ),
				'settings' => 'wcpk_fa_size',
				'section'  => 'wcpk_options_fa',
				'type'     => 'select',
				'choices'  => array(
					'wcpk-fa-ten'       => __( '10px', 'wcpk' ),
					'wcpk_fa_twelve'    => __( '12px', 'wcpk' ),
					'wcpk_fa_fourteen'  => __( '14px', 'wcpk' ),
					'wcpk_fa_sixteen'   => __( '16px', 'wcpk' ),
					'wcpk_fa_eightteen' => __( '18px', 'wcpk' ),
				),
			)
		);

		/*
		 * Tooltip Options
		 * @since 1.0
		 */
		// Tooltip Font Color
		$wp_customize->add_setting( 'wcpk_tooltip_font_color',
			array(
				'default' => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wcpk_tooltip_font_color',
			array(
				'label'    => __( 'Font Color', 'wcpk' ),
				'settings' => 'wcpk_tooltip_font_color',
				'section'  => 'wcpk_options_tt',
			)
		) );
		// Tooltip Background
		$wp_customize->add_setting( 'wcpk_tooltip_bg',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wcpk_tooltip_bg', 
			array(
				'label'    => __( 'Background Color', 'wcpk' ),
				'settings' => 'wcpk_tooltip_bg',
				'section'  => 'wcpk_options_tt',
			)
		) );
		// Tooltip Opacity
		$wp_customize->add_setting( 'wcpk_tooltip_opacity',
			array(
				'default'           => '10',
				'sanitize_callback' => '',
			)
		);
		$wp_customize->add_control( 'wcpk_tooltip_opacity',
			array(
				'label'    => __( 'Background Opacity', 'wcpk' ),
				'settings' => 'wcpk_tooltip_opacity',
				'section'  => 'wcpk_options_tt',
				'type'     => 'range',
				'input_attrs' => array(
					'min'     => 0,
					'max'     => 10,
					'steps'   => 1, 
				),
			)
		);
	}
}

/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_settings = new Wcpk_Settings();