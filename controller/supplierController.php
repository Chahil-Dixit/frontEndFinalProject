<?php
require_once "database.php";
session_start();

// Signup User
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
            'message' => 'Supplier Records Inserted'
        ]);
    }
}

// Get All Supplier Names
if ($_GET['name'] == 'viewAllName') {
    $sql_query = "select id, firstName, lastName from suppliers order by firstName asc";

    $totalData = mysqli_query($link, $sql_query);
    $totalCount = mysqli_num_rows($totalData);
    if ($totalCount == 0) {
        echo json_encode([
            'status' => false,
            'message' => 'No Data Found'
        ]);
    } else {
        $data = [];
        while ($row = $totalData->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }
}