<?php

	/*REGISTRATION USING PIE REGISTRATION FORM*/
	add_action(	'init', '_handle_pie_form_submit' );

	function _handle_pie_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_pie_enabled())
			return;

		add_action( 'pie_register_after_register_validate', 'miniorange_pie_user_registration',10,0);
	}

	function check_pie_enabled()
	{
		return get_option('mo_customer_validation_pie_default_enable') ? true : false;
	}

	function miniorange_pie_user_registration()
	{
		global $moUtility;
		$moUtility->checkSession();
		if (isset($_SESSION['pie_user_registration_status']) && $_SESSION['pie_user_registration_status']=='validated')
		{
				update_option('pie_user_registraion','completed');
		}
		else if(get_option('pie_user_registraion')!=='completed')
		{
			
			$fields = unserialize(get_option('pie_fields'));
			$keys = array_keys($fields);
			
			foreach($keys as $key){
				if($fields[$key]['label'] == get_option('mo_customer_validation_pie_phone_key')){
						$phone = str_replace("-","_",sanitize_title($fields[$key]['type']."_".(isset($fields[$key]['id'])?$fields[$key]['id']:"")));    
						break;
					 }
				 }
			$_SESSION['pie_user_registration'] = true;
			$errors = new WP_Error();
			$phone_number = null;
			if(get_option('mo_customer_validation_pie_enable_type')=="mo_pie_phone_enable")
				$errors = miniorange_site_challenge_otp( $_POST['username'],$_POST['e_mail'],$errors,$_POST[$phone],"phone");
			else if(get_option('mo_customer_validation_pie_enable_type')=="mo_pie_both_enable")
				$errors = miniorange_site_challenge_otp( $_POST['username'],$_POST['e_mail'],$errors,$_POST[$phone],"both");
			else
				$errors = miniorange_site_challenge_otp( $_POST['username'],$_POST['e_mail'],$errors,$_POST[$phone],"email");
		}
		else
		{
				delete_option('pie_user_registraion');
				return;
		}
	}