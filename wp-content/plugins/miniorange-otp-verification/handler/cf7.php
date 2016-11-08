<?php

	/* CF7 CONTACT FORM FUNCTIONS */
	add_action(	'init', '_handle_cf7_form_submit' );	

	function _handle_cf7_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_cf7_enabled())
			return;
		
		add_filter( 'wpcf7_validate_text*', 'miniorange_cf7_text_validation', 1 , 2 );
		add_filter( 'wpcf7_validate_email*', 'miniorange_cf7_text_validation', 1 , 2 );
		add_filter( 'wpcf7_validate_email', 'miniorange_cf7_text_validation', 1 , 2 );
		add_filter( 'wpcf7_validate_tel*', 'miniorange_cf7_text_validation', 1 , 2 );
		add_shortcode('mo_verify_email', '_cf7_email_shortcode' );
		add_shortcode('mo_verify_phone', '_cf7_phone_shortcode' );

		if(array_key_exists('option', $_GET) && $_GET['option'])
		{
			switch (trim($_GET['option'])) 
			{
				case "miniorange-cf7-contact":
					_handle_cf7_contact_form($_GET);		break;
			}
		}
	}

	function check_cf7_enabled()
	{
		return get_option('mo_customer_validation_cf7_contact_enable') ? true : false;
	}
	
	function _handle_cf7_contact_form($getdata)
	{
		global $moUtility;
		$moUtility->checkSession();
		$_SESSION['cf7_contact_page'] = 'true';
		if(array_key_exists('user_email', $getdata) && !$moUtility->mo_check_empty_or_null($getdata['user_email']))
		{
			$_SESSION['cf7_email_verified'] = $getdata['user_email'];
			miniorange_site_challenge_otp('test',$getdata['user_email'],null,$getdata['user_email'],"email");
		}
		else if(array_key_exists('user_phone', $getdata) && !$moUtility->mo_check_empty_or_null($getdata['user_phone']))
		{
			$_SESSION['cf7_phone_verified'] = '+'.trim($getdata['user_phone']);
			miniorange_site_challenge_otp('test','',null,'+'.trim($getdata['user_phone']),"phone");
		}
		else
		{
			if(get_option('mo_customer_validation_cf7_contact_type')=="mo_cf7_contact_phone_enable")
				$result['message']='You will have to provide a Phone Number before you can verify it.';
			else
				$result['message']='You will have to provide an Email Address before you can verify it.';
			$result['result'] = 'error';
			wp_send_json( $result );
		}
	}

	function miniorange_cf7_text_validation($result, $tag)
	{
		global $moUtility;
		$curl = new MocURLOTP();
		$moUtility->checkSession();
		$tag = new WPCF7_Shortcode( $tag );

		$name = $tag->name;

		$value = isset( $_POST[$name] )
			? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) )
			: '';

		if ( 'email' == $tag->basetype && $name==get_option('mo_customer_validation_cf7_email_key')) {
			$_SESSION['cf7_email_submitted'] = $value;
		}

		if ( 'tel' == $tag->basetype && $name=='mo_phone') {
			$_SESSION['cf7_phone_submitted'] = $value;
		}


		if ( 'text' == $tag->basetype && $name=='email_verify' || 'text' == $tag->basetype && $name=='phone_verify') {
			if ( $tag->is_required() && '' == $value ) {
				$error = true;
				$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
			}

			if($_SESSION['cf7_contact_page']=='true')
			{
				$err = false;
				if(array_key_exists('cf7_email_verified', $_SESSION)){
					if(strcasecmp($_SESSION['cf7_email_verified'], $_SESSION['cf7_email_submitted'])!=0){
						$result->invalidate( $tag, "The email OTP was sent to and the email in contact submission do not match." );
						$err = true;
					}
				}
				if(array_key_exists('cf7_phone_verified', $_SESSION)){
					if(strcasecmp($_SESSION['cf7_phone_verified'], $_SESSION['cf7_phone_submitted'])!=0){
						$result->invalidate( $tag, "The phone number OTP was sent to and the phone number in contact submission do not match." );
						$err = true;
					}
				}

				if(!$err){
					$content = json_decode($curl->validate_otp_token($_SESSION['mo_customer_validation_site_txID'], $value),true);
					if(strcasecmp($content['status'], 'SUCCESS') != 0) { 
						$result->invalidate( $tag, 'Invalid OTP Entered' );
					}else{
						session_unset($_SESSION['mo_customer_validation_site_txID']);
					}
				}
			}else{
				session_unset($_SESSION['cf7_email_verified']);
				$result->invalidate( $tag, "There was an unknown error.Please Try Validating your phone/email Again." );
			}
		}

		return $result;
	}


	function _cf7_email_shortcode()
	{
		global $dirOTPName;
		$img = "<div style='display:table;text-align:center;'><img src='".plugin_dir_url($dirOTPName) . "miniorange-otp-verification/includes/images/loader.gif'></div>";
		$html = '<script>jQuery(document).ready(function(){$=jQuery;$("#miniorange_otp_token_submit").click(function(o){ var e=$("input[name='.get_option('mo_customer_validation_cf7_email_key').']").val(); $("#mo_message").empty(),$("#mo_message").append("'.$img.'"),$("#mo_message").show(),$.ajax({url:"'.site_url().'",type:"GET",data:"option=miniorange-cf7-contact&user_email="+e,crossDomain:!0,dataType:"json",contentType:"application/json; charset=utf-8",success:function(o){ if(o.result=="success"){$("#mo_message").empty(),$("#mo_message").append(o.message),$("#mo_message").css("border-top","3px solid green"),$("input[name=email_verify]").focus()}else{$("#mo_message").empty(),$("#mo_message").append(o.message),$("#mo_message").css("border-top","3px solid red"),$("input[name=email_verify]").focus()} ;},error:function(o,e,n){}})});});</script>';
		return $html;
	}

	function _cf7_phone_shortcode()
	{
		global $dirOTPName;
		$img = "<div style='display:table;text-align:center;'><img src='".plugin_dir_url($dirOTPName) . "miniorange-otp-verification/includes/images/loader.gif'></div>";
		$html = '<script>jQuery(document).ready(function(){$=jQuery;$("#miniorange_otp_token_submit").click(function(o){ var e=$("input[name=mo_phone]").val(); $("#mo_message").empty(),$("#mo_message").append("'.$img.'"),$("#mo_message").show(),$.ajax({url:"'.site_url().'",type:"GET",data:"option=miniorange-cf7-contact&user_phone="+e,crossDomain:!0,dataType:"json",contentType:"application/json; charset=utf-8",success:function(o){ if(o.result=="success"){$("#mo_message").empty(),$("#mo_message").append(o.message),$("#mo_message").css("border-top","3px solid green"),$("input[name=email_verify]").focus()}else{$("#mo_message").empty(),$("#mo_message").append(o.message),$("#mo_message").css("border-top","3px solid red"),$("input[name=phone_verify]").focus()} ;},error:function(o,e,n){}})});});</script>';
		return $html;
	}