<?php
class Teaser_Custom_WooCommerce_Display {

    private $textfield_id;

    public function __construct( $id ) {
        $this->textfield_id = $id;
    }

    public function init() {
        add_action( 'woocommerce_before_single_product_summary',  array( $this, 'product_teaser_display' ), 10 );

        add_action( 'woocommerce_after_shop_loop_item_title',  array( $this, 'product_teaser_display' ), 10,0);
    }

    public function product_teaser_display() {

        $teaser = get_post_meta( get_the_ID(), $this->textfield_id, true );
        if ( empty( $teaser ) ) {
            return;
        }

        echo $teaser ;


    }
}