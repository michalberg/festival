<?php

echo'		<input type="checkbox" '.$disabled.' id="um_default" data-toggle="um_default_options" class="app_enable" name="mo_customer_validation_um_default_enable" value="1"
					'.$um_enabled.' /><strong>Ultimate Member Registration Form</strong>';

							get_plugin_form_link(MoConstants::UM_ENABLED);

echo'		<div class="mo_registration_help_desc" '.$um_hidden.' id="um_default_options">
				<b>Choose between Phone or Email Verification</b>
				<p>
					<input type="radio" '.$disabled.' id="um_phone" class="app_enable" name="mo_customer_validation_um_enable_type" value="mo_um_phone_enable"
					'.( $um_enabled_type == "mo_um_phone_enable" ? "checked" : "").'/><strong>Enable Phone verification</strong>
					<a  class="form_query" data-desc="4"><b>[ You will need to add a Phone Number field in your form manually ]</b></a>
					<div id="form_query_desc_4"hidden class="mo_registration_help_desc">
						<ol>
							<li><a href="'.$um_forms.'"  target="_blank">Click here</a> to see your list of forms.</li>
							<li>Click on the <b>Edit link</b> of your form.</li>
							<li>Add a new <b>Mobile Number</b> Field from the list of predefined fields.</li>
							<li>Click on <b>update</b> to save your form.</li>
						</ol>
					</div>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="um_email" class="app_enable" name="mo_customer_validation_um_enable_type" value="mo_um_email_enable"
					'.( $um_enabled_type == "mo_um_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
				</p>
				<p>
					<input type="radio" '.$disabled.' id="um_both" class="app_enable" name="mo_customer_validation_um_enable_type" value="mo_um_both_enable"
						'.( $um_enabled_type == "mo_um_both_enable" ? "checked" : "").' /><strong>Let the user choose</strong>';
				
						mo_form_additional_info(5,7,true);

echo'				<div id="form_query_desc_7"hidden class="mo_registration_help_desc">
						<ol>
							<li><a href="'.$um_forms.'">Click here</a> to see your list of forms.</li>
							<li>Click on the <b>Edit link</b> of your form.</li>
							<li>Add a new <b>Mobile Number</b> Field from the list of predefined fields.</li>
							<li>Click on <b>update</b> to save your form.</li>
						</ol>
					</div>
				</p>
			</div>';