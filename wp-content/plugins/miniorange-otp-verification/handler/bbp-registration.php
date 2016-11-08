<?php
	
	/* BUDDYPRESS REGISTRATION USER FUNCTIONS */
	add_action(	'init', '_handle_bbp_form_submit' );

	function _handle_bbp_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_bbp_enabled())
			return;

		add_filter( 'bp_registration_needs_activation', '__return_false');
		add_filter( 'bp_registration_needs_activation'	, 'fix_signup_form_validation_text');
		add_filter( 'bp_core_signup_send_activation_key', 'disable_activation_email');
		add_filter( 'bp_signup_usermeta','miniorange_bp_user_registration',99,1);
		add_action( 'bp_core_screen_signup','miniorange_check_registration_status',99,0);	
	}
	
	function check_bbp_enabled()
	{
		return get_option('mo_customer_validation_bbp_default_enable') ? true : false;
	}

	function fix_signup_form_validation_text()
	{
		return get_option('mo_customer_validation_bbp_disable_activation') ? false : true;
	}
	
	function disable_activation_email()
	{
		return get_option('mo_customer_validation_bbp_disable_activation') ? false : true;
	}

	function miniorange_bp_user_registration($usermeta)
	{
		global $moUtility;
		$moUtility->checkSession();
		$_SESSION['buddyPress_user_registration'] = true;
		$errors = new WP_Error();
		$phone_number = null;
		foreach ($_POST as $key => $value)
		{
				if($key=="signup_username"){
					$username = $value;
				}elseif ($key=="signup_email") {
					$email = $value;
				}elseif ($key=="signup_password") {
					$password = $value;
				}else{
					$extra_data[$key]=$value;
				}
		}
		global $wpdb;
		$bp_xprofile_fields =$wpdb->prefix."bp_xprofile_fields";
		$extra_data['usermeta'] = $usermeta;
		$reg1 = $wpdb->get_results("SELECT id FROM $bp_xprofile_fields where name ='".get_option('mo_customer_validation_bbp_phone_key')."'");
		foreach($reg1 as $row1)
		{
			$field_key = "field_".$row1->id;
			if(isset($_POST[$field_key]))
			{
				$phone_number = $_POST[$field_key]; 
				break;
			}
		}
		if(get_option('mo_customer_validation_bbp_enable_type')=="mo_bbp_phone_enable")
			$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,'phone',$password,$extra_data);
		else if(get_option('mo_customer_validation_bbp_enable_type')=="mo_bbp_both_enable")
			$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,'both',$password,$extra_data);
		else
			$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone_number,'email',$password,$extra_data);
	}


	function signup_buddyPress_user($user_login,$user_email,$password,$phone_number,$extra_data)
	{
		global $moUtility;
		$moUtility->checkSession();
		if ( isset( $extra_data['signup_with_blog'] ) && is_multisite() )
			$wp_user_id = bp_core_signup_blog( $extra_data['domain'], $extra_data['path'], $extra_data['blog_title'], $user_login, $user_email, $extra_data['usermeta'] );
		else
			$wp_user_id = bp_core_signup_user( $user_login, $password, $user_email, $extra_data['usermeta'] );
		if ( is_wp_error( $wp_user_id ) ) 
			$_SESSION['buddyPress_user_registration'] = 'error';
		else
			$_SESSION['buddyPress_user_registration'] = 'completed';
		if(get_option('mo_customer_validation_bbp_disable_activation'))
			mo_activate_bbp_user($wp_user_id,$user_login);
		do_action( 'bp_complete_signup');
		bp_core_load_template( apply_filters( 'bp_core_template_register', array( 'register', 'registration/register' ) ) );
	}
	
	function mo_activate_bbp_user($userID,$user_login)
	{
		global $wpdb;
		
		$user = $wpdb->get_results( "SELECT activation_key FROM {$wpdb->prefix}signups WHERE active = '0' AND user_login = '".$user_login."'");
		bp_core_activate_signup($user[0]->activation_key);
		BP_Signup::validate($user[0]->activation_key);
		$u = new WP_User( $userID );
		$u->add_role( 'subscriber' );
		return;
	}

	function miniorange_check_registration_status()
	{
		global $moUtility;
		$moUtility->checkSession();
		if(isset($_SESSION['buddyPress_user_registration']) && $_SESSION['buddyPress_user_registration']=="completed")
		{
			buddypress()->signup->step = 'completed-confirmation';
			session_unset();
		}
		else if(isset($_SESSION['buddyPress_user_registration']) && $_SESSION['buddyPress_user_registration']=="error")
		{
			buddypress()->signup->step = 'request-details';
			bp_core_add_message( $wp_user_id->get_error_message(), 'error' );
			session_unset();
		}
	}