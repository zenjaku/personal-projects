<?php
require_once '../connections.php'; // Include your database connection file

if (isset($_POST['cname'])) {
    $cname = $_POST['cname'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT cname FROM computer WHERE cname = ?");
    $stmt->bind_param("s", $cname);
    $stmt->execute();
    $stmt->store_result();

    // Check if cname exists
    if ($stmt->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['exists' => false]);
}
?>