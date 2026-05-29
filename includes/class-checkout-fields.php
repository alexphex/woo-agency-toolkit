<?php
/**
 * Custom checkout fields.
 *
 * @package Woo_Agency_Toolkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WAT_Checkout_Fields
 *
 * Adds custom fields to WooCommerce checkout.
 */
class WAT_Checkout_Fields {

    /**
     * Constructor. Registers WordPress hooks.
     */
    public function __construct() {
        add_filter( 'woocommerce_checkout_fields', array( $this, 'add_delivery_comment_field' ) );
        add_action( 'woocommerce_checkout_process', array( $this, 'validate_delivery_comment' ) );
        add_action( 'woocommerce_checkout_order_processed', array( $this, 'save_delivery_comment' ), 10, 3 );
    }

    /**
     * Add delivery comment field to checkout.
     *
     * @param array $fields Checkout fields.
     * @return array Modified fields.
     */
    public function add_delivery_comment_field( array $fields ): array {
        $fields['order']['delivery_comment'] = array(
            'type'        => 'textarea',
            'label'       => esc_html__( 'Delivery Comment', 'woo-agency-toolkit' ),
            'placeholder' => esc_html__( 'Any special instructions for delivery...', 'woo-agency-toolkit' ),
            'required'    => false,
            'class'       => array( 'form-row-wide' ),
            'priority'    => 20,
        );

        return $fields;
    }

    /**
     * Validate delivery comment field.
     *
     * @return void
     */
    public function validate_delivery_comment(): void {
        if ( empty( $_POST['delivery_comment'] ) ) {
            return;
        }

        $comment = sanitize_textarea_field( wp_unslash( $_POST['delivery_comment'] ) );

        if ( mb_strlen( $comment ) > 500 ) {
            wc_add_notice(
                esc_html__( 'Delivery comment must be 500 characters or less.', 'woo-agency-toolkit' ),
                'error'
            );
        }
    }

    /**
     * Save delivery comment to order meta.
     *
     * @param int       $order_id Order ID.
     * @param array     $posted_data Posted data.
     * @param WC_Order  $order Order object.
     * @return void
     */
    public function save_delivery_comment( int $order_id, array $posted_data, WC_Order $order ): void {
        if ( empty( $posted_data['delivery_comment'] ) ) {
            return;
        }

        $comment = sanitize_textarea_field( wp_unslash( $posted_data['delivery_comment'] ) );
        $order->update_meta_data( '_delivery_comment', $comment );
        $order->save();
    }
}
