<?php
namespace Free_Shipping_Notice;
Class Plugin{
	public function __construct()
	{
		new Settings;
		if(Settings::is_enabled()){
			new Notice;
		}

	}
}
