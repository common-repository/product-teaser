<?php
/*
Plugin Name:Woocommerce Product Teaser
Description: Product Teaser is a free plugin for wooCommerce that allows you add additional short messages or teaser message to products on your market place
Version:1.0.1
Author:Shifa Shaji

*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

include_once 'class-teaser-custom-woocommerce-display.php';
include_once 'class-teaser-custom-woocommerce-field.php';
add_action( 'plugins_loaded', 'product_teaser' );

function product_teaser() {

    if ( is_admin() ) {

        $admin = new Teaser_Custom_WooCommerce_Field ( 'teaser_text_field' );
        $admin->init();
        $plugin = new Teaser_Custom_WooCommerce_Display( 'teaser_text_field' );
        $plugin->init();
    } else {

        $plugin = new Teaser_Custom_WooCommerce_Display( 'teaser_text_field' );
        $plugin->init();
    }
}