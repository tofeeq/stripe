# stripe
Stripe payment gateway using stripejs and stripe-php api

pay.html contains credit card form and stripe.js integration to send credit card info to stripe and getting token back.
Token is then appeneded to form and form is submitted to charge.php to request a charge for specific amount.
Note: no credit card fields are sent to charge.php
