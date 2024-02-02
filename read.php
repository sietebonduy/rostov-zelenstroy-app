<?php
  include 'db.php';
  include 'index.php';

  echo '<div class="container d-flex flex-column justify-content-center align-items-center">';

  $table = $_GET['table'];

  if (empty($table))  {
    echo '<h3 class="text-danger">Данной таблицы нет в базе данных!!!</h3>';
  }
  
  if ($table == "Contracts") {
    $query = "SELECT Contracts.id, Customers.customer_name, Contracts.contract_date, Contracts.completion_date, Contracts.isDeleted FROM Contracts JOIN Customers ON Contracts.customer_id = Customers.id ORDER BY Contracts.id DESC;";
  } elseif ($table == "Flowers") {
    $query = "SELECT Flowers.id, Flowers.flower_name, Flowers.flower_price, Suppliers.supplier_name, Flowers.isDeleted FROM Flowers JOIN Suppliers ON Flowers.supplier_id = Suppliers.id ORDER BY Flowers.id DESC;";
  } elseif ($table == "Orders") {
    $query = "SELECT Orders.id, Orders.contract_number, Customers.customer_name, Flowers.flower_name, Orders.flowers_quantity, Orders.isDeleted FROM Orders JOIN Flowers ON Orders.flower_id = Flowers.id JOIN Contracts ON Contracts.id = Orders.contract_number JOIN Customers ON Customers.id = Contracts.customer_id ORDER BY Orders.id DESC;";
  } else {
    $query = "SELECT * FROM " . $table . " ORDER BY " . $table . ".id DESC;";
  }

  $result_head = mysqli_query($mysqli, $query);
  $result_body = mysqli_query($mysqli, $query);
  $fields = [];

  if (mysqli_num_rows($result_head) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result_head)) {
      foreach( $row as $field => $value) {
        $fields[$i] = $field;
        $i = $i + 1;
      }
    }
  } else {
    echo '<h5 class="text-danger">В таблице нет полей!!!</h5>';
  }

  $fields = array_unique($fields);

  if (mysqli_num_rows($result_body) > 0) {
      echo '<h1>Таблица: ' . $table . '</h1>';
      echo '<form action="create.php" method="post" class="align-self-start"><button class="btn btn-primary" name="table" value="' . $table . '">Добавить запись в таблицу</button></form>';
      echo '<table class="border border-3 border-dark mt-5 w-100 text-white">
      <thead class=""><tr class="bg-primary">';
      foreach ($fields as $value) {
        if ($value == "id" || $value == "isDeleted") {
          continue;
        }
        echo '<th class="border-bottom border-3 border-dark p-2"><p>'. $value .'</p></th>';
      }
      echo '<th class="border-bottom border-3 border-dark p-2"><p>edit</p></th>';
      echo '<th class="border-bottom border-3 border-dark p-2"><p>delete</p></th>';
      echo '</tr></thead><tbody class="bg-secondary">';

      while($row = mysqli_fetch_assoc($result_body)) {
        if ($row["isDeleted"] == 1) { continue; }
        
        echo '<tr>';
        foreach ($fields as $value) {
          if ($value == "id" || $value == "isDeleted") {
            if ($value == "id") { $id = $row["id"]; }
            continue;
          }
          // if ($table == 'Orders' && $value == 'customer_id') {
          //   $customer_id = $row['customer_id'];
          //   $query = "SELECT customer_name From Customers WHERE id = $customer_id";
          //   $result_cus_id = mysqli_query($mysqli, $query);
          //   $row = mysqli_fetch_assoc($result_item);
          //   if (mysqli_num_rows($result_cus_id) > 0) {
          //     $cus_id = mysqli_fetch_assoc($result_cus_id);
          //     echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $cus_id . '</p></td>';
          //   }
          // }

          echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $row[$value] . '</p></td>';
        }
        echo '<td class="border-bottom border-3 border-dark p-2"><form action="edit.php" method="get"><input type="hidden" name="id" value="' . $id . '"><button name="table" value="' . $table . '" class="w-100 h-100 btn btn-secondary border border-0"><p class="p-0 m-0"><svg width="50px" height="100px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="#00000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></p></button></form></td>';
        echo '<td class="border-bottom border-3 border-dark p-2"><form action="delete.php" method="post"><input type="hidden" name="id_delete" value="' . $id . '"><button name="table" value="' . $table . '"  class="w-100 h-100 btn btn-secondary border border-0"><p class="p-0 m-0"><svg width="60px" height="100px" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000"><g id="SVGRepo_bgCarrier" stroke-width="0" transform="translate(0,0), scale(1)"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.24000000000000005"></g><g id="SVGRepo_iconCarrier"> <path d="M10 12V17" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 12V17" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></p></button></form></td>';
        echo '</tr>';
      }
  
      echo '</tbody></table>';
  }
?>