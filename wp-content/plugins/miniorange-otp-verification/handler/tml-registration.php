<?php

	/*THEME MY LOGIN FUNCTIONCS*/
	add_action(	'init', '_handle_tml_reg_form_submit' );

	function _handle_tml_reg_form_submit()
	{
		global $moUtility;
		$moUtility->checkSession();

		if(!check_tml_reg_enabled() || !$moUtility->micr())
			return;

		add_action('register_form', 'miniorange_tml_register_form');
		add_filter('registration_errors', 'miniorange_tml_registration_errors', 1, 3 );
		add_action('admin_post_nopriv_miniorange-validate-otp-form', '_handle_validation_form_action');
		add_action('admin_post_nopriv_validation_goBack', '_handle_validation_goBack_action');
		add_action( 'user_register', 'miniorange_tml_registration_save', 10, 1 );
		
	}

	function check_tml_reg_enabled()
	{
		return get_option('mo_customer_validation_tml_enable') ? true : false;
	}

	function miniorange_tml_register_form()
	{	
 		echo '<input type="hidden" name="register_tml_nonce" value="register_tml_nonce"/>';
 		if(get_option('mo_customer_validation_tml_enable_type') == 'mo_tml_phone_enable' || get_option('mo_customer_validation_tml_enable_type') == 'mo_tml_both_enable')
		{
			echo '<label for="phone_number_mo">Phone Number<br />
				  <input type="text" name="phone_number_mo" id="phone_number_mo" class="input" value="" style=""  /></label>';
		}
	}
	
	function miniorange_tml_registration_save($user_id)
	{
		if ( isset( $_SESSION['phone_number_mo'] ) )
			add_user_meta($user_id, 'telephone', $_SESSION['phone_number_mo']);
		session_unset();
		
	}

	function miniorange_tml_registration_errors($errors, $sanitized_user_login, $user_email )
	{
		global $moUtility;
		$moUtility->checkSession();
		if(get_option('mo_customer_validation_tml_enable_type') == 'mo_tml_phone_enable' || get_option('mo_customer_validation_tml_enable_type') == 'mo_tml_both_enable')
		{
			$phone_number = !$moUtility->mo_check_empty_or_null($_POST['phone_number_mo'])? $_POST['phone_number_mo'] : null;
			if(is_null($phone_number))
				$errors->add( 'empty_phone', __( '<strong>ERROR</strong>: Please type your phone number.' ) );	
		}
		if($moUtility->mo_check_empty_or_null(array_filter($errors->errors)) && isset($_POST['register_tml_nonce']))
		{
			$_SESSION['tml_registration']=true;
			if(get_option('mo_customer_validation_tml_enable_type')=="mo_tml_phone_enable")
				$errors = miniorange_site_challenge_otp($sanitized_user_login,$user_email,$errors,$phone_number,"phone");
			else if(get_option('mo_customer_validation_tml_enable_type')=="mo_tml_both_enable")
				$errors = miniorange_site_challenge_otp($sanitized_user_login,$user_email,$errors,$phone_number,"both");
			else
				$errors = miniorange_site_challenge_otp($sanitized_user_login,$user_email,$errors,$phone_number,"email");
		}
		return $errors;
	}