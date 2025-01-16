<?php
include_once 'connections.php';
session_start();
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $transactions = "SELECT * FROM orders WHERE username = '$username'";
    $showQuery = mysqli_query($connection, $transactions);

    if (!isset($_SESSION['status_delivery'])) {
        while ($date = mysqli_fetch_assoc($showQuery)) {
            if ($date['delivery_date'] > date('Y-m-d')) {
                // $_SESSION['status_delivery'] = 'delivery';
                // $_SESSION['delivery'] = 'You have an order pending to be delivered.';
                break;
            } elseif ($date['delivery_date'] <= date('Y-m-d')) {
                $_SESSION['status_delivery'] = 'delivered';
                $_SESSION['delivered'] = "Your order is on its way to your registered address. Please wait for the delivery rider to contact you.
                <br/> <br/> If you have concern or inquiries please don't hesitate to contact us at +63947-252-1135.
                <br/> <br/>Thank you for your support and patience, have a great day ahead!";
                break;
            }
        }
    }
}