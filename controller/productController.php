<?php
require_once "database.php";
session_start();

// Signup User
if ($_GET['name'] == 'add') {
    foreach ($_POST as &$value) {
        $value = strtolower($value);
    }
    $productName = $_POST["productName"];
    $supplierId = $_POST["supplierId"];
    $tax = $_POST["tax"];
    $discount = $_POST["discount"];
    $productId = time();
    $price = $_POST["price"];
    $query = "insert into products (productId, productName, supplierId, tax, discount, price)
            values('$productId', '$productName','$supplierId','$tax',$discount, '$price')";
    if ($link->query($query) == FALSE) {
        echo json_encode([
            'status' => false,
            'message' => 'Insert Failed'
        ]);
    } else {
        echo json_encode([
            'status' => true,
            'message' => 'Product Records Inserted'
        ]);
    }
}

// Get All Supplier Names
if ($_GET['name'] == 'showAll') {
    $sql_query = "select id, productName, tax, discount, price from products ORDER BY productName asc";

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
            $row['productName'] =  ucwords($row['productName']);
            $data[] = $row;
        }
        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }
}