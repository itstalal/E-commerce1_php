<?php


// require_once __DIR__ . "/vendor/autoload.php";

// $secret_api_key = "sk_test_51PduPCEtsW6rqURCqj3exz7NgMvy1ebARLecL83AYhwCvQNcvO1Rbu5SRmDaQwosQjnBGNlFAyVO25G0dmCc0ZqC00FIk2msOS";

// \Stripe\Stripe::setApiKey($secret_api_key);

// $stripe_session = $checkout_session = \Stripe\Checkout\Session::create([
// 'mode' => 'payment',
// 'success_url' => "http://localhost:8080/PROJET_FINAL_PHP/src/scroll_animation/success.php",
// 'line_items' => [
// [
// 'quantity' => 2,
// "price_data" => [
// 'currency' => 'cad',
// 'unit_amount' => 5000,
// 'product_data' =>[
// "name" =>" Cours d'Analyse Mathematiques"
// ]
// ]
// ],
// [
// 'quantity' => 1,
// "price_data" => [
// 'currency' => 'cad',
// 'unit_amount' => 3000,
// 'product_data' =>[
// "name" =>"Cours d'Algebre Mathematiques"
// ]
// ]
// ]
// ]
// ]);
/*
= \Stripe\Checkout\Session::create([

"line_items" => [

"quantity" => 2,
"unit_amount" => 50 * 100,
"price_data" =>[
"currency" => "cad",
"product_data" => [
"name" => "Cours d'Analyse Mathematiques",
]
],
],

"mode" => "payment",
"success_url" => "http://localhost:8080/ETE2024/COURS/stripePhp/success.php"
]);*/


// http_response_code(302);
// header("Location: " . $stripe_session->url);
echo "hi";
?>