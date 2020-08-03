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
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));		
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

	public function addQuotes($postData = array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.transferwise.tech/v1/quotes');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		// Header Set
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;charset=utf-8'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/json'));
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->tokenCode));

		if (!empty($postData)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		}
		$response = curl_exec($ch);
		curl_close($ch);

		if (preg_match('/<p>HTTP Error 400\. The request is badly formed\.<\/p>/', $response)) {
			$response = array('Message' => 'Bad Request');
		} else {
			$response = json_decode($response, true);
		}
		return $response;
	}

	public function getQuotes($postData = array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.transferwise.tech/v1/quotes/' . $postData['quoteId']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

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

	public function addRecipientAccounts($postData = array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.transferwise.tech/v1/accounts');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		// Header Set
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->tokenCode));

		if (!empty($postData)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		}

		$response = curl_exec($ch);
		curl_close($ch);

		if (preg_match('/<p>HTTP Error 400\. The request is badly formed\.<\/p>/', $response)) {
			$response = array('Message' => 'Bad Request');
		} else {
			$response = json_decode($response, true);
		}
		return $response;
	}

	public function addRecipientAccountsxxx($postData = array())
	{
		$headers = [];
		$headers[] = "Authorization: Bearer " . $this->tokenCode;
		$headers[] = "Content-Type: application/json";
		// $input = Input::all();

		$data = [
			"otp_code" => "333000",
			// "otp_code" => $input['sent_otp'],
		];

		$curl = curl_init();

		// $payload = json_encode($postData);
		// dd($payload);
		$end_point = "https://api.sandbox.transferwise.tech/v1/accounts";
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt($curl, CURLOPT_USERPWD, $this->tokenCode . ":");
		curl_setopt($curl, CURLOPT_URL, $end_point);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		$json_resp = json_decode($result, true);
	}
}
