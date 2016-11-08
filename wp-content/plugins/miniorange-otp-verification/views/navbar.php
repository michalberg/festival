<?php
	global $moUtility;
	echo'	<div class="wrap"><h1>OTP Verification &nbsp;</h1></div>';
			
			//check_is_curl_installed();
	
	echo'	<div id="tab">
				<h2 class="nav-tab-wrapper">';
	
		
	echo '			<a class="nav-tab '.($active_tab == 'account'  ? 'nav-tab-active' : '').'" href="'.$profile_url	.'">Account</a>
					<a class="nav-tab '.($active_tab == 'settings' ? 'nav-tab-active' : '').'" href="'.$settings	.'">Settings</a>
					<a class="nav-tab '.($active_tab == 'config'   ? 'nav-tab-active' : '').'" href="'.$config		.'">SMS/Email Templates</a>
					<a class="nav-tab '.($active_tab == 'messages' ? 'nav-tab-active' : '').'" href="'.$messages	.'">Messages</a>
					<a class="nav-tab '.($active_tab == 'pricing'  ? 'nav-tab-active' : '').'" href="'.$license_url	.'">Licensing Plans</a>
					<a class="nav-tab '.($active_tab == 'help'	   ? 'nav-tab-active' : '').'" href="'.$help_url	.'">Help & Troubleshooting</a>
				</h2>
			</div>';
			
	if(!$moUtility->mo_check_empty_or_null(get_option('mo_customer_validation_transaction_message'))) { 
			echo	'<div  class="error notice is-dismissible mo_registration_error_container"><p style="font-size: 14px;">'.get_option(			     	"mo_customer_validation_transaction_message").'</p>
					</div>';
	 } 