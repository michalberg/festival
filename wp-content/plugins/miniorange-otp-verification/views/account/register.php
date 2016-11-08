<?php	
	
echo'<!--Register with miniOrange-->
	<form name="f" method="post" action="" id="register-form">
		<input type="hidden" name="option" value="mo_registration_register_customer" />
		<div class="mo_registration_divided_layout">
			<div class="mo_registration_table_layout">
				<h3>Register with miniOrange</h3>
				<p>Please enter a valid email that you have access to. You will be able to move forward after verifying an OTP that we will be sending to this email. <b>OR</b> Login using your miniOrange credentials.</p>
				<table class="mo_registration_settings_table">
					<tr>
						<td><b><font color="#FF0000">*</font>Email:</b></td>
						<td><input class="mo_registration_table_textbox" type="email" name="email"
							required placeholder="person@example.com"
							value="'.$current_user->user_email.'" /></td>
					</tr>

					<tr>
						<td><b><font color="#FF0000">*</font>Website/Company Name:</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="company"
							required placeholder="Enter your companyName"
							value="'.$_SERVER["SERVER_NAME"].'" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;FirstName:</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="fname"
							placeholder="Enter your First Name"
							value="'.$current_user->user_firstname.'" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;LastName:</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="lname"
							placeholder="Enter your Last Name"
							value="'.$current_user->user_lastname.'" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;Phone number:</b></td>
						<td><input class="mo_registration_table_textbox" type="tel" id="phone"
							pattern="[\+]\d{7,14}|[\+]\d{1,4}[\s]\d{6,12}" name="phone"
							title="Phone with country code eg. +1xxxxxxxxxx"
							placeholder="Phone with country code eg. +1xxxxxxxxxx"
							value="'.$admin_phone.'" /><br>We will call only if you need support.</td>
						<td></td>
					</tr>

					<tr>
						<td><b><font color="#FF0000">*</font>Password:</b></td>
						<td><input class="mo_registration_table_textbox" required type="password"
							name="password" placeholder="Choose your password (Min. length 6)" /></td>
					</tr>
					<tr>
						<td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
						<td><input class="mo_registration_table_textbox" required type="password"
							name="confirmPassword" placeholder="Confirm your password" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><br /><input type="submit" name="submit" value="Next" style="width:100px;"
							class="button button-primary button-large" /></td>
					</tr>
				</table>
			</div>
		</div>
	</form>';