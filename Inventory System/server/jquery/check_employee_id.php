<?php
// session_start(); // Make sure to start the session
require_once '../connections.php';

if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    $stmt = $conn->prepare("SELECT employee_id FROM employee WHERE employee_id = ?");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $stmt->store_result();

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
