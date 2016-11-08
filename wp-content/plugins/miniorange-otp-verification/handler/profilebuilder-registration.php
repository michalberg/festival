<?php
	
	/* REGISTER PROFILE BUILDER PAGE FUNCTIONS*/
	add_action(	'init', '_handle_profilebuilder_form_submit' );

	function _handle_profilebuilder_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_pb_enabled())
			return;

		add_filter( 'wppb_build_userdata','formbuilder_site_registration_errors',99,2);
		add_filter( 'wppb_register_pre_form_message','miniorange_message_formbuilder_override',1,1);
	}

	function check_pb_enabled()
	{
		return get_option('mo_customer_validation_pb_default_enable') ? true : false;
	}

	function formbuilder_site_registration_errors($userdata,$global_request)
	{
		global $moUtility;
		$moUtility->checkSession();
		$errors = new WP_Error();
		if($global_request['action']=='register' && $_REQUEST['mo_otp_validated'] != 'validated')
		{
			$_SESSION['profileBuilder_registration'] = true;
			$_SESSION['global_request'] = $global_request;
			foreach ($userdata as $key => $value) {
				if($key=="user_login"){
					$username = $value;
				}elseif ($key=="user_email") {
					$email = $value;
				}elseif ($key=="user_pass") {
					$password = $value;
				}else{
					$extra_data[$key]=$value;
				}
			}
			$errors = miniorange_site_challenge_otp($username,$email,$errors,null,"email",$password,$extra_data);
		}
		else
		{
			$_REQUEST['mo_otp_validated'] = '';
			session_unset();
			return $userdata;
		}
	}

    function miniorange_message_formbuilder_override($message)
    {
    	global $moUtility;
		$moUtility->checkSession();
    	if($moUtility->mo_check_empty_or_null($message) && isset($_SESSION['profileBuilder_registration']))
    	{
	    	session_unset();
	    	return;
    	}
    	else
    	{
    		return;
    	}
    }
