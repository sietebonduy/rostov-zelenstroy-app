<?php
include 'db.php';
include 'index.php';

echo '<div class="container d-flex flex-column justify-content-center align-items-center">';

$year = $_POST['s'];

if ($year > 0) {
  echo '<h3>Отчет о выполнении заказов на цветочное оформление в весенне-летний период ' . $year . ' года</h3>';
}

$query = 'SELECT Contracts.id, Flowers.flower_name, Orders.flowers_quantity, Flowers.flower_price, (Orders.flowers_quantity * Flowers.flower_price * 1.35) AS "Стоимость рассады, руб.", Contracts.contract_date
FROM Contracts
JOIN Orders ON Contracts.id = Orders.contract_number
JOIN Flowers ON Orders.flower_id = Flowers.id
WHERE YEAR(Contracts.contract_date) =' . $year . ';';

$result = mysqli_query($mysqli, $query);
$summary = 0;

if (mysqli_num_rows($result) > 0) {
  $i = 0;
  $contact_number = [];
  while($row = mysqli_fetch_assoc($result)) {
    $contact_number[$i] = $row['id'];
    $i = $i + 1;
  }
} else {
  echo '<h5 class="text-danger">Данные на указанный период отсутствуют</h5>';
}

$contact_number = array_unique($contact_number);
sort($contact_number);

for ($i = 0; $i <= count($contact_number); $i++) {
  $query_id =  'SELECT Contracts.id, Flowers.flower_name, Orders.flowers_quantity, Flowers.flower_price, (Orders.flowers_quantity * Flowers.flower_price * 1.35) AS "Стоимость рассады, руб.", Contracts.contract_date
FROM Contracts
JOIN Orders ON Contracts.id = Orders.contract_number
JOIN Flowers ON Orders.flower_id = Flowers.id
WHERE Contracts.id =' . $contact_number[$i] . ' AND YEAR(Contracts.contract_date) =' . $year . ';';
  $result_id = mysqli_query($mysqli, $query_id);
  $summary_id = 0;
  if (mysqli_num_rows($result_id) > 0) {
    echo '<table class="border border-3 border-dark mt-5 w-100 text-white">
    <thead class="">
      <tr class="bg-primary">
        <th class="border-bottom border-3 border-dark p-2"><p>№</p></th>
        <th class="border-bottom border-3 border-dark p-2"><p>Название цветка</p></th>
        <th class="border-bottom border-3 border-dark p-2"><p>Количество рассады, шт.</p></th>
        <th class="border-bottom border-3 border-dark p-2"><p>Цена за 1 шт. рассады, руб.</p></th>
        <th class="border-bottom border-3 border-dark p-2"><p>Стоимость рассады, руб.</p></th>
      </tr>
    </thead>';
    $count = 0;
    while($row = mysqli_fetch_assoc($result_id)) {
          $summary_id = $summary_id + $row['Стоимость рассады, руб.'];
          $count += 1;
        echo '<tbody class="bg-secondary"><tr>';
          echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $count . '</p></td>';
          echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $row['flower_name'] . '</p></td>';
          echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $row['flower_price'] . '</p></td>';
          echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $row['flowers_quantity'] . '</p></td>';
          echo '<td class="border-bottom border-3 border-dark p-2"><p>' . $row['Стоимость рассады, руб.'] . '</p></td>';
          echo '</tr></tbody>';
    }
    echo '</table>';
    $summary = $summary + $summary_id;
    echo '<div class="w-100 mt-3 d-flex flex-column align-items-end"> Номер договора: <b>' . $contact_number[$i] . '</b>' . 'Итого по договору: <b>' . $summary_id . '</b></div>';
  }
}
if ($summary > 0) {
  echo '<h3 class="text-success"><b>Итого:</b> ' . $summary . '</h3>';
}

echo '</div>';

$mysqli->close();

?>