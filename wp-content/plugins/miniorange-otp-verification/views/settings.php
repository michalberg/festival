<?php
	
echo'		<div class="mo_registration_divided_layout">
			<div class="mo_registration_table_layout">';
			
			is_customer_registered();
			
echo'			<form name="f" method="post" action="" id="mo_otp_verification_settings">
				<input type="hidden" name="option" value="mo_customer_validation_settings" />
					<table style="width:100%">
						<tr>
							<td>
								<h2>CONFIGURE YOUR FORM</h2>
							</td>
						</tr>
						<tr>
							<td><b>By following these easy steps you can verify your users email or phone number instantly:
								<ol><li>Select the form <a class="registration_question">[ My form is not in this list ]</a>
									<div style="font-weight:normal" hidden class="mo_registration_help_desc" >We are actively adding support for more forms. Please contact us using the support form on your right or email us at <b>info@miniorange.com</b>. <br/>While contacting us please include enough information about your registration form and how you intend to use this plugin. We will respond promptly.  </div>
								</li>
								<li>Save your settings.</li>
								<li>Log out and go to your registration or landing page for testing.</li>
								<li>To customize your SMS/Email messages/gateway check under <a href="'.$config.'">SMS/Email Templates Tab</a></li>
								<li>For any query related to custom SMS/Email messages/gateway check <a href="'.$help_url.'">Help & Troubleshooting Tab</a></li>
							</b></td>
						</tr>
						<tr>
							<td>
								<hr>
								<div style="float:left;"><h2>Select your form from the list below : </h2></div>
								<div style="margin-top:1em;margin-left:1%;float:left;"><input type="text" id="mo_search" placeholder="Search for your form"></input></div>
							</td>
						</tr>
					</table>
					<table id="mo_forms" style="width: 100%;">
						<tr>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/wp-registration.php';							
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/woocommerce-registration.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/woocommerce-checkout.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/woocommerce-social-login.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/profile-builder.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/simplr-registration.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/ultimate-member.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/event-registration.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/buddypress-registration.php';
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/registrationmagic.php'; 
echo'						</td>
						</tr>
						<tr>
							<td>';
								include $controller . 'forms/userultra-registration.php';
echo'						</td>
						</tr>
						<tr>
	 						<td>';
								include $controller . 'forms/userprofile-registration.php';
echo'						</td>
						</tr>
						<tr>
	 						<td>';
								include $controller . 'forms/pie-registration.php';						
echo'						</td>
						</tr>
						<tr>
	 						<td>';
								include $controller . 'forms/cf7.php';							
echo'						</td>
						</tr>
						<tr>
	 						<td>';
								include $controller . 'forms/ninja-forms.php';							
echo'						</td>
						</tr>
						<tr>
	 						<td>';
								include $controller . 'forms/tml-forms.php';							
echo'						</td>
						</tr>
					</table>
					<table style="width:100%">
						<tr>
							<td>
								<br/>
								<div class="registration_question"><a><b>[ Cannot see your registration form in the list above? Have your own custom registration form? ]</b></a></div>
								<div hidden class="mo_registration_help_desc" >We are actively adding support for more forms. Please contact us using the support form on your right or email us at <b>info@miniorange.com</b>. <br/>While contacting us please include enough information about your registration form and how you intend to use this plugin. We will respond promptly.  </div>
							</td>
						</tr>
						<tr>
							<td><br>
								<input type="hidden" id="error_message" name="error_message" value="">
								<input type="button" id="ov_settings_button"  title="Please select atleast one form from the list above to enable this button" value="Save" style="float:left; width:100px;margin-bottom:2%;" '.$disabled.'
									class="button button-primary button-large" />
								
							</td>
						</tr>
					</table>
			</form>
		</div>
	</div>';