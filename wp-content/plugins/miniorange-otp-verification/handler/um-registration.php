<?php
	
	/* ULTIMATE MEMBER PAGE FUNCTIONS*/
	add_action(	'init', '_handle_um_form_submit' );

	function _handle_um_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_um_enabled())
			return;

		add_action( 'um_submit_form_errors_hook_', 'miniorange_um_phone_validation', 99,1);
		add_action( 'um_before_new_user_register', 'miniorange_um_user_registration', 99,1);
	}

	function check_um_enabled()
	{
		return get_option('mo_customer_validation_um_default_enable') ? true : false;
	}

	function miniorange_um_user_registration($args)
	{
		global $moUtility;
		$moUtility->checkSession();
		$errors = new WP_Error();
		$_SESSION['ultimate_members_registration'] = true;
		$phone_number = null;

		foreach ($args as $key => $value)
		{
			if($key=="user_login"){
				$username = $value;
			}elseif ($key=="user_email") {
				$email = $value;
			}elseif ($key=="user_password") {
				$password = $value;
			}elseif ($key == 'mobile_number'){
					$phone_number = $value;
			}else{
				$extra_data[$key]=$value;
			}
		}
		if(get_option('mo_customer_validation_um_enable_type')=="mo_um_phone_enable")
			$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,"phone",$password,$extra_data);
		else if(get_option('mo_customer_validation_um_enable_type')=="mo_um_both_enable")
			$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,"both",$password,$extra_data);
		else
			$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,"email",$password,$extra_data);
	}

	function miniorange_um_phone_validation($args)
	{
		global $ultimatemember,$moUtility;
		foreach ($args as $key => $value) 
		{
			if ($key == 'mobile_number')
			{
				$pattern = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';
				preg_match($pattern,$value,$matches);
				if($moUtility->mo_check_empty_or_null($matches))
					$ultimatemember->form->add_error($key, __('Please enter a valid Mobile Number E.g: +1XXXXXXXXXX','ultimatemember') );
			}
		}
	}

	function register_ultimateMember_user($user_login,$user_email,$password,$phone_number,$extra_data)
	{
		$args = Array();
		$args['user_login'] = $user_login;
		$args['user_email'] = $user_email;
		$args['user_password'] = $password;
		$args = array_merge($args,$extra_data);
		$user_id = wp_create_user( $user_login,$password, $user_email );
		session_unset();
		do_action('um_after_new_user_register', $user_id, $args);
	}
