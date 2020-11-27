<?php

namespace Free_Shipping_Notice;

class Plugin {

	public function __construct() {
		 new Settings;

		$user_id        = \get_current_user_id();
		$user           = new \WP_User( $user_id );
		$excluded_roles = Settings::get_excluded_roles();

		// Only show the notice if there is an excluded role and the user is not excluded

		if ( ! is_array( $excluded_roles ) || empty( array_intersect( $user->roles, $excluded_roles ) ) ) {
			new Notice;
		}
	}
}
