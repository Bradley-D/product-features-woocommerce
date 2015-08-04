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
    function wcpk_customizer_css() { ?>
        <style type="text/css">
            /* Feature Image Options */
            <?php if ( '' != get_theme_mod( 'wcpk_image_border' ) ) : ?>
            <?php endif; ?>

            <?php if ( '' != get_theme_mod( 'wcpk_border_color' ) ) : ?>
            <?php endif; ?>

            <?php if ( '' != get_theme_mod( 'wcpk_image_padding' ) ) : ?>
            <?php endif; ?>

            <?php if ( '' != get_theme_mod( 'wcpk_image_bg' ) ) : ?>
            <?php endif; ?>

            /* Font Awesome Options */
            <?php if ( '' != get_theme_mod( 'wcpk_fa_size' ) ) : ?>
            <?php endif; ?>

            /* Tooltip Options */
            <?php if ( '' != get_theme_mod( 'wcpk_tooltip_font_color' ) ) : ?>
            <?php endif; ?>

            <?php if ( '' != get_theme_mod( 'wcpk_tooltip_bg' ) ) : ?>
            <?php endif; ?>

            <?php if ( '' != get_theme_mod( 'wcpk_tooltip_opacity' ) ) : ?>
            <?php endif; ?>
        </style> <?php
    }
} // END Wcpk_Style class


/**
 * Instantiate the class.
 * @since 1.0
 */
$wcpk_style = new Wcpk_Style();