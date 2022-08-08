<?php
require_once "database.php";
session_start();

// Add Invoice
if ($_GET['name'] == 'add') {
    foreach ($_POST as &$value) {
        $value = strtolower($value);
    }
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $customerId = time();
    $phone = preg_replace('/[^0-9]/', "", $phone);
    $email = $_POST["email"];
    $address = $_POST["address"];
    $houseNumber = $_POST["houseNumber"];
    $password = $_POST["password"];
    $hash = base64_encode($password);
    $query = "insert into customers (customerId, firstName, lastName, gender, phone, email, address, houseNumber, password)
 values('$customerId', '$firstName','$lastName','$gender',$phone, '$email', '$address','$houseNumber','$hash')";
    if ($link->query($query) == FALSE) {
        echo json_encode([
            'status' => false,
            'message' => 'Insert Failed'
        ]);
    } else {
        echo json_encode([
            'status' => true,
            'message' => 'Customer Records Inserted'
        ]);
    }
}