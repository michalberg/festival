<?php
	
	//wc checkout
	$wc_social_login		  = get_option('mo_customer_validation_wc_social_login_enable') ? "checked" : "";
	
	include $dirOTPName . 'views/forms/woocommerce-social-login.php';
	