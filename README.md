# Stripe payment gateway integration using stripe.js and stripe-php api
Stripe payments using ajax or simple request

## Ajax method
pay_ajax.html is the ajax based implementation of stripe 

## Simple method
pay.html is the simple implementation of stripe 

## How it works
pay.html or pay_ajax.html contains credit card form and stripe.js integration to send credit card info to stripe and getting token back.
Token is then appeneded to form and form is submitted to charge.php to request a charge for specific amount.

> **Note: no credit card fields are sent to charge.php**

## How to use

* Download or pull the code.
* Put your stripe publishable key in pay.html or pay_ajax.html 

```javascript
Stripe.setPublishableKey('pk_test_xxxxxxxxxxxxxxxxx');
```

* Put your stripe secret key in charge.php

```php
\Stripe\Stripe::setApiKey("sk_test_xxxxxxxxxxxxxxxx");
```
