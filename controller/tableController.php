<?php
require_once "database.php";
session_start();

// Get Records customer Table
if (isset($_GET['name']) && $_GET['name'] == 'customersTable') {
    getTableData('customers', $link);
}

// Get Records supplier Table
if (isset($_GET['name']) && $_GET['name'] == 'suppliersTable') {
    getTableData('suppliers', $link);
}

// Get Records product Table
if (isset($_GET['name']) && $_GET['name'] == 'productsTable') {
    $sId = $_SESSION['id'];
    $sql_query = "select products.*, s.firstName, s.lastName from products left join suppliers as s on s.id = products.supplierId";

    if ($_SESSION['role'] != 'admin') {
        $sql_query .= " where s.id = '$sId'";
    }

    $columns = $_POST["search"];
    $search = strtolower($columns['value']);

    if (trim($search) != '') {
        if (!str_contains($sql_query, 'where')) {
            $sql_query .= ' where';
        }
        $sql_query .= " productName LIKE '%$search%' OR supplierId LIKE '%$search%' OR productId LIKE '%$search%' 
        OR tax LIKE '%$search%' OR discount LIKE '%$search%' OR price LIKE '%$search%'";
    }

    $totalData = mysqli_query($link, $sql_query);
    $totalCount = mysqli_num_rows($totalData);

    $sql_query .= " ORDER BY productName asc limit " . $_POST['start'] . ',' . $_POST['length'];

    $table = mysqli_query($link, $sql_query);
    $count = mysqli_num_rows($table);

    if ($count == 0) {
        echo json_encode([
            'status' => false,
            'message' => 'No Data Found 2'
        ]);
    } else {
        $data = [];
        while ($row = $table->fetch_assoc()) {
            $data[] = $row;
        }
        $customArray = [];
        $i = 1;
        foreach ($data as $key => $item) {
            $customArray[$key]['sr_no'] = $_POST['start'] + $i++;
            $customArray[$key]['product_id'] = $item['productId'];
            $customArray[$key]['productName'] = ucwords($item['productName']);
            $customArray[$key]['supplier_id'] = ucwords($item['firstName'] . ' ' . $item['lastName']);
            $customArray[$key]['price'] = '&#36;' . $item['price'];
            $customArray[$key]['tax'] = $item['tax'] . '%';
            $customArray[$key]['discount'] = $item['discount'] . '%';
        }
        echo json_encode([
            'draw' => $_POST['draw'],
            "recordsFiltered" => $totalCount,
            "recordsTotal" => $totalCount,
            'data' => $customArray
        ]);
    }
}

function getTableData($tableName, $link)
{
    if ($tableName == 'customers') {
        $id = 'customerId';
    } else if ($tableName == 'suppliers') {
        $id = 'supplierId';
    } else {
        $id = 'productId';
    }
    $sql_query = "select * from " . $tableName;

    $columns = $_POST["search"];
    $search = strtolower($columns['value']);

    if (trim($search) != '') {
        $sql_query .= " where firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR phone LIKE '%$search%' 
        OR address LIKE '%$search%' OR houseNumber LIKE '%$search%' OR gender LIKE '%$search%' OR $id LIKE '%$search%'";
    }

    $totalData = mysqli_query($link, $sql_query);
    $totalCount = mysqli_num_rows($totalData);

    $sql_query .= " ORDER BY firstName asc limit " . $_POST['start'] . ',' . $_POST['length'];

    $table = mysqli_query($link, $sql_query);
    $count = mysqli_num_rows($table);

    if ($count == 0) {
        echo json_encode([
            'status' => false,
            'message' => 'No Data Found 2'
        ]);
    } else {
        $data = [];
        while ($row = $table->fetch_assoc()) {
            $data[] = $row;
        }
        $customArray = [];
        $i = 1;
        foreach ($data as $key => $item) {
            $customArray[$key]['sr_no'] = $_POST['start'] + $i++;
            $customArray[$key]['customer_id'] = $item[$id];
            $customArray[$key]['first_name'] = ucwords($item['firstName']);
            $customArray[$key]['last_name'] = ucwords($item['lastName']);
            $customArray[$key]['gender'] = ucwords($item['gender']);
            if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $item['phone'], $matches)) {
                $customArray[$key]['phone'] = '+1 ' . $matches[1] . '-' . $matches[2] . '-' . $matches[3];
            }
            $customArray[$key]['email'] = $item['email'];
            $customArray[$key]['address'] = ucwords($item['address']);
            $customArray[$key]['house_number'] = $item['houseNumber'];
        }
        echo json_encode([
            'draw' => $_POST['draw'],
            "recordsFiltered" => $totalCount,
            "recordsTotal" => $totalCount,
            'data' => $customArray
        ]);
    }
}

