<?php

namespace App\Http\Controllers\Api\Transferwise;

class Transferwise_API
{

	private $tokenCode = '';

	public function __construct(String $tokenCode)
	{
		$this->tokenCode = $tokenCode;
	}

	public function getProfileData()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.transferwise.tech/v1/profiles');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		// Header Set
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->tokenCode));

		$response = curl_exec($ch);
		curl_close($ch);
		if (preg_match('/<p>HTTP Error 400\. The request is badly formed\.<\/p>/', $response)) {
			$response = array('Message' => 'Bad Request');
		} else {
			$response = json_decode($response, true);
		}
		return $response;
	}
}
