<?php

	/*REGISTRATION MAGIC USER FUNCTIONCS*/
	add_action(	'init', '_handle_crf_reg_form_submit' );

	function _handle_crf_reg_form_submit()
	{
		global $moUtility;
		$moUtility->checkSession();

		if(!check_crf_enabled() || !$moUtility->micr())
			return;

		if (array_key_exists('option',$_POST) && (strpos($_POST['option'], 'verification_resend_otp_') 
			|| $_POST['option']=='miniorange-validate-otp-form' || $_POST['option']=='miniorange-validate-otp-choice-form') )
			return;

		if(array_key_exists('rm_form_sub_id',$_REQUEST) && $_REQUEST['rm_form_sub_id']!="rm_login_form" && isset($_REQUEST['rm_form_sub_id']))
			_handle_crf_form_submit($_REQUEST);
	}
	

	function check_crf_enabled()
	{
		return get_option('mo_customer_validation_crf_default_enable') ? true : false;
	}

	function _handle_crf_form_submit($requestdata)
	{
		global $wpdb,$moUtility;
		$crf_fields =$wpdb->prefix."rm_fields";
		$email = '';
		$phone = '';
		if(get_option('mo_customer_validation_crf_enable_type') == 'mo_crf_email_enable' || get_option('mo_customer_validation_crf_enable_type') == 'mo_crf_both_enable')
		{
			$reg1 = $wpdb->get_results("SELECT * FROM $crf_fields where field_label ='".get_option('mo_customer_validation_crf_email_key')."'");
			foreach($reg1 as $row1)
			{
				$email = $row1->field_type.'_'.$row1->field_id;
				if(isset($requestdata[$email]))
					break;
			}
			$email = $requestdata[$email];
		}
		if(get_option('mo_customer_validation_crf_enable_type') == 'mo_crf_phone_enable' || get_option('mo_customer_validation_crf_enable_type') == 'mo_crf_both_enable')
		{
			$reg1 = $wpdb->get_results("SELECT * FROM $crf_fields where field_label ='".get_option('mo_customer_validation_crf_phone_key')."'");
			foreach($reg1 as $row1)
			{
				$phone = $row1->field_type.'_'.$row1->field_id;
				if(isset($requestdata[$phone]))
					break;
			}
			$phone = $requestdata[$phone];
		}
			
		if(isset($requestdata['user_name']))
			miniorange_crf_user($email,$requestdata['user_name'],$phone);
		else
			miniorange_crf_user($email,null,$phone);
		
	}

	function miniorange_crf_user($user_email,$user_name,$phone_number)
	{
		global $moUtility;
		$moUtility->checkSession();
		$_SESSION['crf_user_registration'] = true;
		$errors = new WP_Error();
		if(get_option('mo_customer_validation_crf_enable_type')=="mo_crf_phone_enable")
			$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone_number,"phone");
		else if(get_option('mo_customer_validation_crf_enable_type')=="mo_crf_both_enable")
			$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone_number,"both");
		else
			$errors = miniorange_site_challenge_otp($user_name,$user_email,$errors,$phone_number,"email");
	}
