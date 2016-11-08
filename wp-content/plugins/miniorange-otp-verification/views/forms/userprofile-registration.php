<?php

echo'						<input type="checkbox" '.$disabled.' id="upme_default" class="app_enable" data-toggle="upme_default_options" name="mo_customer_validation_upme_default_enable" value="1"
								 '.$upme_enabled.' /><strong>UserProfile Made Easy Registration Form</strong>';
										
									get_plugin_form_link(MoConstants::UPME_FORM_LINK);						 
																
echo '								<div class="mo_registration_help_desc" '.$upme_hidden.' id="upme_default_options">
									<b>Choose between Phone or Email Verification</b>
									<p><input type="radio" '.$disabled.' data-form="upme_phone" id="upme_phone" class="form_options app_enable" name="mo_customer_validation_upme_enable_type" value="mo_upme_phone_enable"
										'.( $upme_enable_type == "mo_upme_phone_enable" ? "checked" : "").' /><strong>Enable Phone verification</strong>';
										
										mo_form_additional_info(null,19,true);
										
echo'									</p>
										<div hidden id="form_query_desc_19" class="mo_registration_help_desc">
											<ol>
												<li><a href="'.$upme_field_list.'" target="_blank">Click here</a> to see your list of fields.</li>
												<li>Click on <b>Click here to add new field</b> button to add a new field.</li>
												<li>Fill up the details of your new field and click on <b>Submit New Field</b>.</li>
												<li>Keep the <b>Meta Key</b> handy as you will need it later on.</li>
											</ol>
										</div>
										
										<div '.($upme_enable_type != "mo_upme_phone_enable" ? "hidden" : "").' class="upme_form mo_registration_help_desc" id="upme_phone_field" >
											Enter the Meta Key of the phone field:<input class="mo_registration_table_textbox" id="upme_phone_field_key" name="upme_phone_field_key" type="text" value="'.$upme_field_key.'">
										</div>
									<p><input type="radio" '.$disabled.' data-form="upme_email" id="upme_email" class="form_options app_enable" name="mo_customer_validation_upme_enable_type" value="mo_upme_email_enable"
										'.( $upme_enable_type == "mo_upme_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
									</p>
									<p><input type="radio" '.$disabled.' data-form="upme_both" id="upme_both" class="form_options app_enable" name="mo_customer_validation_upme_enable_type" value="mo_upme_both_enable"
										'.( $upme_enable_type == "mo_upme_both_enable" ? "checked" : "").' /><strong>Let the user choose</strong>';

										mo_form_additional_info(12,20,true);

echo'									<div hidden id="form_query_desc_20" class="mo_registration_help_desc">
											<ol>
												<li><a href="'.$upme_field_list.'" target="_blank">Click here</a> to see your list of fields.</li>
												<li>Click on <b>Click here to add new field</b> button to add a new field.</li>
												<li>Fill up the details of your new field and click on <b>Submit New Field</b>.</li>
												<li>Keep the <b>Meta Key</b> handy as you will need it later on.</li>
											</ol>
										</div>
										<div '.($upme_enable_type != "mo_upme_both_enable" ? "hidden" :"").' class="upme_form mo_registration_help_desc" id="upme_both_field" >
											Enter the Meta Key of the phone field:<input class="mo_registration_table_textbox" id="upme_phone_field_key1" name="upme_phone_field_key" type="text" value="'.$upme_field_key.'">
										</div>
										
									</p>
								</div>';