<?php
class Teaser_Custom_WooCommerce_Field
{
    private $textfield_id;
    public function __construct($id)
    {
        $this->textfield_id = $id;
    }
    public function init()
    {
        add_filter('woocommerce_product_data_tabs', array($this, 'add_my_custom_product_data_tab'), 99, 1);
        add_action('woocommerce_product_data_panels', array(
            $this, 'product_options_grouping'));
        add_action(
            'woocommerce_process_product_meta',
            array($this, 'add_custom_linked_field_save')
        );
    }
    function add_my_custom_product_data_tab($product_data_tabs)
    {
        $product_data_tabs['Product Teaser'] = array(
            'label' => __('Product Teaser'),
            'target' => 'my_custom_product_data',
        );
        return $product_data_tabs;
    }
    public function add_custom_linked_field_save($post_id)
    {
        if (!(isset($_POST['woocommerce_meta_nonce'], $_POST[$this->textfield_id]) || wp_verify_nonce(sanitize_key($_POST['woocommerce_meta_nonce']), 'woocommerce_save_data'))) {
            return false;
        }
        $product_teaser = sanitize_text_field(
            wp_unslash($_POST[$this->textfield_id])
        );
        update_post_meta(
            $post_id,
            $this->textfield_id,
            esc_attr($product_teaser)
        );
    }
    public function product_options_grouping()
    {
        $description = sanitize_text_field('Enter a description that will be displayed for those who are viewing the product.');
        $placeholder = sanitize_text_field('Tease your product with a short description.');
        ?>
        <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
        <div id="my_custom_product_data" class="panel woocommerce_options_panel">
            <?php
            $args = array(
                'id' => $this->textfield_id,
                'label' => sanitize_text_field('Product Teaser'),
                'placeholder' => $placeholder,
                'desc_tip' => true,
                'description' => $description
            );
            if (!function_exists('woocommerce_wp_text_input')) {
                require_once '/includes/admin/wc-meta-box-functions.php';
            }
            woocommerce_wp_text_input($args);
            ?>
        </div>
        <?php
    }
}
?>