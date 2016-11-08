<?php

class MocURLOTP
{
	
	public static function create_customer($email, $company, $password, $phone = '', $first_name = '', $last_name = '')
	{
		$url = MoConstants::HOSTNAME . '/moas/rest/customer/add';
		$fields = array (
				'companyName' 	 => $company,
				'areaOfInterest' => MoConstants::AREA_OF_INTEREST,
				'firstname' 	 => $first_name,
				'lastname' 		 => $last_name,
				'email' 		 => $email,
				'phone' 		 => $phone,
				'password' 		 => $password
		);
		$json = json_encode($fields);
		$response = self::callAPI($url, $json);
		return $response;
	}
	
	
	function get_customer_key($email, $password) {
		$url 	= MoConstants::HOSTNAME. "/moas/rest/customer/key";
		$fields = array (
					'email' 	=> $email,
					'password'  => $password
				);
		$json = json_encode($fields);
		$response = self::callAPI($url, $json);
		return $response;
	}
	
	function check_customer($email)
	{
		$url 	= MoConstants::HOSTNAME . "/moas/rest/customer/check-if-exists";
		$fields = array(
					'email' 	=> $email,
				);
		$json     = json_encode($fields);
		$response = self::callAPI($url, $json);
		return $response;
	}
	
	function mo_send_otp_token($auth_type,$email='',$phone='')
	{
		global $moUtility;
		$url 		 = MoConstants::HOSTNAME . '/moas/api/auth/challenge';
		$customerKey = get_option('mo_customer_validation_admin_customer_key');
		$apiKey		 =  get_option('mo_customer_validation_admin_api_key');
		
		if($moUtility->mo_check_empty_or_null($customerKey))
			$customerKey = MoConstants::DEFAULT_CUSTOMER_KEY;
		
		if($moUtility->mo_check_empty_or_null($apiKey))
			$apiKey 	 = MoConstants::DEFAULT_API_KEY;
		
		$fields  	 = array(
							'customerKey' 	  => $customerKey,
							'email' 	  	  => $email,
							'phone' 	  	  => $phone,
							'authType' 	  	  => $auth_type,
							'transactionName' => MoConstants::AREA_OF_INTEREST
						);
		$json 		 = json_encode($fields);
		$authHeader  = $this->createAuthHeader($customerKey,$apiKey);
		$response 	 = self::callAPI($url, $json, $authHeader);
		return $response;
	}
	
	function validate_otp_token($transactionId,$otpToken)
	{
		$url 		 = MoConstants::HOSTNAME . '/moas/api/auth/validate';
		$customerKey = MoConstants::DEFAULT_CUSTOMER_KEY;
		$apiKey 	 = MoConstants::DEFAULT_API_KEY;

		$fields 	 = array(
						'txId'  => $transactionId,
						'token' => $otpToken,
					 );

		$json 		 = json_encode($fields);
		$authHeader  = $this->createAuthHeader($customerKey,$apiKey);
		$response    = self::callAPI($url, $json, $authHeader);
		return $response;
	}
	
	function submit_contact_us(  $q_email, $q_phone, $query  )
	{
		$current_user = wp_get_current_user();
		$url    = MoConstants::HOSTNAME . "/moas/rest/customer/contact-us";
		$query  = '['.MoConstants::AREA_OF_INTEREST.']: ' . $query;
		$fields = array(
					'firstName'	=> $current_user->user_firstname,
					'lastName'	=> $current_user->user_lastname,
					'company' 	=> $_SERVER['SERVER_NAME'],
					'email' 	=> $q_email,
					'phone'		=> $q_phone,
					'query'		=> $query
				);
		$field_string = json_encode( $fields );
		$response = self::callAPI($url, $field_string);
		return true;
	}
	
	function forgot_password($email)
	{
		$url 		 = MoConstants::HOSTNAME . '/moas/rest/customer/password-reset';
		$customerKey = get_option('mo_customer_validation_admin_customer_key');
		$apiKey 	 = get_option('mo_customer_validation_admin_api_key');
		
		$fields 	 = array(
				'email' => $email
		);
		
		$json 		 = json_encode($fields);
		$authHeader  = $this->createAuthHeader($customerKey,$apiKey);
		$response    = self::callAPI($url, $json, $authHeader);
		return $response;
	}
	
	
	function check_customer_ln($customerKey,$apiKey){
	
		$url = MoConstants::HOSTNAME . '/moas/rest/customer/license';
		$fields = array(
				'customerId' => $customerKey,
				'applicationName' => MoConstants::APPLICATION_NAME
		);
	
		$json 		 = json_encode($fields);
		$authHeader  = $this->createAuthHeader($customerKey,$apiKey);
		$response    = self::callAPI($url, $json, $authHeader);
		return $response;
	}
	
	
	function send_sms_token($message,$phone)
	{
		$url 		= get_option('mo_user_sms_gateway');
		$message 	= str_replace(" ","+",$message);
		$url 		= str_replace("##message##"	,$message	,$url);
		$url 		= str_replace("##phone##"	,$phone		,$url);
		$response 	= self::callAPI($url,null,null);
		return $response;
	}
	
	function send_email_token($message,$email)
	{
		//update_option('mo_otp_send_phpemail',1);
		$from_mail 	= MoConstants::FROM_EMAIL;
		$subject 	= MoConstants::SUBJECT;
		$headers 	= "From:".$from_mail." \n";
		$headers   .= MoConstants::HEADER_CONTENT_TYPE;
		$content 	= $message;
		if((ini_get('SMTP')!= FALSE)  ||(ini_get('smtp_port') != FALSE))
			$response = wp_mail($email,$subject,$content,$headers);
		else
			$response = false;
		return $response;
	}
	
	
	private static function createAuthHeader($customerKey, $apiKey)
	{
		$currentTimestampInMillis = round(microtime(true) * 1000);
		$currentTimestampInMillis = number_format($currentTimestampInMillis, 0, '', '');
	
		$stringToHash = $customerKey . $currentTimestampInMillis . $apiKey;
		$authHeader = hash("sha512", $stringToHash);
	
		$header = array (
				"Content-Type: application/json",
				"Customer-Key: $customerKey",
				"Timestamp: $currentTimestampInMillis",
				"Authorization: $authHeader"
		);
		return $header;
	}
	
	
	private static function callAPI($url, $json_string, $headers = array("Content-Type: application/json"))
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // required for https urls
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		if(!is_null($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		if(!is_null($json_string)) curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
		$content = curl_exec($ch);
	
		if (curl_errno($ch)) {
			echo 'Request Error:' . curl_error($ch);
			exit();
		}
	
		curl_close($ch);
		return $content;
	}
	
	
}