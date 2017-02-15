<?php
require 'vendor/autoload.php';

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("your stripe api key");

// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:

$post = $_POST;
//you can sanitize $post here i.e sanitize($post)

$token = $post['stripeToken'];
// Charge the user's card:

//verify amount here by getting the id of the product
$productId = $post['product_id'];
$amount = $post['amount'];
$productDescription = "test product";

$amount = $amount * 100; //Stripe expects amounts in cents/pence

try {

	$charge = \Stripe\Charge::create(array(
		"amount" => $amount,
		"currency" => "usd",
		"description" => $productDescription,
		"source" => $token,
	));

	//print_r($charge);

	if ($charge) {

		if ($charge->status == 'succeeded') {
			//store info in orders table along with customer info
			/*
				if charge successful save as orders in orders table with following
				Product Id
				Date
				Amount
			*/
		}
	}

} catch (Exception $e) {
	echo $e->getMessage();
}