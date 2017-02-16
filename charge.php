<?php

require 'vendor/autoload.php';

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys

//Provide your secret key here 
\Stripe\Stripe::setApiKey("sk_test_xxxxxxxxxxxxxxxx");

// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form

//Read JSON from request
$inputJSON = file_get_contents('php://input');

//convert JSON into PHP array
$post = json_decode($inputJSON, TRUE);

//if no valid json found, try it using post/get 
if (!$post) {
	parse_str($inputJSON, $post);
}

//sentize posted data i.e senitize($post);

//Read token 
$errors = [];

if (empty($post['stripe_token'])) {
	$errors[] = "Stripe token missing";
} else {
	$token = $post['stripe_token'];
}

if (empty($post['amount'])) {
	$errors[] = "Amount missing";
} else {
	$amount = $post['amount'];
}

if (empty($post['product_id'])) {
	$errors[] = "Product id missing";
} else {
	$productId = $post['product_id'];
}

if (empty($post['description'])) {
	$errors[] = "Product description missing";
} else {
	$description = $post['description'];
}

if (isset($post['currency'])) {
	$currency = $post['currency']; //usd 
} else {
	$currency = 'usd'; 
}


$response = null;

if (!empty($errors)) {
	
	$response = json_encode(['errors' => $errors]);

} else {



	$amount = $amount * 100; //Stripe expects amounts in cents/pence

	try {

	    $info = array(
			"amount" => $amount,
			"currency" => $currency,
			"description" => $description,
			"source" => $token
		);
		
		 
		
		$charge = \Stripe\Charge::create($info);

		//print_r($charge);


		if ($charge->status == 'succeeded') {

			//verify amount here by getting the id of the product

			/*
				if charge successful save as orders in orders table with following
			*/
			//store info in orders table along with customer info
			$response = json_encode([
					'msg'				=> 'Charge successful',
					'amount'			=> ($charge->amount / 100), //again convert amount to usd from pence :D
					'status'			=> $charge->status,
					'transaction_id'	=> $charge->id,
					'captured'			=> $charge->captured,
					'created'			=> $charge->created,
					'currency'			=> $charge->currency,
					'description'		=> $charge->description,
					'paid'				=> $charge->paid
				]);
		} else {
			$response = json_encode([
					'errors' => ['Charge failed', $e->getMessage()]
				]);
		}

	} catch (Exception $e) {
		//print_r($charge);
		$response = json_encode([
				'errors' => $e->getMessage()
			]);
	}
}

echo $response;