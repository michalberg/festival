<?php
	
	/*SIMPLR REGISTRATION PAGE FUNCTIONS*/
	add_action(	'init', '_handle_simplr_form_submit' );

	function _handle_simplr_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_simplr_enabled())
			return;

		add_filter( 'simplr_validate_form','simplr_site_registration_errors',10,1);
	}	

	function check_simplr_enabled()
	{
		return get_option('mo_customer_validation_simplr_default_enable') ? true : false;
	}

    function simplr_site_registration_errors($errors)
    {
		global $moUtility;
		$moUtility->checkSession();
		if($moUtility->mo_check_empty_or_null($errors) && !isset($_POST['fbuser_id']))
		{
			$_SESSION['simplr_registration'] = true;
			$phone_number = null;
			foreach ($_POST as $key => $value)
			{
				if($key=="username"){
					$username = $value;
				}elseif ($key=="email") {
					$email = $value;
				}elseif ($key=="password") {
					$password = $value;
				}elseif ($key==get_option('mo_customer_validation_simplr_field_key')){
					$pattern = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';
					preg_match($pattern,$value,$matches);
					if(!$moUtility->mo_check_empty_or_null($matches)){
						$phone_number = $value;
					}else{
						$errors[].=__("Please Enter a Valid Phone Number. E.g:+1XXXXXXXXXX.",'simplr-registration-form');
						add_filter($key.'_error_class','_sreg_return_error');
						return $errors;
					}
				}
				else
				{
					$extra_data[$key]=$value;
				}
			}
			if(get_option('mo_customer_validation_simplr_enable_type')=="mo_phone_enable")
				$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,"phone",$password,$extra_data);
			else if(get_option('mo_customer_validation_simplr_enable_type')=="mo_both_enable")
				$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,"both",$password,$extra_data);
			else
				$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,"email",$password,$extra_data);
		}	
		return $errors; 
	}

    function register_simplr_user($user_login,$user_email,$password,$phone_number,$extra_data)
    {
    	$data = Array(); 
    	global $sreg,$simplr_options,$moUtility;
    	if( !$sreg ) { $sreg = new stdClass; }
    	$data['username'] = $user_login;
    	$data['email'] = $user_email;
    	$data['password'] = $password;
    	if(get_option('mo_customer_validation_simplr_field_key'))
    		$data[get_option('mo_customer_validation_simplr_field_key')] = $phone_number;
    	$data = array_merge($data,$extra_data);
    	$atts = $extra_data['atts'];
    	$sreg->output = simplr_setup_user($atts,$data);
    	if($moUtility->mo_check_empty_or_null($sreg->errors))
    	{
	    	if( isset($atts['thanks']) ) {
				$page = get_permalink($atts['thanks']);
				session_unset();
				wp_redirect($page);
				exit();
			}elseif( !$moUtility->mo_check_empty_or_null($simplr_options->thank_you) ) {
				$page = get_permalink($simplr_options->thank_you);
				session_unset();
				wp_redirect($page);
				exit();
			}else {
				session_unset();
				$sreg->success = $sreg->output;
			}
		}
    }