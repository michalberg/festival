<?php 

echo'

	 <div class="mo_registration_divided_layout">
		<div class="mo_registration_table_layout">';

			is_customer_registered();

echo '<form name="f" method="post" action="" id="mo_otp_verification_messages">
		<input type="hidden" name="option" value="mo_customer_validation_messages" />
			<table style="width:100%">
				<tr>
					<td>
						<h2>CONFIGURE MESSAGES
							<span style="float:right;margin-top:-10px;">
								<input type="submit" '.$disabled.' name="save" id="save" class="button button-primary button-large" value="Save Settings"/>
							</span>
						</h2><hr/>
					</td>
				</tr>
				<tr>
					<td> <strong>Configure messages your users will see on successful and failure of Email or SMS delivery.</strong> </td>
				</tr>
				<tr>
					<td>
						<h3>Email Messages</h3><hr/>
						<div style="margin-left:1%;">
							<div style="margin-bottom:1%;"><strong>SUCCESS MESSAGE : </strong>
							<span style="color:red">( NOTE: ##email## in the message body will be replaced by the user\'s email address )</span></div>
							<textarea name="otp_success_email" rows="4" style="width:100%;padding:2%;">'.$otp_success_email.'</textarea><br/>
							<div style="margin-bottom:1%;"><strong>ERROR MESSAGE</strong></div>
							<textarea name="otp_error_email" rows="4" style="width:100%;padding:2%;">'.$otp_error_email.'</textarea><br/>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<h3>SMS/Mobile Messages</h3><hr/>
						<div style="margin-left:1%;">
							<div style="margin-bottom:1%;"><strong>SUCCESS MESSAGE : </strong>
							<span style="color:red">( NOTE: ##phone## in the message body will be replaced by the user\'s mobile number )</span></div>
							<textarea name="otp_success_phone" rows="4" style="width:100%;padding:2%;">'.$otp_success_phone.'</textarea><br/>
							<div style="margin-bottom:1%;"><strong>ERROR MESSAGE</strong></div>
							<textarea name="otp_error_phone" rows="4" style="width:100%;padding:2%;">'.$otp_error_phone.'</textarea><br/>
						</div>
					</td>
				</tr>
				
			</table>
	  </form>'; 

echo '
		</div>
	 </div>	';

