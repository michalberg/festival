<?php

echo'							<input type="checkbox" '.$disabled.' id="ninja_form" class="app_enable" data-toggle="ninja_form_options" name="mo_customer_validation_ninja_form_enable" value="1"
										'.$ninja_form_enabled.' /><strong>Ninja Forms [Form POST]</strong>';
										
									get_plugin_form_link(MoConstants::NINJA_FORMS_LINK);								 
																	
echo'							<div class="mo_registration_help_desc" '.$ninja_form_hidden.' id="ninja_form_options">
									<p><input type="radio" '.$disabled.' id="ninja_form_email" class="app_enable" data-toggle="ninja_form_email_instructions" name="mo_customer_validation_ninja_form_enable_type" value="mo_ninja_form_email_enable"
										'.( $ninja_form_enabled_type == "mo_ninja_form_email_enable" ? "checked" : "").' /><strong>Enable Email verification</strong>
									</p>
									<div '.($ninja_form_enabled_type != "mo_ninja_form_email_enable" ? "hidden" :"").' class="mo_registration_help_desc" id="ninja_form_email_instructions" >
											Follow the following steps to enable Email Verification for Ninja Form: 
											<ol>
												<li><a href="'.$ninja_form_list.'" target="_blank">Click Here</a> to see your list of forms.</li>
												<li>Click on the <b>Edit</b> option of your ninja form.</li>
												<li>Add an Email Field to your form. Note the Field ID of the email field.</li>
												<li>Enter your Form ID and the Email Field ID below:<br>
													<br/>Add Form : <input type="button"  value="+" '. $disabled .' onclick="add_form(\'email\',1);" class="button button-primary" />&nbsp;
													<input type="button" value="-" '. $disabled .' onclick="remove_form(1);" class="button button-primary" /><br/><br/>';
													
													$form_results = get_nf_form_list($ninja_form_otp_enabled,$disabled,1); 
													$counter1 	  =  isset($form_results['counter']) ? max($form_results['counter']-1,0) : 0 ;

echo'											</li>
												<li>Click on the Save Button below to save your settings</li>
											</ol>
									</div>
									<p><input type="radio" '.$disabled.' id="ninja_form_phone" class="app_enable" data-toggle="ninja_form_phone_instructions" name="mo_customer_validation_ninja_form_enable_type" value="mo_ninja_form_phone_enable"
										'.( $ninja_form_enabled_type == "mo_ninja_form_phone_enable" ? "checked" : "").' /><strong>Enable Phone verification</strong>
									</p>
									<div '.($ninja_form_enabled_type != "mo_ninja_form_phone_enable" ? "hidden" : "").' class="mo_registration_help_desc" id="ninja_form_phone_instructions" >
											Follow the following steps to enable Phone Verification for Ninja Form: 
											<ol>
												<li><a href="'.$ninja_form_list.'" target="_blank">Click Here</a> to see your list of forms.</li>
												<li>Click on the <b>Edit</b> option of your ninja form.</li>
												<li>Add an Phone Field to your form. Note the Field ID of the phone field.</li>
												<li>Enter your Form ID and the Phone Field ID below:<br>
													<br/>Add Form : <input type="button"  value="+" '. $disabled .' onclick="add_form(\'phone\',2);" class="button button-primary" />&nbsp;
													<input type="button" value="-" '. $disabled .' onclick="remove_form(2);" class="button button-primary" /><br/><br/>';
													
													$form_results = get_nf_form_list($ninja_form_otp_enabled,$disabled,2); 
													$counter2 	  =  isset($form_results['counter']) ? max($form_results['counter']-1,0) : 0 ;
echo'											</li>
												<li>Click on the Save Button below to save your settings</li>
											</ol>
									</div>
									<p><input type="radio" '.$disabled.' id="ninja_form_both" class="app_enable" data-toggle="ninja_form_both_instructions" name="mo_customer_validation_ninja_form_enable_type" value="mo_ninja_form_both_enable"
										'.( $ninja_form_enabled_type == "mo_ninja_form_both_enable" ? "checked" : "").' /><strong>Let the user Choose</strong>';

										mo_form_additional_info(21,null,false);

echo								'</p>
									<div '.($ninja_form_enabled_type != "mo_ninja_form_both_enable" ? "hidden" : "").' class="mo_registration_help_desc" id="ninja_form_both_instructions" >
											Follow the following steps to enable Phone Verification for Ninja Form: 
											<ol>
												<li><a href="'.$ninja_form_list.'" target="_blank">Click Here</a> to see your list of forms.</li>
												<li>Click on the <b>Edit</b> option of your ninja form.</li>
												<li>Add an Email and Phone Field to your form. Note the Field ID of the fields.</li>
												<li>Enter your Form ID, EMail Field ID and Phone Field ID below:<br>
													<br/>Add Form : <input type="button"  value="+" '. $disabled .' onclick="add_form(\'both\',3);" class="button button-primary" />&nbsp;
													<input type="button" value="-" '. $disabled .' onclick="remove_form(3);" class="button button-primary" /><br/><br/>';
													
													$form_results = get_nf_form_list($ninja_form_otp_enabled,$disabled,3); 
													$counter3	  =  isset($form_results['counter']) ? max($form_results['counter']-1,0) : 0 ;
echo'											</li>
												<li>Click on the Save Button below to save your settings</li>
											</ol>
									</div>
								</div>';

echo 						'<script>
								var count1, count2, count3;
								function add_form(t,n){
									var countIdpAttr = this["count"+n];
									var hidden1="",hidden2="",space="";
									if(n==1)
										hidden2 = "hidden";
									if(n==2)
										hidden1 = "hidden";
									if(n!=3)
										space = "&nbsp;";
									countIdpAttr += 1;
									var sel = "<div id=\'row"+n+"_"+countIdpAttr+"\'> Form ID: <input id=\'ninja_form"+countIdpAttr+"\' class=\'field_data\' name=\'ninja_form[form][]\' type=\'text\' value=\'\'/> <span "+hidden1+" >&nbsp;Email Field ID: <input id=\'ninja_form_email"+countIdpAttr+"\'  class=\'field_data\' name=\'ninja_form[emailkey][]\' type=\'text\' value=\'\'></span> <span "+hidden2+">"+space+"Phone Field ID: <input id=\'ninja_form_phone"+countIdpAttr+"\' class=\'field_data\' name=\'ninja_form[phonekey][]\' type=\'text\' value=\'\'></span></div>"
									if(countIdpAttr!=0)
										$(sel).insertAfter($(\'#row\'+n+\'_\'+(countIdpAttr-1)+\'\'));
									this["count"+n]=countIdpAttr;
								}
								function remove_form(n){
									var countIdpAttr =  this["count"+n];
									if(countIdpAttr != 0){
										$("#row"+n+"_" + countIdpAttr).remove();
										countIdpAttr -= 1;
										this["count"+n]=countIdpAttr;
									}
								}
								jQuery(document).ready(function(){  count1 = '. $counter1 .'; count2 = ' .$counter2. '; count3 = ' .$counter3. ' });
							</script>';


