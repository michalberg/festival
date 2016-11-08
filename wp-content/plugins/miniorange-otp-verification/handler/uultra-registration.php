<?php

	/*USER ULTRA FORM FUNCTIONS*/
	add_action(	'init', '_handle_uultra_reg_form_submit' );

	function _handle_uultra_reg_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_uultra_enabled())
			return;

		if(array_key_exists('xoouserultra-register-form',$_POST))
		{
			$phone = get_option('mo_customer_validation_uultra_phone_key') ? $_POST[get_option('mo_customer_validation_uultra_phone_key')] : null;
			_handle_uultra_form_submit($_POST['user_login'],$_POST['user_email'],$phone);
		}
	}

	function check_uultra_enabled()
	{
		return get_option('mo_customer_validation_uultra_enable') ? true : false;
	}

	function _handle_uultra_form_submit($user_name,$user_email,$phone)
	{		
			$errors = new WP_Error();
			$test = new XooUserRegister;
			$test->uultra_prepare_request( $_POST );
			$test->uultra_handle_errors();
			if(!isset($test->errors))
			{
				global $moUtility;
				$moUtility->checkSession();
				$_SESSION['uultra_user_registration'] = true;
				 
			
				if(get_option('mo_customer_validation_uultra_enable_type')=="mo_uultra_phone_enable")
					$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone,"phone");
				else if(get_option('mo_customer_validation_uultra_enable_type')=="mo_uultra_both_enable")
					$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone,"both");
				else
					$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone,"email");
			}
	}
	