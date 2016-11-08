<?php

echo'	<input type="checkbox" '.$disabled.' id="simplr_default" data-toggle="simplr_default_options" class="app_enable" name="mo_customer_validation_simplr_default_enable" value="1"
				'.$simplr_enabled.' /><strong>Simplr User Registration Form Plus</strong>';

					get_plugin_form_link(MoConstants::SIMPLR_FORM_LINK);

echo'			<div class="mo_registration_help_desc" '.$simplr_hidden.' id="simplr_default_options">
					<b>Choose between Phone or Email Verification</b>
						<p><input type="radio" '.$disabled.' data-form="simplr_phone" id="simplr_phone" class="form_options app_enable" name="mo_customer_validation_simplr_enable_type" value="mo_phone_enable"
							'.( $simplr_enabled_type == "mo_phone_enable" ? "checked" : "" ).' /><strong>Enable Phone verification</strong>';
							
							mo_form_additional_info(null,2,true);

echo'						<div hidden id="form_query_desc_2" class="mo_registration_help_desc">
								<ol>
									<li><a href="'.$simplr_fields_page.'" target="_blank">Click here</a> to see your list of fields.</li>
									<li>Add a new Phone Field by clicking the <b>Add Field</b> button.</li>
									<li>Give the <b>Field Name</b> and <b>Field Key</b> for the new field. Remember the Field Key as you will need it later.</li>
									<li>Click on <b>Add Field</b> button at the bottom of the page to save your new field.</li>
									<li><a href="'.$page_list.'" target="_blank	">Click here</a> to see your list of pages.</li>
									<li>Click on the <b>Edit</b> link of your page to modify it.</li>
									<li>In the ShortCode add the following attribute : <b>fields="{Field Key you provided in Step 2}"</b>. If you already have the fields attribute defined then just add the new field key to the list.</li>
									<li>Click on <b>update</b> to save your page.</li>
								</ol>
							</div>
							</p>
							<div '.($simplr_enabled_type!= "mo_phone_enable" ? "hidden" : "").' class="simplr_form mo_registration_help_desc" id="simplr_phone_field" >
								Enter the Field Key of the phone field:<input class="mo_registration_table_textbox" id="simplr_phone_field_key1" name="simplr_phone_field_key" type="text" value="'.$simplr_field_key.'">
							</div>
							<p><input type="radio" '.$disabled.' data-form="simplr_email" id="simplr_email" class="form_options app_enable" name="mo_customer_validation_simplr_enable_type" value="mo_email_enable"
									'.( $simplr_enabled_type == "mo_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
							</p>
							<p><input type="radio" '.$disabled.' data-form="simplr_both" id="simplr_both" class="form_options app_enable" name="mo_customer_validation_simplr_enable_type" value="mo_both_enable"
									'.( $simplr_enabled_type == "mo_both_enable" ? "checked" : "").' /><strong>Let the user choose</strong>';
			
									mo_form_additional_info(3,8,true);

echo'						<div hidden id="form_query_desc_8" class="mo_registration_help_desc">
								<ol>
									<li><a href="'.$simplr_fields_page.'" target="_blank">Click here</a> to see your list of fields.
									<li>Add a new Phone Field by clicking the <b>Add Field</b> button.</li>
									<li>Give the <b>Field Name</b> and <b>Field Key</b> for the new field. Remember the Field Key as you will need it later.</li>
									<li>Click on <b>Add Field</b> button at the bottom of the page to save your new field.</li>
									<li><a href="'.$page_list.'" target="_blank	">Click here</a> to see your list of pages.</li>
									<li>Click on the <b>Edit</b> link of your page to modify it.</li>
									<li>In the ShortCode add the following attribute : <b>fields="{Field Key you provided in Step 2}"</b>. If you already have the fields attribute defined then just add the new field key to the list.</li>
									<li>Click on <b>update</b> to save your page.</li>
								</ol>
							</div>
							</p>
								<div '.($simplr_enabled_type != "mo_both_enable" ? "hidden" : "").' class="simplr_form mo_registration_help_desc" id="simplr_both_field" >
									Enter the Field Key of the phone field:<input class="mo_registration_table_textbox" id="simplr_phone_field_key2" name="simplr_phone_field_key" type="text" value="'.$simplr_field_key.'">
								</div>
					</div>';