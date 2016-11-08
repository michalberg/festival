<?php 
	
	/*NINJA FORM*/
	add_action(	'ninja_forms_process', 'ninja_form_submit', 1);

	function ninja_form_submit()
	{
		global $moUtility;
		
		if(!$moUtility->micr() || !check_ninja_form_enabled())
			return;

		if (array_key_exists('option',$_POST) && (strpos($_POST['option'], 'verification_resend_otp_') 
			|| $_POST['option']=='miniorange-validate-otp-form' || $_POST['option']=='miniorange-validate-otp-choice-form') )
			return;

		if(array_key_exists('_ninja_forms_display_submit',$_REQUEST)  && array_key_exists('_form_id',$_REQUEST))
			_handle_ninja_form_submit($_REQUEST);
	}

	function check_ninja_form_enabled()
	{
		return get_option('mo_customer_validation_ninja_form_enable') ? true : false;
	}
	
	function _handle_ninja_form_submit($requestdata) 
	{
		global $moUtility;
		$email = '';
		$phone = '';
		$ninja_forms_enabled = maybe_unserialize(get_option('mo_customer_validation_ninja_form_otp_enabled'));
		if(array_key_exists($requestdata['_form_id'],$ninja_forms_enabled))
		{
			$formdata = $ninja_forms_enabled[$requestdata['_form_id']];
			if(get_option('mo_customer_validation_ninja_form_enable_type') == 'mo_ninja_form_email_enable' || get_option('mo_customer_validation_ninja_form_enable_type') == 'mo_ninja_both_enable')
			{
				$field = "ninja_forms_field_".$formdata['emailkey'];
				if(array_key_exists($field,$requestdata)) 
					$email=$requestdata[$field];
			}
			if(get_option('mo_customer_validation_ninja_form_enable_type') == 'mo_ninja_form_phone_enable' || get_option('mo_customer_validation_ninja_form_enable_type') == 'mo_ninja_both_enable')
			{
				$field = "ninja_forms_field_".$formdata['phonekey'];
				if(array_key_exists($field,$requestdata)) 
					$phone=$requestdata[$field];
			}
			miniorange_ninja_form_user($email,null,$phone);
		}
	}

	function miniorange_ninja_form_user($user_email,$user_name,$phone_number)
	{
		global $moUtility;
		$moUtility->checkSession();
		$_SESSION['ninja_form_submit'] = true;
		$errors = new WP_Error();
		if(get_option('mo_customer_validation_ninja_form_enable_type')=="mo_ninja_form_phone_enable")
			$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone_number,"phone");
		else if(get_option('mo_customer_validation_ninja_form_enable_type')=="mo_ninja_form_both_enable")
			$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone_number,"both");
		else
			$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone_number,"email");
	}