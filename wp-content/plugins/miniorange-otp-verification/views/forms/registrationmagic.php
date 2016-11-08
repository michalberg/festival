<?php

echo' 	<input type="checkbox" '.$disabled.' id="crf_default" class="app_enable" data-toggle="crf_default_options" name="mo_customer_validation_crf_default_enable" value="1"
				'.$crf_enabled.' /><strong>Custom User Registration Form Builder [ RegistrationMagic ]</strong>';

						get_plugin_form_link(MoConstants::CRF_FORM_ENABLE);

echo'			<div class="mo_registration_help_desc" '.$crf_hidden.' id="crf_default_options">
					<b>Choose between Phone or Email Verification</b>
					<p><input type="radio" '.$disabled.' id="crf_phone" data-form="crf_phone" class="form_options app_enable" name="mo_customer_validation_crf_enable_type" value="mo_crf_phone_enable"
						'.( $crf_enable_type == "mo_crf_phone_enable" ? "checked" : "" ).' /><strong>Enable Phone verification</strong>';

							mo_form_additional_info(null, 15, true);

echo'					<div hidden id="form_query_desc_15" class="mo_registration_help_desc">
							<ol>
								<li><a href="'.$crf_form_list.'" target="_blank">Click here</a> to see your list of forms.</li>
								<li>Click on <b>fields</b> link of your form to see <i>special field</i> list of fields.</li>
								<li>Choose <b>phone number / mobile number </b> field from the list.</li>
								<li>Enter the <b>Label</b> of your new field. Keep this handy as you will need it later.</li>
								<li>Under RULES section check the box which says <b>Is Required</b>.</li>
								<li>Click on <b>Save</b> button to save your new field.</li>
							</ol>
						</div>
					</p>
				<div '.($crf_enable_type != "mo_crf_phone_enable" ? "hidden" :"").' class="crf_form mo_registration_help_desc" id="crf_phone_field" >
					Enter the Label of the phone field:<input class="mo_registration_table_textbox" id="crf_phone_field_key" name="crf_phone_field_key" type="text" value="'.$crf_phone_field_key.'">
				</div>
					<p><input type="radio" '.$disabled.' id="crf_email" data-form="crf_email" class="form_options app_enable" name="mo_customer_validation_crf_enable_type" value="mo_crf_email_enable"
						'.( $crf_enable_type == "mo_crf_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
					</p>
					<div '.($crf_enable_type != "mo_crf_email_enable" ? "hidden" :"").' class="crf_form mo_registration_help_desc" id="crf_email_field" >
						Enter the Label of the email field:<input class="mo_registration_table_textbox" id="crf_email_field_key" name="crf_email_field_key" type="text" value="'.$crf_email_field_key.'">
					</div>
					<p><input type="radio" '.$disabled.' id="crf_both" data-form="crf_both" class="form_options app_enable" name="mo_customer_validation_crf_enable_type" value="mo_crf_both_enable"
						'.( $crf_enable_type == "mo_crf_both_enable"? "checked" : "" ).' /><strong>Let the user choose</strong>';

						mo_form_additional_info(10,16,true);

echo'				<div hidden id="form_query_desc_16" class="mo_registration_help_desc">
						<ol>
							<li><a href="'.$crf_form_list.'" target="_blank">Click here</a> to see your list of forms.</li>
							<li>Click on <b>fields</b> link of your form to see <i>special field</i> list of fields.</li>
							<li>Choose <b>phone number / mobile number </b> field from the list.</li>
							<li>Enter the <b>Label</b> of your new field. Keep this handy as you will need it later.</li>
							<li>Under RULES section check the box which says <b>Is Required</b>.</li>
							<li>Click on <b>Save</b> button to save your new field.</li>
						</ol>
					</div>
					<div '.($crf_enable_type != "mo_crf_both_enable" ? "hidden" :"").' class="crf_form mo_registration_help_desc" id="crf_both_field" >
						Enter the Label of the phone field:<input class="mo_registration_table_textbox" id="crf_phone_field_key1" name="crf_phone_field_key" type="text" value="'.$crf_phone_field_key.'"><br/>
						Enter the Label of the email field:&nbsp;&nbsp;<input class="mo_registration_table_textbox" id="crf_email_field_key1" name="crf_email_field_key" type="text" value="'.$crf_email_field_key.'">
					</div>
				</p>
			</div>';