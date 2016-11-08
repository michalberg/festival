<?php

	require('cf7.php');
	require('pie-registration.php');
	require('upme-registration.php');
	require('uultra-registration.php');
	require('crf-registration.php');
	require('bbp-registration.php');
	require('event-registration.php');
	require('um-registration.php');
	require('simplr-registration.php');
	require('profilebuilder-registration.php');
	require('woocommerce/wc-checkout.php');
	require('woocommerce/wc-registration.php');
	require('woocommerce/wc-social-login.php');
	require('default-registration.php');
	require('ninja-form.php');
	require('tml-registration.php');


	/* OTP LOGIC */
	function miniorange_site_challenge_otp($user_login, $user_email, $errors, $phone_number=null,$otp_type,$password="",$extra_data=null,$from_both=false)
	{
		global $moUtility;
		$curl = new MocURLOTP();
		$moUtility->checkSession();
		$_SESSION['current_url'] = $moUtility->currentPageUrl();
		$_SESSION['user_email'] = $user_email;
		$_SESSION['user_login'] = $user_login;
		$_SESSION['user_password'] = $password;
		$_SESSION['phone_number_mo'] = $phone_number;
		$_SESSION['extra_data'] = $extra_data;
		if($otp_type=="phone"){
			$pattern = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';
			$match = preg_match($pattern,$phone_number,$matches);
			if(!$match){
				if(isset($_SESSION['woocommerce_checkout_page']) || isset($_SESSION['cf7_contact_page']) || isset($_SESSION['ajax_phone_verified'])){
					$result['message']='Please enter a valid Mobile Number. E.g: +1XXXXXXXXXX';
					$result['result'] = 'error';
					wp_send_json( $result );
				}else{
					miniorange_site_otp_validation_form(null,null,null,"<strong>ERROR:</strong> ".$phone_number." is not a valid phone number. Please enter a valid Phone Number. E.g:+1XXXXXXXXXX",$otp_type,$from_both);
					exit();
				}
			}else{
				$content = json_decode($curl->mo_send_otp_token('SMS','',$phone_number), true);
				if(strcasecmp($content['status'], 'SUCCESS') == 0) {
					$_SESSION['mo_customer_validation_site_txID'] = $content['txId'];
					update_option('mo_otp_verification_phone_otp_count',1);
					$message = get_option("mo_otp_success_phone_message") ? get_option('mo_otp_success_phone_message') : MoMessages::OTP_SENT_PHONE;
					
					if(get_option('mo_otp_plugin_version')>1.4){
						update_option('mo_customer_phone_transactions_remaining',get_option('mo_customer_phone_transactions_remaining')-1);
					}
					if(isset($_SESSION['woocommerce_checkout_page']) || isset($_SESSION['cf7_contact_page']) || isset($_SESSION['ajax_phone_verified'])){
						$result['message']= str_replace("##phone##",$phone_number,$message);
						$result['result'] = 'success';
						wp_send_json( $result );
					}else{
						$message = str_replace("##phone##",$phone_number,$message);
						miniorange_site_otp_validation_form($user_login, $user_email,$phone_number,$message,$otp_type,$from_both);
						exit();
					
					}
				}else{
					$message = get_option("mo_otp_error_phone_message") ? get_option('mo_otp_error_phone_message') : MoMessages::ERROR_OTP_PHONE;
					
					if(isset($_SESSION['woocommerce_checkout_page']) || isset($_SESSION['cf7_contact_page']) || isset($_SESSION['ajax_phone_verified'])){
						$result['message']= str_replace("##phone##",$phone_number,$message);
						$result['result'] = 'error';
						wp_send_json( $result );
					}else{
						$message = str_replace("##phone##",$phone_number,$message);
						miniorange_site_otp_validation_form(null,null,null,$message,$otp_type,$from_both);
						exit();
					}

				}
				
			}
		}elseif($otp_type=="email"){
			//update_option('mo_customer_validation_cloud',false);
			$content = json_decode($curl->mo_send_otp_token('EMAIL',$user_email), true);
			if(strcasecmp($content['status'], 'SUCCESS') == 0) {
				$_SESSION['mo_customer_validation_site_txID'] = $content['txId'];
				update_option('mo_otp_verification_email_otp_count',1);
				$message = get_option("mo_otp_success_email_message") ? get_option('mo_otp_success_email_message') : MoMessages::OTP_SENT_EMAIL;

				if(get_option('mo_otp_plugin_version')>1.4){
					update_option('mo_customer_email_transactions_remaining',get_option('mo_customer_email_transactions_remaining')-1);
				}
				if(isset($_SESSION['woocommerce_checkout_page']) || isset($_SESSION['cf7_contact_page'])){
					$result['message']= str_replace("##email##",$user_email,$message);
					$result['result'] = 'success';
					wp_send_json( $result );
				}else{
					$message = str_replace("##email##",$user_email,$message);
					miniorange_site_otp_validation_form($user_login, $user_email,$phone_number,$message,$otp_type,$from_both);
					exit();
				}

			}else{
				$message = get_option("mo_otp_error_email_message") ? get_option('mo_otp_error_email_message') : MoMessages::ERROR_OTP_EMAIL;
					
				if(isset($_SESSION['woocommerce_checkout_page']) || isset($_SESSION['cf7_contact_page'])){
					$result['message']= str_replace("##email##",$user_email,$message);
					$result['result'] = 'error';
					wp_send_json( $result );
				}else{
					$message = str_replace("##email##",$user_email,$message);
					miniorange_site_otp_validation_form(null,null,null,$message,$otp_type,$from_both);
					exit();
				}

			}
		}elseif($otp_type=="both"){
			$message = "Please select one of the methods below to verify your account. A One time passcode will be sent to the selected method.";
			miniorange_verification_user_choice($user_login, $user_email,$phone_number,$message,$otp_type);
			exit();
		}else{
			miniorange_site_otp_validation_form($user_login, $user_email,$phone_number,$message,"email",$from_both);
			exit();
		}
	}
	

	function _handle_verification_resend_otp_action($otp_type,$from_both)
	{
		$curl = new MocURLOTP();
		global $moUtility;
		$moUtility->checkSession();
		$user_email = $_SESSION['user_email'];
		$user_login  = $_SESSION['user_login'];
		$password = $_SESSION['user_password'];
		$phone_number = $_SESSION['phone_number_mo'];
		$extra_data = $_SESSION['extra_data'];
		
		if($otp_type=="phone"){
			$content = json_decode($curl->mo_send_otp_token('SMS','',$phone_number), true);
			if(strcasecmp($content['status'], 'SUCCESS') == 0) {
				$_SESSION['mo_customer_validation_site_txID'] = $content['txId'];
				if(get_option('mo_otp_plugin_version')>1.4){
						update_option('mo_customer_phone_transactions_remaining',get_option('mo_customer_phone_transactions_remaining')-1);
					}
				update_option('mo_otp_verification_phone_otp_count',get_option('mo_otp_verification_phone_otp_count') + 1);
				$message =  'Another One Time Passcode has been sent ( ' . get_option('mo_otp_verification_phone_otp_count') . ' ) to  <b> ' . $phone_number . '</b><br/><br/>Please enter the OTP below to verify your phone number';
				
				miniorange_site_otp_validation_form($user_login, $user_email,$phone_number,$message,$otp_type,$from_both);
				exit();
			}else{
				miniorange_site_otp_validation_form(null,null,null,"There was an error in sending the OTP to the given Phone Number. Please Try Again.",$otp_type,$from_both);
				exit();
			}
		}elseif($otp_type=="email"){
			$content = json_decode($curl->mo_send_otp_token('EMAIL',$user_email), true);
			if(strcasecmp($content['status'], 'SUCCESS') == 0) {
						$_SESSION['mo_customer_validation_site_txID'] = $content['txId'];
						if(get_option('mo_otp_plugin_version')>1.4){
							update_option('mo_customer_email_transactions_remaining',get_option('mo_customer_email_transactions_remaining')-1);
						}
						update_option('mo_otp_verification_email_otp_count',get_option('mo_otp_verification_email_otp_count') + 1);
						 $message =  'Another One Time Passcode has been sent ( ' . get_option('mo_otp_verification_email_otp_count') . ' )  to <b>' . $user_email. ' </b><br/><br/>Please enter the OTP below to verify your Email Address. If you cannot see the email in your inbox, make sure to check your SPAM folder.';;
				miniorange_site_otp_validation_form($user_login, $user_email,$phone_number,$message,$otp_type,$from_both);
				exit();
			}else{
				miniorange_site_otp_validation_form(null,null,null,"There was an error in sending the OTP to the given Email Address. Please Try Again.",$otp_type,$from_both);
				exit();	
			}
		}elseif($otp_type=='both'){
			$message = "Please select one of the methods below to resend the OTP to:";
			miniorange_verification_user_choice($user_login, $user_email,$phone_number,$message,$otp_type);
			exit();
		}
	}

	function _handle_validation_goBack_action()
	{
		global $moUtility;
		$moUtility->checkSession();
		$url = isset($_SESSION['current_url'])? $_SESSION['current_url'] : '';
		session_unset();
		wp_redirect($url);
		exit();
	}
	
	function _handle_validation_form_action($otp_type,$from_both=false)
	{
		global $moUtility;
		$curl = new MocURLOTP();
		$moUtility->checkSession();
		$user_login = !$moUtility->mo_check_empty_or_null($_SESSION['user_login']) ? $_SESSION['user_login'] : null;
		$user_email = !$moUtility->mo_check_empty_or_null($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
		$phone_number = !$moUtility->mo_check_empty_or_null($_SESSION['phone_number_mo']) ? $_SESSION['phone_number_mo'] : null;
		$password = !$moUtility->mo_check_empty_or_null($_SESSION['user_password']) ? $_SESSION['user_password'] : null;
		$extra_data = !$moUtility->mo_check_empty_or_null($_SESSION['extra_data']) ? $_SESSION['extra_data'] : null;
		$txID = !$moUtility->mo_check_empty_or_null($_SESSION[ 'mo_customer_validation_site_txID' ]) ? $_SESSION[ 'mo_customer_validation_site_txID' ] : null;
		$otp_token = !$moUtility->mo_check_empty_or_null($_REQUEST['mo_customer_validation_otp_token']) ? $_REQUEST['mo_customer_validation_otp_token'] : null;
		
		
		if(!is_null($txID))
		{
			$content = json_decode($curl->validate_otp_token($txID, $otp_token),true);
			if(strcasecmp($content['status'], 'SUCCESS') == 0) { //OTP validated
				$_SESSION['phone_number_mo'] = $phone_number;
				
				if(isset($_SESSION['woocommerce_registration']))
					register_woocommerce_user($user_login,$user_email,$password,$phone_number);
				elseif (isset($_SESSION['profileBuilder_registration'])){
					$_REQUEST['mo_otp_validated']='validated';
					return;
				}
				elseif (isset($_SESSION['ultimate_members_registration']))
					register_ultimateMember_user($user_login,$user_email,$password,$phone_number,$extra_data);
				elseif (isset($_SESSION['event_registration']))
					session_unset();
				elseif (isset($_SESSION['crf_user_registration']))
					session_unset();
				elseif (isset($_SESSION['simplr_registration']))
					register_simplr_user($user_login,$user_email,$password,$phone_number,$extra_data);
				elseif (isset($_SESSION['buddyPress_user_registration']))
					signup_buddyPress_user($user_login,$user_email,$password,$phone_number,$extra_data);
				elseif(isset($_SESSION['uultra_user_registration']))
					session_unset();
				elseif(isset($_SESSION['woocommerce_checkout_page']))
					session_unset();
				elseif(isset($_SESSION['pie_user_registration']))
					$_SESSION['pie_user_registration_status']='validated';
				elseif(isset($_SESSION['wc_social_login']))
					$_SESSION['wc_social_login']='validated';
				elseif (isset($_SESSION['default_wp_registration'])){	
					session_unset('default_wp_registration');
					$errors = register_new_user($user_login, $user_email);
					if ( !is_wp_error($errors) ) {
						$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] :  wp_login_url()."?checkemail=registered";
						wp_redirect( $redirect_to );
						exit();
					}
				}elseif (isset($_SESSION['tml_registration'])){	
					session_unset('tml_registration');
					$errors = register_new_user($user_login, $user_email);
					if ( !is_wp_error($errors) ) {
						$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] :  wp_login_url()."?checkemail=registered";
						wp_redirect( $redirect_to );
						exit();
					}
				}
			}else{  // OTP Validation failed.
				$message = 'Invalid OTP. Please try again';
				if(isset($_SESSION['wc_social_login']))
				{
					$_SESSION['wc_social_login']='invalid';
					return;
				}
				miniorange_site_otp_validation_form($user_login, $user_email,$phone_number, $message,$otp_type,$from_both);
				exit();
			}
		}
	}
	
	function _handle_validate_otp_choice_form($postdata)
	{
		global $moUtility;
		$moUtility->checkSession();
			if($postdata['mo_customer_validation_otp_choice'] == 'user_email_verification')
				miniorange_site_challenge_otp($_SESSION['user_login'],$_SESSION['user_email'],null,$_SESSION['phone_number_mo'],"email",$_SESSION['user_password'],$_SESSION['extra_data'],true);
			else
				miniorange_site_challenge_otp($_SESSION['user_login'],$_SESSION['user_email'],null,$_SESSION['phone_number_mo'],"phone",$_SESSION['user_password'],$_SESSION['extra_data'],true);
	}

	function _handle_mo_ajax_phone_validate($getdata)
	{
		global $moUtility;
		$moUtility->checkSession();
		$_SESSION['ajax_phone_verified'] = '+'.trim($getdata['user_phone']);
		miniorange_site_challenge_otp('ajax_phone','',null,'+'.trim($getdata['user_phone']),"phone");
	}
	

	function _handle_mo_ajax_form_validate_action()
	{
		global $moUtility;
		$moUtility->checkSession();
		if(isset($_SESSION['wc_social_login']))
		{
			_handle_validation_form_action('phone');
			if($_SESSION['wc_social_login']=='validated')
			{
				$result['result'] = 'success';
				wp_send_json( $result );
			}
			else
			{
				$result['message']='Invalid OTP. Please Try Again';
				$result['result'] = 'error';
				wp_send_json( $result );
			}

		}
	}

	function _handle_mo_create_user_wc_action($postdata)
	{
		global $moUtility;
		$moUtility->checkSession();
		if(isset($_SESSION['wc_social_login']) && $_SESSION['wc_social_login']=='validated')
			create_new_wc_social_customer($postdata);
	}
?>