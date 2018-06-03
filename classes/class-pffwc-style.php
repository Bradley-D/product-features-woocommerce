<?php
/*
 * pffwc_Style
 *
 * Output customizer styles
 *
 * @author Bradley Davis
 * @package Product Features For WooCommerce
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

class pffwc_Style {

    public function __construct() {
        $this->pffwc_add_remove_actions();
    }

    public function pffwc_add_remove_actions() {
        add_action( 'wp_head', array( $this, 'pffwc_customizer_css' ) );
    }

    /**
     * Customizer styles
     * @since 1.0
     */
    public function pffwc_customizer_css() { ?>
        <style type="text/css">
            /* Feature Image Options */
            .pffwc-item { <?php
                if ( array_key_exists( 'image_width', $pffwc_customizer_settings ) ) : ?>
                    /* Image Width */
                    max-width: <?php echo $pffwc_customizer_settings['image_width']; ?>;
                <?php endif; ?>
                /* Border Width */
                border-width: <?php echo get_theme_mod( 'pffwc_image_border' ); ?>px;
                /* Border Color */
                border-color: <?php echo get_theme_mod( 'pffwc_border_color' ); ?>;
                /* Image Padding*/
                padding: <?php echo get_theme_mod( 'pffwc_image_padding' ); ?>px;
                /* Image Background */
                background-color: <?php echo get_theme_mod( 'pffwc_image_bg' ); ?>;
            }
            /* Tooltip Options */
            .pffwc-tooltip:hover:before {
                /* Font Color */
                color: <?php echo get_theme_mod( 'pffwc_tooltip_font_color' ); ?>;
                /* Background Color */
                background-color: <?php echo get_theme_mod( 'pffwc_tooltip_bg' ); ?>;
            }
        </style> <?php
    }
} // END pffwc_Style class

/**
 * Instantiate the class.
 * @since 1.0
 */
$pffwc_style = new pffwc_Style();
