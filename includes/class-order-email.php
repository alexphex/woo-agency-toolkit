<?php
/**
 * Custom order email fields.
 *
 * @package Woo_Agency_Toolkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WAT_Order_Email
 *
 * Adds custom fields to WooCommerce order emails.
 */
class WAT_Order_Email {

    /**
     * Constructor. Registers WordPress hooks.
     */
    public function __construct() {
        add_action( 'woocommerce_email_order_meta', array( $this, 'add_delivery_comment_to_email' ), 10, 3 );
    }

    /**
     * Add delivery comment to order email.
     *
     * @param WC_Order $order         Order object.
     * @param bool     $sent_to_admin Whether email is sent to admin.
     * @param bool     $plain_text    Whether email is plain text.
     * @return void
     */
    public function add_delivery_comment_to_email( WC_Order $order, bool $sent_to_admin, bool $plain_text ): void {
        $comment = $order->get_meta( '_delivery_comment' );

        if ( ! $comment ) {
            return;
        }

        if ( $plain_text ) {
            echo "\n" . esc_html__( 'Delivery Comment:', 'woo-agency-toolkit' ) . "\n";
            echo esc_html( $comment ) . "\n";
            return;
        }
        ?>
        <h2><?php esc_html_e( 'Delivery Comment', 'woo-agency-toolkit' ); ?></h2>
        <p><?php echo esc_html( $comment ); ?></p>
        <?php
    }
}
