<?php

	/*REGISTRATION USER PROFILE MADE EASY*/
	add_action(	'init', '_handle_upme_reg_form_submit' );

	function _handle_upme_reg_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_upme_enabled())
			return;

		add_filter( 'insert_user_meta', 'miniorange_upme_insert_user',1,3);
		add_filter( 'upme_registration_custom_field_type_restrictions', 'miniorange_upme_check_phone' , 1, 2);
		
		if(array_key_exists('upme-register-form',$_POST)){
			$phone = get_option('mo_customer_validation_uultra_phone_key') ? $_POST[get_option('mo_customer_validation_uultra_phone_key')] : null;
			_handle_upme_form_submit($_POST);
		}
	}
	
	function check_upme_enabled()
	{
		return get_option('mo_customer_validation_upme_default_enable') ? true : false;
	}

	function _handle_upme_form_submit($POSTED)
	{
		$mobile_number = null;
		foreach($POSTED as $key => $value)
		{
			if($key == get_option('mo_customer_validation_upme_phone_key'))
			{
				$mobile_number = $value;
				break;
			}
		}
		miniorange_upme_user($_POST['user_login'],$_POST['user_email'],$mobile_number);
	}

	function miniorange_upme_insert_user($meta, $user, $update)
	{
		global $moUtility,$upme_save;
		$moUtility->checkSession();
		$file_upload = array_key_exists('file_upload',$_SESSION) ? $_SESSION['file_upload'] : null;
		if(array_key_exists('upme_user_registration',$_SESSION) && $_SESSION['upme_user_registration'] && !is_null($file_upload)){ 
			foreach ($file_upload as $key => $value)
			{
				$current_field_url = get_user_meta($user->ID, $key, true);
                if('' != $current_field_url)
                    upme_delete_uploads_folder_files($current_field_url);                                
				update_user_meta($user->ID, $key, $value);
			}	
    	}	
    	return $meta;
	}

	function miniorange_upme_check_phone($errors,$fields)
	{
		if(empty($errors))
		{
			if($fields['meta'] == get_option('mo_customer_validation_upme_phone_key'))
			{
				$pattern = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';
				$match = preg_match($pattern,$fields['value'],$matches);
				if(!$match)
					$errors[] = "Please enter a valid Phone Number. E.g: +1XXXXXXXXXX";
			}
		}
		return $errors;
	}

	function miniorange_upme_user($user_name,$user_email,$phone_number)
	{
		global $upme_register;
		$upme_register->prepare($_POST);
		$upme_register->handle();
		$file_upload = array();

		if(!isset($upme_register->errors)) {
			global $moUtility;
			$moUtility->checkSession();
			$_SESSION['upme_user_registration'] = true;
			if(!empty($_FILES)) {

				$upload_dir =  wp_upload_dir();
				$target_path = $upload_dir['basedir'] . "/upme/";
			 	if (!is_dir($target_path))
                	mkdir($target_path, 0777);

                foreach ($_FILES as $key => $array) {
	                extract($array);
	                $base_name = sanitize_file_name(basename($name));

	                $target_path = $target_path . time() . '_' . $base_name;

	                $nice_url = $upload_dir['baseurl'] . "/upme/";
	                $nice_url = $nice_url . time() . '_' . $base_name;
	                
	                move_uploaded_file($tmp_name, $target_path);

					$file_upload[$key]=$nice_url;
            	}

			}
			$_SESSION['file_upload'] = $file_upload;
			if(get_option('mo_customer_validation_upme_enable_type')=="mo_upme_phone_enable")
				miniorange_site_challenge_otp($user_name,$user_email,null,$phone_number,"phone");
			else if(get_option('mo_customer_validation_upme_enable_type')=="mo_upme_both_enable")
				miniorange_site_challenge_otp($user_name,$user_email,null,$phone_number,"both");
			else
				miniorange_site_challenge_otp($user_name,$user_email,null,$phone_number,"email");
		}
 	}