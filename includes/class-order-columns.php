<?php
/**
 * Custom order columns.
 *
 * @package Woo_Agency_Toolkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WAT_Order_Columns
 *
 * Adds custom columns to WooCommerce orders list table.
 */
class WAT_Order_Columns {

    /**
     * Constructor. Registers WordPress hooks.
     */
    public function __construct() {
        add_filter( 'manage_woocommerce_page_wc-orders_columns', array( $this, 'add_columns' ) );
        add_action( 'manage_woocommerce_page_wc-orders_custom_column', array( $this, 'render_column' ), 10, 2 );
    }

    /**
     * Add custom columns to orders list.
     *
     * @param array $columns Existing columns.
     * @return array Modified columns.
     */
    public function add_columns( array $columns ): array {
        $new_columns = array();

        foreach ( $columns as $key => $value ) {
            $new_columns[ $key ] = $value;

            if ( 'order_status' === $key ) {
                $new_columns['delivery_comment'] = esc_html__( 'Delivery Comment', 'woo-agency-toolkit' );
            }
        }

        return $new_columns;
    }

    /**
     * Render custom column content.
     *
     * @param string   $column   Column name.
     * @param WC_Order $order    Order object.
     * @return void
     */
    public function render_column( string $column, WC_Order $order ): void {
        if ( 'delivery_comment' !== $column ) {
            return;
        }

        $comment = $order->get_meta( '_delivery_comment' );

        if ( $comment ) {
            echo '<span title="' . esc_attr( $comment ) . '">'
                . esc_html( mb_strimwidth( $comment, 0, 30, '...' ) )
                . '</span>';
        } else {
            echo '<span aria-hidden="true">—</span>';
        }
    }
}
