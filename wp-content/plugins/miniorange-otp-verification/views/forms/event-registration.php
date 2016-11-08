<?php

echo' 		<input type="checkbox" '.$disabled.' id="event_default" class="app_enable" data-toggle="event_default_options" name="mo_customer_validation_event_default_enable" value="1"
					'.$event_enabled.'/><strong>Event Registration Form</strong>';

						get_plugin_form_link(MoConstants::EVENT_FORM);

echo'			<div class="mo_registration_help_desc" '.$event_hidden.' id="event_default_options">
					<b>Choose between Phone or Email Verification</b>
					<p><input type="radio" '.$disabled.' id="event_phone" class="app_enable" name="mo_customer_validation_event_enable_type" value="mo_event_phone_enable"
							'.( $event_enabled_type == "mo_event_phone_enable" ? "checked" : "").' /><strong>Enable Phone verification</strong>
							</p>
							<p>
								<input type="radio" '.$disabled.' id="event_email" class="app_enable" name="mo_customer_validation_event_enable_type" value="mo_event_email_enable"
								'.( $event_enabled_type == "mo_event_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
							</p>
									<p>
										<input type="radio" '.$disabled.' id="event_both" class="app_enable" name="mo_customer_validation_event_enable_type" value="mo_event_both_enable"
											'.( $event_enabled_type == "mo_event_both_enable" ? "checked" : "").' /><strong>Let the user choose</strong>';
					
											mo_form_additional_info(6,null,false);
				
echo'								</p>
				</div>';