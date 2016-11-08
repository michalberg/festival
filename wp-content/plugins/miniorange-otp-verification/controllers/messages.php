<?php

	global $moUtility;
	if(array_key_exists('option',$_POST) && $_POST['option']=='mo_customer_validation_messages' && $moUtility->micr())
	{
		update_option('mo_otp_success_email_message',isset( $_POST['otp_success_email']) ? $_POST['otp_success_email'] : 0);
		update_option('mo_otp_success_phone_message',isset( $_POST['otp_success_phone']) ? $_POST['otp_success_phone'] : 0);
		update_option('mo_otp_error_phone_message',isset( $_POST['otp_error_phone']) ? $_POST['otp_error_phone'] : 0);
		update_option('mo_otp_error_email_message',isset( $_POST['otp_error_email']) ? $_POST['otp_error_email'] : 0);

		update_option( 'mo_customer_validation_message', 'Settings saved successfully.' );
		do_action("mo_registration_show_success_message");
	}

	$otp_success_email 	= get_option("mo_otp_success_email_message") ? get_option('mo_otp_success_email_message') : MoMessages::OTP_SENT_EMAIL;
	$otp_success_phone 	= get_option("mo_otp_success_phone_message") ? get_option('mo_otp_success_phone_message') : MoMessages::OTP_SENT_PHONE;
	$otp_error_phone 	= get_option("mo_otp_error_phone_message")   ? get_option('mo_otp_error_phone_message') : MoMessages::ERROR_OTP_PHONE;
	$otp_error_email 	= get_option("mo_otp_error_email_message") 	 ? get_option('mo_otp_error_email_message') : MoMessages::ERROR_OTP_EMAIL;
	

	include $dirOTPName . 'views/messages.php';