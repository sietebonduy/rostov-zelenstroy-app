<?php
include 'db.php';
include 'index.php';

$table = $_POST["table"];
// echo '<div>';
// if ($table == '') {
//   echo "no";
// } else {
//   echo ''.$table.'';
// }
echo '</div>';

  if ($table == "Contracts") {
    $customer_name = $_POST['customer_name'];
    $contract_date = date("Y-m-d H:i:s", strtotime($_POST['contract_date']));
    $completion_date = date("Y-m-d H:i:s", strtotime($_POST['completion_date']));

    $query = "INSERT INTO Contracts (customer_id, contract_date, completion_date) VALUES (
        (SELECT id FROM Customers WHERE customer_name='$customer_name'),
        '$contract_date',
        '$completion_date'
    )";


  } elseif ($table == "Customers") {
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];
    $phone_number = $_POST['phone_number'];

    echo $customer_name;

    $query = "INSERT INTO Customers (id, customer_name, customer_address, phone_number) VALUES (
      NULL,
      '$customer_name',
      '$customer_address',
      '$phone_number'
    )";

  } elseif ($table == "Flowers") {
    $flower_name = $_POST["flower_name"];
    $flower_price = $_POST["flower_price"];
    $supplier_name = $_POST["supplier_name"];

    $query = "INSERT INTO Flowers (id, flower_name, supplier_id, flower_price) VALUES (
      NULL,
      '$flower_name',
      (SELECT id FROM Suppliers WHERE supplier_name='$supplier_name'),
      ".intval($flower_price)."
    )";
  } elseif ($table == "Orders") {
    $contract_number = $_POST["contract_number"];
    $flower_name = $_POST["flower_name"];
    $flowers_quantity = $_POST["flowers_quantity"];

    $query = "INSERT INTO Orders (contract_number, flower_id, flowers_quantity) VALUES ("
      .intval($contract_number).",
      (SELECT id FROM Flowers WHERE flower_name='$flower_name'),
      ".intval($flowers_quantity)."
    )";
  } elseif ($table == "Suppliers") {
    $supplier_name = $_POST["supplier_name"];
    $suppliers_address = $_POST["suppliers_address"];

    $query = "INSERT INTO Suppliers (id, supplier_name, suppliers_address) VALUES (
      NULL,
      '$supplier_name',
      '$suppliers_address'
    )";
  }
  

  if ($mysqli->query($query) === TRUE) {
    header("location: read.php?table=".$table."");
  } else {
    echo "Ошибка: " . $mysqli->error;
  }