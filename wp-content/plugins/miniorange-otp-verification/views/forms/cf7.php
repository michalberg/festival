<?php

echo'							<input type="checkbox" '.$disabled.' id="cf7_contact" class="app_enable" data-toggle="cf7_contact_options" name="mo_customer_validation_cf7_contact_enable" value="1"
										'.$cf7_enabled.' /><strong>Contact Form 7 - Contact Form</strong>';
										
									get_plugin_form_link(MoConstants::CF7_FORM_LINK);								 
																	
echo'							<div class="mo_registration_help_desc" '.$cf7_hidden.' id="cf7_contact_options">
									<p><input type="radio" '.$disabled.' id="cf7_contact_email" class="app_enable" data-toggle="cf7_contact_email_instructions" name="mo_customer_validation_cf7_contact_type" value="mo_cf7_contact_email_enable"
										'.( $cf7_enabled_type == "mo_cf7_contact_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
									</p>
									<div '.($cf7_enabled_type != "mo_cf7_contact_email_enable" ? "hidden" :"").' class="mo_registration_help_desc" id="cf7_contact_email_instructions" >
											Follow the following steps to enable Email Verification for Contact form 7: 
											<ol>
												<li><a href="'.$page_list.'" target="_blank">Click Here</a> to see your list of pages.</li>
												<li>Click on the <b>Edit</b> option of the page which has your contact form.</li>
												<li>Add the following short code just below your Contact Form 7 shortcode : <code>[mo_verify_email]</code> </li>
												<li><a href="'.$cf7_field_list.'" target="_blank">Click Here</a> to see your list of Contact Forms.</li>
												<li>Click on the <b>Edit</b> option of your form.</li>
												<li>
													Now place the following code in your form where you wish to show the Verify Email button and field : <br>
													<pre>&lt;div style="margin-bottom:3%"&gt;<br/>&lt;input type="button" class="button alt" style="width:100%" id="miniorange_otp_token_submit" title="Please Enter an Email Address to enable this." value="Click here to verify your Email"&gt;&lt;div id="mo_message" hidden="" style="background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;"&gt;&lt;/div&gt;<br/>&lt;/div&gt;<br/><br/>&lt;p&gt;Verify Code (required)&lt;br /&gt;<br/>	[text* email_verify]&lt;/p&gt;</pre>
												</li>
												<li>Enter the name of the email field below:<br>
													<input class="mo_registration_table_textbox" id="cf7_email_field_key" name="cf7_email_field_key" type="text" value="'.$cf7_field_key.'">
													<br/><i> For Reference : [email* &lt;name of your email field&gt;]</i> 
												</li>
												<li>Click on the Save Button below to save your settings</li>
											</ol>
									</div>
									<p><input type="radio" '.$disabled.' id="cf7_contact_phone" class="app_enable" data-toggle="cf7_contact_phone_instructions" name="mo_customer_validation_cf7_contact_type" value="mo_cf7_contact_phone_enable"
										'.( $cf7_enabled_type == "mo_cf7_contact_phone_enable" ? "checked" : "").' /><strong>Enable Phone verification</strong>
									</p>
									<div '.($cf7_enabled_type != "mo_cf7_contact_phone_enable" ? "hidden" : "").' class="mo_registration_help_desc" id="cf7_contact_phone_instructions" >
											Follow the following steps to enable Phone Verification for Contact form 7: 
											<ol>
												<li><a href="'.$page_list.'" target="_blank">Click Here</a> to see your list of pages.</li>
												<li>Click on the <b>Edit</b> option of the page which has your contact form.</li>
												<li>Add the following short code just below your Contact Form 7 shortcode : <code>[mo_verify_phone]</code> </li>
												<li><a href="'.$cf7_field_list.'" target="_blank">Click Here</a> to see your list of Contact Forms.</li>
												<li>Click on the <b>Edit</b> option of your form.</li>
												<li>
													Now place the following code in your form where you wish to show the Verify Email button and field : <br>
													<pre>&lt;p&gt;Phone Number (required)&lt;br /&gt;<br/>	[tel* mo_phone]&lt;/p&gt;<br /><br/>&lt;div style="margin-bottom:3%"&gt;<br/>&lt;input type="button" class="button alt" style="width:100%" id="miniorange_otp_token_submit" title="Please Enter a phone number to enable this." value="Click here to verify your Phone"&gt;&lt;div id="mo_message" hidden="" style="background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;"&gt;&lt;/div&gt;<br/>&lt;/div&gt;<br/><br/>&lt;p&gt;Verify Code (required)&lt;br /&gt;<br/>	[text* phone_verify]&lt;/p&gt;</pre>
												</li>
												<li>Click on the Save Button below to save your settings</li>
											</ol>
									</div>
								</div>';