<?php
require_once "database.php";
session_start();

// Add Invoice
if ($_GET['name'] == 'add') {
    extract($_POST);
    print_r($_POST);
    exit();
    $invId = 'INV' . strtotime(time());
    $customerId = $_SESSION['id'];
    $query = "insert into customerinvoiceheader (invId, customerId) values('$invId', '$customerId')";
    if ($link->query($query) == FALSE) {
        echo json_encode([
            'status' => false,
            'message' => 'Insert Failed'
        ]);
    } else {
        echo json_encode([
            'status' => true,
            'message' => 'Invoice Records Inserted'
        ]);
    }
}