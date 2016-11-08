<?php
	
	/* WOOCOMMERCE REGISTRATION PAGE FUNCTIONS*/
	add_action(	'init', '_handle_wc_reg_form_submit' );

	function _handle_wc_reg_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_wc_reg_enabled())
			return;
		add_filter('woocommerce_process_registration_errors','woocommerce_site_registration_errors',99,4);
		if(get_option('mo_customer_validation_wc_enable_type')==='mo_wc_phone_enable' || get_option('mo_customer_validation_wc_enable_type')==='mo_wc_both_enable')
			add_action( 'woocommerce_register_form', 'mo_add_phone_field' );

	}

	function check_wc_reg_enabled()
	{
		return get_option('mo_customer_validation_wc_default_enable') ? true : false;
	}

	function woocommerce_site_registration_errors($errors,$username,$password,$email)
	{
		global $moUtility;
		$moUtility->checkSession();
		if($moUtility->mo_check_empty_or_null(array_filter($errors->errors))){
			$_SESSION['woocommerce_registration'] = true;
			$pattern = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';

			if( get_option( 'woocommerce_registration_generate_username' )==='no' )
			{
				if (  $moUtility->mo_check_empty_or_null( $username ) || ! validate_username( $username ) )
					return new WP_Error( 'registration-error-invalid-username', __( 'Please enter a valid account username.', 'woocommerce' ) );
				if ( username_exists( $username ) )
					return new WP_Error( 'registration-error-username-exists', __( 'An account is already registered with that username. Please choose another.', 'woocommerce' ) );
			}

			if( get_option( 'woocommerce_registration_generate_password' )==='no' )
			{
				if (  $moUtility->mo_check_empty_or_null( $password ) )
					return new WP_Error( 'registration-error-invalid-password', __( 'Please enter a valid account password.', 'woocommerce' ) );
			}

			if ( $moUtility->mo_check_empty_or_null( $email ) || ! is_email( $email ) )
				return new WP_Error( 'registration-error-invalid-email', __( 'Please enter a valid email address.', 'woocommerce' ) );
			if ( email_exists( $email ) )
				return new WP_Error( 'registration-error-email-exists', __( 'An account is already registered with your email address. Please login.', 'woocommerce' ) );

			do_action( 'woocommerce_register_post', $username, $email, $errors );
			if($errors->get_error_code())
				throw new Exception( $errors->get_error_message() );

			if(get_option('mo_customer_validation_wc_enable_type')=="mo_wc_phone_enable")
			{
				if ( $moUtility->mo_check_empty_or_null( $_POST['billing_phone'] ) )
					return new WP_Error( 'billing_phone_error', __( 'Please enter a valid phone number.', 'woocommerce' ) );
				preg_match($pattern,$_POST['billing_phone'],$matches);
				if ( $moUtility->mo_check_empty_or_null($matches))
					return new WP_Error( 'billing_phone_error', __( 'Please Enter a Valid Phone Number. E.g:+1XXXXXXXXXX', 'woocommerce' ) );
				$errors = miniorange_site_challenge_otp($username,$email,$errors,$_POST['billing_phone'],"phone",$password);
			}
			else if(get_option('mo_customer_validation_wc_enable_type')=="mo_wc_email_enable")
			{
				$phone = isset($_POST['billing_phone']) ? $_POST['billing_phone'] : "";
				$errors = miniorange_site_challenge_otp($username,$email,$errors,$phone,"email",$password);
			}
			else if(get_option('mo_customer_validation_wc_enable_type')=="mo_wc_both_enable")
			{
				if ( $moUtility->mo_check_empty_or_null( $_POST['billing_phone'] ) )
					return new WP_Error( 'billing_phone_error', __( '<strong>Error</strong>: Phone is required!.', 'woocommerce' ) );
				preg_match($pattern,$_POST['billing_phone'],$matches);
				if ( $moUtility->mo_check_empty_or_null($matches))
					return new WP_Error( 'billing_phone_error', __( 'Please Enter a Valid Phone Number. E.g:+1XXXXXXXXXX', 'woocommerce' ) );
				$errors = miniorange_site_challenge_otp($username,$email,$errors,$_POST['billing_phone'],"both",$password);
			}
		}	
		return $errors; 
	}

	function register_woocommerce_user($username,$email,$password,$phone_number)
	{
		global $dirOTPName;
		require_once(  plugin_dir_path($dirOTPName) . 'woocommerce/includes/class-wc-emails.php' );
		WC_Emails::init_transactional_emails();
		
		$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );
		
		if ( is_wp_error( $new_customer ) )
			wc_add_notice( $new_customer->get_error_message(), 'error' );
		if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) 
			wc_set_customer_auth_cookie( $new_customer );

		if(isset($_POST['billing_phone']))
			update_user_meta( $new_customer, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
		
		//wp_safe_redirect( apply_filters( 'woocommerce_registration_redirect', wp_get_referer() ? wp_get_referer() : wc_get_page_permalink('myaccount')));
		session_unset();
		//wp_redirect( site_url()."/".get_page_uri( get_page_by_title( get_option('mo_customer_validation_wc_redirect') )->ID) ."/" );
		wp_redirect(get_permalink( get_page_by_title( get_option('mo_customer_validation_wc_redirect') )->ID));
		exit;
	} 

	function mo_add_phone_field(){
		if(get_option('mo_customer_validation_wc_enable_type')=="mo_wc_phone_enable" || get_option('mo_customer_validation_wc_enable_type')==='mo_wc_both_enable')
		{
			echo '<p class="form-row form-row-wide">
					<label for="reg_billing_phone">'.__( 'Phone', 'woocommerce' ).'<span class="required">*</span></label>
					<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="'.(!empty( $_POST['billing_phone'] ) ? $_POST['billing_phone'] : "").'" />
			  	  </p>';
		}
	}