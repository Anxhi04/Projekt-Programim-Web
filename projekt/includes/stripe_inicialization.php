<?php
require_once __DIR__ . '/../../vendor/autoload.php';


$private_key = "sk_test_51Ss29zIqDX9aL0Ri39idYJJ9Onyen4rbrYMDMAYlk3O3CIjkhvqwAWPuw8EbkOYlSCgYd1ObYkVQ5z7Vkti19JZJ00mUehwWb8";
$public_key = "pk_test_51Ss29zIqDX9aL0RiX1aqtMHsDF6bsDRmevPlhrWgEvasUnav0dD74UGKj8Z8IHaIDB1ARODX9xJS1gxxG2VJUqA000aQEeiwna";
$stripe_account = "Test";
$businessName = "Test";
$company_name = "Test";

/**
 * Inicializimi i Stripe
 */
\Stripe\Stripe::setApiKey($private_key);

$stripe = new \Stripe\StripeClient($private_key);