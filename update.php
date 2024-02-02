<?php
include 'db.php';
include 'index.php';

$table = $_POST["table"];
$id = $_POST["id"];

  if ($table == "Contracts") {
    $customer_name = $_POST['customer_name'];
    $contract_date = date("Y-m-d H:i:s", strtotime($_POST['contract_date']));
    $completion_date = date("Y-m-d H:i:s", strtotime($_POST['completion_date']));

    $query = "UPDATE Contracts SET 
    customer_id = (SELECT id FROM Customers WHERE customer_name='$customer_name'),
    contract_date = '$contract_date',
    completion_date = '$completion_date'
    WHERE id = $id";

  } elseif ($table == "Customers") {
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];
    $phone_number = $_POST['phone_number'];

    $query = "UPDATE Customers SET 
                customer_name = '$customer_name',
                customer_address = '$customer_address',
                phone_number = '$phone_number'
              WHERE id = $id";
    
  } elseif ($table == "Flowers") {
    $flower_name = $_POST["flower_name"];
    $flower_price = $_POST["flower_price"];
    $supplier_name = $_POST["supplier_name"];

    $query = "UPDATE Flowers SET 
                flower_name = '$flower_name',
                supplier_id = (SELECT id FROM Suppliers WHERE supplier_name='$supplier_name'),
                flower_price = ".intval($flower_price)."
              WHERE id = $id";

  } elseif ($table == "Orders") {
    $contract_number = $_POST["contract_number"];
    $flower_name = $_POST["flower_name"];
    $flowers_quantity = $_POST["flowers_quantity"];

    $query = "UPDATE Orders SET 
                contract_number = ".intval($contract_number).",
                flower_id = (SELECT id FROM Flowers WHERE flower_name='$flower_name'),
                flowers_quantity = ".intval($flowers_quantity)."
              WHERE id = $id";

  } elseif ($table == "Suppliers") {
    $supplier_name = $_POST["supplier_name"];
    $suppliers_address = $_POST["suppliers_address"];

    $query = "UPDATE Suppliers SET 
                supplier_name = '$supplier_name',
                suppliers_address = '$suppliers_address'
              WHERE id = $id";
  }
  

  if ($mysqli->query($query) === TRUE) {
    header("location: read.php?table=".$table."");
  } else {
    echo "Ошибка: " . $mysqli->error;
  }