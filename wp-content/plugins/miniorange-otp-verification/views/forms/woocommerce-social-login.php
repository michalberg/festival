<?php

echo' 	<input type="checkbox" '.$disabled.' id="wc_checkout" class="app_enable" name="mo_customer_validation_wc_social_login_enable" value="1"
			'.$wc_social_login.' /><strong>Woocommerce Social Login [ SMS Verification Only ]</strong>';
		
		get_plugin_form_link(MoConstants::WC_SOCIAL_LOGIN);

