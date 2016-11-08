<?php

echo'	<input type="checkbox" '.$disabled.' id="wc_default" data-toggle="wc_default_options" class="app_enable" name="mo_customer_validation_wc_default_enable" value="1"
		'.$woocommerce_registration.' /><strong>Woocommerce Registration Form</strong>';
					
			get_plugin_form_link(MoConstants::WC_FORM_LINK);

echo'		<div class="mo_registration_help_desc" '.$wc_hidden.' id="wc_default_options">
				<b>Choose between Phone or Email Verification</b>
				<p>
					<input type="radio" '.$disabled.' id="wc_phone" class="app_enable" name="mo_customer_validation_wc_enable_type" value="mo_wc_phone_enable"
						'.($wc_enable_type == "mo_wc_phone_enable" ? "checked" : "" ).'/><strong>Enable Phone verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="wc_email" class="app_enable" name="mo_customer_validation_wc_enable_type" value="mo_wc_email_enable"
						'.($wc_enable_type == "mo_wc_email_enable"? "checked" : "" ).'/><strong>Enable Email verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="wc_both" class="app_enable" name="mo_customer_validation_wc_enable_type" value="mo_wc_both_enable"
						'.($wc_enable_type == "mo_wc_both_enable"? "checked" : "" ).'/><strong>Let the user choose</strong>';
							mo_form_additional_info(1,null,false);
echo '			</p>
				<b>Select page to redirect to after registration : </b>';
				if(get_option('mo_customer_validation_wc_redirect'))
					wp_dropdown_pages(array("selected" => get_page_by_title( get_option("mo_customer_validation_wc_redirect") )->ID));
				else
					wp_dropdown_pages();
					
echo'		</div>';