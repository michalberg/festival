<?php

class MoMessages
{
	const OTP_SENT_PHONE 	= 'A OTP (One Time Passcode) has been sent to <strong>##phone##</strong> . Please enter the OTP in the field below to verify your phone.';
	const OTP_SENT_EMAIL 	= 'A One Time Passcode has been sent to <b>##email##</b>. Please enter the OTP below to verify your Email Address. If you cannot see the email in your inbox, make sure to check your SPAM folder.';
	const ERROR_OTP_EMAIL  	= "There was an error in sending the OTP. Please enter a valid email id or contact site Admin.";
	const ERROR_OTP_PHONE  	= "There was an error in sending the OTP to the given Phone Number. Please Try Again or contact site Admin.";
}
new MoMessages;