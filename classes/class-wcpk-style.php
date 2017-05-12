<?php
/*
 * Wcpk_Style
 *
 * Output customizer styles
 *
 * @author Bradley Davis
 * @package WooCommerce Product Key
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

class Wcpk_Style {

    function __construct() {
        $this->init();
    }

    function init() {
        add_action( 'wp_head', array( $this, 'wcpk_customizer_css' ) );
    }

    /**
     * Customizer styles
     * @since 1.0
     */
    function wcpk_customizer_css() {
        // Get WCPK Customizer settings as array
        if ( '' != get_theme_mod( 'wcpk_customizer' ) ) :
            $wcpk_customizer_settings = get_theme_mod( 'wcpk_customizer' );
        endif; ?>

        <style type="text/css">
            /* Feature Image Options */
            .wcpk-item { <?php 
                if ( array_key_exists( 'image_width', $wcpk_customizer_settings ) ) : ?>
                    /* Image Width */
                    max-width: <?php echo $wcpk_customizer_settings['image_width']; ?>;
                <?php endif; ?>
                /* Border Width */
                border-width: <?php echo $wcpk_customizer_settings['image_border']; ?>;
                /* Border Color */
                border-color: <?php echo $wcpk_customizer_settings['border_color']; ?>;
                /* Image Padding*/
                padding: <?php echo $wcpk_customizer_settings['image_padding']; ?>;
                /* Image Background */
                background-color: <?php echo $wcpk_customizer_settings['image_bg']; ?>;
                /* Font Awesome Options */ <?php 
                if ( 'wcpk_image_font' == $wcpk_customizer_settings['key_type'] ) : ?>
                    font-size: <?php echo $wcpk_customizer_settings['fa_size']; ?>;     
                <?php endif; ?>
            }
            /* Tooltip Options */
            .wcpk-tooltip:hover:before {
                /* Font Color */
                color: <?php echo $wcpk_customizer_settings['tooltip_font_color']; ?>;
                /* Background Color */
                background-color: <?php echo $wcpk_customizer_settings['tooltip_bg']?>;
            }
        </style> <?php
    }
} // END Wcpk_Style class


/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_style = new Wcpk_Style();