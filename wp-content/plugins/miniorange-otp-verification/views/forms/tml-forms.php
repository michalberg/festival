<?php

echo'	<input type="checkbox" '.$disabled.' id="tml_default" class="app_enable" data-toggle="tml_options" name="mo_customer_validation_tml_enable" value="1"
			'.$tml_enabled.' /><strong>Theme My Login Form</strong>';

echo'		<div class="mo_registration_help_desc" '.$tml_hidden.' id="tml_options">
				<b>Choose between Phone or Email Verification</b>
				<p>
					<input type="radio" '.$disabled.' id="tml_phone" class="app_enable" name="mo_customer_validation_tml_enable_type" value="mo_tml_phone_enable"
						'.($tml_enable_type == "mo_tml_phone_enable" ? "checked" : "" ).'/><strong>Enable Phone verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="tml_email" class="app_enable" name="mo_customer_validation_tml_enable_type" value="mo_tml_email_enable"
						'.($tml_enable_type == "mo_tml_email_enable"? "checked" : "" ).'/><strong>Enable Email verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="tml_both" class="app_enable" name="mo_customer_validation_tml_enable_type" value="mo_tml_both_enable"
						'.($tml_enable_type == "mo_tml_both_enable"? "checked" : "" ).'/><strong>Let the user choose</strong>';
							mo_form_additional_info(23,null,false);
echo '			</p>
			</div>';