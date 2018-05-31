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

    public function __construct() {
        $this->wcpk_add_remove_actions();
    }

    public function wcpk_add_remove_actions() {
        add_action( 'wp_head', array( $this, 'wcpk_customizer_css' ) );
    }

    /**
     * Customizer styles
     * @since 1.0
     */
    public function wcpk_customizer_css() { ?>
        <style type="text/css">
            /* Feature Image Options */
            .wcpk-item { <?php
                if ( array_key_exists( 'image_width', $wcpk_customizer_settings ) ) : ?>
                    /* Image Width */
                    max-width: <?php echo $wcpk_customizer_settings['image_width']; ?>;
                <?php endif; ?>
                /* Border Width */
                border-width: <?php echo get_theme_mod( 'wcpk_image_border' ); ?>px;
                /* Border Color */
                border-color: <?php echo get_theme_mod( 'wcpk_border_color' ); ?>;
                /* Image Padding*/
                padding: <?php echo get_theme_mod( 'wcpk_image_padding' ); ?>px;
                /* Image Background */
                background-color: <?php echo get_theme_mod( 'wcpk_image_bg' ); ?>;
            }
            /* Tooltip Options */
            .wcpk-tooltip:hover:before {
                /* Font Color */
                color: <?php echo get_theme_mod( 'wcpk_tooltip_font_color' ); ?>;
                /* Background Color */
                background-color: <?php echo get_theme_mod( 'wcpk_tooltip_bg' ); ?>;
            }
        </style> <?php
    }
} // END Wcpk_Style class

/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_style = new Wcpk_Style();
