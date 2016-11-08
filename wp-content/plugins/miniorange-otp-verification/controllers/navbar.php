<?php
	
	global $moUtility,$dirOTPName;
	
	$registered 	= $moUtility->micr();
	$profile_url	= add_query_arg( array('page' => 'account'	), $_SERVER['REQUEST_URI'] );
	$settings		= add_query_arg( array('page' => 'settings'	), $_SERVER['REQUEST_URI'] );
	$messages		= add_query_arg( array('page' => 'messages'	), $_SERVER['REQUEST_URI'] );
	$help_url		= add_query_arg( array('page' => 'help'		), $_SERVER['REQUEST_URI'] );
	$license_url	= add_query_arg( array('page' => 'pricing'	), $_SERVER['REQUEST_URI'] );
	$config			= add_query_arg( array('page' => 'config'	), $_SERVER['REQUEST_URI'] );
	
	$active_tab 	= $_GET['page'];
	
	include $dirOTPName . 'views/navbar.php';