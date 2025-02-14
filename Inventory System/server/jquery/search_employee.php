<?php
// session_start();
require_once "../connections.php"; // Adjust path if needed

function searchEmployee($query, $conn)
{
    $stmt = $conn->prepare("
        SELECT e.employee_id, e.fname, e.lname
        FROM employee e
        WHERE 
            (
                (SELECT a.status 
                 FROM allocation a
                 WHERE a.employee_id = e.employee_id
                 ORDER BY a.created_at DESC
                 LIMIT 1) = 0
                OR NOT EXISTS (
                    SELECT 1 
                    FROM allocation a
                    WHERE a.employee_id = e.employee_id
                )
            )
            AND (e.employee_id = ? OR e.fname = ? OR e.lname = ?)
        ORDER BY e.employee_id
    ");

    $stmt->bind_param("sss", $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $employees = [];

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    echo json_encode($employees);
}

function searchOriginalEmployee($query, $conn)
{
    $stmt = $conn->prepare("
        SELECT e.employee_id, e.fname, e.lname
        FROM employee e
        LEFT JOIN allocation a ON e.employee_id = a.employee_id
        WHERE 
            (
                (
                    a.created_at = (
                        SELECT MAX(a2.created_at)
                        FROM allocation a2
                        WHERE a2.employee_id = e.employee_id
                    )
                    AND a.status = 1
                ) 
                OR a.employee_id IS NULL
            )
            AND (e.employee_id = ? OR e.fname = ? OR e.lname = ?)
        ORDER BY e.employee_id
    ");

    $stmt->bind_param("sss", $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $employees = [];

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    echo json_encode($employees);
}

function searchTransferEmployee($query, $conn)
{
    $stmt = $conn->prepare("
        SELECT e.employee_id, e.fname, e.lname
        FROM employee e
        WHERE 
            (
                (SELECT a.status 
                FROM allocation a
                WHERE a.employee_id = e.employee_id
                ORDER BY a.created_at DESC
                LIMIT 1) = 0
                OR NOT EXISTS (
                    SELECT 1 
                    FROM allocation a
                    WHERE a.employee_id = e.employee_id
                )
            )
            AND (e.employee_id = ? OR e.fname = ? OR e.lname = ?)
        ORDER BY e.employee_id
    ");

    $stmt->bind_param("sss", $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $employees = [];

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    echo json_encode($employees);
}

// Handle Requests
if (isset($_POST['searchQuery'])) {
    searchEmployee(trim($_POST['searchQuery']), $conn);
} elseif (isset($_POST['originalQuery'])) {
    searchOriginalEmployee(trim($_POST['originalQuery']), $conn);
} elseif (isset($_POST['transferQuery'])) {
    searchTransferEmployee(trim($_POST['transferQuery']), $conn);
}
?>