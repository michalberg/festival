<?php
		
	/* EVENT REGISTRATION USER FUNCTIONS */
	add_action(	'init', '_handle_event_form_submit' );

	function _handle_event_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_evr_enabled())
			return;

		add_action( 'evr_process_confirmation','miniorange_evr_user_registration',1,1);
	}

	function check_evr_enabled()
	{
		return get_option('mo_customer_validation_event_default_enable') ? true : false;
	}

	function miniorange_evr_user_registration($reg_form)
	{
		$errors = new WP_Error();
		$event_form_data = Array();
		$phone_number = null;
		global $moUtility;
		$moUtility->checkSession();
		if($_POST['option']!="miniorange-validate-otp-form")
		{
			$_SESSION['event_registration'] = true;
			if(get_option('mo_customer_validation_event_enable_type')=="mo_event_phone_enable")
				$errors = miniorange_site_challenge_otp($reg_form['fname'],$reg_form['email'],$errors,$reg_form['phone'],'phone');
			else if(get_option('mo_customer_validation_event_enable_type')=="mo_event_both_enable")
				$errors = miniorange_site_challenge_otp($reg_form['fname'],$reg_form['email'],$errors,$reg_form['phone'],'both');
			else
				$errors = miniorange_site_challenge_otp($reg_form['fname'],$reg_form['email'],$errors,$reg_form['phone'],'email');
		}
	}	