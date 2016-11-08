<?php
	
	add_action(	'init', '_handle_wc_social_form_submit' );

	function _handle_wc_social_form_submit()
	{
		global $dirOTPName,$moUtility;
	
		if(!$moUtility->micr() || !check_wc_social_login_enabled())
			return;
		
		require_once(  plugin_dir_path($dirOTPName) . 'woocommerce-social-login/includes/class-wc-social-login-provider-profile.php' );

		$providers = array("facebook","twitter","google","amazon","linkedIn","paypal","instagram","disqus","yahoo","vk");
		foreach ($providers as $provider)
		{
			add_filter( 'wc_social_login_'.$provider.'_profile', 'mo_wc_social_login_profile', 99 ,1 );
			add_filter( 'wc_social_login_' . $provider . '_new_user_data', 'mo_wc_social_login', 99 ,2 );
		}
	}

	
	function check_wc_social_login_enabled()
	{
		return get_option('mo_customer_validation_wc_social_login_enable') ? true : false;
	}

	function mo_wc_social_login_profile($profile)
	{
		global $moUtility;
		$moUtility->checkSession();
		$_SESSION['wc_social_login'] = true;
		$_SESSION['wc_provider'] = maybe_serialize($profile);
		return $profile;
	}

	function mo_wc_social_login($usermeta,$profile)
	{
		$message = "Enter your mobile number below for verification :";
		mo_wc_show_phone_field(MoUtility::currentPageUrl(),$usermeta['user_email'],$message,'WC_SOCIAL',$usermeta);
		exit;
	}

	function create_new_wc_social_customer($userdata)
	{
		global $moUtility,$dirOTPName;
		require_once(  plugin_dir_path($dirOTPName) . 'woocommerce/includes/class-wc-emails.php' );
		WC_Emails::init_transactional_emails();
		
		$moUtility->checkSession();
		$auth = maybe_unserialize($_SESSION['wc_provider']);
		session_unset();
		$profile = new WC_Social_Login_Provider_Profile( $auth );
		$phone = $userdata['mo_phone_number'];
		$userdata = array(
			'role'=>'customer',
			'user_login'=>$userdata['user_login'],
			'user_email'=>$userdata['user_email'],
			'user_pass'=>$userdata['user_pass'],
			'first_name'=>$userdata['first_name'],
			'last_name'=>$userdata['last_name']
		);

		if ( empty( $userdata['user_login'] ) ) {
			$userdata['user_login'] = $userdata['first_name'] . $userdata['last_name'];
		}

		$append     = 1;
		$o_username = $userdata['user_login'];

		while ( username_exists( $userdata['user_login'] ) ) {
			$userdata['user_login'] = $o_username . $append;
			$append ++;
		}

		$customer_id = wp_insert_user( $userdata );

		update_user_meta( $customer_id, 'billing_phone', $phone );
		update_user_meta( $customer_id, 'telephone', $phone );
		
		do_action( 'woocommerce_created_customer', $customer_id, $userdata, false );

		$user = get_user_by( 'id', $customer_id );

		$profile->update_customer_profile( $user->ID, $user );

		if ( ! $message = apply_filters( 'wc_social_login_set_auth_cookie', '', $user ) ) {
			wc_set_customer_auth_cookie( $user->ID );
			update_user_meta( $user->ID, '_wc_social_login_' . $profile->get_provider_id() . '_login_timestamp', current_time( 'timestamp' ) );
			update_user_meta( $user->ID, '_wc_social_login_' . $profile->get_provider_id() . '_login_timestamp_gmt', time() );
			do_action( 'wc_social_login_user_authenticated', $user->ID, $profile->get_provider_id() );
		} else {
			wc_add_notice( $message, 'notice' );
		}

		if ( is_wp_error( $customer_id ) ) {
			redirect( 'error', 0, $user_id->get_error_code() );
		} else {
			redirect( null, $customer_id );
		}

	}

	function redirect( $type = null, $user_id = 0, $error_code = 'wc-social-login-error' ) {

		$user = get_user_by( 'id', $user_id );

		if ( isset( $user->user_email ) && '' === $user->user_email ) {
			$return_url = add_query_arg( 'wc-social-login-missing-email', 'true', wc_customer_edit_account_url() );
		} else {
			$return_url = get_transient( 'wcsl_' . md5( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) );
			$return_url = $return_url ? esc_url( urldecode( $return_url ) ) : wc_get_page_permalink( 'myaccount' );
			delete_transient( 'wcsl_' . md5( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) );
		}

		if ( 'error' === $type ) {
			$return_url = add_query_arg( $error_code, 'true', $return_url );
		}
		wp_safe_redirect( esc_url_raw( $return_url ) );
		exit;
	}