<?php

$sms_template_guide_url = $moUtility->micv() ? 'smsTemplate.jpg' : 'smsTemplateOb.jpg';
$sms_gateway_guide_url = $moUtility->micv() ? 'smsGateway.jpg' : 'smsGatewayOb.jpg';
$email_template_guide_url = $moUtility->micv() ? 'emailTemplate.jpg' : 'emailTemplateOb.jpg';
$email_gateway_guide_url = $moUtility->micv() ? 'emailGateway.jpg' : 'emailGatewayOb.jpg';
$hidden			   = $moUtility->micv() ? '' : "hidden"; 

include $dirOTPName . 'views/configuration.php';