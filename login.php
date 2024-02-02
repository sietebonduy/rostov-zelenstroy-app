<?php 
include 'db.php';
session_start();

$errorMessage = '';
$id = 0;
$recaptcha = $_POST['g-recaptcha-response']; 

if (!isset($_SESSION['captcha_attempts'])) {
  $_SESSION['captcha_attempts'] = 0;
}

function Login($username, $email, $password, $remember) {
  global $mysqli;
  global $errorMessage;
  global $id;

  $query = "SELECT * FROM Users WHERE email = '$email'";
  $result = $mysqli->query($query);
  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row["id"];
    $hashed_password = $row['password'];
    $role = $row['role'];
    $count = $row['count'];
    $last_visit = $row['last_visit'];

    if (password_verify($password, $hashed_password)) {
      $_SESSION['id'] = $id;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $password;
      $_SESSION['role'] = $role;
      $_SESSION['count'] = $count;
      $_SESSION['last_visit'] = $last_visit;
      $_SESSION['token'] = bin2hex(random_bytes(16));
      if ($remember) {
        setcookie('id', $_SESSION['id'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('username', $_SESSION['username'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('email', $_SESSION['email'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('password', $_SESSION['password'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('role', $_SESSION['role'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('count', $_SESSION['count'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('last_visit', $_SESSION['last_visit'], time() + (30 * 24 * 60 * 60), '/');
        setcookie('token', $_SESSION['token'], time() + (30 * 24 * 60 * 60), '/');
      }
      return true;
    } else {
      $errorMessage = "Неверный пароль!";
    }
  } else {
    $errorMessage = "Неверный email!";
  }
  return false;
}


function Logout() { 
  setcookie('id', '', time() - 1); setcookie('username', '', time() - 1);
  setcookie('email', '', time() - 1); setcookie('password', '', time() - 1);
  setcookie('role', '', time() - 1); setcookie('count', '', time() - 1);
  setcookie('last_visit', '', time() - 1); setcookie('token', '', time() - 1);
  unset($_SESSION['id']); unset($_SESSION['username']);
  unset($_SESSION['email']); unset($_SESSION['password']);
  unset($_SESSION['role']); unset($_SESSION['count']);
  unset($_SESSION['last_visit']); unset($_SESSION['token']);
}

// if (isset($_COOKIE)) {
//   $enter_site = Login($_COOKIE['username'], $_COOKIE['email'], $_COOKIE['password'], $_COOKIE['remember'] == 'on');
// }

$enter_site = false;
Logout();

echo $count_logs;

if (isset($_POST['submit_btn'])) {
  $recaptcha = $_POST['g-recaptcha-response']; 
  $secret_key = '6Lf9otsoAAAAADUFhx_Xi77AmnjbNTVUHTq4OX6G'; 
  $url = 'https://www.google.com/recaptcha/api/siteverify?secret='. $secret_key . '&response=' . $recaptcha;
  $response = file_get_contents($url); 
  $response = json_decode($response); 
  if ($response->success == true) {
    if (count($_POST) > 0) { $enter_site = Login($_POST['username'], $_POST['email'], $_POST['password'], $_POST['remember'] == 'on'); }
    if ($enter_site) { $_SESSION['captcha_attempts'] = 0; header('Location: index.php'); exit(); }
  } else { 
    $errorMessage = 'Вы не прошли капчу!'; 
    $_SESSION['captcha_attempts']++;
    if ($_SESSION['captcha_attempts'] >= 3) {
      echo '<script>alert("Вы ввели неверную капчу три раза. Вам необходимо подождать некоторое время")</script>';
    }
  } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Login</title>
</head>
<body class="bg-light w-100 h-100">
  <div class="d-flex justify-content-end gap-2 mt-2 mx-3">
    <form action="index.html">
      <input class="btn btn-primary" type="submit" value="Главная">
    </form>    
  </div>
  <div class="container d-flex flex-column justify-content-center align-items-center my-5">
  <h3 class="mb-3">Вход на сайт</h3>
  <form id="login_form" action="" method="post" class="col-3 border border-3 border-success-subtle rounded px-2 pt-3">
    <div class="mb-3">
      <label for="username" class="w-100">Введите имя:</label></br>
      <input required type="text" name="username" class="w-100">
    </div>
    <div class="mb-3">
      <label for="email" class="w-100">Введите эл. почту:</label></br>
      <input required type="email" name="email" class="w-100">
    </div>
    <div class="mb-3">
      <label for="username" class="w-100">Введите пароль:</label></br>
      <input required type="password" name="password" class="w-100">
    </div>
    <div class="g-recaptcha mb-3 w-100" data-sitekey="6Lf9otsoAAAAAGUWqqRCsCaA7RIc9OV8UF03-N_H"></div>
    <div class="mb-3">
      <input type="checkbox" name="remember"> Запомнить меня
    </div>
    <div class="mb-3">
      <input type="submit" value="Войти" class="w-50 btn btn-success" name="submit_btn">
      <a class="mx-3" href="./registration.php">Регистрация</a>
    </div>
  </form>
  <div class="mt-3">
      <a class="mx-3" href="./reset_password.php">Восстановление пароля</a>
    </div>
  <?php
    if (isset($errorMessage)) {
      echo "<div class='text-danger mt-5'>$errorMessage</div>";
    }
  ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
