<?php
include 'db.php';
include 'index.php';

$table = $_POST['table'];

if ($table == "Contracts") {
  $query = "SELECT Customers.customer_name, Contracts.contract_date, Contracts.completion_date FROM Contracts JOIN Customers ON Contracts.customer_id = Customers.id;";
} elseif ($table == "Flowers") {
  $query = "SELECT Flowers.flower_name, Flowers.flower_price, Suppliers.supplier_name FROM Flowers JOIN Suppliers ON Flowers.supplier_id = Suppliers.id;";
} elseif ($table == "Orders") {
  $query = "SELECT Orders.contract_number, Flowers.flower_name, Orders.flowers_quantity FROM Orders JOIN Flowers ON Orders.flower_id = Flowers.id;";
} else {
  $query = "SELECT * FROM " . $table . ";";
}

$result_head = mysqli_query($mysqli, $query);
$fields = [];
$data = ['table' => $table];

$i = 0;
while ($row = mysqli_fetch_assoc($result_head)) {
  foreach( $row as $field => $value) {
    $fields[$i] = $field;
    $i = $i + 1;
  }
}

$fields = array_unique($fields);

echo '<div class="container d-flex flex-column justify-content-center align-items-center">';
echo '<div class="w-100 row d-flex flex-column justify-content-center align-items-center">';
// value="'.$table.' name="table"
echo '<form class="col-6 border border-3 border-success-subtle rounded p-3" action="add.php" method="post">';
echo '<h3 class="mb-3 text-success">Таблица: ' . $table . '</h3>';

foreach ($fields as $value) {
  if ($value == "id" || $value == "isDeleted") {
    continue;
  } elseif ($value == "customer_name" && $table == "Contracts") {
    echo '<label for="' . $value . '" class="form-label">'. $value .'</label>';
    echo '</br><select name="' . $value . '" class="w-100 bg-white border border-1 rounded mb-3 p-2">';
    $query_item = 'SELECT ' . $value . ' FROM Customers ORDER BY ' . $value . ';';
    $result_item = mysqli_query($mysqli, $query_item);
    while ($row = mysqli_fetch_assoc($result_item)) {
      echo '<option value="'. $row[$value] .'">'. $row[$value] .'</option>';
    }
    echo '</select>';
    continue;
  } elseif ($value == "supplier_name" && $table == "Flowers") {
    echo '<label name="' . $value . '" class="form-label">'. $value .'</label>';
    echo '</br><select name="' . $value . '" class="w-100 bg-white border border-1 rounded mb-3 p-2">';
    $query_item = 'SELECT ' . $value . ' FROM Suppliers ORDER BY ' . $value . ';';
    $result_item = mysqli_query($mysqli, $query_item);
    while ($row = mysqli_fetch_assoc($result_item)) {
      echo '<option value="'. $row[$value] .'">'. $row[$value] .'</option>';
    }
    echo '</select>';
    continue;
  } elseif ($value == "flower_name" && $table == "Orders") {
    echo '<label name="' . $value . '" class="form-label">'. $value .'</label>';
    echo '</br><select name="' . $value . '" class="w-100 bg-white border border-1 rounded mb-3 p-2">';
    $query_item = 'SELECT ' . $value . ' FROM Flowers ORDER BY ' . $value . ';';
    $result_item = mysqli_query($mysqli, $query_item);
    while ($row = mysqli_fetch_assoc($result_item)) {
      echo '<option value="'. $row[$value] .'">'. $row[$value] .'</option>';
    }
    echo '</select>';
    continue;
  } elseif ($value == "contract_number" && $table == "Orders") {
    echo '<label name="' . $value . '" class="form-label">'. $value .'</label>';
    echo '</br><select name="' . $value . '" class="w-100 bg-white border border-1 rounded mb-3 p-2">';
    $query_item = 'SELECT id FROM Contracts ORDER BY id;';
    $result_item = mysqli_query($mysqli, $query_item);
    while ($row = mysqli_fetch_assoc($result_item)) {
      echo '<option value="'. $row['id'] .'">'. $row['id'] .'</option>';
    }
    echo '</select>';
    continue;
  }
  
  echo '<div class="mb-3">';
  echo '<label for="' . $value . '" class="form-label">'. $value .'</label>';
  echo '<input name=' . $value . ' type="text" class="form-control" id="Input">';
  echo '</div>';
}
?>
<button type="submit" name="table" value="<?php echo $table; ?>" class="w-25 btn btn-success mt-3">Создать поле</button>
</form></div></div>



