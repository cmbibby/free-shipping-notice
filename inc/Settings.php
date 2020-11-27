<?php

namespace Free_Shipping_Notice;

class Settings {


	/**
	 * Hook into the settings tabs
	 */
	public function __construct() {
		 add_filter( 'woocommerce_get_sections_shipping', array( $this, 'free_shipping_add_settings_tab' ) );
		add_filter( 'woocommerce_get_settings_shipping', array( $this, 'free_shipping_settings' ), 10, 2 );
	}

	/**
	 * Add a tab for the plugin in the shipping tab
	 *
	 * @param object $settings_tab
	 *
	 * @return object
	 */
	public function free_shipping_add_settings_tab( $settings_tab ) {
		$settings_tab['shipping_free_shipping'] = __( 'Free Shipping Notice', 'free-shipping-notice' );
		return $settings_tab;
	}

	/**
	 * Add the settings field
	 *
	 * @param array $settings
	 * @param array $current_section
	 *
	 * @return array
	 */
	public function free_shipping_settings( $settings, $current_section ) {
		if ( 'shipping_free_shipping' == $current_section ) {
			$custom_settings = array(
				array(
					'name' => __( 'Free Shipping Notices', 'free-shipping-notice' ),
					'type' => 'title',
					'desc' => __( 'Display the amount remaining to qualify for free shipping', 'free-shipping-notice' ),
					'id'   => 'wc_free_shipping',
					'css'  => 'min-width:200px;',
				),
				array(
					'title'    => __( 'Free Shipping Amount', 'free-shipping-notice' ),
					'type'     => 'number',
					'desc_tip' => __( 'The Free shipping amount', 'free-shipping-notice' ),
					'default'  => 0,
					'id'       => 'wc_free_shipping_amount',
					'css'      => 'height:100px;',
					'css'      => 'width:100px;',
				),
				array(
					'title'    => __( 'Message', 'free-shipping-notice' ),
					'type'     => 'textarea',
					'desc_tip' => __( 'The text you would like displayed in the notice. Use {amount} and {amount_remaining} as variable placeholders', 'free-shipping-notice' ),
					'default'  => __( 'Hey! We have free shipping for orders over {amount} spend another {amount_remaining} to get free shipping', 'free-shipping-notice' ),
					'id'       => 'wc_free_shipping_message',
					'css'      => 'height:200px;',
					'css'      => 'min-width:200px;',
				),
				array(
					'title'   => __( 'Include Tax', 'free-shipping-notice' ),
					'desc'    => __( 'Include Tax in calculation', 'free-shipping-notice' ),
					'id'      => 'wc_free_shipping_tax',
					'default' => 'yes',
					'type'    => 'checkbox',
					'css'     => 'min-width:200px;',
				),
				array(
					'title'   => __( 'Display on Cart', 'free-shipping-notice' ),
					'desc'    => __( 'Display on Cart Page', 'free-shipping-notice' ),
					'id'      => 'wc_free_shipping_cart',
					'default' => 'yes',
					'type'    => 'checkbox',
					'css'     => 'min-width:200px;',
				),
				array(
					'title'   => __( 'Display on Checkout', 'free-shipping-notice' ),
					'desc'    => __( 'Display on Checkout Page', 'free-shipping-notice' ),
					'id'      => 'wc_free_shipping_checkout',
					'default' => 'yes',
					'type'    => 'checkbox',
					'css'     => 'min-width:200px;',
				),
				array(
					'title'   => __( 'Hide for these roles', 'free-shipping-notice' ),
					'id'      => 'wc_free_shipping_excluded_roles',
					'type'    => 'multiselect',
					'options' => $this->get_user_roles(),
				),
				'section_end' => array(
					'type' => 'sectionend',
					'id'   => 'wc_free_shipping',
				),
			);
			return $custom_settings;
		} else {
			return $settings;
		}
	}

	protected function get_user_roles() {
		$roles = new \WP_Roles;
		return $roles->get_names();
	}

	public static function get_excluded_roles() {
		return get_option( 'wc_free_shipping_excluded_roles' );
	}

	public static function get_freeship_amount() {
	  return get_option( 'wc_free_shipping_amount' );
	}

	public static function get_message() {
	  return get_option( 'wc_free_shipping_message' );
	}

	public static function display_in_cart() {
	  if ( 'yes' == get_option( 'wc_free_shipping_cart' ) ) {
			return true;
		} else {
		return false;
		}
	}

	public static function display_in_checkout() {
	  if ( 'yes' == get_option( 'wc_free_shipping_checkout' ) ) {
			return true;
		} else {
		return false;
		}
	}

	public static function include_tax() {
		if ( 'yes' == get_option( 'wc_free_shipping_tax' ) ) {
			return true;
		} else {
			return false;
		}
	}
}
