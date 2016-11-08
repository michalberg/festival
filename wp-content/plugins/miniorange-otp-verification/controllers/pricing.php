<?php

$form_action 	  	= MoConstants::HOSTNAME.'/moas/login';
$redirect_url	  	= MoConstants::HOSTNAME .'/moas/initializepayment';
$free_plan_name 	= 'Free';
$basic_plan_name 	= 'Your SMS Gateway';
$premium_plan_name 	= 'miniOrange SMS Gateway';
$free_plan_price	= 'Free';
$basic_plan_price 	= '$249 - One Time Payment';
$premium_plan_price	= '$0 - One Time Payment';
$width 				= $plan ? "63%" : "96%";
global $moUtility;
$vl = $moUtility->mclv();

$free_plan_features =array(
		"Email Address Verifications",
		"Phone Verifications",
		"",
		"",
		"",
		""
);

$basic_plan_features =array(
		"Email Address Verifications",
		"Phone Verifications",
		"Custom Email Template ",
		"Custom SMS Template",
		"Custom SMS/SMTP Gateway",
		"Custom Integration/Work***"
);


$premium_plan_features =array(
		"Email Address Verifications",
		"Phone Verifications",
		"Custom Email Template ",
		"Custom SMS Template",
		"Custom SMS/SMTP Gateway",
		"Custom Integration/Work***"
);

include $dirOTPName . 'views/pricing.php';