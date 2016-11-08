<?php

echo'	<input type="checkbox" '.$disabled.' id="wp_default" class="app_enable" data-toggle="wp_default_options" name="mo_customer_validation_wp_default_enable" value="1"
			'.$default_registration.' /><strong>WordPress Default Registration Form</strong>';

echo'		<div class="mo_registration_help_desc" '.$wp_default_hidden.' id="wp_default_options">
				<b>Choose between Phone or Email Verification</b>
				<p>
					<input type="radio" '.$disabled.' id="wp_default_phone" class="app_enable" name="mo_customer_validation_wp_default_enable_type" value="mo_wp_default_phone_enable"
						'.($wp_default_type == "mo_wp_default_phone_enable" ? "checked" : "" ).'/><strong>Enable Phone verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="wp_default_email" class="app_enable" name="mo_customer_validation_wp_default_enable_type" value="mo_wp_default_email_enable"
						'.($wp_default_type == "mo_wp_default_email_enable"? "checked" : "" ).'/><strong>Enable Email verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="wp_default_both" class="app_enable" name="mo_customer_validation_wp_default_enable_type" value="mo_wp_default_both_enable"
						'.($wp_default_type == "mo_wp_default_both_enable"? "checked" : "" ).'/><strong>Let the user choose</strong>';
							mo_form_additional_info(22,null,false);
echo '			</p>
			</div>';