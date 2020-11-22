<?php

namespace Free_Shipping_Notice;

class Notice
{
	public function __construct()
	{
		// Hook into where we want the notices to be displayed
		if(Settings::display_in_cart()){
			add_action('woocommerce_before_cart', array($this, 'maybe_display_amount'), 1);
		}
		if(Settings::display_in_checkout()){
			add_action('woocommerce_before_checkout_form', array($this, 'maybe_display_amount'), 1);
		}


	}

	public function maybe_display_amount()
	{
		$subtotal         = \WC()->cart->get_subtotal();
		$free_ship_amount = Settings::get_freeship_amount();
		$message = Settings::get_message();
		if ($subtotal < $free_ship_amount) {
			$amount_to_spend = $free_ship_amount - $subtotal;
			wc_add_notice($this->parse_message_vars($message, $amount_to_spend, $free_ship_amount));
		}
	}

	public function parse_message_vars($message, $amount_to_spend, $amount)
	{
		$message = str_replace('{amount_remaining}', wc_price($amount_to_spend), $message);
		$message = str_replace('{amount}',wc_price($amount), $message);
		return $message;
	}
}
