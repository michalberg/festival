<?php


//ninja form
$ninja_form_enabled		  = get_option('mo_customer_validation_ninja_form_enable') ? "checked" : "";
$ninja_form_hidden		  = $ninja_form_enabled== "checked" ? "" : "hidden";
$ninja_form_enabled_type  = get_option('mo_customer_validation_ninja_form_enable_type');
$ninja_form_list 		  = admin_url().'admin.php?page=ninja-forms';
$ninja_form_otp_enabled   = maybe_unserialize(get_option('mo_customer_validation_ninja_form_otp_enabled'));

include $dirOTPName . 'views/forms/ninja-forms.php';