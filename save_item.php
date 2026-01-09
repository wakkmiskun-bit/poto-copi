<?php
include 'db.php';
if(isset($_POST['name'])){
    $name = $_POST['name'];
    $cat  = $_POST['category'];
    $price = $_POST['price'];
    $icon = $_POST['icon_or_img'];

    $sql = "INSERT INTO items (name, category, price, icon_or_img) VALUES ('$name', '$cat', '$price', '$icon')";
    if(mysqli_query($conn, $sql)){
        header("Location: admin.php");
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>