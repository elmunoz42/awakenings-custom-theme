<?php
/**
 * Customer on-hold order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( __( 'Hi %s,', 'woocommerce' ), $order->get_billing_first_name() ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
<p><?php _e( 'Thanks again for your booking. Until we confirm the payment of at least the deposit, the studio space cannot be guaranteed. Additionally, please make sure to pay the remainder by the date of the event as well.', 'woocommerce' ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput ?>

<?php

printf(
	wp_kses(
		/* translators: %1$s Order pay link */
		__( 'Here\'s a link to make a $ %1$s payment towards the total $ %2$s for your event on %3$s when you’re ready: %4$s', 'woocommerce' ),
		array(
			'a' => array(
				'href' => array(),
			),
		)
	),  $order->get_total(),
	 get_post_meta($order->get_order_number(), 'total_booking_cost', true),
	get_post_meta($order->get_order_number(), 'event_start_datetime', true),
	'<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay this invoice', 'woocommerce' ) . '</a>'
);
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
// do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
// do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?>
<br>
<p>
<?php _e( 'Thank you for your attention to this matter.', 'woocommerce' ); // phpcs:ignore WordPress.XSS.EscapeOutput ?>
</p>
<?php

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
