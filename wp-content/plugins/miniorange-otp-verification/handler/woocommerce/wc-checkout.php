<?php
	
	/* WOOCOMMERCE CHECKOUT FORM FUNCTIONS */
	add_action(	'init', '_handle_wc_checkout_form_submit' );
	
	function _handle_wc_checkout_form_submit()
	{
		global $moUtility;
		if(!$moUtility->micr() || !check_wc_checkout_enabled())
		return;
	
		add_action( 'woocommerce_checkout_process', 'my_custom_checkout_field_process');
		add_action( 'woocommerce_after_checkout_billing_form','my_custom_checkout_field',99);

		if(array_key_exists('option', $_GET) && $_GET['option'])
		{
			switch (trim($_GET['option'])) 
			{
				case 'miniorange-woocommerce-checkout':
					_handle_woocommere_checkout_form($_GET);	break;
			}
		}
	}


	function check_wc_checkout_enabled()
	{
		return get_option('mo_customer_validation_wc_checkout_enable') ? true : false;
	}


	function _handle_woocommere_checkout_form($getdata)
	{
		global $moUtility;
		$moUtility->checkSession();
		$result = array();
		$_SESSION['woocommerce_checkout_page'] = 'true';
		if(get_option('mo_customer_validation_wc_checkout_type')=="mo_wc_phone_enable")
			miniorange_site_challenge_otp('test',$getdata['user_email'],null,'+'.trim($getdata['user_phone']),"phone");
		else
			miniorange_site_challenge_otp('test',$getdata['user_email'],null,$getdata['user_email'],"email");
	}


	function my_custom_checkout_field( $checkout )
	{
		if((get_option('mo_customer_validation_wc_checkout_guest') && is_user_logged_in())){ return; }
		echo '<div id="woocommerce-shipping-fields"><h3>' . __('User Verification') . '</h3>';
		if(!get_option('mo_customer_validation_wc_checkout_button'))
		{
			if(get_option('mo_customer_validation_wc_checkout_type')=="mo_wc_phone_enable"){
				echo '<div title="Please Enter a Phone Number to enable this link"><a href="#" ';
				echo 'style="text-align:center;color:grey;pointer-events:none;" ';
				echo 'id="miniorange_otp_token_submit" class="" >'.__("[ Click here to verify your Phone ]").'</a></div>';
			}else{
				echo '<div title="Please Enter an Email Address to enable this link"><a href="#" ';
				echo 'style="text-align:center;color:grey;pointer-events:none;" ';
				echo 'id="miniorange_otp_token_submit" class="" >'.__("[ Click here to verify your Email ]").'</a></div>';
			}
		}
		else
		{
			if(get_option('mo_customer_validation_wc_checkout_type')=="mo_wc_phone_enable")
				echo '<input type="button" class="button alt" style="width: 100%;" id="miniorange_otp_token_submit" disabled title="Please Enter a Phone Number to enable this." value="Click here to verify your Phone"></input>';
			else
				echo '<input type="button" class="button alt" style="width: 100%;" id="miniorange_otp_token_submit" disabled title="Please Enter an Email Address to enable this." value="Click here to verify your Email"></input>';
		}
		
		echo '<div id="mo_message" hidden></div>';

		woocommerce_form_field( 'order_verify', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('Verify Code'),
        'required'  	=> true,
        'placeholder'   => __('Enter Verification Code'),
        ), $checkout->get_value( 'order_verify' ));

        echo '<script> jQuery(document).ready(function() { $ = jQuery,';
        echo '$(".woocommerce-message").length>0&&($("#order_verify").focus(),$("#mo_message").addClass("woocommerce-message"),$("#mo_message").show());';
		if(!get_option('mo_customer_validation_wc_checkout_button'))
		{
		   	if(get_option('mo_customer_validation_wc_checkout_type')=="mo_wc_phone_enable")
		   	{
			    echo '""!=$("input[name=billing_phone]").val()&&$("#miniorange_otp_token_submit").removeAttr("style");';
			    echo '$("input[name=billing_phone]").change(function(){if($("input[name=billing_phone]").val()!=""){$("#miniorange_otp_token_submit").removeAttr("style");}else{$("#miniorange_otp_token_submit").css({"color":"grey","pointer-events":"none"}); }})';
			}
			else
			{
				echo '""!=$("input[name=billing_email]").val()&&$("#miniorange_otp_token_submit").removeAttr("style");';
				echo '$("input[name=billing_email]").change(function(){if($("input[name=billing_email]").val()!=""){$("#miniorange_otp_token_submit").removeAttr("style");}else{$("#miniorange_otp_token_submit").css({"color":"grey","pointer-events":"none"}); }})';
			}
		}
		else
		{
			if(get_option('mo_customer_validation_wc_checkout_type')=="mo_wc_phone_enable")
			{
			    echo '""!=$("input[name=billing_phone]").val()&&$("#miniorange_otp_token_submit").prop( "disabled", false );';
			    echo ' $("input[name=billing_phone]").change(function() {if ($("input[name=billing_phone]").val() != "") {$("#miniorange_otp_token_submit").prop( "disabled", false );} else { $("#miniorange_otp_token_submit").prop( "disabled", true ); }})';
			}
			else
			{
				echo '""!=$("input[name=billing_email]").val()&&$("#miniorange_otp_token_submit").prop( "disabled", false );';
				echo ' $("input[name=billing_email]").change(function() {if ($("input[name=billing_email]").val() != "") {$("#miniorange_otp_token_submit").prop( "disabled", false );} else { $("#miniorange_otp_token_submit").prop( "disabled", true ); }})';
			}
		}
		//echo ' ,$("#order_verify").focus() ';
		echo ',$(".woocommerce-error").length>0&&$("html, body").animate({scrollTop:$("div.woocommerce").offset().top-50},1e3),$("#miniorange_otp_token_submit").click(function(o){var e=$("input[name=billing_email]").val(),n=$("input[name=billing_phone]").val(),a=$("div.woocommerce");a.addClass("processing").block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),$.ajax({url:"'.site_url().'",type:"GET",data:"option=miniorange-woocommerce-checkout&user_email="+e+"&user_phone="+n,crossDomain:!0,dataType:"json",contentType:"application/json; charset=utf-8",success:function(o){ if(o.result=="success"){$(".blockUI").hide(),$("#mo_message").empty(),$("#mo_message").append(o.message),$("#mo_message").addClass("woocommerce-message"),$("#mo_message").show(),$("#order_verify").focus()}else{$(".blockUI").hide(),$("#mo_message").empty(),$("#mo_message").append(o.message),$("#mo_message").addClass("woocommerce-error"),$("#mo_message").show();} ;},error:function(o,e,n){}}),o.preventDefault()});});</script>';
		echo '</div>';
	}


	function my_custom_checkout_field_process()
	{
		global $moUtility;
		$curl = new MocURLOTP();
		$moUtility->checkSession();
		if((get_option('mo_customer_validation_wc_checkout_guest') && is_user_logged_in())){ return; }
		if(isset($_SESSION['woocommerce_checkout_page']))
		{
			if ( ! $_POST['order_verify'] )
			{
					if(get_option('mo_customer_validation_wc_checkout_type')=="mo_wc_phone_enable")
						wc_add_notice( __( 'Please enter the verification sent to your phone' ), 'error' );
					else
						wc_add_notice( __( 'Please enter the verification sent to your email address' ), 'error' );
			}
			else
			{
				$content = json_decode($curl->validate_otp_token($_SESSION['mo_customer_validation_site_txID'], $_POST['order_verify']),true);
				if(strcasecmp($content['status'], 'SUCCESS') != 0) { 
					wc_add_notice( __( 'Invalid OTP Entered' ), 'error' );
				}else{
					session_unset($_SESSION['mo_customer_validation_site_txID']);
					session_unset($_SESSION['woocommerce_checkout_page']);
				}
			}
		}
		else
		{
			wc_add_notice( __( '<strong>Verify Code</strong> is a required field' ), 'error' );
		}
	}