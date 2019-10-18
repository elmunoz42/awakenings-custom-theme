<?php
/**
 * Customer invoice email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.
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

/**
 * Executes the e-mail header.
 *
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<?php if ( $order->has_status( 'pending' ) ) { ?>
	<p>
	<?php
	// invoice_notes default: We have approved your event at the Awakenings. Your invoice for this event is attached below with the Awakenings Studio Rental Agreement. Please make sure you read and understand the agreement as that is necessary for booking the space.
	echo '<p>' . $order->get_meta('invoice_notes') . '</p>';
	printf(
		wp_kses(
			/* translators: %1$s Site title, %2$s Order pay link */
			__( 'Please make the required payments as soon as you can so that we can confirm your event on our calendar.  Until we receive the required payment, your event will remain tentative and could be bumped if we do not hear back from you soon. You understand that returning the required payment secures your event and represents your agreement to the contract below. For your convenience, you can approve your contract and pay online with this link: %2$s. ', 'woocommerce' ),
			array(
				'a' => array(
					'href' => array(),
				),
			)
		),
		esc_html( get_bloginfo( 'name', 'display' ) ),
		'<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay for this order', 'woocommerce' ) . '</a>'
	);
	echo '<br>';
	echo '<p>Also, if you have not done so, please log into <a href="https://awakenings.org/login">your Awakenings.org dashboard </a> to provide an event description for our calendar.  We have found that events get much more attention and interest when they include a description and an image.  You can also activate registration management for your event. This will provide a registration box for participants to RSVP or buy tickets for the event. Once you login you can find your event under the "Manage / Create Events" tab or with this <a href="https://staging.awakenings.org/events/community/edit/event/'. $order->get_meta('event_id') . '" target="_blank">link<a/>. </p>
 <p>Thanks for supporting our wellness community with your great events and energy.  It is a pleasure to be able to host your activities at Awakenings!</p>
 <p>With warmth,</p>
 <p>The Awakenings Team<p>'
	?>
	</p>

<?php } else { ?>
	<p>
	<?php
		echo $order->get_meta('invoice_notes');
		/* translators: %s Order date */
		printf( esc_html__( 'Here are the details of your order placed on %s:', 'woocommerce' ), esc_html( wc_format_datetime( $order->get_date_created() ) ) );
	?>
	</p>
<?php
}

/**
 * Hook for the woocommerce_email_order_details.
 *
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for the woocommerce_email_order_meta.
 *
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for woocommerce_email_customer_details.
 *
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?>
<p>

</p>
<?php

/**
 * Executes the email footer.
 *
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