// Get Records invoice Table
if (isset($_GET['name']) && $_GET['name'] == 'myInvoiceTable') {
    $cId = $_SESSION['id'];
    $sql_query = "select ih.id as invoiceId,ih.invId, c.firstName, c.lastName, ifo.total, ifo.tax, ifo.total, ifo.discount, ifo.finalAmount from customerinvoiceheader ih left join customerinvoicefooter ifo on ifo.invId = ih.id
              left join customers c on c.id = ih.customerId";

    if ($_SESSION['role'] != 'admin') {
        $sql_query .= " where c.id = '$cId'";
    }

    $columns = $_POST["search"];
    $search = strtolower($columns['value']);

    if (trim($search) != '') {
        if (!str_contains($sql_query, 'where')) {
            $sql_query .= ' where';
        } else {
            $sql_query .= ' and';
        }
        $sql_query .= " c.firstName LIKE '%$search%' OR c.lastName LIKE '%$search%' OR ih.id LIKE '%$search%'";
    }

    $totalData = mysqli_query($link, $sql_query);
    $totalCount = mysqli_num_rows($totalData);

    $sql_query .= " ORDER BY ih.created_at desc limit " . $_POST['start'] . ',' . $_POST['length'];

    $table = mysqli_query($link, $sql_query);
    $count = mysqli_num_rows($table);

    if ($count == 0) {
        echo json_encode([
            'status' => false,
            'message' => 'No Data Found 2'
        ]);
    } else {
        $data = [];
        while ($row = $table->fetch_assoc()) {
            $data[] = $row;
        }
        $customArray = [];
        $i = 1;
        foreach ($data as $key => $item) {
            $customArray[$key]['sr_no'] = $_POST['start'] + $i++;
            $customArray[$key]['inv_id'] = $item['invId'];
            $customArray[$key]['firstName'] = ucwords($item['firstName']);
            $customArray[$key]['lastName'] = ucwords($item['lastName']);
            $customArray[$key]['total'] = '&#36;' . $item['total'];
            $customArray[$key]['tax'] = '&#36;' . $item['tax'];
            $customArray[$key]['discount'] = '&#36;' . $item['discount'];
            $customArray[$key]['finalAmount'] = '&#36;' . $item['finalAmount'];
            $customArray[$key]['viewInvoice'] = '<button type="button" class="viewInvoice" data-id="' . $item['invoiceId'] . '"><i class="fas fa-eye"></i></button>';
        }
        echo json_encode([
            'draw' => $_POST['draw'],
            "recordsFiltered" => $totalCount,
            "recordsTotal" => $totalCount,
            'data' => $customArray
        ]);
    }
}

// Get Records invoice Table
if (isset($_GET['name']) && $_GET['name'] == 'supplierInvoiceTable') {
    $cId = $_SESSION['id'];
    $sql_query = "select ih.id as invoiceId,ih.invId, c.firstName, c.lastName, ifo.total, ifo.tax, ifo.total, ifo.discount, ifo.finalAmount from customerinvoiceheader ih left join customerinvoicefooter ifo on ifo.invId = ih.id
              left join customers c on c.id = ih.customerId";

//    if ($_SESSION['role'] != 'admin') {
//        $sql_query .= " where ih.supplierId = '$cId'";
//    }

    $columns = $_POST["search"];
    $search = strtolower($columns['value']);

    if (trim($search) != '') {
        if (!str_contains($sql_query, 'where')) {
            $sql_query .= ' where';
        } else {
            $sql_query .= ' and';
        }
        $sql_query .= " c.firstName LIKE '%$search%' OR c.lastName LIKE '%$search%' OR ih.id LIKE '%$search%'";
    }

    $totalData = mysqli_query($link, $sql_query);
    $totalCount = mysqli_num_rows($totalData);

    $sql_query .= " ORDER BY ih.created_at desc limit " . $_POST['start'] . ',' . $_POST['length'];

    $table = mysqli_query($link, $sql_query);
    $count = mysqli_num_rows($table);

    if ($count == 0) {
        echo json_encode([
            'status' => false,
            'message' => 'No Data Found 2'
        ]);
    } else {
        $data = [];
        while ($row = $table->fetch_assoc()) {
            $data[] = $row;
        }
        $customArray = [];
        $i = 1;
        foreach ($data as $key => $item) {
            $customArray[$key]['sr_no'] = $_POST['start'] + $i++;
            $customArray[$key]['inv_id'] = $item['invId'];
            $customArray[$key]['name'] = ucwords($item['firstName'] . '     ' . $item['lastName']);
            $customArray[$key]['total'] = '&#36;' . $item['total'];
            $customArray[$key]['tax'] = '&#36;' . $item['tax'];
            $customArray[$key]['discount'] = '&#36;' . $item['discount'];
            $customArray[$key]['finalAmount'] = '&#36;' . $item['finalAmount'];
            $customArray[$key]['viewInvoice'] = '<button type="button" class="viewInvoice" data-id="' . $item['invoiceId'] . '"><i class="fas fa-eye"></i></button>';
        }
        echo json_encode([
            'draw' => $_POST['draw'],
            "recordsFiltered" => $totalCount,
            "recordsTotal" => $totalCount,
            'data' => $customArray
        ]);
    }
}