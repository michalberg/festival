<?php
/**
* Plugin Name: Email Verification / SMS verification / Mobile Verification
* Plugin URI: http://miniorange.com
* Description: Email verification for all forms Woocommerce, Contact 7 etc. SMS and Mobile Verification for all forms. Enterprise grade. Active Support. 
* Version: 2.8.5
* Author: miniOrange
* Author URI: http://miniorange.com
* License: GPL2
*/

require('views/common-elements.php');
require('helper/utility.php');
require('helper/constants.php');
require('helper/curl.php');
require('helper/messages.php');
require('handler/registration.php');
include_once 'handler/miniorange_register_form.php';
require 'includes/lib/encryption.php';


class Miniorange_Customer_Validation {

	function __construct() {
		add_action(	'init', array($this, 'miniorange_customer_validation_handle_form' ));
		add_action( 'admin_menu', array( $this, 'miniorange_customer_validation_menu' ) );
		add_action( 'admin_init',  array( $this, 'miniorange_registration_save_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'mo_registration_plugin_settings_style' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'mo_registration_plugin_settings_script' ) );
		add_action( 'enqueue_scripts', array( $this, 'mo_registration_plugin_settings_style' ) );
		add_action( 'enqueue_scripts', array( $this, 'mo_registration_plugin_settings_script' ) );
		add_action( 'mo_registration_show_success_message', array( $this, 'mo_registration_success_message'));
		add_action( 'mo_registration_show_error_message', array( $this, 'mo_registration_error_message'));
		register_deactivation_hook(__FILE__, array( $this, 'mo_registration_deactivate'));
	}
	

	function miniorange_customer_validation_menu() 
	{
		$menu_slug = 'settings';
		add_menu_page (	'OTP Verification' , 'OTP Verification' , 'activate_plugins', $menu_slug , array( $this, 'mo_customer_validation_options'), plugin_dir_url(__FILE__) . 'includes/images/miniorange_icon.png' );
		
		add_submenu_page( $menu_slug	,'OTP Verification'	,'Settings'				,'administrator',$menu_slug	, array( $this, 'mo_customer_validation_options'));
		add_submenu_page( $menu_slug	,'OTP Verification'	,'Account'				,'administrator','account'	, array( $this, 'mo_customer_validation_options'));
		add_submenu_page( $menu_slug	,'OTP Verification'	,'SMS/EMail Templates'	,'administrator','config'	, array( $this, 'mo_customer_validation_options'));
		add_submenu_page( $menu_slug	,'OTP Verification'	,'Messages'				,'administrator','messages'	, array( $this, 'mo_customer_validation_options'));
		add_submenu_page( $menu_slug	,'OTP Verification'	,'Licensing Plans'		,'administrator','pricing'	, array( $this, 'mo_customer_validation_options'));
		add_submenu_page( $menu_slug	,'OTP Verification'	,'Troubleshooting'		,'administrator','help'		, array( $this, 'mo_customer_validation_options'));
	}

	function  mo_customer_validation_options()
	{
		include 'controllers/main-controller.php';
	}

	function mo_registration_plugin_settings_style()
	{
		wp_enqueue_style( 'mo_customer_validation_admin_settings_style', plugins_url('includes/css/mo_customer_validation_style.css?version=1.1.1', __FILE__));
		wp_enqueue_style( 'mo_customer_validation_admin_settings_phone_style', plugins_url('includes/css/phone.css', __FILE__));				
	}

	function mo_registration_plugin_settings_script()
	{
		wp_enqueue_script( 'mo_customer_validation_admin_settings_phone_script', plugins_url('includes/js/phone.js', __FILE__ ));
		wp_enqueue_script( 'mo_customer_validation_admin_settings_phone_script', plugins_url('includes/js/bootstrap.min.js', __FILE__ ));
		wp_enqueue_script( 'mo_customer_validation_admin_settings_script', plugins_url('includes/js/settings.js?version=1.1.1', __FILE__ ), array('jquery'));
	}

	function mo_registration_deactivate()
	{
		delete_option('mo_customer_validation_transactionId');
		delete_option('mo_customer_validation_admin_password');
		delete_option('mo_customer_validation_registration_status');
		delete_option('mo_customer_validation_admin_phone');
		delete_option('mo_customer_validation_new_registration');
		delete_option('mo_customer_validation_admin_customer_key');
		delete_option('mo_customer_validation_admin_api_key');
		delete_option('mo_customer_validation_customer_token');
		delete_option('mo_customer_validation_verify_customer');
		delete_option('mo_customer_validation_message');
		delete_option('mo_customer_check_ln');
	}

	function miniorange_registration_save_settings()
	{
		global $moUtility;
		if ( current_user_can( 'manage_options' ) && isset($_POST['option']))
		{
			$option = trim($_POST['option']);
			switch($option)
			{
				case "mo_customer_validation_settings":
					$this->_save_settings($_POST);					break;
				case "mo_validation_contact_us_query_option":
					$this->_mo_validation_support_query($_POST);	break;
			}
 		}
		
	}
	
	function miniorange_customer_validation_handle_form()
	{
		global $moUtility;
		
		if(get_option('mo_otp_plugin_version')>1.4){
			$email = get_option('mo_customer_email_transactions_remaining');
			$phone = get_option('mo_customer_email_transactions_remaining');
			//$t = "'quick_recharge'";
			update_option('mo_customer_validation_transaction_message','You have '.$email.' Email Transactions and '.$phone.' Phone Transactions remaining.');
			//For quick recharge <a href="#" onclick="document.getElementById('.$t.').submit()">click here</a>
		}
		
		if(array_key_exists('option', $_REQUEST) && $_REQUEST['option'] && $moUtility->micr())
		{
			switch (trim($_REQUEST['option'])) 
			{
				case "validation_goBack":
					_handle_validation_goBack_action();								break;
				case "miniorange-ajax-otp-generate":
					_handle_mo_ajax_phone_validate($_GET);							break;
				case "miniorange-ajax-otp-validate":
					_handle_mo_ajax_form_validate_action($_GET);					break;
				case "mo_ajax_form_validate":
					_handle_mo_create_user_wc_action($_POST);						break;
				case "miniorange-validate-otp-form":
					$from_both = $_POST['from_both']=='true' ? true : false;
					_handle_validation_form_action($_POST['otp_type'],$from_both);	break;
				case "verification_resend_otp_phone":
					$from_both = $_POST['from_both']=='true' ? true : false;
					_handle_verification_resend_otp_action("phone",$from_both); 	break;
				case "verification_resend_otp_email":
					$from_both = $_POST['from_both']=='true' ? true : false;
					_handle_verification_resend_otp_action("email",$from_both);		break;
				case "verification_resend_otp_both":
					$from_both = $_POST['from_both']=='true' ? true : false;
					_handle_verification_resend_otp_action("both",$from_both);		break;
				case "miniorange-validate-otp-choice-form":
					_handle_validate_otp_choice_form($_POST);						break;
				case "check_mo_ln":
					$moUtility->_handle_mo_check_ln(true,
							get_option('mo_customer_validation_admin_customer_key'),
							get_option('mo_customer_validation_admin_api_key')
					);																break;
				default :
					break;
			}
		}
	}
	
	function _save_settings($posted)
	{
		global $moUtility;
		if($moUtility->micr()){
			
				update_option('mo_customer_validation_wp_default_enable',isset( $posted['mo_customer_validation_wp_default_enable']) ? $posted['mo_customer_validation_wp_default_enable'] : 0);
				update_option('mo_customer_validation_wp_default_enable_type',isset( $posted['mo_customer_validation_wp_default_enable_type']) ? $posted['mo_customer_validation_wp_default_enable_type'] : 0);
				update_option('mo_customer_validation_wc_default_enable',isset( $posted['mo_customer_validation_wc_default_enable']) ? $posted['mo_customer_validation_wc_default_enable'] : 0);
				update_option('mo_customer_validation_wc_enable_type',isset( $posted['mo_customer_validation_wc_enable_type']) ? $posted['mo_customer_validation_wc_enable_type'] : '');
				update_option('mo_customer_validation_wc_social_login_enable',isset( $posted['mo_customer_validation_wc_social_login_enable']) ? $posted['mo_customer_validation_wc_social_login_enable'] : '');
				update_option('mo_customer_validation_pb_default_enable',isset( $posted['mo_customer_validation_pb_default_enable']) ? $posted['mo_customer_validation_pb_default_enable'] : 0);
				update_option('mo_customer_validation_um_default_enable',isset( $posted['mo_customer_validation_um_default_enable']) ? $posted['mo_customer_validation_um_default_enable'] : 0);
				update_option('mo_customer_validation_simplr_default_enable',isset( $posted['mo_customer_validation_simplr_default_enable']) ? $posted['mo_customer_validation_simplr_default_enable'] : 0);
				update_option('mo_customer_validation_simplr_enable_type',isset( $posted['mo_customer_validation_simplr_enable_type']) ? $posted['mo_customer_validation_simplr_enable_type'] : '');
				update_option('mo_customer_validation_simplr_field_key',isset( $posted['simplr_phone_field_key']) ? $posted['simplr_phone_field_key'] : '');
				update_option('mo_customer_validation_um_enable_type',isset( $posted['mo_customer_validation_um_enable_type']) ? $posted['mo_customer_validation_um_enable_type'] : '');
				update_option('mo_customer_validation_event_default_enable',isset( $posted['mo_customer_validation_event_default_enable']) ? $posted['mo_customer_validation_event_default_enable'] : '');
				update_option('mo_customer_validation_event_enable_type',isset( $posted['mo_customer_validation_event_enable_type']) ? $posted['mo_customer_validation_event_enable_type'] : '');
				update_option('mo_customer_validation_bbp_default_enable',isset( $posted['mo_customer_validation_bbp_default_enable']) ? $posted['mo_customer_validation_bbp_default_enable'] : 0);
				update_option('mo_customer_validation_bbp_disable_activation',isset( $posted['mo_customer_validation_bbp_disable_activation']) ? $posted['mo_customer_validation_bbp_disable_activation'] : '');
				update_option('mo_customer_validation_crf_default_enable',isset( $posted['mo_customer_validation_crf_default_enable']) ? $posted['mo_customer_validation_crf_default_enable'] : 0);
				update_option('mo_customer_validation_crf_enable_type',isset( $posted['mo_customer_validation_crf_enable_type']) ? $posted['mo_customer_validation_crf_enable_type'] : 0);
				update_option('mo_customer_validation_crf_phone_key',isset( $posted['crf_phone_field_key']) ? $posted['crf_phone_field_key'] : '');
				update_option('mo_customer_validation_crf_email_key',isset( $posted['crf_email_field_key']) ? $posted['crf_email_field_key'] : '');
				update_option('mo_customer_validation_uultra_default_enable',isset( $posted['mo_customer_validation_uultra_default_enable']) ? $posted['mo_customer_validation_uultra_default_enable'] : 0);
				update_option('mo_customer_validation_uultra_enable_type',isset( $posted['mo_customer_validation_uultra_enable_type']) ? $posted['mo_customer_validation_uultra_enable_type'] : '');
				update_option('mo_customer_validation_uultra_phone_key',isset( $posted['uultra_phone_field_key']) ? $posted['uultra_phone_field_key'] : '');
				
				update_option('mo_customer_validation_bbp_enable_type',isset( $posted['mo_customer_validation_bbp_enable_type']) ? $posted['mo_customer_validation_bbp_enable_type'] : '');
				update_option('mo_customer_validation_bbp_phone_key',isset( $posted['bbp_phone_field_key']) ? $posted['bbp_phone_field_key'] : '');
				update_option('mo_customer_validation_wc_checkout_enable',isset( $posted['mo_customer_validation_wc_checkout_enable']) ? $posted['mo_customer_validation_wc_checkout_enable'] : 0);
				update_option('mo_customer_validation_wc_checkout_type',isset( $posted['mo_customer_validation_wc_checkout_type']) ? $posted['mo_customer_validation_wc_checkout_type'] : '');
				update_option('mo_customer_validation_wc_checkout_guest',isset( $posted['mo_customer_validation_wc_checkout_guest']) ? $posted['mo_customer_validation_wc_checkout_guest'] : '');
				update_option('mo_customer_validation_wc_checkout_button',isset( $posted['mo_customer_validation_wc_checkout_button']) ? $posted['mo_customer_validation_wc_checkout_button'] : '');
				update_option('mo_customer_validation_upme_default_enable',isset( $posted['mo_customer_validation_upme_default_enable']) ? $posted['mo_customer_validation_upme_default_enable'] : 0);
				update_option('mo_customer_validation_upme_enable_type',isset( $posted['mo_customer_validation_upme_enable_type']) ? $posted['mo_customer_validation_upme_enable_type'] : '');
				update_option('mo_customer_validation_upme_phone_key',isset( $posted['upme_phone_field_key']) ? $posted['upme_phone_field_key'] : '');
				update_option('mo_customer_validation_pie_default_enable',isset( $posted['mo_customer_validation_pie_default_enable']) ? $posted['mo_customer_validation_pie_default_enable'] : 0);
				update_option('mo_customer_validation_pie_enable_type',isset( $posted['mo_customer_validation_pie_enable_type']) ? $posted['mo_customer_validation_pie_enable_type'] : '');
				update_option('mo_customer_validation_pie_phone_key',isset( $posted['pie_phone_field_key']) ? $posted['pie_phone_field_key'] : '');
				update_option('mo_customer_validation_wc_redirect',isset($posted['page_id']) ? get_the_title($posted['page_id']) : 'My Account');
				update_option('mo_customer_validation_cf7_contact_enable',isset( $posted['mo_customer_validation_cf7_contact_enable']) ? $posted['mo_customer_validation_cf7_contact_enable'] : 0);
				update_option('mo_customer_validation_cf7_contact_type',isset( $posted['mo_customer_validation_cf7_contact_type']) ? $posted['mo_customer_validation_cf7_contact_type'] : '');
				update_option('mo_customer_validation_cf7_email_key',isset( $posted['cf7_email_field_key']) ? $posted['cf7_email_field_key'] : '');
				
				if(array_key_exists('ninja_form',$posted))
				{
					$form  = array();
					if(isset( $posted['mo_customer_validation_ninja_form_enable']) && $posted['mo_customer_validation_ninja_form_enable']==1)
						if(!$moUtility->mo_check_empty_or_null(array_filter($posted['ninja_form']['form']))){
							if($posted['mo_customer_validation_ninja_form_enable_type']=='mo_ninja_form_email_enable' && $moUtility->mo_check_empty_or_null(array_filter($posted['ninja_form']['emailkey'])))
								$posted['error_message'] = 'Please fill in the form id and email field id of your Ninja Form';
							else if($posted['mo_customer_validation_ninja_form_enable_type']=='mo_ninja_form_phone_enable' && $moUtility->mo_check_empty_or_null(array_filter($posted['ninja_form']['phonekey'])))
								$posted['error_message'] = 'Please fill in the form id and phone field id of your Ninja Form';
							else if($moUtility->mo_check_empty_or_null(array_filter($posted['ninja_form']['emailkey'])) && $moUtility->mo_check_empty_or_null(array_filter($posted['ninja_form']['phonekey'])))
								$posted['error_message'] = 'Please fill in the form id and field id of your Ninja Form';
						}else
							$posted['error_message'] = 'Please fill in the form id of your Ninja Form';
					if(!$posted['error_message'])
					{
						foreach (array_filter($posted['ninja_form']['form']) as $key => $value)
							$form[$value]=array('emailkey'=>$posted['ninja_form']['emailkey'][$key],'phonekey'=>$posted['ninja_form']['phonekey'][$key]);
						update_option('mo_customer_validation_ninja_form_otp_enabled',maybe_serialize($form));
						update_option('mo_customer_validation_ninja_form_enable',isset( $posted['mo_customer_validation_ninja_form_enable']) ? $posted['mo_customer_validation_ninja_form_enable'] : 0);
						update_option('mo_customer_validation_ninja_form_enable_type',isset( $posted['mo_customer_validation_ninja_form_enable_type']) ? $posted['mo_customer_validation_ninja_form_enable_type'] : '');
					}
				}

				update_option('mo_customer_validation_tml_enable',isset( $posted['mo_customer_validation_tml_enable']) ? $posted['mo_customer_validation_tml_enable'] : 0);
				update_option('mo_customer_validation_tml_enable_type',isset( $posted['mo_customer_validation_tml_enable_type']) ? $posted['mo_customer_validation_tml_enable_type'] : 0);

				if(!$posted['error_message']){
					update_option( 'mo_customer_validation_message', 'Settings saved successfully. You can go to your registration form page to test the plugin. <a href="'.wp_logout_url().'">Click here</a> to logout.' );
					$this->mo_registration_show_success_message();
				}else{
					update_option( 'mo_customer_validation_message', $posted['error_message']);
					$this->mo_registration_show_error_message();
				}
			
		}else{
			update_option('mo_customer_validation_message','Please register an account before trying to enable OTP verification for any form.');
			$this->mo_registration_show_error_message();
		}
	}

	function mo_registration_success_message() {
		$message = get_option('mo_customer_validation_message'); 
		echo '	<div class="notice notice-success is-dismissible"> <p>'.$message.'</p> </div>';
	}

	function mo_registration_error_message() {
		$message = get_option('mo_customer_validation_message');
		echo '	<div class="notice notice-error is-dismissible"> <p>'.$message.'</p> </div>';
	}

	function mo_registration_show_success_message()
	{
		remove_action( 'admin_notices', array( $this, 'mo_registration_error_message') );
		add_action( 'admin_notices', array( $this, 'mo_registration_success_message') );
	}

	function mo_registration_show_error_message()
	{
		remove_action( 'admin_notices', array( $this, 'mo_registration_success_message') );
		add_action( 'admin_notices', array( $this, 'mo_registration_error_message') );
	}

	private function _mo_validation_support_query($POSTED)
	{
		// Contact Us query
		global $moUtility;
		$email = sanitize_text_field($POSTED['query_email']);
		$phone = sanitize_text_field($POSTED['query_phone']);
		$query = sanitize_text_field($POSTED['query']);
		$customer = new MocURLOTP();
		if ( $moUtility->mo_check_empty_or_null( $email ) || $moUtility->mo_check_empty_or_null( $query ) ) {
			update_option('mo_customer_validation_message', 'Please fill up Email and Query fields to submit your query.');
			$this->mo_idp_show_error_message();
		} else {
			$submited = $customer->submit_contact_us( $email, $phone, $query );
			if ( $submited == false ) {
				update_option('mo_customer_validation_message', 'Your query could not be submitted. Please try again.');
				$this->mo_registration_show_error_message();
			} else {
				update_option('mo_customer_validation_message', 'Thanks for getting in touch! We shall get back to you shortly.');
				$this->mo_registration_show_success_message();
			}
		}
	}
}

new Miniorange_Customer_Validation;
?>