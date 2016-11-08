<?php

	global $dirOTPName;
	
	if(empty($email))
		$email 		= $current_user->user_email;
	
	include $dirOTPName . 'views/support.php';