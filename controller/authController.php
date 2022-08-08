<?php
require_once "database.php";
session_start();

// Check if email exists for signup
if (isset($_GET['name']) && $_GET['name'] == 'check_exists_email') {
    $email = $_GET["email"];

    // Prepare a select statement
    $sql_query = "select email from admin where email = '$email' UNION select email from customers where email = '$email'  
UNION select email from suppliers where email = '$email' ";
    $result = mysqli_query($link, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }
}

// Check if phone exists for signup
if (isset($_GET['name']) && $_GET['name'] == 'check_exists_mobile') {
    $phone = $_GET["phone"];
    // Prepare a select statement
    $sql_query = "select * from admin where phone = '$phone' UNION select * from customers where phone = '$phone'  
UNION select * from suppliers where phone = '$phone' ";
    $result = mysqli_query($link, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }
}

function getDataFromTable($link, $table, $email, $password)
{
    $sql_query = "select * from $table where email='$email' AND password='$password'";
//    echo $sql_query;
    return mysqli_query($link, $sql_query);
}

// Check Whether Given Credentials for login is valid or invalid
if ($_GET['name'] == 'login') {
    $email = $_POST["newEmail"];
    $password = $_POST["password"];
    $password = base64_encode($password);
    $table = 'admin';
    $queryResult = getDataFromTable($link, $table, $email, $password);
    $count = mysqli_num_rows($queryResult);
    if ($count == 0) {
        $table = 'customers';
        $queryResult = getDataFromTable($link, $table, $email, $password);
        $count = mysqli_num_rows($queryResult);
        if ($count == 0) {
            $table = 'suppliers';
            $queryResult = getDataFromTable($link, $table, $email, $password);
            $count = mysqli_num_rows($queryResult);
            if ($count == 0) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Please enter valid credentials'
                ]);
            } else {
                setDataToSession($queryResult, $table);
            }
        } else {
            setDataToSession($queryResult, $table);
        }
    } else {
        setDataToSession($queryResult, $table);
    }
}

function setDataToSession($table, $tableName)
{
    $row = mysqli_fetch_assoc($table);
    $_SESSION["loggedIn"] = true;
    $_SESSION["id"] = $row['id'];
    $_SESSION["firstName"] = $row['firstName'];
    $_SESSION["lastName"] = $row['lastName'];
    $_SESSION["role"] = $tableName;
    echo json_encode([
        'status' => true,
        'message' => 'Logged in successfully'
    ]);
}

// Signup User
if ($_GET['name'] == 'signup') {
    $email = $_POST["email"];
    $name = $_POST["tName"];
    $phone = $_POST["phone"];
    $subjectId = $_POST["subjectId"];
    $teacherId = $_POST["teacherId"];
    $password = $_POST["password"];
    $hash = base64_encode($password);
    $query = "insert into users (name, subjectId, teacherId, role, email, phone, password) 
            values('$name','$subjectId','$teacherId','t', '$email', '$phone', '$hash')";
    if ($link->query($query) == FALSE) {
        echo json_encode([
            'status' => false,
            'message' => 'Failed to add user please try again'
        ]);
    } else {
        echo json_encode([
            'status' => true,
            'message' => 'Signed Up Successfully'
        ]);
    }
}