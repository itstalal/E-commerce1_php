<?php
session_start();
require '../../db/fonction.php';
include './navbar.php';

if (!isset($_SESSION['utilisateur'])) {
    header('Location: CONNEXION.php');
    exit();
}

// Get the order ID from the query string
$orderID = isset($_GET['orderID']) ? $_GET['orderID'] : null;

if (!$orderID) {
    // Handle error: Order ID not provided
    echo "Error: Order ID not provided.";
    exit();
}

// Retrieve the order details from PayPal API
$orderDetails = getOrderDetailsFromPayPal($orderID);

if (!$orderDetails) {
    // Handle error: Unable to retrieve order details
    echo "Error: Unable to retrieve order details.";
    exit();
}

// Validate the order details (e.g., check the amount, currency, etc.)
$expectedAmount = calculateExpectedAmount(); // Implement this function to calculate the expected amount
if ($orderDetails['purchase_units'][0]['amount']['value'] != $expectedAmount) {
    // Handle error: Amount mismatch
    echo "Error: Amount mismatch.";
    exit();
}

// Save the order to the database
if (saveOrderToDatabase($orderDetails)) {
   echo "valid!";
   
} else {
    echo "Error: Unable to save the order.";
}
?>