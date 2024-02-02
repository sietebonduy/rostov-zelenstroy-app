<?php
include 'db.php';
session_start();

if (isset($_GET['token'])) {
  $token = $_GET['token'];
    $query = "SELECT * FROM Users WHERE reset_token = '$token'";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        if (isset($_POST['submit_btn'])) {
            $new_password = $_POST['new_password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE Users SET password = '$hashed_password', reset_token = NULL WHERE id = $id";
            $mysqli->query($query);
            echo "<script>alert('Пароль успешно изменен.')</script>";
            header('Location: login.php');
            exit();
        }
    } else {
        echo "<script>alert('Неверный токен сброса пароля.')</script>";
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
  <h3 class="mb-3">Восстановление пароля</h3>
  <form action="" method="post" class="col-3 border border-3 border-success-subtle rounded p-3">
    <div class="mb-3">
      <label for="new password" class="w-100">Введите новый пароль:</label></br>
      <input type="password" name="new_password" class="w-100" required>
    </div>
    <div class="mb-3">
      <input type="submit" value="Восстановить" class="w-100 btn btn-success" name="submit_btn">
    </div>
  </form>
  <?php
    if (isset($errorMessage)) {
      echo "<div class='text-danger mt-5'>$errorMessage</div>";
    }
  ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>