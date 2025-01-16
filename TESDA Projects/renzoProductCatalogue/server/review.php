<?php
include_once 'connections.php';
session_start();

if (isset($_POST['submit-review'])) {
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $productId = $_POST['productId'];
    $username = $_SESSION['username'];

    $reviewId = date('Ymd') . '-' . $username . rand(100, 999);

    $review = "INSERT INTO review (reviewId, username, rate, reviews, productId) 
               VALUES ('$reviewId', '$username', '$rating', '$review', '$productId')";

    $reviewQuery = mysqli_query($connection, $review);

    if ($reviewQuery) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Review posted.';
        echo "<script>window.location.href = '../pages/order-page.php?productId=$productId'</script>";
        exit();
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to submit the review, please try again later.';
        echo "<script>window.location.href = '../pages/order-page.php?productId=$productId'</script>";
        exit();
    }
}
