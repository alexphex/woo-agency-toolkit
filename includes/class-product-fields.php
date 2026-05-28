<?php
/**
 * Custom product fields.
 *
 * @package Woo_Agency_Toolkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WAT_Product_Fields
 *
 * Adds custom fields to WooCommerce products.
 */
class WAT_Product_Fields {

    /**
     * Constructor. Registers WordPress hooks.
     */
    public function __construct() {
        add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_production_time_field' ) );
        add_action( 'woocommerce_process_product_meta', array( $this, 'save_production_time_field' ) );
        add_action( 'woocommerce_single_product_summary', array( $this, 'display_production_time' ), 25 );
    }

    /**
     * Add production time field to product admin.
     *
     * @return void
     */
    public function add_production_time_field(): void {
        woocommerce_wp_text_input(
            array(
                'id'                => '_production_time',
                'label'             => esc_html__( 'Production Time (days)', 'woo-agency-toolkit' ),
                'placeholder'       => '3',
                'desc_tip'          => true,
                'description'       => esc_html__( 'Enter the number of days required to produce this item.', 'woo-agency-toolkit' ),
                'type'              => 'number',
                'custom_attributes' => array(
                    'min'  => '1',
                    'step' => '1',
                ),
            )
        );
    }

    /**
     * Save production time field.
     *
     * @param int $post_id Product post ID.
     * @return void
     */
    public function save_production_time_field( int $post_id ): void {
        if ( ! isset( $_POST['_production_time'] ) ) {
            return;
        }

        $production_time = absint( $_POST['_production_time'] );

        if ( $production_time > 0 ) {
            update_post_meta( $post_id, '_production_time', $production_time );
        } else {
            delete_post_meta( $post_id, '_production_time' );
        }
    }

    /**
     * Display production time on single product page.
     *
     * @return void
     */
    public function display_production_time(): void {
        global $product;

        $production_time = get_post_meta( $product->get_id(), '_production_time', true );

        if ( ! $production_time ) {
            return;
        }

        echo '<p class="production-time">'
            . esc_html__( 'Production time: ', 'woo-agency-toolkit' )
            . '<strong>'
            . esc_html(
                sprintf(
                    /* translators: %d: number of days */
                    _n( '%d day', '%d days', (int) $production_time, 'woo-agency-toolkit' ),
                    (int) $production_time
                )
            )
            . '</strong>'
            . '</p>';
    }
}
