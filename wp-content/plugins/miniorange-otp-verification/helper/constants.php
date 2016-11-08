<?php

class MoConstants
{
	const DEFAULT_CUSTOMER_KEY 	= "16555";
	const DEFAULT_API_KEY 		= "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";
	const PCODE 				= "UHJlbWl1bSBQbGFuIC0gV1AgT1RQIFZFUklGSUNBVElPTg==";
	const BCODE 				= "RG8gaXQgWW91cnNlbGYgUGxhbiAtIFdQIE9UUCBWRVJJRklDQVRJT04=";
	const CCODE					= "bWluaU9yYW5nZSBTTVMvU01UUCBHYXRld2F5IC0gV1AgT1RQIFZFUklGSUNBVElPTg==";
	const HOSTNAME				= "https://auth.miniorange.com";
	const FROM_EMAIL			= "no-reply@miniorange.com";
	const SUPPORT_EMAIL 		= "info@miniorange.com";
	const SUBJECT				= "One Time Passcode";
	const HEADER_CONTENT_TYPE	= "Content-Type: text/html";
	const SUCCESS				= "SUCCESS";
	const FAILURE				= "FAILURE";
	const AREA_OF_INTEREST		= "WP OTP Verification Plugin";
	const APPLICATION_NAME		= "wp_otp_verification";
	const DEFAULT_SMS_TEMPLATE  = "Dear Customer, Your OTP is ##otp##. Use this Passcode to complete your transaction. Thank you."; 
	const EMAIL_SUBJECT 		= "Your Requested One Time Passcode";
	const DEFAULT_EMAIL_TEMPLATE= "Dear Customer, \n\nYour One Time Passcode for completing your transaction is: ##otp##\nPlease use this Passcode to complete your transaction. Do not share this Passcode with anyone.\n\nThank You,\nminiOrange Team.";
	const RCON_TEMPLATE			= " YOUR CODE IS : ##otp##";
	
	//form links
	const PB_FORM_LINK			= 'https://wordpress.org/plugins/profile-builder/';
	const WC_FORM_LINK          = 'https://wordpress.org/plugins/woocommerce/';
	const SIMPLR_FORM_LINK  	= 'https://wordpress.org/plugins/simplr-registration-form/';
	const UM_ENABLED 			= 'https://wordpress.org/plugins/ultimate-member/';
	const EVENT_FORM			= 'https://wordpress.org/plugins/event-registration/';
	const BBP_FORM_LINK 		= 'https://wordpress.org/plugins/buddypress/';
	const CRF_FORM_ENABLE		= 'https://wordpress.org/plugins/custom-registration-form-builder-with-submission-manager/';
	const UULTRA_FORM_LINK 		= 'https://wordpress.org/plugins/users-ultra/';
	const UPME_FORM_LINK	    = 'http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/4109874';
	const PIE_FORM_LINK 		= 'http://pieregister.com/';
	const CF7_FORM_LINK 		= 'https://wordpress.org/plugins/contact-form-7/';
	const WC_SOCIAL_LOGIN		= 'https://woocommerce.com/products/woocommerce-social-login/';
	const NINJA_FORMS_LINK		= 'https://ninjaforms.com/';
	
	function __construct()
	{
		$this->define_global();
	}
	
	function define_global()
	{
		global $moUtility,$dirOTPName;
		$moUtility  = new MoUtility();
		$dirOTPName = plugin_dir_path(dirName(__FILE__));
	}
}
new MoConstants;