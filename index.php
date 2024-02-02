<?php 
include 'db.php';

session_start();

if (
  !isset($_SESSION['id']) && isset($_COOKIE['id']) &&
  !isset($_SESSION['username']) && isset($_COOKIE['username']) &&
  !isset($_SESSION['email']) && isset($_COOKIE['email']) &&
  !isset($_SESSION['role']) && isset($_COOKIE['role']) &&
  !isset($_SESSION['count']) && isset($_COOKIE['count']) &&
  !isset($_SESSION['last_visit']) && isset($_COOKIE['last_visit'])
  ) {
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['email'] = $_COOKIE['email'];
    $_SESSION['role'] = $_COOKIE['role'];
    $_SESSION['count'] = $_COOKIE['count'];
    $_SESSION['last_visit'] = $_COOKIE['last_visit'];
}

$id = $_SESSION['id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$count = $_SESSION['count'];
$last_visit = $_SESSION['last_visit'];

if ($username == null) {
  header('Location: login.php');
  exit();
} elseif ($role == 'operator') {
  if ($count == 0) {
    $message = 'Добро пожаловать!';
  } else {
    $message = "Добро пожаловать! Вы зашли в " . ($count + 1). " раз. Дата последнего входа: " . $last_visit;
  }
}

$count += 1;
$query = "UPDATE Users SET count = $count, last_visit = now() WHERE id = $id";
$result = $mysqli->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Login</title>
</head>
<body class="bg-light w-100 h-100">
  <div class="d-flex justify-content-end gap-2 mt-2 mx-3">
    <?php 
      if ($role == 'admin') {
        ?> 
          <form action="applications.php">
            <input class="btn btn-success" type="submit" value="Заявки">
          </form>
        <?php
      }
    ?>
    <form action="login.php">
      <input class="btn btn-danger" type="submit" value="Выход из аккаунта">
    </form>
  </div>
  <div class="container d-flex flex-column justify-content-center align-items-center my-5">
  <div class="row gap-5">
  <?php
    if (isset($message)) {
      echo "<h4 class='text-primary'>$message</h4>";
    }
    if ($role == 'operator' || $role == 'admin') {
      ?> 
      <div class="col">
        <h3>Ведомость</h3>
          <form action="form.php" method="post">
          <div class="d-flex gap-1">
            <select name="s" id="">
              <option value="">Выберите год</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
            </select>
            <input type="submit" value="Сформировать ведомость">
          </form>
        </div>
      </div>
      <?php
    }
    if ($role == 'admin') {
      ?>
      <div class="col">
        <h3>Просмотр таблиц:</h3>
        <form action="read.php" method="get">
          <div class="d-flex gap-1">
            <select name="table" id="">
              <option>Выберите таблицу</option> 
              <option value="Contracts">Constacts</option>
              <option value="Customers">Customers</option>
              <option value="Flowers">Flowers</option>
              <option value="Orders">Orders</option>
              <option value="Suppliers">Suppliers</option>
            </select>
            <input type="submit" value="Показать таблицу">
          </div>
        </form>
      </div>
      <?php
    }
    if ($role == 'guest') { 
      ?>
      <div class="container d-flex flex-column justify-content-center align-items-center">
        <h3 class="mb-5">Ростовзеленстрой</h3>
        <!-- ... -->
      </div>
      <?php
    }
  ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>