<?php
require_once '../connections.php'; // Include your database connection file

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Prepare and execute the query to check if the Employee ID exists
    $stmt = $conn->prepare("SELECT employee_id FROM employee WHERE employee_id = ?");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if the Employee ID exists in the database
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
