<?php
require_once "database.php";
session_start();

// Add Invoice
if ($_GET['name'] == 'add') {
    extract($_POST);
    $invId = 'INV' . time();
    if ($_SESSION['role'] === 'customers') {
        $tableInitial = 'customer';
    } else {
        $tableInitial = 'supplier';
    }
    $customerId = $_SESSION['id'];
    $query = "insert into " . $tableInitial . "invoiceheader (invId, customerId) values('$invId', '$customerId')";
    if (!$link->query($query)) {
        echo json_encode([
            'status' => false,
            'message' => 'Insert Failed'
        ]);
    } else {
        $headerId = $link->insert_id;
        $query = "insert into " . $tableInitial . "invoicefooter (invId, total, tax, discount, finalAmount) 
                values('$headerId', '$total', '$tax', '$discount', '$finalTotal')";

        if (!$link->query($query)) {
            $link->query("delete from " . $tableInitial . "invoiceheader where id = '$headerId'");
            echo json_encode([
                'status' => false,
                'message' => 'Insert Failed'
            ]);
        } else {
            $insertArr = [];
            foreach ($qty as $key => $item) {
                $supplierId = '';
                $sql = "select supplierId from products where id = '$product[$key]'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $supplierId = $row['supplierId'];
                    }
                }

                $query = "insert into " . $tableInitial . "invoicebody (invId, supplierId, productId, qty) 
                            values('$headerId', '$supplierId', '$product[$key]', '$item')";
                if ($supplierId === '' || !$link->query($query)) {
                    $link->query("delete from " . $tableInitial . "invoicebody where invId = '$headerId'");
                    $link->query("delete from " . $tableInitial . "invoicefooter where id = '$footerId'");
                    echo json_encode([
                        'status' => false,
                        'message' => 'Insert Failed'
                    ]);
                    break;
                }
            }
            echo json_encode([
                'status' => true,
                'message' => 'Invoice Records Inserted'
            ]);
        }
    }
}

// View Invoice
if ($_GET['name'] == 'view') {
    extract($_POST);
    if ($_SESSION['role'] === 'customers' || $_SESSION['role'] === 'admin') {
        $tableInitial = 'customer';
    } else {
        $tableInitial = 'supplier';
    }
    $sql_query = "select ih.invId as invoiceId,ih.created_at, c.firstName, c.lastName, c.phone, ifo.total, ifo.tax, ifo.total, ifo.discount, ifo.finalAmount from " . $tableInitial . "invoiceheader ih left join " . $tableInitial . "invoicefooter ifo on ifo.invId = ih.id
              left join customers c on c.id = ih.customerId where ih.id='$invId'";
    $table = mysqli_query($link, $sql_query);
    $count = mysqli_num_rows($table);

    if ($count == 0) {
        echo json_encode([
            'status' => false,
            'message' => 'No Data Found'
        ]);
    } else {
        $data = [];
        while ($row = $table->fetch_assoc()) {
            $data[] = $row;
        }
        $customArray = [];
        $i = 1;
        foreach ($data as $key => $item) {
            $customArray['inv_id'] = $item['invoiceId'];
            $customArray['firstName'] = ucwords($item['firstName']);
            $customArray['lastName'] = ucwords($item['lastName']);
            $customArray['total'] = '&#36;' . number_format((float)$item['total'], 2, '.', '');
            $customArray['tax'] = '&#36;' . number_format((float)$item['tax'], 2, '.', '');
            $customArray['discount'] = '&#36;' . number_format((float)$item['discount'], 2, '.', '');
            $customArray['finalAmount'] = '&#36;' . number_format((float)$item['finalAmount'], 2, '.', '');

            $customArray['header'] = '<table></table>';

            $sql_query = "select ib.qty, p.productName, p.price, s.firstName, s.lastName from " . $tableInitial . "invoicebody ib left join products p on p.id = ib.productId left join suppliers s on s.id = p.supplierId where ib.invId='$invId'";
            $table = mysqli_query($link, $sql_query);
            $count = mysqli_num_rows($table);

            if ($count == 0) {
                echo json_encode([
                    'status' => false,
                    'message' => 'No Data Found'
                ]);
                return;
            } else {
                $pData = [];
                while ($row = $table->fetch_assoc()) {
                    $pData[] = $row;
                }
                $customArray['products'] = '
                    <h2 class="text-center">Super Store</h2>
                    <table class="table table-responsive table-borderless">
                        <tr>
                            <td colspan="3" class="w-100 float-end">Customer Name</td>
                            <td class="w-100 float-end">' . ucwords($item['firstName'] . ' ' . $item['lastName']) . '</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="w-100 float-end">Invoice Id</td>
                            <td class="w-100 float-end">' . '&#36;' . $item['invoiceId'] . '</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="w-100 float-end">Customer Phone</td>
                            <td class="w-100 float-end">' . $item['phone'] . '</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="w-100 float-end">Date</td>
                            <td class="w-100 float-end">' . date('d M Y h:m:s A', strtotime($item['created_at'])) . '</td>
                        </tr>
                    </table>
                    <h4>Product Details</h4>
                    <table class="table table-bordered table-responsive-lg">
                        <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Supplier Name</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>';
                foreach ($pData as $key => $pDatum) {
                    $customArray['products'] .= '<tr>
                                <td>' . ++$key . '</td>
                                <td>' . $pDatum['productName'] . '</td>
                                <td>' . ucwords($pDatum['firstName'] . ' ' . $pDatum['lastName']) . '</td>
                                <td>' . $pDatum['qty'] . '</td>
                                <td>' . $pDatum['qty'] * $pDatum['price'] . '</td>
                            </tr>';
                }
                $customArray['products'] .= '</tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4">Total</td>
                        <td>' . '&nbsp;&nbsp;&nbsp;&#36;' . number_format((float)$item['total'], 2, '.', '') . '</td>
                    </tr>
                    <tr>
                        <td colspan="4">Discount</td>
                        <td class="text-success">' . '-&nbsp;&#36;' . number_format((float)$item['discount'], 2, '.', '') . '</td>
                    </tr>
                    <tr>
                        <td colspan="4">Tax</td>
                        <td>' . '&nbsp;&nbsp;&nbsp;&#36;' . number_format((float)$item['tax'], 2, '.', '') . '</td>
                    </tr>
                    <tr>
                        <td colspan="4">Grand Total</td>
                        <td>' . '&nbsp;&nbsp;&nbsp;&#36;' . number_format((float)$item['finalAmount'], 2, '.', '') . '</td>
                    </tr>
                    </tfoot>
                </table>';
            }
        }
        echo json_encode([
            'status' => true,
            'data' => $customArray
        ]);
    }
}