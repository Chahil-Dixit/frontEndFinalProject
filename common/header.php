<?php
require_once 'controller/database.php';
session_start();
if (!isset($_SESSION["loggedIn"])) {
    header('Location:login.php', true);
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SuperStore Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>css/jquery.dataTables.css">
    <link href="<?php echo $baseUrl ?>css/toastr.min.css" rel="stylesheet"/>
    <link href="<?php echo $baseUrl ?>css/style.css" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        const role = '<?php echo $_SESSION['role']; ?>';
        const base_url = '<?php echo $baseUrl; ?>';
    </script>
    <style>
        .container {
            height: 80vh;
        }
    </style>
</head>
<body class="vw-100 overflow-hidden">
<div class="loading">Loading&#8230;</div>
<nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
    <a class="navbar-brand text-white" href="#">Super Store</a>
    <a class="nav-link float-lg-end logoutLink text-white" href="<?php echo $baseUrl ?>logout.php"
       onclick="return confirm('Are you sure, you want to logout?')">
        Log Out
    </a>
</nav>

<ul class="sidebar">
    <!--    <li>-->
    <!--        <a class="text-decoration-none" href="index.php">Dashboard</a>-->
    <!--    </li>-->
    <?php if ($_SESSION['role'] === 'admin') { ?>
        <li>
            <a class="text-decoration-none" href="customerView.php">Customers</a>
        </li>
        <li>
            <a class="text-decoration-none" href="supplierView.php">Suppliers</a>
        </li>
    <?php }
    if ($_SESSION['role'] === 'suppliers' || $_SESSION['role'] === 'admin') {
        ?>
        <li>
            <a class="text-decoration-none" href="productView.php">Product</a>
        </li>
    <?php } ?>
    <li>
        <a class="text-decoration-none" href="myInvoiceView.php">
            <?php echo(($_SESSION['role'] === 'suppliers' || $_SESSION['role'] === 'admin') ? 'Customer' : 'My'); ?>
            Invoices
        </a>
    </li>
    <?php if ($_SESSION['role'] === 'suppliers' || $_SESSION['role'] === 'admin') { ?>
        <li>
            <a class="text-decoration-none" href="supplierInvoice.php">Suppliers Invoice</a>
        </li>
    <?php }
    if ($_SESSION['role'] !== 'admin') { ?>
        <li>
            <a class="text-decoration-none" href="#" data-toggle="modal" data-target="#purchaseModal">Purchase</a>
        </li>
    <?php } ?>
</ul>