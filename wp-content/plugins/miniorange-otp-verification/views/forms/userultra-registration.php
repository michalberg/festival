<?php

echo'							<input type="checkbox" '.$disabled.' id="uultra_default" class="app_enable" data-toggle="uultra_default_options" name="mo_customer_validation_uultra_default_enable" value="1"
										'.$uultra_enabled.' /><strong>User Ultra Registration Form</strong>';

										get_plugin_form_link(MoConstants::UULTRA_FORM_LINK);

echo'							<div class="mo_registration_help_desc" '.$uultra_hidden.' id="uultra_default_options">
									<b>Choose between Phone or Email Verification</b>
									<p><input type="radio" '.$disabled.' data-form="uultra_phone" id="uultra_phone" class="form_options app_enable" name="mo_customer_validation_uultra_enable_type" value="mo_uultra_phone_enable"
										'.( $uultra_enable_type == "mo_uultra_phone_enable" ? "checked" : "").' /><strong>Enable Phone verification</strong>';									

										mo_form_additional_info(null, 17, true);

echo'									<div hidden id="form_query_desc_17" class="mo_registration_help_desc">
											<ol>
												<li><a href="'.$uultra_form_list.'" target="_blank">Click here</a> to see your list of fields.</li>
												<li>Click on <b>Click here to add new field</b> button to add a new field.</li>
												<li>Fill up the details of your new field and click on <b>Submit New Field</b>.</li>
												<li>Keep the <b>Meta Key</b> handy as you will need it later on.</li>
											</ol>
										</div>
									</p>
									<div '.($uultra_enable_type  != "mo_uultra_phone_enable" ? "hidden" : "").' class="uultra_form mo_registration_help_desc" id="uultra_phone_field" >
											Enter the Meta Key of the phone field:<input class="mo_registration_table_textbox" id="uultra_phone_field_key" name="uultra_phone_field_key" type="text" value="'.$uultra_field_key.'">
										</div>
									<p><input type="radio" '.$disabled.' data-form="uultra_email" id="uultra_email" class="form_options app_enable" name="mo_customer_validation_uultra_enable_type" value="mo_uultra_email_enable"
										 '.( $uultra_enable_type == "mo_uultra_email_enable" ? "checked" : "" ).' /><strong>Enable Email verification</strong>
									</p>
									<p><input type="radio" '.$disabled.' data-form="uultra_both" id="uultra_both" class="form_options app_enable" name="mo_customer_validation_uultra_enable_type" value="mo_uultra_both_enable"
										'.( $uultra_enable_type == "mo_uultra_both_enable" ? "checked" : "" ).' /><strong>Let the user choose</strong>';

										 mo_form_additional_info(11,18,true);

echo'									<div hidden id="form_query_desc_18" class="mo_registration_help_desc">
											<ol>
												<li><a href="'.$uultra_form_list.'" target="_blank">Click here</a> to see your list of fields.</li>
												<li>Click on <b>Click here to add new field</b> button to add a new field.</li>
												<li>Fill up the details of your new field and click on <b>Submit New Field</b>.</li>
												<li>Keep the <b>Meta Key</b> handy as you will need it later on.</li>
											</ol>
										</div>
										<div '.($uultra_enable_type  != "mo_uultra_both_enable" ? "hidden" :"").' class="uultra_form mo_registration_help_desc" id="uultra_both_field" >
											Enter the Meta Key of the phone field:<input class="mo_registration_table_textbox" id="uultra_phone_field_key1" name="uultra_phone_field_key" type="text" value="'.$uultra_field_key.'">
										</div>
									</p>
								</div>';