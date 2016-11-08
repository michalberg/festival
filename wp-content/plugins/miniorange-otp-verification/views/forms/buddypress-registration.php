<?php

echo'		<input type="checkbox" '.$disabled.' id="bbp_default" class="app_enable" data-toggle="bbp_default_options" name="mo_customer_validation_bbp_default_enable" value="1"
				'.$bbp_enabled.' /><strong>BuddyPress Registration Form</strong>';

					get_plugin_form_link(MoConstants::BBP_FORM_LINK);

echo'			<div class="mo_registration_help_desc" '.$bbp_hidden.' id="bbp_default_options">
					<p><input type="checkbox" '.$disabled.' class="form_options" '.$automatic_activation.' id="bbp_disable_activation_link" name="mo_customer_validation_bbp_disable_activation" value="1"/> &nbsp;<strong>Automatically activate users after verification</strong><br/><i>( No activation email would be sent after verification )</i></p>
					<b>Choose between Phone or Email Verification</b>
					<p><input type="radio" '.$disabled.' data-form="bbp_phone" id="bbp_phone" class="form_options app_enable" name="mo_customer_validation_bbp_enable_type" value="mo_bbp_phone_enable"
							'.( $bbp_enable_type == "mo_bbp_phone_enable" ? "checked" : "").' /><strong>Enable Phone verification</strong>
						<a class="form_query" data-desc="13"> <b>[ You will need to add a Phone Number field manually ]</b></a>
						<div hidden id="form_query_desc_13" class="mo_registration_help_desc">
							<ol>
								<li><a href="'.$bbp_fields.'" target="_blank">Click here</a> to see your list of fields.</li>
								<li>Add a new Phone Field by clicking the <b>Add New Field</b> button.</li>
								<li>Give the <b>Field Name</b> and <b>Description</b> for the new field. Remember the Field Name as you will need it later.</li>
								<li>Select the field <b>type</b> from the select box. Choose <b>Number</b>.</li>
								<li>Select the field <b>requirement</b> from the select box to the right.</li>
								<li>Click on <b>Save</b> button to save your new field.</li>
							</ol>
						</div>
					</p>
					<div '.($bbp_enable_type != "mo_bbp_phone_enable" ? "hidden" : "").' class="bbp_form mo_registration_help_desc" id="bbp_phone_field">
						Enter the Name of the phone field:<input class="mo_registration_table_textbox" id="bbp_phone_field_key" name="bbp_phone_field_key" type="text" value="'.$bbp_field_key.'">
					</div>
					<p><input type="radio" '.$disabled.' data-form="bbp_email mo_registration_help_desc" id="bbp_email" class="form_options app_enable" name="mo_customer_validation_bbp_enable_type" value="mo_bbp_email_enable"
						'.( $bbp_enable_type == "mo_bbp_email_enable"? "checked" : "" ).' /><strong>Enable Email verification</strong>
					</p>
					<p><input type="radio" '.$disabled.'  data-form="bbp_both" id="bbp_both mo_registration_help_desc" class="form_options app_enable" name="mo_customer_validation_bbp_enable_type" value="mo_bbp_both_enable"
							'.( $bbp_enable_type == "mo_bbp_both_enable" ? "checked" : "").' /><strong>Let the user choose</strong>';
	
						mo_form_additional_info(9,14,true);

echo'				<div hidden id="form_query_desc_14" class="mo_registration_help_desc">
						<ol>
							<li><a href="'.$bbp_fields.'" target="_blank">Click here</a> to see your list of fields.</li>
							<li>Add a new Phone Field by clicking the <b>Add New Field</b> button.</li>
							<li>Give the <b>Field Name</b> and <b>Description</b> for the new field. Remember the Field Name as you will need it later.></li>
							<li>Select the field <b>type</b> from the select box. Choose <b>Number</b>.</li>
							<li>Select the field <b>requirement</b> from the select box to the right.</li>
							<li>Click on <b>Save</b> button to save your new field.</li>
						</ol>
					</div>
					</p>
					<div '.($bbp_enable_type != "mo_bbp_both_enable" ? "hidden" : "").' class="bbp_form" id="bbp_both_field" >
						Enter the Name of the phone field:<input class="mo_registration_table_textbox" id="bbp_phone_field_key1" name="bbp_phone_field_key" type="text" value="'.$bbp_field_key.'">
					</div>';
					
echo'			</div>';


