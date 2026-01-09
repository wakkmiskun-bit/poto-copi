<?php
include 'db.php';
header('Content-Type: application/json');

if(isset($_POST['name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $item = mysqli_real_escape_string($conn, $_POST['item']);

    $q = "INSERT INTO orders (customer_name, customer_phone, item_name) VALUES ('$name', '$phone', '$item')";
    
    if(mysqli_query($conn, $q)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>