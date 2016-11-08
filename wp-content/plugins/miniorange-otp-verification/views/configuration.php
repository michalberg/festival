<?php
global $dirOTPName,$moUtility;
echo '<div class="mo_registration_divided_layout">
				<div class="mo_registration_table_layout">';
				is_customer_registered();
		
		echo '<table style="width: 100%;">
			<tr>
				<td colspan="3">
					<h3>SMS & EMAIL CONFIGURATION</h3><hr>
				</td>
			</tr>
			<tr>
				<td>
					<b>Look at the sections below to customize the Email and SMS that you receive:</b>
					<ol>
						<li><b><a href="#sms">Custom SMS Template</a> :</b> Change the text of the message that you receive on your phones.</li>
						<li><b><a href="#sms">Custom SMS Gateway</a> :</b> You can configure settings to use your own SMS gateway.</li>
						<li><b><a href="#email">Custom Email Template</a> :</b> Change the text of the email that you receive.</li>
						<li><b><a href="#email">Custom Email Gateway</a> :</b> You can configure settings to use your own Email gateway.</li>
					</ol>
			</tr>
			<tr>
				<td>
					<a class="form_query" data-desc="21"><b>[ How can I change the SenderID/Number of the SMS I receive? ]</b></a>
					<div id="form_query_desc_21" hidden class="mo_registration_help_desc" >
						SenderID/Number is gateway specific. You will need to use your own SMS gateway for this.
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<a class="form_query" data-desc="22"><b>[ How can I change the Sender Email of the Email I receive? ]</b></a>
					<div id="form_query_desc_22" hidden class="mo_registration_help_desc" >
						Sender Email is gateway specific. You will need to use your own Email gateway for this.
					</div>
				</td>
			</tr>
			<tr id="sms">
				<td>
					<h2>SMS Configuration</h2><hr/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Custom SMS Template:</b>
					<div style="padding:2%;background-color: rgba(111, 111, 111, 0.09);">
						<img src=" '.plugins_url( 'miniorange-otp-verification/includes/images/'.$sms_template_guide_url, $dirOTPName ). ' " />
						<div '. $hidden. ' style="text-align:center">
							<input '. $disabled. ' type="button" title="Need to be registered for this option to be available"  value="Change SMS Template" onclick="extraSettings(\''.MoConstants::HOSTNAME.'\',\'/moas/showsmstemplate\');" class="button button-primary button-large" style="margin-right: 3%;">
						</div>
					</div>
					<b>Custom SMS Gateway:</b>
					<div style="padding:2%;background-color: rgba(111, 111, 111, 0.09);">
						<img src=" '.plugins_url( 'miniorange-otp-verification/includes/images/'.$sms_gateway_guide_url, $dirOTPName ). '" />
						<div '. $hidden. ' style="text-align:center">
							<input '. $disabled. ' type="button" title="Need to be registered for this option to be available"  value="Change SMS Gateway" onclick="extraSettings(\''.MoConstants::HOSTNAME.'\',\'/moas/smsconfig\');" class="button button-primary button-large" style="margin-right: 3%;">
						</div>	
					</div>
				</td>
			</tr>
			<tr id="email">
				<td>
					<h2>Email Configuration</h2><hr/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Custom Email Template:</b>
					<div style="padding:2%;background-color: rgba(111, 111, 111, 0.09);">
						<img src=" '.plugins_url( 'miniorange-otp-verification/includes/images/'.$email_template_guide_url, $dirOTPName ). '" />
						<div '. $hidden. ' style="text-align:center">
							<input '. $disabled. ' type="button" title="Need to be registered for this option to be available"  value="Change Email Template" onclick="extraSettings(\''.MoConstants::HOSTNAME.'\',\'/moas/showemailtemplate\');" class="button button-primary button-large" style="margin-right: 3%;">
						</div>
					</div>
					<b>Custom Email Gateway:</b>
					<div style="padding:2%;background-color: rgba(111, 111, 111, 0.09);">
						<img src=" '.plugins_url( 'miniorange-otp-verification/includes/images/'.$email_gateway_guide_url,$dirOTPName ). '" />
						<div '. $hidden. ' style="text-align:center">
							<input type="button" '. $disabled. ' title="Need to be registered for this option to be available"  value="Change Email Gateway" onclick="extraSettings(\''.MoConstants::HOSTNAME.'\',\'/moas/configureSMTP\');" class="button button-primary button-large" style="margin-right: 3%;">
						</div>
					</div>
				</td>
			</tr>
		</table>
		<form id="showExtraSettings" action="'. MoConstants::HOSTNAME.'/moas/login" target="_blank" method="post">
	       <input type="hidden" id="extraSettingsUsername" name="username" value=" '. $email.'"/>
	       <input type="hidden" id="extraSettingsRedirectURL" name="redirectUrl" value="" />
		</form>
	</div>
	</div>';
	?>