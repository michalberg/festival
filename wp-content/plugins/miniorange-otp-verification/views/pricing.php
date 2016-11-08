<?php

echo' <div class="mo_registration_pricing_layout" style="width:'.$width.'">';

is_customer_registered();

echo'<table class="mo_registration_pricing_table">
		<h2>LICENSING PLANS
			<span style="float:right">
				<input type="button" '.$disabled.' name="check_btn" id="check_btn" class="button button-primary button-large" value="Check License"/>
				<input type="button" name="ok_btn" id="ok_btn" class="button button-primary button-large" value="OK, Got It" onclick="window.location.href=\''.$settings.'\'" />
			</span>
		<h2>
		<hr>
		<tr style="vertical-align:top;">';

			if(!$plan)
			{
	echo'		<td>
					<div class="mo_registration_thumbnail mo_registration_pricing_free_tab" >
						<h3 class="mo_registration_pricing_header">'.$free_plan_name.'</h3>
						<h4 class="mo_registration_pricing_sub_header">( You are automatically on this plan )<br/><br/></h4>
						<hr>
						<!--<p class="mo_registration_pricing_text">For 1 site - Forever</p><hr>-->
						<p  style="margin-bottom: 31.6%;" class="mo_registration_pricing_text">$0 - One Time Payment<br/><br/>( 10 SMS and 10 Email Transactions )<br/><br/><br/></p>
						<hr>
						<p class="mo_registration_pricing_text">Features:</p>
						<p class="mo_registration_pricing_text" >';

							foreach($free_plan_features as $feature)
								echo $feature . '<br/>';
	echo'
						</p>
						<hr>
						<p class="mo_registration_pricing_text">Basic Support by Email</p>
					</div>
				</td>';
			}
	
echo'		<td>
				<div class="mo_registration_thumbnail mo_registration_pricing_paid_tab">
					<h3 class="mo_registration_pricing_header">'.$basic_plan_name.'</h3>
						<h4 class="mo_registration_pricing_sub_header">';
						if($vl)
	echo'						<input type="button" style="margin-bottom:3.8%;" '.$disabled.' class="button button-primary button-large" onclick="mo2f_upgradeform(\'email_verification_upgrade_instances_plan\')" value="Buy More Insatnces"></input>
						</h4>';
						else
							echo'<input type="button" style="margin-bottom:3.8%;" '.$disabled.' class="button button-primary button-large" onclick="mo2f_upgradeform(\'wp_email_verification_intranet_basic_plan\')" value="Upgrade Now"></input></h4>';

echo'				<hr>
					<!--<p class="mo_registration_pricing_text">For 1+ site</p><hr>-->
					<p style="margin-bottom: 31.6%;" class="mo_registration_pricing_text"><b>'.$basic_plan_price.'</b><br/><br/>
						  ( Unlimited SMS and Email )<br/><br/><br/>
					</p>
					<hr>
					<p class="mo_registration_pricing_text">Features:</p>
					<p class="mo_registration_pricing_text" >';

							foreach($basic_plan_features as $feature)
								echo $feature . '<br/>';
echo'
						</p>
					<hr>
					<p class="mo_registration_pricing_text">Premium Support Plans</p>
				</div>
			</td>
		</td>
		<td><div class="mo_registration_thumbnail mo_registration_pricing_free_tab">
				<h3 class="mo_registration_pricing_header">'.$premium_plan_name.'</h3>
				<h4 class="mo_registration_pricing_sub_header">';
						if(strcmp($plan,MoConstants::PCODE)!=0 && strcmp($plan,MoConstants::BCODE)!=0 && strcmp($plan,MoConstants::CCODE)!=0)
	echo'						<input type="button" style="margin-bottom:3.8%;"  '.$disabled.' class="button button-primary button-large" onclick="mo2f_upgradeform(\'wp_otp_verification_basic_plan\')" value="Upgrade Now"></input>';
						else
	echo'						<input type="button" style="margin-bottom:3.8%;"  '.$disabled.' class="button button-primary button-large" onclick="mo2f_upgradeform(\'otp_recharge_plan\')" value="Recharge"></input>';

