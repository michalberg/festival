<?php
	
	function is_customer_registered()
	{
		global $moUtility;
		$registration_url = add_query_arg( array('page' => 'account'), $_SERVER['REQUEST_URI'] );
		if(!$moUtility->micr()) 
		{ 
			echo '<div style="display:block;margin-top:10px;color:red;background-color:rgba(251, 232, 0, 0.15);padding:5px;border:solid 1px rgba(255, 0, 9, 0.36);">
			Please <a href="'.$registration_url.'">Register or Login with miniOrange</a> to enable OTP Verification.
			</div>';
		 }
	}
	
	
	function get_plugin_form_link($formalink)
	{
		global $dirOTPName;
		echo '<img class="form_preview" title="Click here to see Form" style="margin-bottom:-4px" data-formlink="'.$formalink.'" src="'.plugins_url( 'miniorange-otp-verification/includes/images/i.png', $dirOTPName ).'" />';
	}
	
	
	function mo_form_additional_info($desc_no1,$desc_no2,$additional_field)
	{
		if(!is_null($desc_no1))
			echo '<a  class="form_query" data-desc="'.$desc_no1.'"><b>[ What does this mean? ]</b></a>';
		if($additional_field)
			echo '<a class="form_query" data-desc="'.$desc_no2.'"> <b>[ You will need to add a Phone Number field manually ]</b></a>';
		echo '<div id="form_query_desc_'.$desc_no1.'" hidden class="mo_registration_help_desc" >New users can validate their Email or Phone Number using either Email or Phone Verification. They will be prompted during registration to choose one of the two verification methods.</div>';
	}


	function extra_post_data($data=null)
	{
		if(isset($_SESSION['event_registration'])){
			if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form' )
				show_hidden_fields($key,$value);
		    $i = 0;
		    while($i<count($_POST['attendee'])){
		    	echo ' <input type="hidden" name="attendee['.$i.'][first_name]" value="'.$_POST["attendee"][$i]["first_name"].'">';
		    	echo ' <input type="hidden" name="attendee['.$i.'][last_name]" value="'.$_POST["attendee"][$i]["last_name"].'">';
		    	$i++;
			}
		}elseif (isset($_SESSION['crf_user_registration'])) {
			foreach ($_REQUEST as $key => $value)
				if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form' )
					show_hidden_fields($key,$value);
		}elseif(isset($_SESSION['woocommerce_registration'])){
			foreach ($_POST as $key => $value)
				if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form')
					show_hidden_fields($key,$value);
				if(isset($_REQUEST['g-recaptcha-response']))
					 echo '<input type="hidden" name="g-recaptcha-response" value="'.$_POST['g-recaptcha-response'].'" />';
		}elseif(isset($_SESSION['uultra_user_registration'])){
			foreach ($_POST as $key => $value) {
				if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['upme_user_registration'])){
			foreach ($_POST as $key => $value) {
				if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['pie_user_registration'])){
			foreach ($_POST as $key => $value) {
				if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['profileBuilder_registration'])){
			foreach ($_POST as $key => $value) {
				if($key!='option' && $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['default_wp_registration'])){
			foreach ($_POST as $key => $value) {
				if($key!='user_login'&&$key!="user_email"&&$key!='register_nonce'&&$key!='option')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['wc_social_login'])){
			foreach ($data as $key => $value) {
				if($key!='register_nonce'&&$key!='option')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['ultimate_members_registration'])) {
			foreach($_POST as $key => $value) {
				if($key!='register_nonce'&&$key!='option'&&$key!='form_id'&&$key!='timestamp')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['ninja_form_submit'])) {
			foreach($_POST as $key => $value) {
				if($key!='option'&& $key!='mo_customer_validation_otp_token' && $key!='miniorange_otp_token_submit' && $key!='miniorange-validate-otp-choice-form')
					show_hidden_fields($key,$value);
			}
		}elseif(isset($_SESSION['tml_registration'])){
			foreach ($_POST as $key => $value) {
				if($key!='user_login'&&$key!="user_email"&&$key!='register_tml_nonce'&&$key!='option')
					show_hidden_fields($key,$value);
			}
		}
	}

	function show_hidden_fields($key,$value)
	{
		if(is_array($value))
			foreach ($value as $t => $val)
				echo '<input type="hidden" name="'.$key.'[]" value="'.$val.'" />';
		else	
			echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
	}


	function miniorange_site_otp_validation_form($user_login,$user_email,$phone_number,$message,$otp_type,$from_both)
	{
		global $moUtility,$dirOTPName;
		header('Content-Type: text/html; charset=utf-8');
		echo '<html>
				<head>
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<link rel="stylesheet" type="text/css" href="' . plugins_url('miniorange-otp-verification/includes/css/mo_customer_validation_style.css', $dirOTPName) . '" />
				</head>
				<body>
					<div class="mo-modal-backdrop">
						<div class="mo_customer_validation-modal" tabindex="-1" role="dialog" id="mo_site_otp_form">
							<div class="mo_customer_validation-modal-backdrop"></div>
							<div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
								<div class="login mo_customer_validation-modal-content">
									<div class="mo_customer_validation-modal-header">
										<b>Validate OTP (One Time Passcode)</b>
										<a class="close" href="#" onclick="mo_validation_goback();" >'.__( '&larr; Go Back' ).'</a>
									</div>
									<div class="mo_customer_validation-modal-body center">
										<div>'.$message.'</div><br /> ';
										if(!$moUtility->mo_check_empty_or_null($user_email) || !$moUtility->mo_check_empty_or_null($phone_number))
										{
		echo'								<div class="mo_customer_validation-login-container">
												<form name="f" method="post" action="">
													<input type="hidden" name="option" value="miniorange-validate-otp-form" />
													<input type="number" name="mo_customer_validation_otp_token"  autofocus="true" placeholder="" id="mo_customer_validation_otp_token" required="true" class="mo_customer_validation-textbox" autofocus="true" pattern="[0-9]{4,8}" title="Only digits within range 4-8 are allowed."/>
													<br /><input type="submit" name="miniorange_otp_token_submit" id="miniorange_otp_token_submit" class="miniorange_otp_token_submit"  value="Validate OTP" />
													<input type="hidden" name="otp_type" value="'.$otp_type.'">';
													if(!$from_both){
		echo'											<input type="hidden" id="from_both" name="from_both" value="false">
														<a style="float:right"  onclick="mo_otp_verification_resend();"> Resend OTP</a>';
													}else{
		echo'											<input type="hidden" id="from_both" name="from_both" value="true">
														<a style="float:right"  onclick="mo_select_goback();"> Resend OTP</a>';
													}
													extra_post_data();
		echo'									</form>
												<a href="http://miniorange.com/2-factor-authentication" hidden></a>
											</div>';
										}
		echo'						</div>
								</div>
							</div>
						</div>
					</div>
					<form name="f" method="post" action="" id="validation_goBack_form">
						<input id="validation_goBack" name="option" value="validation_goBack" type="hidden"></input>
					</form>
					
					<form name="f" method="post" action="" id="verification_resend_otp_form">
						<input id="verification_resend_otp" name="option" value="verification_resend_otp_'.$otp_type.'" type="hidden"></input>';
						if(!$from_both)
		echo'				<input type="hidden" id="from_both" name="from_both" value="false">';
						else
		echo'				<input type="hidden" id="from_both" name="from_both" value="true">';
						
						extra_post_data();
					
		echo'		</form>

					<form name="f" method="post" action="" id="goBack_choice_otp_form">
						<input id="verification_resend_otp" name="option" value="verification_resend_otp_both" type="hidden"></input>
						<input type="hidden" id="from_both" name="from_both" value="true">';
						
						extra_post_data();
					
		echo'		</form>

					<style> .mo_customer_validation-modal{ display: block !important; } </style>
					<script>
						function mo_validation_goback(){
							document.getElementById("validation_goBack_form").submit();
						}
						
						function mo_otp_verification_resend(){
							document.getElementById("verification_resend_otp_form").submit();
						}

						function mo_select_goback(){
							document.getElementById("goBack_choice_otp_form").submit();
						}
					</script>
				</body>
		    </html>';
	}
	

	function miniorange_verification_user_choice($user_login, $user_email,$phone_number,$message,$otp_type)
	{
		global $moUtility,$dirOTPName;

		echo'	<html>
					<head>
						<meta http-equiv="X-UA-Compatible" content="IE=edge">
						<meta name="viewport" content="width=device-width, initial-scale=1">
						<link rel="stylesheet" type="text/css" href="' . plugins_url('miniorange-otp-verification/includes/css/mo_customer_validation_style.css', $dirOTPName) . '" />
					</head>
					<body>
						<div class="mo-modal-backdrop">
							<div class="mo_customer_validation-modal" tabindex="-1" role="dialog" id="mo_site_otp_choice_form">
								<div class="mo_customer_validation-modal-backdrop"></div>
								<div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
									<div class="login mo_customer_validation-modal-content">
										<div class="mo_customer_validation-modal-header">
											<b>Select Verification Type</b>
											<a class="close" href="#" onclick="mo_validation_goback();" >'. __( '&larr; Go Back' ).'</a>
										</div>
										<div class="mo_customer_validation-modal-body center">
											<div>'.$message.'</div><br /> ';
											if(!$moUtility->mo_check_empty_or_null($user_email) || !$moUtility->mo_check_empty_or_null($phone_number))
											{
		echo'									<div class="mo_customer_validation-login-container">
													<form name="f" method="post" action="">
														<input id="miniorange-validate-otp-choice-form" type="hidden" name="option" value="miniorange-validate-otp-choice-form" />
														<input type="radio" checked name="mo_customer_validation_otp_choice" value="user_email_verification" />Email Verification<br>
														<input type="radio" name="mo_customer_validation_otp_choice" value="user_phone_verification" />Phone Verification<br>
														<br /><input type="submit" name="miniorange_otp_token_user_choice" id="miniorange_otp_token_user_choice" class="miniorange_otp_token_submit"  value="Send OTP" />';
														extra_post_data();
		echo'										</form>
													<a href="http://miniorange.com/cloud-identity-broker-service" style="display:none;"></a>
													<a href="http://miniorange.com/strong_auth" style="display:none;"></a>
													<a href="http://miniorange.com/single-sign-on-sso" style="display:none;"></a>
													<a href="http://miniorange.com/fraud" style="display:none;"></a>
												</div>';
											}
		echo'							</div>
									</div>
								</div>
							</div>
						</div>
						<form name="f" method="post" action="" id="validation_goBack_form">
							<input id="validation_goBack" name="option" value="validation_goBack" type="hidden"></input>
						</form>
						<style> .mo_customer_validation-modal{ display: block !important; } </style>
						<script>	
							function mo_validation_goback(){
								document.getElementById("validation_goBack_form").submit();
							}
						</script>
					</body>
			    </html>';
	}    



	function mo_wc_show_phone_field($goBackURL,$user_email,$message,$form,$usermeta)
	{
		global $moUtility,$dirOTPName;
		$img = "<div style='display:table;text-align:center;'><img src='".plugin_dir_url($dirOTPName) . "miniorange-otp-verification/includes/images/loader.gif'></div>";
		
		echo'	<html>
					<head>
						<meta http-equiv="X-UA-Compatible" content="IE=edge">
						<meta name="viewport" content="width=device-width, initial-scale=1">
						<link rel="stylesheet" type="text/css" href="' . plugins_url('miniorange-otp-verification/includes/css/mo_customer_validation_style.css', $dirOTPName) . '" />
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
					</head>
					<body>
						<div class="mo-modal-backdrop">
							<div class="mo_customer_validation-modal" tabindex="-1" role="dialog" id="mo_site_otp_choice_form">
								<div class="mo_customer_validation-modal-backdrop"></div>
								<div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
									<div class="login mo_customer_validation-modal-content">
										<div class="mo_customer_validation-modal-header">
											<b>Validate your Phone Number</b>
											<a class="close" href="#" onclick="window.location =\''.$goBackURL.'\'" >'.__( '&larr; Go Back' ).'</a>
										</div>
										<div class="mo_customer_validation-modal-body center">
											<div id="message">'.$message.'</div><br /> ';
											if(!$moUtility->mo_check_empty_or_null($user_email))
											{
		echo'									<div class="mo_customer_validation-login-container">
													<form name="f" id="validate_otp_form" method="post" action="">
														<input id="validate_phone" type="hidden" name="option" value="mo_ajax_form_validate" />
														<input type="hidden" name="form" value="'.$form.'" />
														<input type="text" name="mo_phone_number"  autofocus="true" placeholder="" id="mo_phone_number" required="true" class="mo_customer_validation-textbox" autofocus="true" pattern="^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$" title="Enter a number in the following format : +1XXXXXXXXX "/>
														<div id="mo_message" hidden="" style="background-color: #f7f6f7;padding: 1em 2em 1em 1.5em;color:black;"></div><br/>
														<div id="mo_validate_otp" hidden>
															Verify Code : <input type="number" name="mo_customer_validation_otp_token"  autofocus="true" placeholder="" id="mo_customer_validation_otp_token" required="true" class="mo_customer_validation-textbox" autofocus="true" pattern="[0-9]{4,8}" title="Only digits within range 4-8 are allowed."/>
														</div>
														<input type="button" hidden id="validate_otp" name="otp_token_submit" class="miniorange_otp_token_submit"  value="Validate" />
														<input type="button" id="send_otp" class="miniorange_otp_token_submit"  value="Send OTP" />';
														extra_post_data($usermeta);
		echo'										</form>
													<a href="http://miniorange.com/cloud-identity-broker-service" style="display:none;"></a>
													<a href="http://miniorange.com/strong_auth" style="display:none;"></a>
													<a href="http://miniorange.com/single-sign-on-sso" style="display:none;"></a>
													<a href="http://miniorange.com/fraud" style="display:none;"></a>
												</div>';
											}
		echo'							</div>
									</div>
								</div>
							</div>
						</div>
						<style> .mo_customer_validation-modal{ display: block !important; } </style>
						<script>
							jQuery(document).ready(function() {
							    $ = jQuery;
							    $("#send_otp").click(function(o) {
							        var e = $("input[name=mo_phone_number]").val();
							        $("#mo_message").empty(), $("#mo_message").append("'.$img.'"), $("#mo_message").show(), $.ajax({
							            url: "'.site_url().'",
							            type: "GET",
							            data: "option=miniorange-ajax-otp-generate&user_phone=" + e,
							            crossDomain: !0,
							            dataType: "json",
							            contentType: "application/json; charset=utf-8",
							            success: function(o) {
							                if (o.result == "success") {
							                    $("#mo_message").empty(), $("#mo_message").append(o.message), $("#mo_message").css("border-top", "3px solid green"), $("#validate_otp").show(), $("#send_otp").val("Resend OTP"), $("#mo_validate_otp").show(), $("input[name=mo_validate_otp]").focus()
							                } else {
							                    $("#mo_message").empty(), $("#mo_message").append(o.message), $("#mo_message").css("border-top", "3px solid red"), $("input[name=mo_phone_number]").focus()
							                };
							            },
							            error: function(o, e, n) {}
							        })
							    });
								$("#validate_otp").click(function(o) {
							        var e = $("input[name=mo_customer_validation_otp_token]").val();
							        $("#mo_message").empty(), $("#mo_message").append("'.$img.'"), $("#mo_message").show(), $.ajax({
							            url: "'.site_url().'",
							            type: "GET",
							            data: "option=miniorange-ajax-otp-validate&mo_customer_validation_otp_token=" + e,
							            crossDomain: !0,
							            dataType: "json",
							            contentType: "application/json; charset=utf-8",
							            success: function(o) {
							                if (o.result == "success") {
							                    $("#mo_message").empty(), $("#validate_otp_form").submit()
							                } else {
							                    $("#mo_message").empty(), $("#mo_message").append(o.message), $("#mo_message").css("border-top", "3px solid red"), $("input[name=validate_otp]").focus()
							                };
							            },
							            error: function(o, e, n) {}
							        })
							    });
							});
						</script>
					</body>
			    </html>';
	}


	function get_nf_form_list($ninja_form_otp_enabled,$disabled,$key)
	{
		$keyunter = 0;
		if(isset($ninja_form_otp_enabled) && !empty($ninja_form_otp_enabled))
		{
			foreach ($ninja_form_otp_enabled as $form_id=>$ninja_form) 
			{
				echo '<div id="row'.$key.'_'.$keyunter.'">
						Form ID: <input class="field_data" id="ninja_form'.$keyunter.'" name="ninja_form[form][]" type="text" value="'.$form_id.'">&nbsp;
						<span '.($key==2 ? 'hidden' : '' ).'>Email Field ID: <input class="field_data" id="ninja_form_email_'.$key.'_'.$keyunter.'" name="ninja_form[emailkey][]" type="text" value="'.$ninja_form['emailkey'].'"></span>
						<span '.($key==1 ? 'hidden' : '' ).'>Phone Field ID: <input class="field_data" id="ninja_form_phone_'.$key.'_'.$keyunter.'" name="ninja_form[phonekey][]" type="text" value="'.$ninja_form['phonekey'].'"></span>';
				echo '</div>';
				$keyunter+=1;
			}
		}
		else
		{
			echo '<div id="row'.$key.'_0"> 
						Form ID: <input id="ninja_form_'.$key.'_0" class="field_data"  name="ninja_form[form][]" type="text" value="">&nbsp;
						<span '.($key==2 ? "hidden" : "" ).'>Email Field ID: <input id="ninja_form_email_'.$key.'_0" class="field_data" name="ninja_form[emailkey][]" type="text" value=""></span>
						<span '.($key==1 ? "hidden" : "" ).'>Phone Field ID: <input id="ninja_form_phone_'.$key.'_0" class="field_data"  name="ninja_form[phonekey][]" type="text" value=""></span>';
			echo '</div>';
		}
		$result['counter']	 = $keyunter;
		return $result;
	}