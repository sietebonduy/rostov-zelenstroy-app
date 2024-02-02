<?php
include 'db.php';
include 'index.php';

$table = $_POST["table"];
$id = $_POST["id_delete"];

$query = "UPDATE $table SET 
isDeleted = 1
WHERE id = $id";

if ($mysqli->query($query) === TRUE) {
  header("location: read.php?table=".$table."");
} else {
  echo "Ошибка: " . $mysqli->error;
}
?>