echo' 			</h4>
				<hr>
				<!--<p class="mo_registration_pricing_text">For 1+ site, Setup and Custom Work</p><hr>-->
				<p  class="mo_registration_pricing_text"><b>'.$premium_plan_price.'</b><br/>+
					  <select class="mo-form-control">
					    <option>&nbsp;&nbsp;&nbsp;&nbsp;$10 per 100 SMS / Email*</option>
						<option>&nbsp;&nbsp;&nbsp;$35 per 500 SMS / Email*</option>
						<option>&nbsp;&nbsp;&nbsp;$50 per 1k SMS / Email*</option>
						<option>&nbsp;&nbsp;&nbsp;$100 per 5k SMS / Email*</option>
						<option>&nbsp;&nbsp;&nbsp;$150 per 10k SMS / Email*</option>
						 <option>&nbsp;&nbsp;&nbsp;$750 per 50k SMS / Email*</option>
					  </select>
					    <br>( Does not include SMS delivery prices** )<br/>( You can refill at anytime )<br/>( Lifetime validity )<br/><br><br/>
				</p>
				</p>
				<hr>
				<p class="mo_registration_pricing_text">Features:</p>
				<p class="mo_registration_pricing_text" >';

						foreach($premium_plan_features as $feature)
							echo $feature . '<br/>';
echo'
						</p><hr>
				<p class="mo_registration_pricing_text">Premium Support Plans</p>
			</div></td>
		</td>
		</tr>

		</table>
		<br>
		<div id="disclaimer" style="margin-bottom:15px;">
			<span style="font-size:15px;">
				<b>SMS gateway</b> is a service provider for sending SMS on your behalf to your users.<br>
				<b>SMTP gateway</b> is a service provider for sending Emails on your behalf to your users.<br><br>
				*Transaction prices may very depending on country. If you want to use more than 50k transactions, mail us at <a href="mailto:info@miniorange.com"><b>info@miniorange.com</b></a> or submit a support request using the support form under User <a href="'.$profile_url.'">Profile tab</a>.<br/><br/>
				**If you want to <b>use miniorange SMS/SMTP gateway</b>, and your country is not in list, mail us at <a href="mailto:info@miniorange.com"><b>info@miniorange.com</b></a> or submit a support request using the support form under User <a href="'.$profile_url.'">Profile tab</a>. We will get back to you promptly.<br><br>
				***<b>Custom integration charges</b> will be applied for supporting a registration form which is not already supported by our plugin. Each request will be handled on a per case basis.<br>
				
				

			</span>
		</div>

		<h3>10 Days Return Policy -</h3>
		<p>At miniOrange, we want to ensure you are 100% happy with your purchase.  If the premium plugin you purchased is not working as advertised and youâ€™ve attempted to resolve any feature issues with our support team, which couldn\'t get resolved. We will refund the whole amount within 10 days of the purchase. Please email us at <a href="mailto:info@miniorange.com">info@miniorange.com</a> for any queries regarding the return policy.<br>
If you have any doubts regarding the licensing plans, you can mail us at <a href="mailto:'.MoConstants::SUPPORT_EMAIL.'">'.MoConstants::SUPPORT_EMAIL.'</a> or submit a query using the support form.</p>
		<br>

		</div>

	 <form style="display:none;" id="mocf_loginform" action="'.$form_action.'" target="_blank" method="post">
		<input type="email" name="username" value="'.$email.'" />
		<input type="text" name="redirectUrl" value="'.$redirect_url.'" />
		<input type="text" name="requestOrigin" id="requestOrigin"  />
	</form>
	<form id="mo_ln_form" style="display:none;" action="" method="post">
		<input type="hidden" name="option" value="check_mo_ln" />
	</form>
	<script>
		function mo2f_upgradeform(planType){
			jQuery("#requestOrigin").val(planType);
			jQuery("#mocf_loginform").submit();
		}

	</script>';